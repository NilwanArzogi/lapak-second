{{--
    Product Card Component
    Usage: @include('components.product-card', ['product' => $product, 'index' => $loop->index])
--}}

<div class="product-card" style="animation-delay: {{ ($index ?? 0) * 70 }}ms">

    {{-- Image + Condition Badge --}}
    <div class="card-img-wrap">
        <img src="{{ $product->gambar }}"
             alt="{{ $product->nama_barang }}"
             loading="lazy">

        <span class="card-badge {{ $product->kondisi === 'baru' ? 'badge-baru' : 'badge-bekas' }}">
            {{ $product->kondisi }}
        </span>
    </div>

    {{-- Info + Action --}}
    <div class="card-body">
        <div class="card-name" title="{{ $product->nama_barang }}">
            {{ $product->nama_barang }}
        </div>

        <div class="card-price">
            Rp {{ number_format($product->harga, 0, ',', '.') }}
        </div>

        <button class="add-btn"
                @click="addToCart({
                    id:    {{ $product->id }},
                    name:  '{{ addslashes($product->nama_barang) }}',
                    harga: {{ $product->harga }}
                })">
            <i class="fas fa-plus"></i>
            Tambah ke Keranjang
        </button>
    </div>

</div>
