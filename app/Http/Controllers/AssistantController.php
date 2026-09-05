<?php

namespace App\Http\Controllers;

use App\Ai\Agents\DeskAssistant;
use App\Support\VertexToken;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Laravel\Ai\Messages\AssistantMessage;
use Laravel\Ai\Messages\UserMessage;
use Laravel\Ai\Responses\StreamedAgentResponse;
use Throwable;

/**
 * One endpoint, POST /assistant, behind the web middleware group (session and CSRF).
 * Guard order: input shape, per visitor and per session limits (route middleware), then a
 * whole site daily cap, then the model. History lives in the session, last six turns only.
 */
class AssistantController extends Controller
{
    private const HISTORY_KEY = 'assistant.history';

    public function __invoke(Request $request)
    {
        $data = $request->validate([
            'message' => ['required', 'string', 'min:1', 'max:'.config('hms.assistant.max_input_chars')],
        ]);

        $message = trim(preg_replace('/\s+/u', ' ', $data['message']));

        if ($this->overSessionCap($request)) {
            return $this->refusal('You have reached today\'s limit for the assistant. The desk is happy to help by email.');
        }

        if ($this->overSiteCap()) {
            return $this->refusal('The assistant is resting for today. Please use the availability search or write to the desk.');
        }

        $history = collect($request->session()->get(self::HISTORY_KEY, []))
            ->map(fn ($m) => $m['role'] === 'user' ? new UserMessage($m['content']) : new AssistantMessage($m['content']))
            ->all();

        try {
            $token = VertexToken::get();
            config(['ai.providers.vertex.key' => $token, 'ai.providers.vertex-fallback.key' => $token]);
        } catch (Throwable $e) {
            Log::warning('assistant token failure', ['error' => $e->getMessage()]);

            return $this->refusal('The assistant is offline right now. The desk answers email within the day.');
        }

        $this->countSession($request);
        $this->countSite();

        return (new DeskAssistant($history))
            ->stream($message, provider: config('hms.assistant.providers'))
            ->then(function (StreamedAgentResponse $response) use ($request, $message) {
                $turns = collect($request->session()->get(self::HISTORY_KEY, []))
                    ->push(['role' => 'user', 'content' => $message])
                    ->push(['role' => 'assistant', 'content' => mb_substr($response->text, 0, 2000)])
                    ->take(-2 * config('hms.assistant.history_turns'))
                    ->values()
                    ->all();
                $request->session()->put(self::HISTORY_KEY, $turns);
                Log::info('assistant turn', [
                    'in' => $response->usage->promptTokens ?? null,
                    'out' => $response->usage->completionTokens ?? null,
                    'chars' => mb_strlen($message),
                ]);
            });
    }

    public function reset(Request $request): JsonResponse
    {
        $request->session()->forget(self::HISTORY_KEY);

        return response()->json(['ok' => true]);
    }

    private function refusal(string $text): JsonResponse
    {
        return response()->json(['refusal' => $text], 429);
    }

    private function sessionKey(Request $request): string
    {
        return 'assistant.day.'.now()->toDateString().'.'.sha1($request->session()->getId());
    }

    private function siteKey(): string
    {
        return 'assistant.day.'.now()->toDateString().'.site';
    }

    private function overSessionCap(Request $request): bool
    {
        return (int) Cache::get($this->sessionKey($request), 0) >= (int) config('hms.assistant.session_daily_cap');
    }

    private function overSiteCap(): bool
    {
        return (int) Cache::get($this->siteKey(), 0) >= (int) config('hms.assistant.site_daily_cap');
    }

    private function countSession(Request $request): void
    {
        Cache::add($this->sessionKey($request), 0, now()->addDay());
        Cache::increment($this->sessionKey($request));
    }

    private function countSite(): void
    {
        Cache::add($this->siteKey(), 0, now()->addDay());
        Cache::increment($this->siteKey());
    }
}
