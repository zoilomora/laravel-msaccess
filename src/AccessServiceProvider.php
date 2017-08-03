<?php

namespace ZoiloMora;

use Illuminate\Database\DatabaseManager;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;
use ZoiloMora\Illuminate\Database\AccessConnection;

class AccessServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application events.
     */
    public function boot()
    {
        Model::setConnectionResolver($this->app['db']);
    }

    /**
     * Register the service provider.
     */
    public function register()
    {
        // Add database driver.
        $this->app->resolving('db', function ($db) {
            /** @var DatabaseManager $db */
            $db->extend('pdo_access', function ($config, $name) {
                $config['name'] = $name;
                return new AccessConnection($config);
            });
        });
    }
}