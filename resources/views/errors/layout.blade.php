<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') — {{ config('app.name') }}</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:wght@300;400;500&display=swap"
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
            --bg: #0d0d0f;
            --surface: #16161a;
            --border: rgba(255, 255, 255, 0.07);
            --text: #f0eff4;
            --muted: #7c7c8a;

            --accent: @yield('accent', '#6c63ff')

            ;

            --accent-dim: @yield('accent-dim', 'rgba(108,99,255,0.12)')

            ;
        }

        body {
            background: var(--bg);
            color: var(--text);
            font-family: 'DM Sans', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        /* Background grid */
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background-image:
                linear-gradient(var(--border) 1px, transparent 1px),
                linear-gradient(90deg, var(--border) 1px, transparent 1px);
            background-size: 60px 60px;
            mask-image: radial-gradient(ellipse 80% 80% at 50% 50%, black 30%, transparent 100%);
            z-index: 0;
        }

        /* Glow blob */
        body::after {
            content: '';
            position: fixed;
            width: 600px;
            height: 600px;
            border-radius: 50%;
            background: var(--accent-dim);
            filter: blur(120px);
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 0;
            animation: pulse 6s ease-in-out infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                transform: translate(-50%, -50%) scale(1);
                opacity: 0.6;
            }

            50% {
                transform: translate(-50%, -50%) scale(1.15);
                opacity: 1;
            }
        }

        .container {
            position: relative;
            z-index: 1;
            text-align: center;
            padding: 2rem;
            max-width: 560px;
            width: 100%;
            animation: fadeUp 0.7s cubic-bezier(0.16, 1, 0.3, 1) both;
        }

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(24px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .code-wrap {
            position: relative;
            display: inline-block;
            margin-bottom: 1.5rem;
        }

        .code {
            font-family: 'Syne', sans-serif;
            font-size: clamp(96px, 20vw, 160px);
            font-weight: 800;
            line-height: 1;
            color: transparent;
            -webkit-text-stroke: 2px var(--accent);
            letter-spacing: -4px;
            user-select: none;
        }

        .code-fill {
            position: absolute;
            inset: 0;
            font-family: 'Syne', sans-serif;
            font-size: clamp(96px, 20vw, 160px);
            font-weight: 800;
            line-height: 1;
            letter-spacing: -4px;
            color: var(--accent);
            opacity: 0.08;
            user-select: none;
        }

        .badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: var(--accent-dim);
            border: 1px solid var(--accent);
            color: var(--accent);
            font-size: 11px;
            font-weight: 500;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            padding: 5px 14px;
            border-radius: 999px;
            margin-bottom: 1.25rem;
        }

        .badge::before {
            content: '';
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: var(--accent);
            animation: blink 1.4s ease-in-out infinite;
        }

        @keyframes blink {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.2;
            }
        }

        h1 {
            font-family: 'Syne', sans-serif;
            font-size: clamp(22px, 4vw, 30px);
            font-weight: 700;
            margin-bottom: 0.75rem;
            color: var(--text);
        }

        p {
            font-size: 16px;
            color: var(--muted);
            line-height: 1.7;
            margin-bottom: 2.5rem;
        }

        .actions {
            display: flex;
            gap: 12px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 11px 24px;
            border-radius: 10px;
            font-family: 'DM Sans', sans-serif;
            font-size: 14px;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.2s ease;
            cursor: pointer;
            border: none;
        }

        .btn-primary {
            background: var(--accent);
            color: #fff;
        }

        .btn-primary:hover {
            filter: brightness(1.15);
            transform: translateY(-1px);
        }

        .btn-ghost {
            background: var(--surface);
            color: var(--muted);
            border: 1px solid var(--border);
        }

        .btn-ghost:hover {
            background: rgba(255, 255, 255, 0.06);
            color: var(--text);
            transform: translateY(-1px);
        }

        .divider {
            width: 48px;
            height: 1px;
            background: var(--border);
            margin: 2rem auto;
        }

        .meta {
            font-size: 12px;
            color: var(--muted);
            opacity: 0.5;
        }

        svg.icon {
            width: 16px;
            height: 16px;
            fill: none;
            stroke: currentColor;
            stroke-width: 2;
            stroke-linecap: round;
            stroke-linejoin: round;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="code-wrap">
            <div class="code-fill">@yield('code')</div>
            <div class="code">@yield('code')</div>
        </div>

        <div class="badge">@yield('badge-text')</div>

        <h1>@yield('heading')</h1>
        <p>@yield('description')</p>

        <div class="actions">
            @yield('actions')
        </div>

        <div class="divider"></div>
        <p class="meta">Error @yield('code') · {{ config('app.name') }} · {{ now()->format('Y') }}</p>
    </div>
</body>

</html>
