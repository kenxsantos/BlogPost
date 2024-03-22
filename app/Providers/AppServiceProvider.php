<?php

namespace App\Providers;

use App\Http\ViewComposers\ActivityComposer;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
       
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);
        Blade::aliasComponent('components.badge', 'badge');
        Blade::aliasComponent('components.updated', 'updated');
        Blade::aliasComponent('components.card', 'card');
        Blade::aliasComponent('components.tags', 'tags');
        Blade::aliasComponent('components.errors', 'errors');

        // view()->composer('*', ActivityComposer::class);
        view()->composer(['post.index', 'post.show'], ActivityComposer::class);
    }
}
