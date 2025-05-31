<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    protected $fillable = [
        'message_id',
        'file_name',
        'file_url',
        'mime_type',
    ];

    // Thuộc về tin nhắn
    public function message()
    {
        return $this->belongsTo(Message::class);
    }
}
