<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Conversation extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'customer_id',
        'status'
    ];

    // Quan hệ với User (customer)
    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    // Quan hệ với nhiều nhân viên/ người tham gia (pivot table)
    public function users()
    {
        return $this->belongsToMany(User::class, 'conversation_user')
                    ->withPivot('role')
                    ->withTimestamps();
    }

    // Quan hệ với tin nhắn
    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    // Tin nhắn cuối cùng
    public function lastMessage()
    {
        return Message::where('conversation_id', $this->id)
            ->orderBy('created_at', 'desc')
            ->first();
    }

    public function lastMessageAt()
    {
        $lastMessage = $this->lastMessage();
        if (!$lastMessage) {
            return ''; // hoặc 'No messages yet'
        }
        return Carbon::parse($lastMessage->created_at)->diffForHumans();
    }

    public function unreadMessagesCount()
    {
        return $this->messages()
            ->where('is_seen', 0) // Chỉ đếm tin nhắn chưa đọc
            ->where('sender_id', '!=', Auth::id())
            ->count();
    }
}
