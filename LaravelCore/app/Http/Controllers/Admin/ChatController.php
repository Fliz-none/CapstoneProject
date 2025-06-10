<?php

namespace App\Http\Controllers\Admin;

use App\Events\PusherBroadcast;
use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class ChatController extends Controller
{
    const NAME = 'Chat';

    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct()
    {
        parent::__construct();
        if ($this->user === null) {
            $this->user = Auth::user();
        }
        $this->middleware(['auth']);
    }

    public function index(Request $request)
    {
        if (isset($request->key)) {
            switch ($request->key) {
                case 'messages':
                    $offset = $request->input('offset', 0);
                    $limit = 10;
                    $messages = Message::where('conversation_id', $request->conversation_id)
                        ->orderBy('created_at', 'desc')
                        ->skip($offset)
                        ->take($limit)
                        ->get()
                        ->reverse(); // Reverse to show the latest messages at the bottom
                    Message::where('conversation_id', $request->conversation_id)
                        ->where('sender_id', '!=', $this->user->id)
                        ->where('is_seen', false)
                        ->update(['is_seen' => true]);
                    return view('admin.chat.messages', compact('messages'));
                case 'conversations':
                    $search = $request->search;
                    $active_id = $request->input('active_id', false);
                    $conversations = Conversation::with('customer')
                        ->whereHas('users', function ($q) {
                            $q->where('user_id', Auth::id());
                        })
                        ->when($search, function ($query, $search) {
                            $query->whereHas('customer', function ($q) use ($search) {
                                $q->where('name', 'like', '%' . $search . '%');
                            });
                        })
                        ->get();
                    return view('admin.chat.conversations', ['conversations' => $conversations ?? [], 'active_id' => $active_id]);
                default:
                    abort(404);
            }
        } else {
            if ($request->ajax()) {
            } else {
                $pageName = self::NAME . ' management';
                return view('admin.chats', compact('pageName'));
            }
        }
    }

    public function broadcast(Request $request)
    {
        // Validate message + files
        $request->validate([
            'conversation_id' => 'required|numeric',
            'message' => 'required|string|max:192',
            'attachments' => 'nullable|array|max:5', // Tối đa 5 files
            'attachments.*' => 'file|max:10240',     // Mỗi file ≤ 10MB
        ], [
            'conversation_id.required' => 'The conversation has not been found.',
            'message.required' => 'The message field is required.',
            'message.string' => 'The message field must be a string.',
            'message.max' => 'The message field must not be greater than 192 characters.',
            'attachments.max' => 'You can only upload up to 5 attachments.',
            'attachments.*.max' => 'Each attachment must not be greater than 10MB.',
        ]);

        try {
            $messageText = $request->get('message');
            $conversationId = $request->get('conversation_id');
            $attachments = $request->file('attachments', []);

            if (empty($messageText) && count($attachments) === 0) {
                return response()->json(['message' => 'The message field is required if no attachment is provided.'], 422);
            }

            DB::beginTransaction();

            // Tìm hoặc tạo cuộc trò chuyện
            $conversation = Conversation::firstOrCreate([
                'id' => $conversationId,
            ]);

            //Authorization
            if (!$conversation->users->contains(Auth::id())) {
                abort(403);
            }

            // Tạo message
            $message = Message::create([
                'conversation_id' => $conversation->id,
                'sender_id' => Auth::id(),
                'content' => $messageText ?? '',
            ]);

            // Xử lý attachments (tách riêng)
            $this->handleAttachments($attachments, $message);

            DB::commit();

            // Load quan hệ đầy đủ để phát broadcast
            $message->load('sender', 'attachments');

            broadcast(new PusherBroadcast($message));

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            DB::rollBack();
            log_exception($e);
            return response()->json(['message' => 'An error occurred while sending the message!'], 500);
        }
    }
    protected function handleAttachments(array $files, Message $message): void
    {
        try {
            foreach ($files as $file) {
                $extension = $file->getClientOriginalExtension();
                $uuidName = Str::uuid() . '.' . $extension;

                $path = $file->storeAs('', $uuidName, 'chat_attachments');

                $message->attachments()->create([
                    'file_name' => $file->getClientOriginalName(),
                    'file_url' => asset('storage/chat/' . $uuidName),
                    'mime_type' => $file->getMimeType(),
                    'size' => $file->getSize(),
                ]);
            }
        } catch (\Exception $e) {
            log_exception($e);
        }
    }
}
