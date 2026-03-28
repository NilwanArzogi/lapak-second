<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Lapak Second')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --bg:          #f0f2f7;
            --card:        #ffffff;
            --border:      #e2e6ef;
            --border-focus:#6366f1;
            --surface:     #f7f8fc;
            --text:        #1a1a2e;
            --text-2:      #4a4a6a;
            --muted:       #9494b0;
            --accent:      #6366f1;
            --accent-dark: #4f46e5;
            --accent-glow: rgba(99,102,241,0.15);
            --green:       #22c55e;
            --red:         #ef4444;
            --white:       #ffffff;
        }

        html, body { height: 100%; }

        body {
            background: var(--bg);
            color: var(--text);
            font-family: 'DM Sans', sans-serif;
            font-weight: 400;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        /* Background decorations */
        body::before {
            content: '';
            position: fixed;
            top: -200px; left: -200px;
            width: 600px; height: 600px;
            background: radial-gradient(circle, rgba(99,102,241,0.12) 0%, transparent 70%);
            pointer-events: none;
        }
        body::after {
            content: '';
            position: fixed;
            bottom: -150px; right: -150px;
            width: 500px; height: 500px;
            background: radial-gradient(circle, rgba(139,92,246,0.1) 0%, transparent 70%);
            pointer-events: none;
        }

        /* ── Card ── */
        .auth-card {
            position: relative; z-index: 1;
            width: 100%; max-width: 420px;
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: 24px;
            padding: 2.5rem 2rem;
            margin: 1.5rem;
            box-shadow: 0 4px 6px rgba(0,0,0,0.04), 0 20px 60px rgba(99,102,241,0.08);
            animation: card-up 0.45s cubic-bezier(0.22,1,0.36,1) both;
        }

        @keyframes card-up {
            from { opacity: 0; transform: translateY(20px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* ── Logo ── */
        .auth-logo {
            display: flex; align-items: center; gap: 0.5rem;
            font-family: 'Syne', sans-serif; font-weight: 800;
            font-size: 1.1rem; color: var(--text);
            text-decoration: none; margin-bottom: 2rem;
        }
        .logo-dot {
            width: 10px; height: 10px;
            background: var(--accent); border-radius: 50%;
            box-shadow: 0 0 0 3px rgba(99,102,241,0.2);
            animation: pulse 2s ease-in-out infinite;
        }
        @keyframes pulse {
            0%,100% { box-shadow: 0 0 0 3px rgba(99,102,241,0.2); }
            50%      { box-shadow: 0 0 0 6px rgba(99,102,241,0.1); }
        }

        /* ── Heading ── */
        .auth-title {
            font-family: 'Syne', sans-serif; font-weight: 800;
            font-size: 1.65rem; letter-spacing: -0.03em;
            color: var(--text); margin-bottom: 0.35rem;
        }
        .auth-sub {
            color: var(--muted); font-size: 0.875rem;
            margin-bottom: 1.75rem; line-height: 1.6;
        }

        /* ── Alert ── */
        .alert {
            padding: 0.75rem 1rem; border-radius: 12px;
            font-size: 0.82rem; margin-bottom: 1.25rem;
            display: flex; align-items: center; gap: 0.6rem;
        }
        .alert-error   { background: #fef2f2; border: 1px solid #fecaca; color: #dc2626; }
        .alert-success { background: #f0fdf4; border: 1px solid #bbf7d0; color: #16a34a; }

        /* ── Google Button ── */
        .google-btn {
            display: flex; align-items: center; justify-content: center; gap: 0.75rem;
            width: 100%; padding: 0.85rem 1rem;
            background: var(--white);
            border: 1.5px solid var(--border);
            border-radius: 14px;
            color: var(--text);
            font-family: 'DM Sans', sans-serif;
            font-size: 0.9rem; font-weight: 500;
            text-decoration: none;
            transition: all 0.2s ease;
            cursor: pointer;
            box-shadow: 0 1px 3px rgba(0,0,0,0.06);
        }
        .google-btn:hover {
            border-color: #c7d2fe;
            background: #fafbff;
            box-shadow: 0 4px 16px rgba(99,102,241,0.12);
            transform: translateY(-1px);
        }
        .google-btn:active { transform: translateY(0); }

        /* ── Divider ── */
        .divider {
            display: flex; align-items: center; gap: 0.75rem;
            margin: 1.25rem 0; color: var(--muted); font-size: 0.78rem;
        }
        .divider::before, .divider::after {
            content: ''; flex: 1; height: 1px; background: var(--border);
        }

        /* ── Form ── */
        .form-group { margin-bottom: 1rem; }
        .form-label {
            display: block; font-size: 0.75rem; font-weight: 600;
            text-transform: uppercase; letter-spacing: 0.08em;
            color: var(--text-2); margin-bottom: 0.45rem;
        }
        .input-wrap { position: relative; }
        .input-icon {
            position: absolute; left: 1rem; top: 50%; transform: translateY(-50%);
            color: var(--muted); font-size: 0.82rem; pointer-events: none;
        }
        .form-input {
            width: 100%; padding: 0.8rem 1rem 0.8rem 2.5rem;
            background: var(--surface);
            border: 1.5px solid var(--border);
            border-radius: 12px; color: var(--text);
            font-family: 'DM Sans', sans-serif;
            font-size: 0.9rem; font-weight: 400;
            outline: none; transition: all 0.2s;
        }
        .form-input::placeholder { color: var(--muted); }
        .form-input:focus {
            border-color: var(--accent);
            background: var(--white);
            box-shadow: 0 0 0 3px var(--accent-glow);
        }
        .form-input.is-invalid { border-color: var(--red); }
        .invalid-feedback { font-size: 0.78rem; color: var(--red); margin-top: 0.35rem; }

        /* Password toggle */
        .form-input.has-toggle { padding-right: 2.75rem; }
        .toggle-pass {
            position: absolute; right: 0.85rem; top: 50%; transform: translateY(-50%);
            background: none; border: none; color: var(--muted);
            cursor: pointer; font-size: 0.85rem; padding: 0.25rem;
            transition: color 0.2s;
        }
        .toggle-pass:hover { color: var(--accent); }

        /* ── Remember row ── */
        .check-row {
            display: flex; align-items: center;
            margin-bottom: 1.5rem;
        }
        .check-label {
            display: flex; align-items: center; gap: 0.6rem;
            font-size: 0.85rem; color: var(--text-2); cursor: pointer;
        }
        .check-label input[type="checkbox"] {
            appearance: none; width: 16px; height: 16px;
            border: 1.5px solid var(--border); border-radius: 5px;
            position: relative; cursor: pointer; transition: all 0.2s; flex-shrink: 0;
        }
        .check-label input[type="checkbox"]:checked {
            background: var(--accent); border-color: var(--accent);
        }
        .check-label input[type="checkbox"]:checked::after {
            content: '✓'; position: absolute; top: 50%; left: 50%;
            transform: translate(-50%,-50%); font-size: 10px; color: white; font-weight: 700;
        }

        /* ── Submit button ── */
        .submit-btn {
            width: 100%; padding: 0.9rem;
            background: var(--accent); color: white;
            border: none; border-radius: 14px;
            font-family: 'Syne', sans-serif; font-weight: 700;
            font-size: 0.9rem; letter-spacing: 0.03em;
            cursor: pointer; transition: all 0.25s;
            display: flex; align-items: center; justify-content: center; gap: 0.5rem;
            box-shadow: 0 4px 14px rgba(99,102,241,0.35);
        }
        .submit-btn:hover {
            background: var(--accent-dark);
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(99,102,241,0.4);
        }
        .submit-btn:active { transform: translateY(0); }

        /* ── Footer ── */
        .auth-footer {
            text-align: center; margin-top: 1.25rem;
            font-size: 0.85rem; color: var(--muted);
        }
        .auth-footer a {
            color: var(--accent); text-decoration: none; font-weight: 600;
        }
        .auth-footer a:hover { text-decoration: underline; }

        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: var(--bg); }
        ::-webkit-scrollbar-thumb { background: var(--border); border-radius: 3px; }
    </style>
</head>
<body>
    @yield('content')

    <script>
        function togglePassword(id) {
            const input = document.getElementById(id);
            const icon  = document.getElementById(id + '-icon');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.replace('fa-eye', 'fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.replace('fa-eye-slash', 'fa-eye');
            }
        }
    </script>
    @stack('scripts')
</body>
</html>
