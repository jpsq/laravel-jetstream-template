<?php

namespace App\Providers;

use App\Facades\Services;
use Illuminate\Support\ServiceProvider;

use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Support\Facades\Storage;
use League\Flysystem\Filesystem;
use PlatformCommunity\Flysystem\BunnyCDN\BunnyCDNAdapter;
use PlatformCommunity\Flysystem\BunnyCDN\BunnyCDNClient;

class BunnyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Storage::extend('bunnycdn', function ($app, $config) {
            $storage_zone = Services::get('bunnyStorage', 'zone', $config['storage_zone']);
            $api_key = Services::get('bunnyStorage', 'api_key', $config['api_key']);
            $region = Services::get('bunnyStorage', 'region', $config['region']);
            $pull_zone = Services::get('bunnyStorage', 'pull_zone', $config['pull_zone']);

            $adapter = new BunnyCDNAdapter(new BunnyCDNClient($storage_zone, $api_key, $region), $pull_zone);
            return new FilesystemAdapter(new Filesystem($adapter, $config), $adapter, $config);
        });
    }
}
