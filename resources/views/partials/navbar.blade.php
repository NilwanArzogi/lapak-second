<nav class="main-nav">
    <a href="{{ route('shop.index') }}" class="nav-logo">
        <div class="logo-dot"></div>
        Lapak Second
    </a>

    <div class="nav-actions">
        @auth
            {{-- Keranjang (user & semua role) --}}
            <button class="nav-btn" @click="showCart = true">
                <i class="fas fa-bag-shopping"></i>
                <span x-cloak x-show="cart.length > 0"
                      x-text="cart.length" class="cart-badge"></span>
            </button>

            {{-- Tombol khusus Admin --}}
            @can('admin')
                <a href="{{ route('admin.dashboard') }}" class="nav-btn" title="Dashboard Admin">
                    <i class="fas fa-gauge-high"></i>
                </a>
            @endcan

            {{-- Tombol khusus Seller (bukan admin) --}}
            @can('seller')
                <a href="{{ route('admin.products.index') }}" class="nav-btn" title="Kelola Produk Saya">
                    <i class="fas fa-box"></i>
                </a>
            @endcan

            {{-- User Dropdown --}}
            <div style="position:relative;" x-data="{ open: false }">
                <button class="nav-btn"
                        @click="open = !open"
                        style="gap:0.4rem; width:auto; padding:0 0.85rem; font-size:0.78rem; font-family:'Syne',sans-serif; font-weight:600;">

                    {{-- Avatar Google atau inisial --}}
                    @if(auth()->user()->avatar)
                        <img src="{{ auth()->user()->avatar }}"
                             style="width:22px; height:22px; border-radius:50%; object-fit:cover;">
                    @else
                        <i class="fas fa-user"></i>
                    @endif

                    <span style="max-width:80px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">
                        {{ Str::limit(auth()->user()->name, 10) }}
                    </span>
                    <i class="fas fa-chevron-down" style="font-size:0.65rem; opacity:0.5;"></i>
                </button>

                {{-- Dropdown --}}
                <div x-cloak x-show="open" @click.outside="open = false"
                     style="position:absolute; right:0; top:calc(100% + 8px);
                            background:var(--surface-2); border:1px solid var(--border);
                            border-radius:14px; padding:0.5rem; min-width:200px;
                            box-shadow:0 16px 48px rgba(0,0,0,0.4); z-index:999;">

                    {{-- Info user --}}
                    <div style="padding:0.6rem 0.75rem; border-bottom:1px solid var(--border); margin-bottom:0.4rem;">
                        <div style="font-size:0.75rem; color:var(--muted);">Login sebagai</div>
                        <div style="font-family:'Syne',sans-serif; font-weight:700; font-size:0.85rem;">
                            {{ auth()->user()->name }}
                        </div>
                        {{-- Role badge --}}
                        <div style="margin-top:0.3rem;">
                            @if(auth()->user()->isAdmin())
                                <span style="font-size:0.65rem; font-weight:700; font-family:'Syne',sans-serif; text-transform:uppercase; letter-spacing:0.08em; background:rgba(99,102,241,0.15); color:#818cf8; border:1px solid rgba(99,102,241,0.3); padding:0.15rem 0.5rem; border-radius:100px;">
                                    ⚡ Admin
                                </span>
                            @elseif(auth()->user()->isSeller())
                                <span style="font-size:0.65rem; font-weight:700; font-family:'Syne',sans-serif; text-transform:uppercase; letter-spacing:0.08em; background:rgba(245,158,11,0.15); color:#fbbf24; border:1px solid rgba(245,158,11,0.3); padding:0.15rem 0.5rem; border-radius:100px;">
                                    🏪 Seller
                                </span>
                            @else
                                <span style="font-size:0.65rem; font-weight:700; font-family:'Syne',sans-serif; text-transform:uppercase; letter-spacing:0.08em; background:var(--accent-glow); color:var(--accent); border:1px solid rgba(200,255,62,0.3); padding:0.15rem 0.5rem; border-radius:100px;">
                                    👤 User
                                </span>
                            @endif
                        </div>
                    </div>

                    {{-- Menu sesuai role --}}
                    @can('admin-or-seller')
                        <a href="{{ route('admin.products.index') }}"
                           style="display:flex; align-items:center; gap:0.6rem; padding:0.6rem 0.75rem; border-radius:10px; color:var(--muted); font-size:0.85rem; text-decoration:none; transition:all 0.2s;"
                           onmouseover="this.style.background='var(--surface-3)'; this.style.color='var(--white)';"
                           onmouseout="this.style.background='none'; this.style.color='var(--muted)';">
                            <i class="fas fa-box" style="width:14px;"></i>
                            Kelola Produk
                        </a>
                    @endcan

                    @can('admin')
                        <a href="{{ route('admin.orders.index') }}"
                           style="display:flex; align-items:center; gap:0.6rem; padding:0.6rem 0.75rem; border-radius:10px; color:var(--muted); font-size:0.85rem; text-decoration:none; transition:all 0.2s;"
                           onmouseover="this.style.background='var(--surface-3)'; this.style.color='var(--white)';"
                           onmouseout="this.style.background='none'; this.style.color='var(--muted)';">
                            <i class="fas fa-bag-shopping" style="width:14px;"></i>
                            Kelola Pesanan
                        </a>
                        <a href="{{ route('admin.users.index') }}"
                           style="display:flex; align-items:center; gap:0.6rem; padding:0.6rem 0.75rem; border-radius:10px; color:var(--muted); font-size:0.85rem; text-decoration:none; transition:all 0.2s;"
                           onmouseover="this.style.background='var(--surface-3)'; this.style.color='var(--white)';"
                           onmouseout="this.style.background='none'; this.style.color='var(--muted)';">
                            <i class="fas fa-users" style="width:14px;"></i>
                            Kelola User
                        </a>
                    @endcan

                    <div style="border-top:1px solid var(--border); margin:0.4rem 0;"></div>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                                style="width:100%; padding:0.6rem 0.75rem; background:none; border:none; color:var(--muted); font-family:'DM Sans',sans-serif; font-size:0.85rem; cursor:pointer; border-radius:10px; display:flex; align-items:center; gap:0.6rem; transition:all 0.2s; text-align:left;"
                                onmouseover="this.style.background='rgba(255,77,109,0.1)'; this.style.color='#ff8fa3';"
                                onmouseout="this.style.background='none'; this.style.color='var(--muted)';">
                            <i class="fas fa-arrow-right-from-bracket" style="width:14px;"></i>
                            Keluar
                        </button>
                    </form>
                </div>
            </div>

        @else
            <a href="{{ route('login') }}"
               style="padding:0 1rem; height:42px; display:flex; align-items:center; gap:0.5rem; background:var(--accent); color:var(--ink); border-radius:12px; font-family:'Syne',sans-serif; font-weight:700; font-size:0.8rem; text-decoration:none; transition:all 0.2s; letter-spacing:0.03em;"
               onmouseover="this.style.boxShadow='0 0 20px rgba(200,255,62,0.35)'; this.style.transform='translateY(-1px)';"
               onmouseout="this.style.boxShadow='none'; this.style.transform='translateY(0)';">
                <i class="fas fa-arrow-right-to-bracket"></i>
                Login
            </a>
        @endauth
    </div>
</nav>
