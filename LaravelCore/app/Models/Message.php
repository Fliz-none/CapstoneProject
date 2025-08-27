<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class Message extends Model
{
    use SoftDeletes;

    protected $appends = ['renderData', 'ids_conversation'];
    protected $fillable = [
        'conversation_id',
        'sender_id',
        'content',
        'json_data',
        'is_seen',
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

    public function getRenderDataAttribute()
    {
        $data = $this->json_data ? json_decode($this->json_data, true) : null;
        if (!$data) return $data;
        switch ($data['action']) {
            case 'check_order':
                $order = $data['order'];
                return view('admin.chat.messages.check_order', compact('order'))->render();
            case 'check_stock':
                $stock = $data['stock'];
                return view('admin.chat.messages.check_stock', compact('stock'))->render();
            case 'ask_product':
                $product = $data['product'];
                return view('admin.chat.messages.ask_product', compact('product'))->render();
            case 'ask_branch':
                $branches = $data['branches'];
                return view('admin.chat.messages.ask_branch', compact('branches'))->render();
            case 'ask_post':
                $posts = $data['posts'];
                return view('admin.chat.messages.ask_post', compact('posts'))->render();
            case 'ask_company':
                $shop_info = $data['shop_info'];
                return view('admin.chat.messages.ask_company', compact('shop_info'))->render();
            case 'ask_promotions':
                $promotions = $data['promotions'];
                return view('admin.chat.messages.ask_promotions', compact('promotions'))->render();
            default:
                return null;
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



    public function getIdsConversationAttribute()
    {
        $ids = DB::table('conversation_user')
            ->where('conversation_id', $this->conversation_id)
            ->pluck('user_id');

        return $ids;
    }
}
