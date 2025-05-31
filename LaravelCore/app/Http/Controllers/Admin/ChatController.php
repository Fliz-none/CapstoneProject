<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

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
}
