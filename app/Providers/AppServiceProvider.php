<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;use App\Models\Chatbot;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
{
    if (env('APP_ENV') === 'production') {
        URL::forceScheme('https');
    }

    // Make $chatbot available to all views that include 'navbar'
    View::composer('navbar', function ($view) {
        $chatbot = Chatbot::where('is_active', true)->first()?->script_code ?? '';
        $view->with('chatbot', $chatbot);
    });
}
}
