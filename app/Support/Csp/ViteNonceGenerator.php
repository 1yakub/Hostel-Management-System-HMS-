<?php

namespace App\Support\Csp;

use Illuminate\Support\Facades\Vite;
use Spatie\Csp\Nonce\NonceGenerator;

/**
 * One nonce per request, shared by the Content Security Policy header and every script tag
 * Vite renders. This is the integration the spatie/laravel-csp README describes.
 */
class ViteNonceGenerator implements NonceGenerator
{
    public function generate(): string
    {
        return Vite::cspNonce() ?? Vite::useCspNonce();
    }
}
