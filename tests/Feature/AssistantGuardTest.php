<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

/**
 * The guards in front of the model. None of these tests reach Vertex: every path here is
 * rejected before a token is minted, which is exactly the point.
 */
class AssistantGuardTest extends TestCase
{
    use RefreshDatabase;

    public function test_message_is_required_and_capped(): void
    {
        $this->postJson('/assistant', ['message' => ''])->assertStatus(422);
        $this->postJson('/assistant', ['message' => str_repeat('a', 501)])->assertStatus(422);
    }


    public function test_per_visitor_burst_limit_applies(): void
    {
        $limit = (int) config('hms.assistant.per_minute');
        // Burn the per minute budget with invalid payloads (validation runs after throttling? No:
        // throttle middleware runs first, so 422s still count).
        for ($i = 0; $i < $limit; $i++) {
            $this->withSession([])->postJson('/assistant', ['message' => ''])->assertStatus(422);
        }
        $this->postJson('/assistant', ['message' => ''])->assertStatus(429);
    }

    public function test_site_wide_daily_cap_turns_the_assistant_off(): void
    {
        Cache::put('assistant.day.'.now()->toDateString().'.site', (int) config('hms.assistant.site_daily_cap'), now()->addDay());

        $this->postJson('/assistant', ['message' => 'Is a bed free tonight?'])
            ->assertStatus(429)
            ->assertJsonFragment(['refusal' => 'The assistant is resting for today. Please use the availability search or write to the desk.']);
    }

    public function test_assistant_is_absent_when_disabled(): void
    {
        config(['hms.assistant.enabled' => false]);

        $this->get('/')->assertOk()->assertDontSee('Ask the desk');
    }

    public function test_get_is_not_allowed(): void
    {
        $this->get('/assistant')->assertStatus(405);
    }
}
