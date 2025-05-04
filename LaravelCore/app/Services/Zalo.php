<?php

namespace App\Services;

use App\Models\Setting;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;

class Zalo
{
    protected $company_id;
    protected $client;
    protected $oaId;
    protected $accessToken;
    protected $refreshToken;
    protected $appId;
    protected $appSecret;

    public function __construct()
    {
        $this->client = new Client();
    }

    /**
     * Gửi tin nhắn ZNS
     */
    public function send($phone, $template_id, $params, $company_id)
    {
        $settings = Cache::get('settings_' . $company_id);
        $this->company_id = $company_id;
        $this->oaId = $settings['zalo_oa_id'];
        $this->appId = $settings['zalo_app_id'];
        $this->appSecret = $settings['zalo_app_secret'];
        $this->accessToken = Cache::get('zalo_access_token_' . $company_id);
        $this->refreshToken = Cache::get('zalo_refresh_token_' . $company_id);
        $accessToken = $this->accessToken;
        try {
            $response = $this->client->post('https://business.openapi.zalo.me/message/template', [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'access_token' => $accessToken, // Thay bằng access token của bạn
                ],
                'json' => [
                    'phone' => $this->format_phone($phone),
                    'template_id' => $template_id,
                    'template_data' => $params,
                    'tracking_id' => 'booking',
                ],
            ]);
            return json_decode($response->getBody(), true);
        } catch (\Exception $e) {
            return [
                'error' => true,
                'message' => $e->getMessage(),
            ];
        }
    }

    /**
     * Làm mới Access Token khi hết hạn
     */
    public function refreshAccessToken()
    {
        $url = 'https://oauth.zaloapp.com/v4/access_token';

        try {
            $response = $this->client->post($url, [
                'form_params' => [
                    'app_id' => $this->appId,
                    'grant_type' => 'refresh_token',
                    'refresh_token' => $this->refreshToken,
                    'app_secret' => $this->appSecret,
                ],
            ]);

            $data = json_decode($response->getBody(), true);

            if (isset($data['access_token']) && isset($data['refresh_token'])) {
                Cache::put('zalo_access_token_' . $this->company_id, $data['access_token'], now()->addSeconds(3600));
                Cache::put('zalo_refresh_token_' . $this->company_id, $data['refresh_token'], now()->addDays(30));
                Setting::where('company_id', $this->company_id)->firstWhere('key', 'zalo_access_token')->update(['zalo_access_token' => $data['access_token']]);
                Setting::where('company_id', $this->company_id)->firstWhere('key', 'zalo_refresh_token')->update(['zalo_refresh_token' => $data['refresh_token']]);
                $this->accessToken = $data['access_token'];
                $this->refreshToken = $data['refresh_token'];
                return $data['access_token'];
            }
            throw new \Exception('Failed to refresh Access Token');
        } catch (\Exception $e) {
            // Xử lý lỗi nếu có
            return [
                'error' => true,
                'message' => $e->getMessage(),
            ];
        }
    }

    /**
     * Lấy Access Token (tự động làm mới nếu hết hạn)
     */
    public function getAccessToken()
    {
        if (!$this->accessToken) {
            $this->accessToken = $this->refreshAccessToken();
        }

        return $this->accessToken;
    }

    /**
     * Định dạng lại đúng số phone
     */
    static function format_phone($phone)
    {
        $phone = preg_replace('/\s+/', '', $phone);

        if (strpos($phone, '0') === 0) {
            $phone = '+84' . substr($phone, 1);
        }
        return $phone;
    }
}
