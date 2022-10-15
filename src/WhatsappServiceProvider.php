<?php

namespace LaravelNotification\Whatsapp;

use Illuminate\Support\ServiceProvider;
use Illuminate\Notifications\ChannelManager;
use Illuminate\Support\Facades\Notification;

class WhatsappServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/config/whatsapp.php' => config_path('whatsapp.php'),
        ], 'config');

        $this->mergeConfigFrom(__DIR__.'/config/whatsapp.php', 'whatsapp');
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(Whatsapp::class, function ($app) {
            return new Whatsapp(config('whatsapp.phone_number_id'), config('whatsapp.token'));
        });

        Notification::resolved(static function (ChannelManager $service) {
            $service->extend('whatsapp', static function ($app) {
                return $app->make(WhatsappChannel::class);
            });
        });
    }

    
}
