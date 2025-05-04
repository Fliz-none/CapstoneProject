<?php

namespace App\Providers;

use Hypweb\Flysystem\GoogleDrive\GoogleDriveAdapter;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\ServiceProvider;
use League\Flysystem\Filesystem;

class GoogleDriveServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        Storage::extend('google', function($app, $config) {
            $client = new \Google_Client();
            $client->setClientId($config['client_id']);
            $client->setClientSecret($config['client_secret']);
            $client->refreshToken($config['refresh_token']);
            $service = new \Google_Service_Drive($client);

            $adapter = new GoogleDriveAdapter($service, $config['folder_id']);

            return new Filesystem($adapter);
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
