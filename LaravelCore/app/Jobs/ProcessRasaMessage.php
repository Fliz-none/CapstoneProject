<?php

namespace App\Jobs;

use App\Models\Message;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Firebase\JWT\JWT;
use App\Events\PusherBroadcast;
use GenerateMessage;

class ProcessRasaMessage implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    protected $message;

    public function __construct(Message $message)
    {
        $this->message = $message;
    }

    public function handle()
    {
        try {
            $userId = (string) $this->message->sender_id;

            // Tạo JWT token
            $jwt = JWT::encode([
                'sub' => $userId,
                'iat' => time(),
            ], env('JWT_SECRET'), 'HS256');

            // Gửi request tới Rasa
            $rasaUrl = env('RASA_WEBHOOK_URL', 'http://localhost:8001/webhooks/smsolutions/webhook');

            $response = Http::withToken($jwt)
                ->timeout(8)
                ->post($rasaUrl, [
                    'sender' => $userId,
                    'message' => $this->message->content,
                ]);

            $rasa_responses = $response->json();
            // Biến để merge text + custom
            $merged = [
                'text'   => null,
                'custom' => null
            ];

            foreach ($rasa_responses as $rasa_resp) {
                if (!empty($rasa_resp['text'])) {
                    $merged['text'] = $rasa_resp['text'];
                }
                if (!empty($rasa_resp['custom'])) {
                    $merged['custom'] = $rasa_resp['custom'];
                }
            }

            // Chỉ lưu nếu có text hoặc custom
            if ($merged['text'] || $merged['custom']) {
                $aiMessage = Message::create([
                    'conversation_id' => $this->message->conversation_id,
                    'sender_id'       => null,
                    'content'         => $merged['text'],
                    'json_data' => $merged['custom']
                            ? json_encode($merged['custom'], JSON_UNESCAPED_UNICODE)
                            : null
                ]);
                broadcast(new PusherBroadcast($aiMessage));
            } else {
                Log::error("Không có nội dung hoặc custom từ Rasa");
            }
        } catch (\Exception $e) {
            log_exception($e);
        }
    }
}
