<?php

namespace App\Providers;

use App\Models\Plan;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $freePlanId = config('strip.athlete_free_plan_id');
        $this->app->singleton('freePlanId', function () use ($freePlanId) {
            return $freePlanId;
        });
        $freePlanName = config('strip.athlete_free_plan_name');
        $this->app->singleton('freePlanName', function () use ($freePlanName) {
            return $freePlanName;
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

    }
}
