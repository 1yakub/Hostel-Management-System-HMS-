<?php

namespace App\Providers;

use App\Ai\Gateways\VertexGateway;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;
use Laravel\Ai\AiManager;
use Laravel\Ai\Providers\OpenAiCompatibleProvider;

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

        // Vertex through its OpenAI compatible API, with a 404 (model withdrawn) treated as a
        // failover error, so the next model in config('hms.assistant.providers') answers.
        $this->app->make(AiManager::class)->extend('vertex-openai', function ($app, array $config) {
            $events = $app->make(Dispatcher::class);

            return (new OpenAiCompatibleProvider($config, $events))->useTextGateway(new VertexGateway($events));
        });


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
