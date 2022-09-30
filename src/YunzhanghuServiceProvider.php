<?php

namespace Lichv\Yunzhanghu;

use Illuminate\Support\ServiceProvider;

class YunzhanghuServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->app->singleton('yunzhanghu',function(){
           return new Yunzhanghu();
        });
    }

    public function provides()
    {
        return ['yunzhanghu'];
    }
}
