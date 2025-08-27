<?php

namespace App\Http\Controllers;

use App\Events\PusherBroadcast;
use App\Jobs\ProcessRasaMessage;
use App\Models\Attachment;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use GenerateMessage;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ChatController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->user === null) {
            $this->user = Auth::user();
        }
        $this->middleware(['auth']);

        $this->middleware(function ($request, $next) {
            Controller::init();
            return $next($request);
        });
    }

    public function index(Request $request)
    {
        if (isset($request->key)) {
            switch ($request->key) {
                case 'messages':
                    $offset = $request->input('offset', 0);
                    $messages = Message::with(['sender', 'attachments'])->whereHas('conversation', function ($q) {
                        $q->where('customer_id', $this->user->id);
                    })
                        ->orderBy('created_at', 'desc')
                        ->skip($offset)
                        ->take(10)
                        ->get()
                        ->reverse(); // Reverse to show the latest messages at the bottom
                    Message::whereHas('conversation', function ($q) {
                        $q->where('customer_id', $this->user->id);
                    })
                        ->where('sender_id', '!=', $this->user->id)
                        ->where('is_seen', false)
                        ->update(['is_seen' => true]);
                    return response()->json($messages);
                default:
                    abort(404);
            }
        } else {
            abort(404);
            // if ($request->ajax()) {
            // } else {
            // }
        }
    }


    public function broadcast(Request $request)
    {
        DB::beginTransaction();
        try {
            $request->validate([
                'message' => 'nullable|string|max:192',
                'attachments.*' => 'file|max:102400', // 100Mb max mỗi file
            ], [
                'message.string' => 'Kiểu dữ liệu không hợp lệ.',
                'message.max' => 'Tin nhắn quá dài',
            ]);

            $messageText = $request->get('message');

            // Tạo hoặc lấy conversation
            $conversation = Conversation::firstOrCreate([
                'customer_id' => Auth::id(),
                'created_by' => Auth::id(),
            ]);

            $admins = User::permission(User::ACCESS_ADMIN)->pluck('id')->toArray();
            $conversation->users()->syncWithoutDetaching(array_merge($admins, [Auth::id()]));

            // Tạo message (có thể rỗng nếu chỉ gửi file)
            $message = Message::create([
                'conversation_id' => $conversation->id,
                'sender_id' => Auth::id(),
                'content' => $messageText,
            ]);

            // Tách file ảnh và file khác
            if ($request->hasFile('attachments')) {
                foreach ($request->file('attachments') as $file) {
                    $uuidName = Str::uuid() . '.' . $file->getClientOriginalExtension();
                    $file->storeAs('', $uuidName, 'chat_attachments'); // vẫn đúng path

                    Attachment::create([
                        'message_id' => $message->id,
                        'file_name' => $file->getClientOriginalName(),
                        'file_url' => asset('storage/chat/' . $uuidName),
                        'mime_type' => $file->getMimeType(),
                        'size' => $file->getSize(),
                    ]);
                }
            }

            broadcast(new PusherBroadcast($message->load('attachments')));
            DB::commit();
            if ((bool)$request->aiEnabled) {
                // 🔹 Check Rasa status trước khi queue
                $rasaUrl = env('RASA_WEBHOOK_URL', 'http://localhost:8001/webhooks/smsolutions/webhook');
                $statusUrl = preg_replace('#/webhooks/.+$#', '/status', $rasaUrl);

                try {
                    $jwt = JWT::encode(['sub' => Auth::id(), 'iat' => time()], env('JWT_SECRET'), 'HS256');
                    $ping = Http::withToken($jwt)->timeout(3)->get($statusUrl);

                    if ($ping->successful()) {
                        Log::info("✅ ProcessRasaMessage queue");
                        dispatch(new ProcessRasaMessage($message));
                    } else {
                        Log::warning("⚠️ Rasa trả về lỗi status: " . $ping->status());
                    }
                } catch (\Throwable $e) {
                    Log::error("❌ Không kết nối được Rasa: " . $e->getMessage());
                }
            }

            return response()->json($message);
        } catch (\Exception $e) {
            log_exception($e);
            DB::rollBack();
            return response()->json('An error occurred while sending the message!', 500);
        }
    }
}
