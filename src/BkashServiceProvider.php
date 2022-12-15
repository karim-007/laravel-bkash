<?php

namespace Karim007\LaravelBkash;

use Karim007\LaravelBkash\Payment\BRefund;
use Karim007\LaravelBkash\Payment\BPayment;
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

        $this->app->bind("bpayment", function () {
            return new BPayment();
        });

        $this->app->bind("brefundPayment", function () {
            return new BRefund();
        });
    }
}
