<?php

namespace App\Http\Controllers\Api;

use App\Events\PusherBroadcast;
use App\Http\Controllers\Controller;
use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PusherController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        if ($this->user === null) {
            $this->user = Auth::user();
        }
        $this->middleware(['auth']);
    }

    public function broadcast(Request $request)
    {
        try {
            $request->validate([
                'message' => 'required|string|max:192',
                'conversation_id' => 'required|exists:conversations,id',
            ], [
                'message.required' => 'The message field is required.',
                'message.string' => 'The message field must be a string.',
                'message.max' => 'The message field must not be greater than 192 characters.',
                'conversation_id.required' => 'The conversation id field is required.',
                'conversation_id.exists' => 'The conversation id field does not exist.',
            ]);

            $messageText = $request->get('message');
            $conversation = Conversation::firstOrCreate([
                'id' => $request->get('conversation_id')
            ]);
            if (!$conversation->users->contains(Auth::id())) {
                abort(403);
            }
            $message = Message::create([
                'conversation_id' => $conversation->id,
                'sender_id' => Auth::id(),
                'content' => $messageText,
            ]);

            broadcast(new PusherBroadcast($message))->toOthers();
        } catch (\Exception $e) {
            log_exception($e);
            return response()->json('An error occurred, while sending the message!', 500);
        }
    }
}
