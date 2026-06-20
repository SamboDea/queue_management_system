<!DOCTYPE html>
<html lang="km">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ចុចចាប់លេខរងចាំ</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Battambang:wght@400;700&family=Inter:wght@400;500;600&display=swap');

        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        :root {
            --red: #E14B4B;
            --red-lt: #FEE2E2;
            --red-dk: #B91C1C;
            --blue-lt: #EEF2FF;
            --blue-dk: #1D4ED8;
            --green: #22C55E;
            --green-lt: #DCFCE7;
            --green-dk: #166534;
            --amber-lt: #FEF9C3;
            --amber-dk: #92400E;
            --gray-50: #F9FAFB;
            --gray-100: #F3F4F6;
            --gray-200: #E5E7EB;
            --gray-400: #9CA3AF;
            --gray-600: #4B5563;
            --gray-800: #1F2937;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: #F0F4FF;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 2rem 1rem 4rem;
            color: var(--gray-800);
        }

        .topbar {
            width: 100%;
            max-width: 640px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .app-label {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
            font-weight: 600;
            color: var(--red);
            letter-spacing: .04em;
            text-transform: uppercase;
        }

        .app-label .dot {
            width: 28px;
            height: 28px;
            border-radius: 8px;
            background: var(--red);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .card {
            width: 100%;
            max-width: 640px;
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, .10);
            overflow: hidden;
        }

        .card-header {
            background: linear-gradient(135deg, #E14B4B 0%, #C0392B 100%);
            padding: 1.5rem 1.75rem 1.25rem;
            color: #fff;
        }

        .card-header .eyebrow {
            font-size: 11px;
            font-weight: 600;
            letter-spacing: .08em;
            text-transform: uppercase;
            opacity: .8;
            margin-bottom: 6px;
        }

        .card-header h1 {
            font-family: 'Battambang', serif;
            font-size: 22px;
            font-weight: 700;
            line-height: 1.3;
            margin-bottom: 4px;
        }

        .card-header .sub {
            font-size: 13px;
            opacity: .75;
        }

        .tasks {
            padding: 1rem 1.25rem 1.25rem;
        }

        .section-head {
            font-size: 11px;
            font-weight: 600;
            color: var(--gray-400);
            letter-spacing: .07em;
            text-transform: uppercase;
            padding: 0 .5rem;
            margin-bottom: 8px;
            margin-top: 4px;
        }

        .task {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            padding: 14px 16px;
            border-radius: 10px;
            border: 1.5px solid var(--gray-200);
            background: #fff;
            margin-bottom: 10px;
            cursor: pointer;
            transition: border-color .15s, background .15s, box-shadow .15s;
            user-select: none;
        }

        .task:hover {
            border-color: #93C5FD;
            box-shadow: 0 2px 8px rgba(59, 130, 246, .12);
        }

        .task.done {
            background: var(--gray-50);
            border-color: var(--gray-200);
            pointer-events: none;
        }

        .task.loading {
            opacity: .6;
            pointer-events: none;
        }

        .tick {
            flex-shrink: 0;
            width: 38px;
            height: 38px;
            margin-top: 2px;
            border-radius: 50%;
            border: 2px solid #D1D5DB;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background .2s, border-color .2s;
            background: #fff;
            font-size: 16px;
            font-weight: 700;
            color: var(--gray-400);
        }

        .task.done .tick {
            background: var(--green);
            border-color: var(--green);
            color: #fff;
        }

        .task-body {
            flex: 1;
            min-width: 0;
        }

        .task-km {
            font-family: 'Battambang', serif;
            font-size: 16px;
            line-height: 1.5;
            color: var(--gray-800);
        }

        .task.done .task-km {
            text-decoration: line-through;
            color: var(--gray-400);
        }

        .task-en {
            font-size: 11px;
            color: var(--gray-400);
            margin-top: 1px;
        }

        .badge {
            flex-shrink: 0;
            align-self: flex-start;
            font-size: 11px;
            font-weight: 600;
            padding: 4px 12px;
            border-radius: 20px;
        }

        .badge-red {
            background: var(--red-lt);
            color: var(--red-dk);
        }

        .badge-blue {
            background: var(--blue-lt);
            color: var(--blue-dk);
        }

        .badge-amber {
            background: var(--amber-lt);
            color: var(--amber-dk);
        }

        .badge-green {
            background: var(--green-lt);
            color: var(--green-dk);
        }

        .card-footer {
            border-top: 1px solid var(--gray-100);
            padding: .875rem 1.75rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: var(--gray-50);
        }

        .footer-note {
            font-size: 12px;
            color: var(--gray-400);
        }

        /* RECEIPT OVERLAY */
        #receipt-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, .55);
            backdrop-filter: blur(3px);
            z-index: 100;
            align-items: center;
            justify-content: center;
        }

        #receipt-overlay.show {
            display: flex;
        }

        #receipt {
            background: #fff;
            border-radius: 12px;
            width: 340px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0, 0, 0, .25);
            animation: pop .2s cubic-bezier(.34, 1.56, .64, 1);
        }

        @keyframes pop {
            from {
                transform: scale(.85);
                opacity: 0;
            }

            to {
                transform: scale(1);
                opacity: 1;
            }
        }

        .receipt-top {
            background: linear-gradient(135deg, #E14B4B, #C0392B);
            padding: 1.25rem 1.5rem 1rem;
            color: #fff;
            text-align: center;
        }

        .receipt-top .school-name {
            font-size: 11px;
            font-weight: 600;
            letter-spacing: .08em;
            text-transform: uppercase;
            opacity: .8;
            margin-bottom: 4px;
        }

        .receipt-top .receipt-title {
            font-family: 'Battambang', serif;
            font-size: 18px;
            font-weight: 700;
        }

        .receipt-body {
            padding: 1.25rem 1.5rem;
        }

        .queue-box {
            text-align: center;
            margin-bottom: 1rem;
            padding: .875rem;
            background: var(--gray-50);
            border-radius: 10px;
            border: 1.5px dashed var(--gray-200);
        }

        .queue-label {
            font-size: 10px;
            font-weight: 600;
            color: var(--gray-400);
            letter-spacing: .08em;
            text-transform: uppercase;
            margin-bottom: 4px;
        }

        .queue-number {
            font-size: 52px;
            font-weight: 700;
            color: var(--red);
            line-height: 1;
            letter-spacing: -2px;
        }

        .queue-sub {
            font-size: 11px;
            color: var(--gray-400);
            margin-top: 4px;
        }

        .receipt-row {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            padding: 7px 0;
            border-bottom: 1px solid var(--gray-100);
            font-size: 12px;
            gap: 8px;
        }

        .receipt-row:last-of-type {
            border-bottom: none;
        }

        .receipt-row .lbl {
            color: var(--gray-400);
            font-weight: 500;
            white-space: nowrap;
        }

        .receipt-row .val {
            color: var(--gray-800);
            font-weight: 500;
            text-align: right;
            font-family: 'Battambang', serif;
            font-size: 13px;
            line-height: 1.4;
        }

        .receipt-row .val.en {
            font-family: 'Inter', sans-serif;
            font-size: 12px;
        }

        .receipt-barcode {
            text-align: center;
            margin: 1rem 0 .5rem;
            font-size: 9px;
            color: #D1D5DB;
            letter-spacing: .06em;
        }

        .barcode-lines {
            display: flex;
            justify-content: center;
            gap: 2px;
            height: 36px;
            margin-bottom: 4px;
        }

        .barcode-lines span {
            display: block;
            background: var(--gray-800);
            border-radius: 1px;
        }

        .receipt-actions {
            display: flex;
            gap: 8px;
            padding: 0 1.5rem 1.25rem;
        }

        .btn-print {
            flex: 1;
            padding: 10px;
            border-radius: 8px;
            background: var(--gray-800);
            color: #fff;
            border: none;
            font-family: inherit;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            transition: opacity .15s;
        }

        .btn-print:hover {
            opacity: .85;
        }

        .btn-close {
            padding: 10px 16px;
            border-radius: 8px;
            background: var(--gray-100);
            color: var(--gray-600);
            border: none;
            font-family: inherit;
            font-size: 13px;
            font-weight: 500;
            cursor: pointer;
        }

        .btn-close:hover {
            background: var(--gray-200);
        }

        /* PRINT */
        @media print {
            body>*:not(#print-area) {
                display: none !important;
            }

            #print-area {
                display: block !important;
                font-family: 'Inter', sans-serif;
            }

            #print-area .pr-wrap {
                width: 80mm;
                margin: 0 auto;
                font-size: 12px;
                color: #000;
                padding: 8mm 6mm;
            }

            .pr-center {
                text-align: center;
                margin-bottom: 6mm;
            }

            .pr-school {
                font-size: 10px;
                letter-spacing: .06em;
                text-transform: uppercase;
                color: #555;
                margin-bottom: 3mm;
            }

            .pr-title {
                font-size: 16px;
                font-weight: 700;
                margin-bottom: 1mm;
            }

            .pr-divider {
                border: none;
                border-top: 1px dashed #999;
                margin: 4mm 0;
            }

            .pr-queue-label {
                font-size: 9px;
                letter-spacing: .08em;
                text-transform: uppercase;
                color: #888;
                margin-bottom: 2mm;
            }

            .pr-queue-num {
                font-size: 56px;
                font-weight: 700;
                color: #000;
                line-height: 1;
                letter-spacing: -3px;
                margin-bottom: 2mm;
            }

            .pr-queue-sub {
                font-size: 10px;
                color: #777;
            }

            .pr-row {
                display: flex;
                justify-content: space-between;
                padding: 2mm 0;
                border-bottom: 1px solid #eee;
                font-size: 11px;
                gap: 4mm;
            }

            .pr-row:last-child {
                border-bottom: none;
            }

            .pr-lbl {
                color: #888;
            }

            .pr-val {
                font-weight: 600;
                text-align: right;
            }

            .pr-barcode {
                text-align: center;
                margin: 4mm 0 2mm;
                font-size: 8px;
                color: #bbb;
            }

            .pr-bar-lines {
                display: flex;
                justify-content: center;
                gap: 2px;
                height: 10mm;
                margin-bottom: 2mm;
            }

            .pr-bar-lines span {
                display: block;
                background: #000;
                border-radius: 1px;
            }

            .pr-footer {
                text-align: center;
                font-size: 9px;
                color: #aaa;
                margin-top: 4mm;
            }
        }

        #print-area {
            display: none;
        }

    </style>
