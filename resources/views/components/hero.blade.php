{{--
    Hero Section Component - dengan search bar terintegrasi
    Usage: @include('components.hero')
--}}

<header class="hero">
    <div class="hero-bg-blob purple"></div>
    <div class="hero-bg-blob lime"></div>

    <div style="max-width:1400px; margin:0 auto; position:relative;">

        <div class="hero-label">
            <span style="width:6px;height:6px;background:var(--accent);border-radius:50%;display:inline-block;"></span>
            Gadget Murah & Berkualitas
        </div>

        <h1>Elektronik <span>Pilihan</span><br>Harga Terbaik.</h1>

        <p class="hero-sub">
            Smartphone, laptop, dan aksesoris bekas berkualitas.
            Diperiksa, terverifikasi, siap dipakai.
        </p>

        {{-- ★ Search Bar di Hero ★ --}}
        @include('components.search-bar')

    </div>
</header>
