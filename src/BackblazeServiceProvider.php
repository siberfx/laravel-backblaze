<?php namespace Hpolthof\Backblaze;

use BackblazeB2\Client;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\ServiceProvider;
use League\Flysystem\Filesystem;
use Mhetreramesh\Flysystem\BackblazeAdapter;


class BackblazeServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Storage::extend('b2', function ($app, $config) {
            if(!(
                isset($config['accountId']) ||
                isset($config['applicationKey']) ||
                isset($config['bucketName']))) {
                throw new BackblazeException('Please set all configuration keys. (accountId, applicationKey, bucketName)');
            }

            $client = new Client($config['accountId'], $config['applicationKey']);
            $adapter = new BackblazeAdapter($client, $config['bucketName']);
            return new Filesystem($adapter);
        });
    }

    public function register()
    {

    }
}

