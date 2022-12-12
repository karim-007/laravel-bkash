<?php

namespace Karim007\LaravelBkash;

use Karim007\LaravelBkash\Payment\Refund;
use Karim007\LaravelBkash\Payment\Payment;
use Illuminate\Support\ServiceProvider;

class BkashServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . "/../config/bkash.php" => config_path("bkash.php")
        ]);

        $this->loadRoutesFrom(__DIR__ . "/routes/bkash_route.php");
        $this->loadViewsFrom(__DIR__ . '/Views', 'bkash');
    }

    /**
     * Register application services
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . "/../config/bkash.php", "bkash");

        $this->app->bind("payment", function () {
            return new Payment();
        });

        $this->app->bind("refundPayment", function () {
            return new Refund();
        });
    }
}
