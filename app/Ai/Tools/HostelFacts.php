<?php

namespace App\Ai\Tools;

use Illuminate\Contracts\JsonSchema\JsonSchema;
use Illuminate\Support\Str;
use Laravel\Ai\Contracts\Tool;
use Laravel\Ai\Tools\Request;

class HostelFacts implements Tool
{
    public function description(): string
    {
        return 'Look up a practical fact about the hostel (hours, breakfast, payment, cancellation, lockers, Wi-Fi, directions, contact). Pass a short topic. Read only.';
    }

    public function schema(JsonSchema $schema): array
    {
        return [
            'topic' => $schema->string()->max(80)->description('What the visitor wants to know, a few words')->required(),
        ];
    }

    public function handle(Request $request): string
    {
        $data = $request->validate(['topic' => ['required', 'string', 'max:80']]);
        $topic = Str::lower($data['topic']);
        $words = collect(preg_split('/\W+/', $topic))->filter(fn ($w) => mb_strlen($w) > 2);

        $hits = collect(config('hms.faq'))->filter(function ($f) use ($words) {
            $hay = Str::lower($f['q'].' '.$f['a']);
            return $words->contains(fn ($w) => str_contains($hay, $w));
        })->map(fn ($f) => "{$f['q']} {$f['a']}")->take(3);

        $h = config('hms');
        $contact = "Desk: {$h['phone']}, {$h['email']}. Address: {$h['address_line']}, {$h['city']}. Check in from {$h['check_in']}, check out by {$h['check_out']}.";

        return $hits->isEmpty()
            ? "No note on that topic. Known facts: {$contact} If it is not covered here, the visitor should email the desk."
            : $hits->implode("\n")."\n".$contact;
    }
}
