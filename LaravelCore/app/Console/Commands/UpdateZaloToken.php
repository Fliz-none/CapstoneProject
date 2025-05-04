<?php

namespace App\Console\Commands;

use App\Models\Setting;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use GuzzleHttp\Client;

class UpdateZaloToken extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:zalo_token'; // Tên command

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update Zalo Access Token'; // Mô tả command
    
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Setting::where('key', 'has_zalo')->where('value',1)->pluck('company_id')->each(function ($company_id) {
            $url = 'https://oauth.zaloapp.com/v4/access_token';
            $client = new Client();
            try {
                $app_id = Setting::where('key', 'zalo_app_id')->where('company_id', $company_id)->first()->value;
                $app_secret = Setting::where('key', 'zalo_app_secret')->where('company_id', $company_id)->first()->value;
                $refresh_token = Setting::where('key', 'zalo_refresh_token')->where('company_id', $company_id)->first()->value;
                $response = $client->post($url, [
                    'headers' => [
                        'Content-Type' => 'application/x-www-form-urlencoded',
                        'secret_key' => $app_secret,
                    ],
                    'form_params' => [
                        'refresh_token' => $refresh_token,
                        'app_id' => $app_id,
                        'grant_type' => 'refresh_token',
                    ],
                ]);
    
                $data = json_decode($response->getBody(), true);
                if (isset($data['access_token']) && isset($data['refresh_token'])) {
                    Cache::put('zalo_access_token_' . $company_id, $data['access_token'], now()->addSeconds(3600));
                    Cache::put('zalo_refresh_token_' . $company_id, $data['refresh_token'], now()->addDays(30));
                    Setting::where('company_id', $company_id)->firstWhere('key', 'zalo_access_token')->update(['value' => $data['access_token']]);
                    Setting::where('company_id', $company_id)->firstWhere('key', 'zalo_refresh_token')->update(['value' => $data['refresh_token']]);
                    $this->info('Zalo token updated successfully.');
                    return $data['access_token'];
                }
    
                throw new \Exception('Failed to refresh Access Token');
                $this->info(Carbon::now()->format('d/m/Y') . ': Update Zalo token successfully');
            } catch (\Throwable $throwable) {
                $this->info(Carbon::now()->format('d/m/Y') . ': Error:' . $throwable->getMessage());
            }
        });
    }
}
