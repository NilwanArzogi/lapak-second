<nav class="main-nav">
    <a href="{{ route('shop.index') }}" class="nav-logo">
        <div class="logo-dot"></div>
        Lapak Second
    </a>

    <div class="nav-actions">
        @auth
            {{-- Cart Button --}}
            <button class="nav-btn" @click="showCart = true">
                <i class="fas fa-bag-shopping"></i>
                <span x-cloak x-show="cart.length > 0"
                      x-text="cart.length"
                      class="cart-badge">
                </span>
            </button>

            {{-- Admin Link --}}
            @if(auth()->user()->isAdmin())
                <a href="{{ route('admin.dashboard') }}" class="nav-btn" title="Dashboard Admin">
                    <i class="fas fa-gauge-high"></i>
                </a>
            @endif

            {{-- User Dropdown --}}
            <div style="position:relative;" x-data="{ open: false }">
                <button class="nav-btn" @click="open = !open" style="gap:0.4rem; width:auto; padding:0 0.85rem; font-size:0.78rem; font-family:'Syne',sans-serif; font-weight:600;">
                    <i class="fas fa-user"></i>
                    <span style="max-width:80px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;">
                        {{ Str::limit(auth()->user()->name, 10) }}
                    </span>
                    <i class="fas fa-chevron-down" style="font-size:0.65rem; opacity:0.5;"></i>
                </button>

                {{-- Dropdown Menu --}}
                <div x-cloak x-show="open" @click.outside="open = false"
                     style="position:absolute; right:0; top:calc(100% + 8px);
                            background:var(--surface-2); border:1px solid var(--border);
                            border-radius:14px; padding:0.5rem; min-width:180px;
                            box-shadow:0 16px 48px rgba(0,0,0,0.4); z-index:999;">

                    <div style="padding:0.6rem 0.75rem; border-bottom:1px solid var(--border); margin-bottom:0.4rem;">
                        <div style="font-size:0.75rem; color:var(--muted);">Login sebagai</div>
                        <div style="font-family:'Syne',sans-serif; font-weight:700; font-size:0.85rem;">
                            {{ auth()->user()->name }}
                        </div>
                        <div style="font-size:0.7rem; color:var(--accent);">
                            {{ auth()->user()->role }}
                        </div>
                    </div>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                                style="width:100%; padding:0.6rem 0.75rem; background:none; border:none;
                                       color:var(--muted); font-family:'DM Sans',sans-serif; font-size:0.85rem;
                                       cursor:pointer; border-radius:10px; display:flex; align-items:center;
                                       gap:0.6rem; transition:all 0.2s; text-align:left;"
                                onmouseover="this.style.background='rgba(255,77,109,0.1)'; this.style.color='#ff8fa3';"
                                onmouseout="this.style.background='none'; this.style.color='var(--muted)';">
                            <i class="fas fa-arrow-right-from-bracket"></i>
                            Keluar
                        </button>
                    </form>
                </div>
            </div>
        @else
            <a href="{{ route('login') }}"
               style="padding:0 1rem; height:42px; display:flex; align-items:center; gap:0.5rem;
                      background:var(--accent); color:var(--ink); border-radius:12px;
                      font-family:'Syne',sans-serif; font-weight:700; font-size:0.8rem;
                      text-decoration:none; transition:all 0.2s; letter-spacing:0.03em;"
               onmouseover="this.style.boxShadow='0 0 20px rgba(200,255,62,0.35)'; this.style.transform='translateY(-1px)';"
               onmouseout="this.style.boxShadow='none'; this.style.transform='translateY(0)';">
                <i class="fas fa-arrow-right-to-bracket"></i>
                Login
            </a>
        @endauth
    </div>
</nav>
