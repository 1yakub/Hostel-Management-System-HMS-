<?php

namespace App\Ai\Gateways;

use Laravel\Ai\Gateway\OpenAiCompatible\OpenAiCompatibleGateway;

/**
 * The OpenAI compatible gateway, used for Vertex AI, with one change: a 404 also moves the
 * request to the next model in the provider list. Vertex answers 404 when a model is withdrawn
 * or not enabled for the project. On Nov 24 2026 the first model left Vertex and every
 * question ended in a 500, because the SDK fails over only on 429, 402 and 5xx overloads.
 */
class VertexGateway extends OpenAiCompatibleGateway
{
    #[\Override]
    protected function overloadedStatusCodes(): array
    {
        return [...parent::overloadedStatusCodes(), 404];
    }
}
