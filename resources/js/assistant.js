// Site assistant widget. One POST per message, streamed back as server sent events.
// Everything the model returns is rendered as text, never as HTML.
export default function assistant() {
    return {
        open: false,
        busy: false,
        input: '',
        messages: [],
        suggestions: [
            'Is a dorm bed free this weekend?',
            'What time is check in?',
            'Do you have a private room for two?',
        ],
        error: null,
        controller: null,

        toggle() {
            this.open = !this.open
            if (this.open) this.$nextTick(() => this.$refs.input?.focus())
        },

        pick(text) {
            this.input = text
            this.send()
        },

        async send() {
            const text = this.input.trim()
            if (!text || this.busy) return
            if (text.length > 500) { this.error = 'Please keep it under 500 characters.'; return }
            this.error = null
            this.input = ''
            this.messages.push({ role: 'user', text })
            // Take the reactive proxy back out of the array; mutating the raw object would not render.
            const idx = this.messages.push({ role: 'assistant', text: '', pending: true, note: false }) - 1
            const reply = this.messages[idx]
            this.busy = true
            this.scroll()

            this.controller = new AbortController()
            try {
                const res = await fetch('/assistant', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'text/event-stream, application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                    body: JSON.stringify({ message: text }),
                    signal: this.controller.signal,
                    credentials: 'same-origin',
                })

                if (!res.ok || !res.body) {
                    let msg = 'The assistant could not answer just now. Please try again in a minute.'
                    try { const j = await res.json(); msg = j.refusal || (j.errors && Object.values(j.errors)[0][0]) || j.message || msg } catch {}
                    if (res.status === 429 && !msg) msg = 'Too many messages in a short time. Please wait a minute.'
                    reply.text = msg; reply.pending = false; reply.note = true
                    return
                }

                const reader = res.body.getReader()
                const decoder = new TextDecoder()
                let buffer = ''
                while (true) {
                    const { value, done } = await reader.read()
                    if (done) break
                    buffer += decoder.decode(value, { stream: true })
                    let idx
                    while ((idx = buffer.indexOf('\n\n')) >= 0) {
                        const chunk = buffer.slice(0, idx); buffer = buffer.slice(idx + 2)
                        for (const line of chunk.split('\n')) {
                            if (!line.startsWith('data: ')) continue
                            const payload = line.slice(6)
                            if (payload === '[DONE]') continue
                            try {
                                const ev = JSON.parse(payload)
                                if (typeof ev.delta === 'string' && /text/i.test(ev.type || '')) reply.text += ev.delta
                                else if (ev.type === 'error') { reply.text = reply.text || 'Something went wrong on our side. Please try again.'; reply.note = true }
                            } catch { /* ignore partial lines */ }
                        }
                        this.scroll()
                    }
                }
                if (!reply.text) { reply.text = 'I could not find an answer to that. The desk can help by email.'; reply.note = true }
            } catch (e) {
                if (e.name !== 'AbortError') { reply.text = 'The connection dropped. Please try again.'; reply.note = true }
            } finally {
                reply.pending = false
                this.busy = false
                this.controller = null
                this.scroll()
            }
        },

        stop() {
            this.controller?.abort()
        },

        scroll() {
            this.$nextTick(() => { const el = this.$refs.log; if (el) el.scrollTop = el.scrollHeight })
        },
    }
}
