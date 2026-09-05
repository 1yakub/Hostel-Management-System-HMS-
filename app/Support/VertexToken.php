<?php

namespace App\Support;

use Google\Auth\Credentials\ServiceAccountCredentials;
use Illuminate\Support\Facades\Cache;
use RuntimeException;

/**
 * Short lived access token for Vertex AI, minted from a service account that holds only
 * roles/aiplatform.user. The key file lives outside the repository (VERTEX_SA_KEY_PATH)
 * and the token is cached for fifty minutes so a busy hour costs one signing call.
 */
class VertexToken
{
    private const CACHE_KEY = 'vertex.access_token';

    public static function get(): string
    {
        return Cache::remember(self::CACHE_KEY, now()->addMinutes(50), function () {
            $path = config('services.vertex.key_path');

            if (! $path || ! is_readable($path)) {
                throw new RuntimeException('Vertex service account key is not configured.');
            }

            $credentials = new ServiceAccountCredentials(
                ['https://www.googleapis.com/auth/cloud-platform'],
                json_decode((string) file_get_contents($path), true, 512, JSON_THROW_ON_ERROR),
            );

            $token = $credentials->fetchAuthToken();

            if (empty($token['access_token'])) {
                throw new RuntimeException('Vertex token request returned no token.');
            }

            return $token['access_token'];
        });
    }

    public static function forget(): void
    {
        Cache::forget(self::CACHE_KEY);
    }
}
