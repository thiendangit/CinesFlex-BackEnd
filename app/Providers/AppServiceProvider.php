<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Relations\Relation;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
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
        // morph map for order detail
        // Relation::morphMap([
        //     'products' => 'App\Models\Product',
        //     'tickets' => 'App\Models\Ticket',
        //     'images' => 'App\Models\Image',
        // ]);
    }
}
