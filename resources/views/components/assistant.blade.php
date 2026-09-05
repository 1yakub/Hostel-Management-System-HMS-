@if (config('hms.assistant.enabled'))
<div x-data="assistant()" class="fixed bottom-5 right-5 z-50 flex flex-col items-end gap-3 print:hidden">
    <section x-show="open" x-cloak x-transition.origin.bottom.right.duration.150ms role="dialog" aria-label="Ask the desk" @keydown.escape.window="open = false"
        class="flex h-[min(34rem,calc(100vh-7rem))] w-[min(24rem,calc(100vw-2.5rem))] flex-col overflow-hidden rounded-photo border border-rule bg-chalk shadow-lift">
        <header class="flex items-center justify-between border-b border-rule px-4 py-3">
            <div>
                <p class="font-semibold">Ask the desk</p>
                <p class="text-xs text-slate">Website assistant. Answers about beds, prices and the house. It cannot book for you.</p>
            </div>
            <button type="button" @click="open = false" class="rounded-control p-1.5 text-slate hover:bg-chalk-2 hover:text-ink" aria-label="Close">
                <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M6 6l12 12M18 6L6 18" /></svg>
            </button>
        </header>

        <div x-ref="log" class="flex-1 space-y-3 overflow-y-auto px-4 py-4 text-[0.95rem]" aria-live="polite">
            <template x-if="messages.length === 0">
                <div>
                    <p class="rounded-photo rounded-tl-sm bg-white px-3 py-2 text-ink">Hello. Ask about free beds, prices, check in or how to get here.</p>
                    <div class="mt-3 flex flex-wrap gap-2">
                        <template x-for="s in suggestions" :key="s">
                            <button type="button" @click="pick(s)" class="rounded-control border border-rule bg-white px-3 py-1.5 text-sm hover:border-fern-500 hover:text-fern-700" x-text="s"></button>
                        </template>
                    </div>
                </div>
            </template>
            <template x-for="(m, i) in messages" :key="i">
                <div :class="m.role === 'user' ? 'flex justify-end' : 'flex justify-start'">
                    <p class="max-w-[85%] whitespace-pre-wrap rounded-photo px-3 py-2"
                       :class="m.role === 'user' ? 'rounded-tr-sm bg-ink text-chalk' : (m.note ? 'rounded-tl-sm bg-marigold-100 text-ink' : 'rounded-tl-sm bg-white text-ink')">
                        <span x-text="m.text"></span><span x-show="m.pending && !m.text" class="inline-block w-6 text-slate" aria-label="Thinking">&hellip;</span>
                    </p>
                </div>
            </template>
        </div>

        <form @submit.prevent="send" class="border-t border-rule bg-white p-3">
            <div class="flex items-end gap-2">
                <label for="assistant-input" class="sr-only">Your question</label>
                <textarea id="assistant-input" x-ref="input" x-model="input" rows="1" maxlength="500" placeholder="Ask about a bed or the house"
                    @keydown.enter.prevent="send" :disabled="busy"
                    class="min-h-[2.75rem] flex-1 resize-none rounded-control border-rule bg-white px-3 py-2.5 text-base text-ink placeholder:text-slate-2 focus:border-fern-500 focus:ring-fern-500 disabled:bg-chalk-2"></textarea>
                <button type="submit" x-show="!busy" class="rounded-control bg-ink px-3.5 py-2.5 text-sm font-medium text-chalk hover:bg-ink-2 disabled:opacity-50" :disabled="!input.trim()">Send</button>
                <button type="button" x-show="busy" x-cloak @click="stop" class="rounded-control border border-rule bg-white px-3.5 py-2.5 text-sm font-medium hover:bg-chalk-2">Stop</button>
            </div>
            <p x-show="error" x-cloak class="mt-2 text-sm text-danger" x-text="error"></p>
            <p class="mt-2 text-xs text-slate">Answers come from a language model and can be wrong. For anything binding, ask the desk.</p>
        </form>
    </section>

    <button type="button" @click="toggle" :aria-expanded="open" aria-controls="assistant" class="flex items-center gap-2 rounded-control bg-ink px-4 py-3 text-sm font-medium text-chalk shadow-lift hover:bg-ink-2">
        <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true"><path d="M4 5h16v10H9l-5 4V5z" /></svg>
        <span x-text="open ? 'Close' : 'Ask the desk'"></span>
    </button>
</div>
@endif
