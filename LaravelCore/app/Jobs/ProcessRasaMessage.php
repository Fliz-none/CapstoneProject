<?php

namespace App\Jobs;

use App\Models\Message;
use GenerateMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Firebase\JWT\JWT;
use App\Events\PusherBroadcast;

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

            $jwt = JWT::encode([
                'sub' => $userId,
                'iat' => time(),
            ], env('JWT_SECRET'), 'HS256');

            $rasaUrl = env('RASA_WEBHOOK_URL', 'http://localhost:8001/webhooks/smsolutions/webhook');

            $response = Http::withToken($jwt)
                ->timeout(20)
                ->post($rasaUrl, [
                    'sender' => $userId,
                    'message' => $this->message->content,
                ]);

            $rasa_responses = $response->json();

            foreach ($rasa_responses as $rasa_resp) {
                $text = $rasa_resp['text'] ?? null;
                $data_custom = $rasa_resp['custom'] ?? null;

                if ($text) {
                    $aiMessage = Message::create([
                        'conversation_id' => $this->message->conversation_id,
                        'sender_id' => null,
                        'content' => $text,
                        'json_data' => $rasa_resp,
                    ]);
                    broadcast(new PusherBroadcast($aiMessage));
                } else if ($data_custom) {
                    $obj = new GenerateMessage();
                    $aiMessage = $obj->gener_response($data_custom);
                    broadcast(new PusherBroadcast($aiMessage));
                }
            }
        } catch (\Exception $e) {
            log_exception($e);
        }
    }
}
