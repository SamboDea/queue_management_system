<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Queue Display — NTTI-QMS</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link
        href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600&family=Space+Mono:wght@400;700&display=swap"
        rel="stylesheet">
    <style>
        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        :root {
            --bg: #080c12;
            --surface: #0e1520;
            --card: #111a27;
            --border: rgba(255, 255, 255, 0.07);
            --blue: #2d7dd2;
            --blue-dim: rgba(45, 125, 210, 0.15);
            --amber: #e8a838;
            --amber-dim: rgba(232, 168, 56, 0.12);
            --green: #2eb87e;
            --red: #e05252;
            --text: #eef2f7;
            --muted: rgba(255, 255, 255, 0.35);
            --faint: rgba(255, 255, 255, 0.08);
        }

        html,
        body {
            height: 100%;
            background: var(--bg);
            color: var(--text);
            font-family: 'Space Grotesk', sans-serif;
            overflow: hidden;
        }

        .layout {
            display: grid;
            grid-template-rows: 64px 1fr 44px;
            height: 100vh;
        }

        /* ── Header ── */
        .header {
            background: var(--surface);
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 28px;
        }

        .header-brand {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .brand-icon {
            width: 36px;
            height: 36px;
            background: var(--blue);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Space Mono', monospace;
            font-size: 13px;
            font-weight: 700;
            color: #fff;
        }

        .brand-text {
            font-size: 15px;
            font-weight: 500;
            letter-spacing: 0.03em;
        }

        .brand-sub {
            font-size: 11px;
            color: var(--muted);
            margin-top: 1px;
        }

        .header-clock {
            text-align: right;
        }

        .clock-time {
            font-family: 'Space Mono', monospace;
            font-size: 24px;
            font-weight: 700;
            letter-spacing: 0.06em;
            line-height: 1;
        }

        .clock-date {
            font-size: 11px;
            color: var(--muted);
            margin-top: 3px;
            letter-spacing: 0.04em;
        }

        /* ── Body ── */
        .body {
            display: grid;
            grid-template-columns: 1fr 300px;
            overflow: hidden;
        }

        /* ── Left ── */
        .left {
            padding: 20px;
            display: flex;
            flex-direction: column;
            gap: 16px;
            overflow: hidden;
        }

        .section-title {
            font-size: 10px;
            font-weight: 500;
            letter-spacing: 0.16em;
            text-transform: uppercase;
            color: var(--muted);
            margin-bottom: 10px;
        }

        /* Counter grid */
        .counters {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 10px;
        }

        .counter-card {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 14px 16px;
            position: relative;
            overflow: hidden;
            transition: border-color 0.3s, box-shadow 0.3s;
        }

        .counter-card.active {
            border-color: rgba(45, 125, 210, 0.4);
        }

        .counter-card.active::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: var(--blue);
        }

        .counter-card.busy {
            border-color: rgba(232, 168, 56, 0.35);
        }

        .counter-card.busy::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: var(--amber);
        }

        .counter-card.closed {
            opacity: 0.4;
        }

        /* Flash animation when new ticket is called */
        .counter-card.flash {
            animation: flashCard 1.2s ease;
        }

        @keyframes flashCard {
            0% {
                box-shadow: 0 0 0 0 rgba(45, 125, 210, 0.9);
            }

            50% {
                box-shadow: 0 0 0 14px rgba(45, 125, 210, 0.25);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(45, 125, 210, 0);
            }
        }

        .counter-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .counter-label {
            font-size: 11px;
            color: var(--muted);
            letter-spacing: 0.05em;
        }

        .status-pill {
            font-size: 9px;
            font-weight: 500;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            padding: 2px 8px;
            border-radius: 999px;
        }

        .status-pill.active {
            background: var(--blue-dim);
            color: #5ba8f5;
            border: 1px solid rgba(45, 125, 210, 0.3);
        }

        .status-pill.busy {
            background: var(--amber-dim);
            color: #f0c060;
            border: 1px solid rgba(232, 168, 56, 0.3);
        }

        .status-pill.closed {
            background: var(--faint);
            color: var(--muted);
            border: 1px solid var(--border);
        }

        .counter-ticket {
            font-family: 'Space Mono', monospace;
            font-size: 40px;
            font-weight: 700;
            line-height: 1;
            letter-spacing: -1px;
        }

        .counter-ticket.active {
            color: #5ba8f5;
        }

        .counter-ticket.busy {
            color: #f0c060;
        }

        .counter-ticket.closed {
            font-size: 14px;
            color: var(--muted);
            padding-top: 10px;
        }

        .counter-ticket.empty {
            font-size: 14px;
            color: var(--muted);
            padding-top: 10px;
        }

        .counter-foot {
            margin-top: 8px;
            font-size: 11px;
            color: var(--muted);
        }

        /* Now serving strip */
        .now-serving {
            background: var(--card);
            border: 1px solid rgba(45, 125, 210, 0.25);
            border-radius: 12px;
            padding: 16px 18px;
            flex: 1;
        }

        .serving-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 8px;
            margin-top: 4px;
        }

        .serving-cell {
            background: var(--surface);
            border-radius: 8px;
            padding: 10px 12px;
            display: flex;
            flex-direction: column;
            gap: 4px;
            transition: background 0.3s;
        }

        .serving-cell.new-call {
            animation: highlightCell 2s ease;
        }

        @keyframes highlightCell {
            0% {
                background: rgba(45, 125, 210, 0.4);
            }

            100% {
                background: var(--surface);
            }
        }

        .serving-cell-label {
            font-size: 10px;
            color: var(--muted);
        }

        .serving-cell-ticket {
            font-family: 'Space Mono', monospace;
            font-size: 22px;
            font-weight: 700;
            color: var(--text);
        }

        .live-dot {
            display: inline-block;
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: var(--blue);
            margin-right: 6px;
            animation: live-blink 1.6s ease-in-out infinite;
        }

        @keyframes live-blink {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.2;
            }
        }

        /* ── Right ── */
        .right {
            border-left: 1px solid var(--border);
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        .right-top {
            flex: 1;
            padding: 20px;
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }

        .waiting-list {
            flex: 1;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            gap: 5px;
            scrollbar-width: none;
        }

        .waiting-list::-webkit-scrollbar {
            display: none;
        }

        .waiting-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 9px 12px;
            border-radius: 8px;
            background: var(--faint);
        }

        .waiting-row.is-next {
            background: var(--blue-dim);
            border: 1px solid rgba(45, 125, 210, 0.3);
        }

        .waiting-ticket {
            font-family: 'Space Mono', monospace;
            font-size: 16px;
            font-weight: 700;
            color: var(--text);
        }

        .waiting-row.is-next .waiting-ticket {
            color: #5ba8f5;
        }

        .waiting-meta {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .next-badge {
            font-size: 9px;
            font-weight: 500;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            background: var(--blue);
            color: #fff;
            padding: 2px 7px;
            border-radius: 4px;
        }

        .wait-est {
            font-size: 11px;
            color: var(--muted);
        }

        /* Stats */
        .right-stats {
            padding: 16px;
            border-top: 1px solid var(--border);
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 8px;
        }

        .stat-card {
            background: var(--card);
            border-radius: 8px;
            padding: 12px;
            border: 1px solid var(--border);
            text-align: center;
        }

        .stat-num {
            font-family: 'Space Mono', monospace;
            font-size: 24px;
            font-weight: 700;
            color: var(--text);
        }

        .stat-label {
            font-size: 10px;
            color: var(--muted);
            margin-top: 3px;
            letter-spacing: 0.04em;
        }

        /* Category badges */
        .cat-badge {
            display: inline-block;
            font-size: 10px;
            font-weight: 500;
            padding: 1px 6px;
            border-radius: 4px;
            font-family: 'Space Mono', monospace;
        }

        .cat-A {
            background: rgba(45, 125, 210, 0.2);
            color: #5ba8f5;
        }

        .cat-B {
            background: rgba(232, 168, 56, 0.18);
            color: #f0c060;
        }

        .cat-C {
            background: rgba(46, 184, 126, 0.18);
            color: #4fd49e;
        }

        /* ── Ticker ── */
        .ticker {
            background: var(--surface);
            border-top: 1px solid var(--border);
            height: 44px;
            display: flex;
            align-items: center;
            overflow: hidden;
            gap: 0;
        }

        .ticker-tag {
            flex-shrink: 0;
            background: var(--blue);
            color: #fff;
            font-size: 10px;
            font-weight: 500;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            padding: 0 16px;
            height: 100%;
            display: flex;
            align-items: center;
        }

        .ticker-scroll {
            flex: 1;
            overflow: hidden;
            position: relative;
        }

        .ticker-inner {
            white-space: nowrap;
            font-size: 12px;
            color: var(--muted);
            animation: ticker-move 30s linear infinite;
            display: inline-block;
            padding-left: 100%;
        }

        @keyframes ticker-move {
            0% {
                transform: translateX(0);
            }

            100% {
                transform: translateX(-50%);
            }
        }

        /* ── Toast notification ── */
        .toast-wrap {
            position: fixed;
            top: 80px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 9999;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 10px;
        }

        .toast-item {
            background: #1a2e47;
            border: 1px solid rgba(45, 125, 210, 0.5);
            border-radius: 14px;
            padding: 16px 28px;
            display: flex;
            align-items: center;
            gap: 16px;
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.6);
            min-width: 340px;
            animation: toastIn 0.4s cubic-bezier(0.16, 1, 0.3, 1) both;
        }

        .toast-item.out {
            animation: toastOut 0.4s ease forwards;
        }

        @keyframes toastIn {
            from {
                opacity: 0;
                transform: translateY(-20px) scale(0.95);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        @keyframes toastOut {
            from {
                opacity: 1;
                transform: translateY(0) scale(1);
            }

            to {
                opacity: 0;
                transform: translateY(-20px) scale(0.95);
            }
        }

        .toast-icon {
            width: 48px;
            height: 48px;
            background: var(--blue-dim);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            flex-shrink: 0;
        }

        .toast-counter {
            font-size: 12px;
            color: var(--muted);
            margin-bottom: 2px;
        }

        .toast-ticket {
            font-family: 'Space Mono', monospace;
            font-size: 36px;
            font-weight: 700;
            color: #5ba8f5;
            line-height: 1;
        }

        .toast-label {
            font-size: 12px;
            color: var(--muted);
            margin-top: 3px;
        }
    </style>
</head>

<body>
    <div class="layout">

        {{-- ── Header ── --}}
        <header class="header">
            <div class="header-brand">
                <div class="brand-icon">Q</div>
                <div>
                    <div class="brand-text">NTTI-QMS</div>
                    <div class="brand-sub">Queue Management System</div>
                </div>
            </div>
            <div class="header-clock">
                <div class="clock-time" id="clock">--:--:--</div>
                <div class="clock-date" id="date-line">--</div>
            </div>
        </header>

        {{-- ── Body ── --}}
        <div class="body">

            {{-- Left panel --}}
            <div class="left">

                {{-- Counters --}}
                <div>
                    <div class="section-title">Counter status</div>
                    <div class="counters" id="counters-grid">
                        @foreach ($counters as $counter)
                            <div class="counter-card {{ $counter->status }}" id="counter-{{ $counter->id }}"
                                data-ticket="{{ $counter->current_ticket }}">
                                <div class="counter-head">
                                    <span class="counter-label">{{ $counter->name }}</span>
                                    <span class="status-pill {{ $counter->status }}">
                                        {{ ucfirst($counter->status) }}
                                    </span>
                                </div>
                                @if ($counter->status !== 'closed' && $counter->current_ticket)
                                    <div class="counter-ticket {{ $counter->status }}">
                                        {{ $counter->current_ticket }}
                                    </div>
                                    <div class="counter-foot">Serving now</div>
                                @elseif ($counter->status === 'closed')
                                    <div class="counter-ticket closed">Closed</div>
                                    <div class="counter-foot">Offline</div>
                                @else
                                    <div class="counter-ticket empty">Waiting...</div>
                                    <div class="counter-foot">Ready</div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Now serving strip --}}
                <div class="now-serving">
                    <div class="section-title">
                        <span class="live-dot"></span>Now serving
                    </div>
                    <div class="serving-grid" id="serving-grid">
                        @forelse ($serving as $s)
                            <div class="serving-cell">
                                <span class="serving-cell-label">{{ optional($s->counter)->name ?? '—' }}</span>
                                <span class="serving-cell-ticket">{{ $s->ticket_number }}</span>
                            </div>
                        @empty
                            <div class="serving-cell" style="grid-column: span 4;">
                                <span class="serving-cell-label" style="font-size:13px">No tickets being served</span>
                            </div>
                        @endforelse
                    </div>
                </div>

            </div>

            {{-- Right panel --}}
            <div class="right">
                <div class="right-top">
                    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:12px">
                        <div class="section-title" style="margin:0">Waiting queue</div>
                        <span style="font-size:11px;color:var(--muted)" id="waiting-count">
                            {{ $waiting->count() }} in queue
                        </span>
                    </div>

                    <div class="waiting-list" id="waiting-list">
                        @forelse ($waiting as $i => $q)
                            <div class="waiting-row {{ $i === 0 ? 'is-next' : '' }}">
                                <div style="display:flex;align-items:center;gap:8px">
                                    <span class="cat-badge cat-{{ $q->category }}">{{ $q->category }}</span>
                                    <span class="waiting-ticket">{{ $q->ticket_number }}</span>
                                </div>
                                <div class="waiting-meta">
                                    @if ($i === 0)
                                        <span class="next-badge">Next</span>
                                    @else
                                        <span class="wait-est">~{{ $i * 2 }} min</span>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div style="text-align:center;padding:32px 0;color:var(--muted);font-size:13px">
                                Queue is empty
                            </div>
                        @endforelse
                    </div>
                </div>

                <div class="right-stats">
                    <div class="stat-card">
                        <div class="stat-num" id="stat-served">{{ $servedToday }}</div>
                        <div class="stat-label">Served today</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-num">{{ $avgWait ? round($avgWait) . 'm' : '—' }}</div>
                        <div class="stat-label">Avg wait</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-num" id="stat-waiting">{{ $waiting->count() }}</div>
                        <div class="stat-label">Waiting</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-num">{{ $counters->where('status', '!=', 'closed')->count() }}</div>
                        <div class="stat-label">Open counters</div>
                    </div>
                </div>
            </div>

        </div>

        {{-- ── Ticker ── --}}
        <div class="ticker">
            <div class="ticker-tag">Notice</div>
            <div class="ticker-scroll">
                <div class="ticker-inner">
                    Welcome to NTTI-QMS &nbsp;&nbsp;&nbsp;&nbsp;
                    Please keep your ticket number ready &nbsp;&nbsp;&nbsp;&nbsp;
                    Category A — General Services &nbsp;&nbsp; Category B — Finance &nbsp;&nbsp; Category C — VIP
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    Operating hours: Monday – Friday, 08:00 – 17:00 &nbsp;&nbsp;&nbsp;&nbsp;
                    Thank you for your patience &nbsp;&nbsp;&nbsp;&nbsp;
                    Welcome to NTTI-QMS &nbsp;&nbsp;&nbsp;&nbsp;
                    Please keep your ticket number ready &nbsp;&nbsp;&nbsp;&nbsp;
                    Category A — General Services &nbsp;&nbsp; Category B — Finance &nbsp;&nbsp; Category C — VIP
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    Operating hours: Monday – Friday, 08:00 – 17:00 &nbsp;&nbsp;&nbsp;&nbsp;
                    Thank you for your patience
                </div>
            </div>
        </div>

    </div>

    {{-- Toast container --}}
    <div class="toast-wrap" id="toast-wrap"></div>

    <script>
        // ── Clock ─────────────────────────────────────────────────────────────────
        function tick() {
            const now = new Date();
            const pad = n => String(n).padStart(2, '0');
            document.getElementById('clock').textContent =
                pad(now.getHours()) + ':' + pad(now.getMinutes()) + ':' + pad(now.getSeconds());

            const days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
            const months = ['January', 'February', 'March', 'April', 'May', 'June',
                'July', 'August', 'September', 'October', 'November', 'December'
            ];
            document.getElementById('date-line').textContent =
                days[now.getDay()] + ', ' + now.getDate() + ' ' + months[now.getMonth()] + ' ' + now.getFullYear();
        }
        tick();
        setInterval(tick, 1000);

        // ── Sound Engine (Web Audio API — no file needed) ─────────────────────────
        const AudioCtx = window.AudioContext || window.webkitAudioContext;
        let audioCtx = null;

        function getAudioCtx() {
            if (!audioCtx) audioCtx = new AudioCtx();
            return audioCtx;
        }

        function playCallSound() {
            try {
                const ctx = getAudioCtx();
                const tones = [880, 1100, 880];

                tones.forEach((freq, i) => {
                    const osc = ctx.createOscillator();
                    const gain = ctx.createGain();

                    osc.connect(gain);
                    gain.connect(ctx.destination);

                    osc.type = 'sine';
                    osc.frequency.setValueAtTime(freq, ctx.currentTime + i * 0.18);

                    gain.gain.setValueAtTime(0, ctx.currentTime + i * 0.18);
                    gain.gain.linearRampToValueAtTime(0.4, ctx.currentTime + i * 0.18 + 0.02);
                    gain.gain.exponentialRampToValueAtTime(0.001, ctx.currentTime + i * 0.18 + 0.3);

                    osc.start(ctx.currentTime + i * 0.18);
                    osc.stop(ctx.currentTime + i * 0.18 + 0.35);
                });
            } catch (e) {
                console.warn('Sound error:', e);
            }
        }

        // ── Text-to-Speech announcement ───────────────────────────────────────────
        function announceTicket(ticket, counterName) {
            if (!window.speechSynthesis) return;
            window.speechSynthesis.cancel();

            const text = `Number ${ticket.split('').join(' ')}, please proceed to ${counterName}`;
            const utter = new SpeechSynthesisUtterance(text);
            utter.lang = 'en-US';
            utter.rate = 0.85;
            utter.pitch = 1;
            utter.volume = 1;

            window.speechSynthesis.speak(utter);
        }

        // ── Toast notification ────────────────────────────────────────────────────
        function showToast(ticket, counterName) {
            const wrap = document.getElementById('toast-wrap');
            const el = document.createElement('div');
            el.className = 'toast-item';
            el.innerHTML = `
                <div class="toast-icon">🔔</div>
                <div>
                    <div class="toast-counter">${counterName}</div>
                    <div class="toast-ticket">${ticket}</div>
                    <div class="toast-label">Please proceed to counter</div>
                </div>
            `;
            wrap.appendChild(el);

            setTimeout(() => {
                el.classList.add('out');
                setTimeout(() => el.remove(), 400);
            }, 5000);
        }

        // ── Track serving state to detect new calls ───────────────────────────────
        let prevServing = {};

        @foreach ($serving as $s)
            prevServing[{{ $s->counter_id ?? 0 }}] = '{{ $s->ticket_number }}';
        @endforeach

        // ── Live polling every 4 seconds ──────────────────────────────────────────
        async function refreshData() {
            try {
                const res = await fetch('{{ route('queue.live-data') }}');
                const data = await res.json();

                // ── Update counter cards ─────────────────────────────────────────
                data.counters.forEach(counter => {
                    const card = document.getElementById('counter-' + counter.id);
                    if (!card) return;

                    const oldTicket = card.dataset.ticket;
                    const newTicket = counter.current_ticket;

                    // Detect new ticket → play sound + announce + toast + flash
                    if (newTicket && newTicket !== oldTicket) {
                        playCallSound();
                        announceTicket(newTicket, counter.name);
                        showToast(newTicket, counter.name);

                        card.classList.remove('flash');
                        void card.offsetWidth; // force reflow
                        card.classList.add('flash');
                        setTimeout(() => card.classList.remove('flash'), 1200);
                    }

                    card.dataset.ticket = newTicket || '';
                    card.className = 'counter-card ' + counter.status;

                    const ticketEl = card.querySelector('.counter-ticket');
                    const footEl = card.querySelector('.counter-foot');
                    const pillEl = card.querySelector('.status-pill');

                    if (pillEl) {
                        pillEl.className = 'status-pill ' + counter.status;
                        pillEl.textContent = counter.status.charAt(0).toUpperCase() + counter.status.slice(1);
                    }

                    if (counter.status === 'closed') {
                        if (ticketEl) {
                            ticketEl.className = 'counter-ticket closed';
                            ticketEl.textContent = 'Closed';
                        }
                        if (footEl) footEl.textContent = 'Offline';
                    } else if (newTicket) {
                        if (ticketEl) {
                            ticketEl.className = 'counter-ticket ' + counter.status;
                            ticketEl.textContent = newTicket;
                        }
                        if (footEl) footEl.textContent = 'Serving now';
                    } else {
                        if (ticketEl) {
                            ticketEl.className = 'counter-ticket empty';
                            ticketEl.textContent = 'Waiting...';
                        }
                        if (footEl) footEl.textContent = 'Ready';
                    }
                });

                // ── Update now-serving grid ──────────────────────────────────────
                const servingGrid = document.getElementById('serving-grid');
                if (data.serving.length === 0) {
                    servingGrid.innerHTML = `
                        <div class="serving-cell" style="grid-column:span 4">
                            <span class="serving-cell-label" style="font-size:13px">No tickets being served</span>
                        </div>`;
                } else {
                    servingGrid.innerHTML = data.serving.map(s => `
                        <div class="serving-cell ${prevServing[s.counter_id] !== s.ticket_number ? 'new-call' : ''}">
                            <span class="serving-cell-label">${s.counter ? s.counter.name : '—'}</span>
                            <span class="serving-cell-ticket">${s.ticket_number}</span>
                        </div>
                    `).join('');
                }

                // Update prevServing map
                prevServing = {};
                data.serving.forEach(s => {
                    prevServing[s.counter_id] = s.ticket_number;
                });

                // ── Update waiting list ──────────────────────────────────────────
                const list = document.getElementById('waiting-list');
                if (data.waiting.length === 0) {
                    list.innerHTML =
                        `<div style="text-align:center;padding:32px 0;color:var(--muted);font-size:13px">Queue is empty</div>`;
                } else {
                    list.innerHTML = data.waiting.map((q, i) => `
                        <div class="waiting-row ${i === 0 ? 'is-next' : ''}">
                            <div style="display:flex;align-items:center;gap:8px">
                                <span class="cat-badge cat-${q.category}">${q.category}</span>
                                <span class="waiting-ticket">${q.ticket_number}</span>
                            </div>
                            <div class="waiting-meta">
                                ${i === 0
                                    ? '<span class="next-badge">Next</span>'
                                    : `<span class="wait-est">~${i * 2} min</span>`
                                }
                            </div>
                        </div>
                    `).join('');
                }

                // ── Update stats ─────────────────────────────────────────────────
                document.getElementById('stat-served').textContent = data.served_today;
                document.getElementById('stat-waiting').textContent = data.waiting.length;
                document.getElementById('waiting-count').textContent = data.waiting.length + ' in queue';

            } catch (e) {
                console.warn('Queue refresh failed:', e);
            }
        }

        // Unlock AudioContext on first user interaction (browser policy)
        document.addEventListener('click', () => getAudioCtx(), {
            once: true
        });

        // Start polling every 4 seconds
        setInterval(refreshData, 4000);
    </script>
</body>

</html>
