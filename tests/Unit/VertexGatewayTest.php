<?php

namespace Tests\Unit;

use App\Ai\Gateways\VertexGateway;
use Closure;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use Laravel\Ai\AiManager;
use Laravel\Ai\Exceptions\FailoverableException;
use Tests\TestCase;

/**
 * A withdrawn model (404) must move the request to the next model; a bad request (400) must not.
 */
class VertexGatewayTest extends TestCase
{
    private function gateway(): object
    {
        return new class(app(Dispatcher::class)) extends VertexGateway
        {
            public function run(Closure $callback): mixed
            {
                return $this->withErrorHandling('vertex', $callback);
            }
        };
    }

    public function test_a_404_is_a_failover_error(): void
    {
        Http::fake(['*' => Http::response(['error' => ['message' => 'Publisher model was not found']], 404)]);

        $this->expectException(FailoverableException::class);

        $this->gateway()->run(fn () => Http::post('https://vertex.test/chat/completions')->throw());
    }

    public function test_a_400_is_not_a_failover_error(): void
    {
        Http::fake(['*' => Http::response(['error' => ['message' => 'Bad request']], 400)]);

        $this->expectException(RequestException::class);

        $this->gateway()->run(fn () => Http::post('https://vertex.test/chat/completions')->throw());
    }

    public function test_both_vertex_providers_use_the_vertex_gateway(): void
    {
        $ai = app(AiManager::class);

        $this->assertInstanceOf(VertexGateway::class, $ai->instance('vertex')->textGateway());
        $this->assertInstanceOf(VertexGateway::class, $ai->instance('vertex-fallback')->textGateway());
    }
}
