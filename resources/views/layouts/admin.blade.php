<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin — Lapak Second')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        :root {
            --bg:        #f0f2f7;
            --card:      #ffffff;
            --border:    #e2e6ef;
            --surface:   #f7f8fc;
            --text:      #1a1a2e;
            --text-2:    #4a4a6a;
            --muted:     #9494b0;
            --accent:    #6366f1;
            --accent-dk: #4f46e5;
            --accent-gl: rgba(99,102,241,0.1);
            --green:     #22c55e;
            --red:       #ef4444;
            --orange:    #f59e0b;
            --sidebar-w: 240px;
        }

        body {
            background: var(--bg);
            color: var(--text);
            font-family: 'DM Sans', sans-serif;
            min-height: 100vh;
            display: flex;
        }

        /* ── Sidebar Overlay (mobile) ── */
        .sidebar-overlay {
            display: none;
            position: fixed; inset: 0;
            background: rgba(0,0,0,0.5);
            z-index: 99;
            backdrop-filter: blur(2px);
        }
        .sidebar-overlay.active { display: block; }

        /* ── Sidebar ── */
        .sidebar {
            width: var(--sidebar-w);
            flex-shrink: 0;
            background: var(--card);
            border-right: 1px solid var(--border);
            height: 100vh;
            position: sticky;
            top: 0;
            display: flex;
            flex-direction: column;
            padding: 1.5rem 1rem;
            transition: transform 0.3s cubic-bezier(0.22,1,0.36,1);
            z-index: 100;
        }

        .sidebar-logo {
            display: flex; align-items: center; gap: 0.5rem;
            font-family: 'Syne', sans-serif; font-weight: 800; font-size: 1.05rem;
            color: var(--text); text-decoration: none;
            padding: 0.5rem 0.75rem; margin-bottom: 1.5rem;
        }
        .logo-dot {
            width: 8px; height: 8px; background: var(--accent);
            border-radius: 50%; box-shadow: 0 0 0 3px rgba(99,102,241,0.2);
        }

        .sidebar-label {
            font-size: 0.65rem; font-weight: 700; text-transform: uppercase;
            letter-spacing: 0.12em; color: var(--muted);
            padding: 0 0.75rem; margin-bottom: 0.5rem; margin-top: 1rem;
        }

        .nav-item {
            display: flex; align-items: center; gap: 0.75rem;
            padding: 0.65rem 0.75rem; border-radius: 10px;
            color: var(--text-2); text-decoration: none;
            font-size: 0.875rem; font-weight: 500;
            transition: all 0.2s; margin-bottom: 0.15rem;
        }
        .nav-item i { width: 16px; text-align: center; font-size: 0.85rem; }
        .nav-item:hover { background: var(--accent-gl); color: var(--accent); }
        .nav-item.active { background: var(--accent-gl); color: var(--accent); font-weight: 600; }

        .sidebar-footer {
            margin-top: auto; padding-top: 1rem;
            border-top: 1px solid var(--border);
        }
        .user-info {
            display: flex; align-items: center; gap: 0.6rem;
            padding: 0.6rem 0.75rem; margin-bottom: 0.5rem;
        }
        .user-avatar {
            width: 32px; height: 32px; border-radius: 10px;
            background: var(--accent-gl); color: var(--accent);
            display: flex; align-items: center; justify-content: center;
            font-family: 'Syne', sans-serif; font-weight: 700;
            font-size: 0.8rem; flex-shrink: 0;
        }
        .user-name { font-size: 0.82rem; font-weight: 600; color: var(--text); }
        .user-role { font-size: 0.7rem; color: var(--accent); }

        .logout-btn {
            display: flex; align-items: center; gap: 0.6rem;
            width: 100%; padding: 0.65rem 0.75rem;
            border-radius: 10px; border: none;
            background: none; color: var(--muted);
            font-size: 0.875rem; cursor: pointer;
            transition: all 0.2s; font-family: 'DM Sans', sans-serif;
        }
        .logout-btn:hover { background: #fef2f2; color: var(--red); }

        /* ── Main ── */
        .main { flex: 1; min-height: 100vh; overflow-x: hidden; min-width: 0; }

        /* ── Topbar ── */
        .topbar {
            background: var(--card);
            border-bottom: 1px solid var(--border);
            padding: 0 1.5rem;
            height: 56px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: sticky; top: 0; z-index: 10;
            gap: 1rem;
        }
        .topbar-left { display: flex; align-items: center; gap: 0.75rem; min-width: 0; }
        .page-title {
            font-family: 'Syne', sans-serif; font-weight: 800;
            font-size: 1rem; color: var(--text);
            white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
        }

        /* Hamburger button */
        .menu-btn {
            display: none;
            width: 36px; height: 36px; border-radius: 10px;
            background: var(--surface); border: 1px solid var(--border);
            color: var(--text-2); cursor: pointer;
            align-items: center; justify-content: center;
            font-size: 0.9rem; flex-shrink: 0; transition: all 0.2s;
        }
        .menu-btn:hover { background: var(--accent-gl); color: var(--accent); }

        .content { padding: 1.5rem; }

        /* ── Cards ── */
        .card { background: var(--card); border: 1px solid var(--border); border-radius: 16px; }
        .card-header {
            padding: 1.25rem 1.5rem; border-bottom: 1px solid var(--border);
            display: flex; justify-content: space-between; align-items: center;
            flex-wrap: wrap; gap: 0.75rem;
        }
        .card-body { padding: 1.5rem; }

        /* ── Alert ── */
        .alert {
            padding: 0.75rem 1rem; border-radius: 10px;
            font-size: 0.85rem; margin-bottom: 1.5rem;
            display: flex; align-items: center; gap: 0.6rem;
        }
        .alert-success { background: #f0fdf4; border: 1px solid #bbf7d0; color: #16a34a; }
        .alert-error   { background: #fef2f2; border: 1px solid #fecaca; color: var(--red); }

        /* ── Buttons ── */
        .btn {
            display: inline-flex; align-items: center; gap: 0.4rem;
            padding: 0.6rem 1.1rem; border-radius: 10px;
            font-size: 0.82rem; font-weight: 600;
            cursor: pointer; border: none; text-decoration: none;
            transition: all 0.2s; font-family: 'DM Sans', sans-serif;
        }
        .btn-primary   { background: var(--accent); color: white; }
        .btn-primary:hover { background: var(--accent-dk); transform: translateY(-1px); box-shadow: 0 4px 12px rgba(99,102,241,0.3); }
        .btn-danger    { background: #fef2f2; color: var(--red); border: 1px solid #fecaca; }
        .btn-danger:hover { background: var(--red); color: white; }
        .btn-secondary { background: var(--surface); color: var(--text-2); border: 1px solid var(--border); }
        .btn-secondary:hover { background: var(--border); }
        .btn-sm { padding: 0.4rem 0.75rem; font-size: 0.78rem; }

        /* ── Table ── */
        .table-wrap { overflow-x: auto; -webkit-overflow-scrolling: touch; }
        table { width: 100%; border-collapse: collapse; font-size: 0.85rem; }
        thead tr { border-bottom: 1px solid var(--border); }
        th {
            padding: 0.75rem 1rem; text-align: left;
            font-size: 0.7rem; text-transform: uppercase;
            letter-spacing: 0.1em; color: var(--muted);
            font-weight: 600; white-space: nowrap;
        }
        td { padding: 0.9rem 1rem; border-bottom: 1px solid var(--border); vertical-align: middle; }
        tbody tr:last-child td { border-bottom: none; }
        tbody tr:hover { background: var(--surface); }

        /* ── Form ── */
        .form-group { margin-bottom: 1.25rem; }
        .form-label {
            display: block; font-size: 0.78rem; font-weight: 600;
            color: var(--text-2); margin-bottom: 0.45rem;
            text-transform: uppercase; letter-spacing: 0.06em;
        }
        .form-input, .form-select, .form-textarea {
            width: 100%; padding: 0.75rem 1rem;
            background: var(--surface); border: 1.5px solid var(--border);
            border-radius: 10px; color: var(--text);
            font-family: 'DM Sans', sans-serif; font-size: 0.9rem;
            outline: none; transition: all 0.2s;
        }
        .form-input:focus, .form-select:focus, .form-textarea:focus {
            border-color: var(--accent); background: white;
            box-shadow: 0 0 0 3px rgba(99,102,241,0.1);
        }
        .form-input.is-invalid, .form-select.is-invalid { border-color: var(--red); }
        .invalid-feedback { font-size: 0.78rem; color: var(--red); margin-top: 0.3rem; }
        .form-textarea { resize: vertical; min-height: 100px; }
        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }

        /* ── Badge ── */
        .badge {
            display: inline-flex; align-items: center; gap: 0.3rem;
            font-size: 0.68rem; font-weight: 700; font-family: 'Syne', sans-serif;
            letter-spacing: 0.06em; text-transform: uppercase;
            padding: 0.25rem 0.65rem; border-radius: 100px;
        }
        .badge::before { content: ''; width: 5px; height: 5px; border-radius: 50%; background: currentColor; }
        .badge-green  { background: #f0fdf4; color: #16a34a; border: 1px solid #bbf7d0; }
        .badge-orange { background: #fffbeb; color: #d97706; border: 1px solid #fde68a; }
        .badge-red    { background: #fef2f2; color: var(--red);  border: 1px solid #fecaca; }
        .badge-blue   { background: #eff6ff; color: #2563eb; border: 1px solid #bfdbfe; }
        .badge-purple { background: var(--accent-gl); color: var(--accent); border: 1px solid #c7d2fe; }

        /* ── Image ── */
        .img-thumb { width: 48px; height: 48px; border-radius: 10px; object-fit: cover; border: 1px solid var(--border); }
        .img-placeholder {
            width: 48px; height: 48px; border-radius: 10px;
            background: var(--surface); border: 1px solid var(--border);
            display: flex; align-items: center; justify-content: center;
            color: var(--muted); font-size: 1.1rem;
        }

        /* ── Modal ── */
        .modal-overlay {
            position: fixed; inset: 0; background: rgba(0,0,0,0.4);
            backdrop-filter: blur(4px); z-index: 999;
            display: flex; align-items: center; justify-content: center; padding: 1rem;
        }
        .modal-box {
            background: white; border-radius: 20px; padding: 2rem;
            max-width: 380px; width: 100%;
            box-shadow: 0 20px 60px rgba(0,0,0,0.15); text-align: center;
        }
        .modal-icon {
            width: 56px; height: 56px; border-radius: 16px;
            background: #fef2f2; color: var(--red);
            display: flex; align-items: center; justify-content: center;
            font-size: 1.5rem; margin: 0 auto 1rem;
        }
        .modal-title { font-family: 'Syne', sans-serif; font-weight: 800; font-size: 1.1rem; margin-bottom: 0.4rem; }
        .modal-desc  { font-size: 0.875rem; color: var(--muted); margin-bottom: 1.5rem; }
        .modal-actions { display: flex; gap: 0.75rem; justify-content: center; }

        /* ════════════════════════════════
           RESPONSIVE — MOBILE
        ════════════════════════════════ */
        @media (max-width: 768px) {

            body { display: block; } /* sidebar keluar dari flow */

            /* Sidebar jadi fixed, tersembunyi di kiri */
            .sidebar {
                position: fixed;
                left: 0; top: 0;
                height: 100vh;
                transform: translateX(-100%);
            }
            .sidebar.open {
                transform: translateX(0);
                box-shadow: 4px 0 24px rgba(0,0,0,0.15);
            }

            /* Hamburger tampil */
            .menu-btn { display: flex; }

            .content { padding: 1rem; }
            .form-grid { grid-template-columns: 1fr; }

            /* Table scroll horizontal */
            .table-wrap { border-radius: 0; }
        }
    </style>
    @stack('styles')
</head>
<body>

    {{-- Overlay (klik untuk tutup sidebar di mobile) --}}
    <div class="sidebar-overlay" id="sidebar-overlay" onclick="closeSidebar()"></div>

    {{-- ── Sidebar ── --}}
    <aside class="sidebar" id="sidebar">
        <a href="{{ route('shop.index') }}" class="sidebar-logo">
            <div class="logo-dot"></div>
            Lapak Second
        </a>

        <p class="sidebar-label">Menu</p>
        <a href="{{ route('admin.dashboard') }}"
           class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="fas fa-gauge-high"></i> Dashboard
        </a>
        <a href="{{ route('admin.products.index') }}"
           class="nav-item {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
            <i class="fas fa-box"></i> Produk
        </a>
        <a href="{{ route('admin.orders.index') }}"
           class="nav-item {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
            <i class="fas fa-bag-shopping"></i> Pesanan
        </a>
        <a href="{{ route('admin.users.index') }}"
           class="nav-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
            <i class="fas fa-users"></i> Pengguna
        </a>

        <p class="sidebar-label">Lainnya</p>
        <a href="{{ route('shop.index') }}" class="nav-item">
            <i class="fas fa-store"></i> Lihat Toko
        </a>

        <div class="sidebar-footer">
            <div class="user-info">
                <div class="user-avatar">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <div>
                    <div class="user-name">{{ Str::limit(auth()->user()->name, 14) }}</div>
                    <div class="user-role">Administrator</div>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="logout-btn">
                    <i class="fas fa-arrow-right-from-bracket"></i> Keluar
                </button>
            </form>
        </div>
    </aside>

    {{-- ── Main Content ── --}}
    <div class="main">

        {{-- Topbar --}}
        <div class="topbar">
            <div class="topbar-left">
                {{-- Hamburger (mobile only) --}}
                <button class="menu-btn" onclick="openSidebar()">
                    <i class="fas fa-bars"></i>
                </button>
                <div class="page-title">@yield('page-title', 'Dashboard')</div>
            </div>
            <div>@yield('topbar-actions')</div>
        </div>

        {{-- Content --}}
        <div class="content">

            {{-- Flash Messages --}}
            @if(session('success'))
                <div class="alert alert-success">
                    <i class="fas fa-circle-check"></i> {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-error">
                    <i class="fas fa-circle-exclamation"></i> {{ session('error') }}
                </div>
            @endif

            @yield('content')
        </div>
    </div>

    <script>
        function openSidebar() {
            document.getElementById('sidebar').classList.add('open');
            document.getElementById('sidebar-overlay').classList.add('active');
            document.body.style.overflow = 'hidden';
        }
        function closeSidebar() {
            document.getElementById('sidebar').classList.remove('open');
            document.getElementById('sidebar-overlay').classList.remove('active');
            document.body.style.overflow = '';
        }
        // Tutup sidebar kalau klik nav item di mobile
        document.querySelectorAll('.nav-item').forEach(item => {
            item.addEventListener('click', () => {
                if (window.innerWidth <= 768) closeSidebar();
            });
        });
    </script>

    @stack('scripts')
</body>
</html>
