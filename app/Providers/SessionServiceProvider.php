<?php

namespace App\Providers;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\ServiceProvider;
use App\Extensions\CustomDatabaseSessionHandler;

class SessionServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Session::extend('custom_database', function ($app) {
            $connection = $app['config']['session.connection'];
            $table = $app['config']['session.table'];
            $lifetime = $app['config']['session.lifetime'];
            
            return new CustomDatabaseSessionHandler(
                $app['db']->connection($connection),
                $table,
                $lifetime,
                $app
            );
        });
    }
    
    public function register()
    {
        //
    }
}