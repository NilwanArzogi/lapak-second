<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Affiliate — Lapak Second')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        :root {
            --bg: #f0f2f7; --card: #fff; --border: #e2e6ef; --surface: #f7f8fc;
            --text: #1a1a2e; --text-2: #4a4a6a; --muted: #9494b0;
            --accent: #22c55e; --accent-dk: #16a34a; --accent-gl: rgba(34,197,94,0.1);
            --red: #ef4444;
        }
        body { background: var(--bg); color: var(--text); font-family: 'DM Sans', sans-serif; min-height: 100vh; }

        /* Topbar */
        .topbar {
            background: var(--card); border-bottom: 1px solid var(--border);
            padding: 0 2rem; height: 56px;
            display: flex; align-items: center; justify-content: space-between;
            position: sticky; top: 0; z-index: 10;
        }
        .topbar-logo { font-family: 'Syne', sans-serif; font-weight: 800; font-size: 1rem; color: var(--text); text-decoration: none; display: flex; align-items: center; gap: 0.5rem; }
        .logo-dot { width: 8px; height: 8px; background: var(--accent); border-radius: 50%; box-shadow: 0 0 0 3px rgba(34,197,94,0.2); }
        .page-title { font-family: 'Syne', sans-serif; font-weight: 700; font-size: 0.95rem; }

        .content { max-width: 960px; margin: 0 auto; padding: 2rem 1.5rem; }

        /* Reuse admin styles */
        .card { background: var(--card); border: 1px solid var(--border); border-radius: 16px; }
        .card-header { padding: 1.25rem 1.5rem; border-bottom: 1px solid var(--border); display: flex; justify-content: space-between; align-items: center; }
        .alert { padding: 0.75rem 1rem; border-radius: 10px; font-size: 0.85rem; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.6rem; }
        .alert-success { background: #f0fdf4; border: 1px solid #bbf7d0; color: #16a34a; }
        .btn { display: inline-flex; align-items: center; gap: 0.4rem; padding: 0.6rem 1.1rem; border-radius: 10px; font-size: 0.82rem; font-weight: 600; cursor: pointer; border: none; text-decoration: none; transition: all 0.2s; font-family: 'DM Sans', sans-serif; }
        .btn-primary { background: var(--accent); color: white; }
        .btn-primary:hover { background: var(--accent-dk); }
        .btn-secondary { background: var(--surface); color: var(--text-2); border: 1px solid var(--border); }
        .btn-sm { padding: 0.4rem 0.75rem; font-size: 0.78rem; }
        .table-wrap { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; font-size: 0.85rem; }
        th { padding: 0.75rem 1rem; text-align: left; font-size: 0.7rem; text-transform: uppercase; letter-spacing: 0.1em; color: var(--muted); font-weight: 600; border-bottom: 1px solid var(--border); }
        td { padding: 0.9rem 1rem; border-bottom: 1px solid var(--border); vertical-align: middle; }
        tbody tr:last-child td { border-bottom: none; }
        tbody tr:hover { background: var(--surface); }
        .badge { display: inline-flex; align-items: center; gap: 0.3rem; font-size: 0.68rem; font-weight: 700; font-family: 'Syne', sans-serif; letter-spacing: 0.06em; text-transform: uppercase; padding: 0.25rem 0.65rem; border-radius: 100px; }
        .badge::before { content: ''; width: 5px; height: 5px; border-radius: 50%; background: currentColor; }
        .badge-green  { background: #f0fdf4; color: #16a34a; border: 1px solid #bbf7d0; }
        .badge-orange { background: #fffbeb; color: #d97706; border: 1px solid #fde68a; }
        .badge-blue   { background: #eff6ff; color: #2563eb; border: 1px solid #bfdbfe; }
        .badge-red    { background: #fef2f2; color: var(--red); border: 1px solid #fecaca; }
    </style>
    @stack('styles')
</head>
<body>
    <div class="topbar">
        <a href="{{ route('shop.index') }}" class="topbar-logo">
            <div class="logo-dot"></div> Lapak Second
        </a>
        <div class="page-title">🔗 Panel Afiliator</div>
        <form method="POST" action="{{ route('logout') }}" style="margin:0;">
            @csrf
            <button type="submit" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-right-from-bracket"></i> Keluar
            </button>
        </form>
    </div>

    <div class="content">
        @if(session('success'))
            <div class="alert alert-success"><i class="fas fa-circle-check"></i> {{ session('success') }}</div>
        @endif
        @yield('content')
    </div>

    @stack('scripts')
</body>
</html>