</head>
<body>

    <div class="topbar">
        <div class="app-label">
            <div class="dot">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="9 11 12 14 22 4" />
                    <path d="M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11" />
                </svg>
            </div>
            Queue System
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <div class="eyebrow">School Enrollment · ចុះឈ្មះចូលរៀន</div>
            <h1>ចុចចាប់លេខរងចាំ</h1>
            <div class="sub">ចុចលើប្រភេទ → ទទួលប័ណ្ណរង់ចាំ · Click a category → Get your queue ticket</div>
        </div>

        <div class="tasks">
            <div class="section-head">📋 ជ្រើសប្រភេទសេវា · Select Service</div>

            {{-- Category A --}}
            <div class="task" data-category="A" data-km="សួរព័ត៌មានចុះឈ្មះចូលរៀន" data-en="Inquire about enrollment information" data-desk="តុ A · Desk A" data-badge="badge-red" onclick="takeQueue(this)">
                <div class="tick">A</div>
                <div class="task-body">
                    <div class="task-km">សួរព័ត៌មានចុះឈ្មះចូលរៀន</div>
                    <div class="task-en">Inquire about enrollment information · Desk A</div>
                </div>
                <span class="badge badge-red">ប្រភេទ A</span>
            </div>

            {{-- Category B --}}
            <div class="task" data-category="B" data-km="ទិញពាក្យចូលរៀន" data-en="Purchase application form" data-desk="តុ B · Desk B" data-badge="badge-blue" onclick="takeQueue(this)">
                <div class="tick">B</div>
                <div class="task-body">
                    <div class="task-km">ទិញពាក្យចូលរៀន</div>
                    <div class="task-en">Purchase application form · Desk B</div>
                </div>
                <span class="badge badge-blue">ប្រភេទ B</span>
            </div>

            {{-- Category C --}}
            <div class="task" data-category="C" data-km="ទិញពាក្យចុះឈ្មះ" data-en="Purchase registration form" data-desk="តុ C · Desk C" data-badge="badge-amber" onclick="takeQueue(this)">
                <div class="tick">C</div>
                <div class="task-body">
                    <div class="task-km">ទិញពាក្យចុះឈ្មះ</div>
                    <div class="task-en">Purchase registration form · Desk C</div>
                </div>
                <span class="badge badge-amber">ប្រភេទ C</span>
            </div>
        </div>

        <div class="card-footer">
            <span class="footer-note" id="footer-note">☐ ចុចលើប្រភេទ ដើម្បីទទួលប័ណ្ណរង់ចាំ</span>
        </div>
    </div>

    {{-- RECEIPT OVERLAY --}}
    <div id="receipt-overlay" onclick="closeOnBg(event)">
        <div id="receipt">
            <div class="receipt-top">
                <div class="school-name">🏫 វិទ្យាស្ថាន · School</div>
                <div class="receipt-title">ប័ណ្ណរង់ចាំ · Waiting Receipt</div>
            </div>
            <div class="receipt-body">
                <div class="queue-box">
                    <div class="queue-label">លេខរង់ចាំ · Queue No.</div>
                    <div class="queue-number" id="r-queue">—</div>
                    <div class="queue-sub" id="r-category-label">ប្រភេទ —</div>
                </div>
                <div class="receipt-row">
                    <span class="lbl">សេវា · Service</span>
                    <span class="val" id="r-km">—</span>
                </div>
                <div class="receipt-row">
                    <span class="lbl">English</span>
                    <span class="val en" id="r-en">—</span>
                </div>
                <div class="receipt-row">
                    <span class="lbl">ទីតាំង · Location</span>
                    <span class="val" id="r-desk">—</span>
                </div>
                <div class="receipt-row">
                    <span class="lbl">កាលបរិច្ឆេទ · Date</span>
                    <span class="val en" id="r-date">—</span>
                </div>
                <div class="receipt-row">
                    <span class="lbl">ម៉ោង · Time</span>
                    <span class="val en" id="r-time">—</span>
                </div>
                <div class="receipt-barcode">
                    <div class="barcode-lines" id="r-barcode"></div>
                    <div id="r-ticket-number">—</div>
                </div>
            </div>
            <div class="receipt-actions">
                <button class="btn-print" onclick="printReceipt()">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="6 9 6 2 18 2 18 9" />
                        <path d="M6 18H4a2 2 0 01-2-2v-5a2 2 0 012-2h16a2 2 0 012 2v5a2 2 0 01-2 2h-2" />
                        <rect x="6" y="14" width="12" height="8" />
                    </svg>
                    បោះពុម្ព Receipt
                </button>
                <button class="btn-close" onclick="closeReceipt()">បិទ</button>
            </div>
        </div>
    </div>

    <div id="print-area"></div>

    <script>
        let currentData = {};

        function takeQueue(el) {
            el.classList.add('loading');
            document.getElementById('footer-note').textContent = '⏳ កំពុងដំណើរការ...';

            const category = el.dataset.category;

            fetch('{{ route("take") }}', {
                    method: 'POST'
                    , headers: {
                        'Content-Type': 'application/json'
                        , 'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        , 'Accept': 'application/json'
                    , }
                    , body: JSON.stringify({
                        category
                    })
                , })
                .then(res => res.json())
                .then(data => {
                    el.classList.remove('loading');
                    el.classList.add('done');
                    el.querySelector('.tick').textContent = '✓';
                    const badge = el.querySelector('.badge');
                    badge.className = 'badge badge-green';
                    badge.textContent = '✓ រួចរាល់';

                    const now = new Date();
                    currentData = {
                        ticketNumber: data.ticket_number
                        , category: category
                        , km: el.dataset.km
                        , en: el.dataset.en
                        , desk: el.dataset.desk
                        , date: now.toLocaleDateString('km-KH', {
                            year: 'numeric'
                            , month: 'long'
                            , day: 'numeric'
                        })
                        , time: now.toLocaleTimeString('en-US', {
                            hour: '2-digit'
                            , minute: '2-digit'
                        })
                    , };

                    showReceipt(currentData);
                    document.getElementById('footer-note').textContent = '✅ ទទួលបានប័ណ្ណរង់ចាំ · Ticket issued!';
                })
                .catch(() => {
                    el.classList.remove('loading');
                    document.getElementById('footer-note').textContent = '❌ មានបញ្ហា · Error. Try again.';
                });
        }

        function showReceipt(d) {
            document.getElementById('r-queue').textContent = d.ticketNumber;
            document.getElementById('r-category-label').textContent = 'ប្រភេទ · Category ' + d.category;
            document.getElementById('r-km').textContent = d.km;
            document.getElementById('r-en').textContent = d.en;
            document.getElementById('r-desk').textContent = d.desk;
            document.getElementById('r-date').textContent = d.date;
            document.getElementById('r-time').textContent = d.time;
            document.getElementById('r-ticket-number').textContent = d.ticketNumber;

            const bc = document.getElementById('r-barcode');
            bc.innerHTML = '';
            [3, 1, 2, 1, 3, 2, 1, 3, 1, 2, 1, 3, 2, 1, 3, 1, 2, 3, 1, 2, 1, 3, 1, 2, 3].forEach((w, i) => {
                const s = document.createElement('span');
                s.style.width = w + 'px';
                s.style.opacity = i % 2 === 0 ? '1' : '0';
                bc.appendChild(s);
            });

            document.getElementById('receipt-overlay').classList.add('show');
        }

        function closeReceipt() {
            document.getElementById('receipt-overlay').classList.remove('show');
        }

        function closeOnBg(e) {
            if (e.target.id === 'receipt-overlay') closeReceipt();
        }

        function printReceipt() {
            const d = currentData;
            const barHTML = [3, 1, 2, 1, 3, 2, 1, 3, 1, 2, 1, 3, 2, 1, 3, 1, 2, 3, 1, 2, 1, 3, 1, 2, 3]
                .map((w, i) => `<span style="width:${w}px;background:${i%2===0?'#000':'transparent'};display:inline-block;height:100%;border-radius:1px;"></span>`)
                .join('');

            document.getElementById('print-area').innerHTML = `
        <div class="pr-wrap">
            <div class="pr-center">
                <div class="pr-school">🏫 វិទ្យាស្ថាន · School Name</div>
                <div class="pr-title">ប័ណ្ណរង់ចាំ · Waiting Receipt</div>
            </div>
            <hr class="pr-divider">
            <div class="pr-center">
                <div class="pr-queue-label">លេខរង់ចាំ · Queue No.</div>
                <div class="pr-queue-num">${d.ticketNumber}</div>
                <div class="pr-queue-sub">ប្រភេទ · Category ${d.category}</div>
            </div>
            <hr class="pr-divider">
            <div class="pr-row"><span class="pr-lbl">សេវា · Service</span><span class="pr-val">${d.km}</span></div>
            <div class="pr-row"><span class="pr-lbl">English</span><span class="pr-val">${d.en}</span></div>
            <div class="pr-row"><span class="pr-lbl">ទីតាំង · Location</span><span class="pr-val">${d.desk}</span></div>
            <div class="pr-row"><span class="pr-lbl">កាលបរិច្ឆេទ</span><span class="pr-val">${d.date}</span></div>
            <div class="pr-row"><span class="pr-lbl">ម៉ោង · Time</span><span class="pr-val">${d.time}</span></div>
            <hr class="pr-divider">
            <div class="pr-barcode">
                <div class="pr-bar-lines" style="display:flex;justify-content:center;gap:2px;height:10mm;margin-bottom:2mm;">${barHTML}</div>
                <div>${d.ticketNumber}</div>
            </div>
            <div class="pr-footer">សូមរង់ចាំដំណឹង · Please wait for your number<br>រក្សាប័ណ្ណនេះទុក · Keep this receipt</div>
        </div>`;

            closeReceipt();
            setTimeout(() => window.print(), 100);
        }

    </script>
</body>
</html>
