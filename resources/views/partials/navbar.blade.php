<nav class="main-nav">
    <a href="/" class="nav-logo">
        <div class="logo-dot"></div>
        Lapak Second
    </a>

    <div class="nav-actions">
        {{-- Cart Button --}}
        <button class="nav-btn" @click="showCart = true">
            <i class="fas fa-bag-shopping"></i>
            <span x-cloak x-show="cart.length > 0"
                  x-text="cart.length"
                  class="cart-badge">
            </span>
        </button>

        {{-- Profile Button --}}
        <button class="nav-btn">
            <i class="fas fa-user"></i>
        </button>
    </div>
</nav>
