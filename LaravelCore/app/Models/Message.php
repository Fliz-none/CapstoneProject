<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Crypt;

class Message extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'conversation_id',
        'sender_id',
        'content',
        'json_data',
        'is_seen',
        'answer_id',
     ];

    //Encrypt content before save
    public function setContentAttribute($value)
    {
        $this->attributes['content'] = Crypt::encryptString($value);
    }

    // Decrypt content when access
    public function getContentAttribute($value)
    {
        try {
            return Crypt::decryptString($value);
        } catch (\Exception $e) {
            return $value;
        }
    }

    public function setJsonDataAttribute($value)
    {
        if (is_array($value) || is_object($value)) {
            $value = json_encode($value);
        }

        $this->attributes['json_data'] = Crypt::encryptString($value);
    }

    public function getJsonDataAttribute($value)
    {
        try {
            $decrypted = Crypt::decryptString($value);
            return json_decode($decrypted, true) ?? $decrypted;
        } catch (\Exception $e) {
            return $value;
        }
    }


    public function conversation()
    {
        return $this->belongsTo(Conversation::class);
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function attachments()
    {
        return $this->hasMany(Attachment::class);
    }
}
