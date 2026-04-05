{{-- Ganti <aside class="sidebar"> di layouts/admin.blade.php dengan ini --}}

<aside class="sidebar" id="sidebar">
    <a href="{{ route('shop.index') }}" class="sidebar-logo">
        <div class="logo-dot"></div>
        Lapak Second
    </a>

    <p class="sidebar-label">Menu</p>

    @can('admin')
        <a href="{{ route('admin.dashboard') }}"
           class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="fas fa-gauge-high"></i> Dashboard
        </a>
    @endcan

    @if(auth()->user()->isAdmin() || auth()->user()->isSeller())
        <a href="{{ route('admin.products.index') }}"
           class="nav-item {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
            <i class="fas fa-box"></i> Produk
            @if(auth()->user()->isSeller())
                <span style="font-size:0.62rem; color:var(--muted); margin-left:auto;">Milikku</span>
            @endif
        </a>
    @endif

    @can('admin')
        <a href="{{ route('admin.orders.index') }}"
           class="nav-item {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
            <i class="fas fa-bag-shopping"></i> Pesanan
        </a>
        <a href="{{ route('admin.affiliates.index') }}"
           class="nav-item {{ request()->routeIs('admin.affiliates.*') ? 'active' : '' }}">
            <i class="fas fa-link"></i> Afiliator
        </a>
        <a href="{{ route('admin.users.index') }}"
           class="nav-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
            <i class="fas fa-users"></i> Pengguna
        </a>
    @endcan

    <p class="sidebar-label">Lainnya</p>
    <a href="{{ route('shop.index') }}" class="nav-item">
        <i class="fas fa-store"></i> Lihat Toko
    </a>

    <div class="sidebar-footer">
        <div class="user-info">
            @if(auth()->user()->avatar)
                <img src="{{ auth()->user()->avatar }}"
                     style="width:32px;height:32px;border-radius:10px;object-fit:cover;flex-shrink:0;">
            @else
                <div class="user-avatar">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
            @endif
            <div>
                <div class="user-name">{{ Str::limit(auth()->user()->name, 14) }}</div>
                <div class="user-role" style="font-size:0.68rem;">
                    {{ auth()->user()->roleLabel() }}
                </div>
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
