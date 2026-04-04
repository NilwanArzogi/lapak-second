{{-- 
    Ganti bagian <aside class="sidebar">...</aside> 
    di resources/views/layouts/admin.blade.php dengan ini
--}}

<aside class="sidebar" id="sidebar">
    <a href="{{ route('shop.index') }}" class="sidebar-logo">
        <div class="logo-dot"></div>
        Lapak Second
    </a>

    <p class="sidebar-label">Menu</p>

    {{-- Dashboard: admin saja --}}
    @can('admin')
        <a href="{{ route('admin.dashboard') }}"
           class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="fas fa-gauge-high"></i> Dashboard
        </a>
    @endcan

    {{-- Produk: admin & seller --}}
    @can('admin-or-seller')
        <a href="{{ route('admin.products.index') }}"
           class="nav-item {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
            <i class="fas fa-box"></i>
            Produk
            @if(auth()->user()->isSeller())
                <span style="font-size:0.65rem; color:var(--muted); margin-left:auto;">Milikku</span>
            @endif
        </a>
    @endcan

    {{-- Pesanan & User: admin saja --}}
    @can('admin')
        <a href="{{ route('admin.orders.index') }}"
           class="nav-item {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
            <i class="fas fa-bag-shopping"></i> Pesanan
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
            {{-- Avatar atau inisial --}}
            @if(auth()->user()->avatar)
                <img src="{{ auth()->user()->avatar }}"
                     style="width:32px; height:32px; border-radius:10px; object-fit:cover; flex-shrink:0;">
            @else
                <div class="user-avatar">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
            @endif
            <div>
                <div class="user-name">{{ Str::limit(auth()->user()->name, 14) }}</div>
                <div class="user-role">
                    @if(auth()->user()->isAdmin())   ⚡ Administrator
                    @elseif(auth()->user()->isSeller()) 🏪 Seller
                    @else 👤 User
                    @endif
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
