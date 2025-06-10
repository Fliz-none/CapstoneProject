<?php

namespace App\Http\Controllers;

use App\Events\PusherBroadcast;
use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ChatController extends Controller
{
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
                    $messages = Message::with('sender')->whereHas('conversation', function ($q) {
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
            if ($request->ajax()) {
            } else {
            }
        }
    }


    public function broadcast(Request $request)
    {
        DB::beginTransaction();
        try {
            $request->validate([
                'message' => 'required|string|max:192',
            ], [
                'message.required' => 'The message field is required.',
                'message.string' => 'The message field must be a string.',
                'message.max' => 'The message field must not be greater than 192 characters.',
            ]);

            $messageText = $request->get('message');
            $conversation = Conversation::firstOrCreate([
                'customer_id' => Auth::id()
            ]);
            if ($conversation->wasRecentlyCreated) {
                $admins = User::permission(User::ACCESS_ADMIN)->pluck('id');
                $conversation->users()->syncWithoutDetaching($admins);
            }
            $message = Message::create([
                'conversation_id' => $conversation->id,
                'sender_id' => Auth::id(),
                'content' => $messageText,
            ]);

            broadcast(new PusherBroadcast($message));
            DB::commit();
        } catch (\Exception $e) {
            log_exception($e);
            DB::rollBack();
            return response()->json('An error occurred, while sending the message!', 500);
        }
    }
}
