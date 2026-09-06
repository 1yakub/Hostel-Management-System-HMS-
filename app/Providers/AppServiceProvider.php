<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;

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
        // the request nonce exists before any view renders; the CSP header reuses it
        Vite::useCspNonce();


        // Two independent limits on the assistant: a per IP burst and a per session window.
        RateLimiter::for('assistant', function (Request $request) {
            return [
                Limit::perMinute((int) config('hms.assistant.per_minute'))->by('ip:'.$request->ip()),
                Limit::perMinutes(10, (int) config('hms.assistant.per_ten_minutes'))->by('session:'.$request->session()->getId()),
            ];
        });

        //
    }
}
