<div>
    <p class="section-label">Produk Dipilih</p>

    {{-- Cart Items Loop --}}
    <template x-for="(item, index) in cart" :key="index">
        <div class="cart-item">
            <div>
                <div class="cart-item-name" x-text="item.name"></div>
                <div class="cart-item-price"
                     x-text="'Rp ' + item.harga.toLocaleString('id-ID')">
                </div>
            </div>
            <button class="remove-btn" @click="removeFromCart(index)">
                <i class="fas fa-trash-can"></i>
            </button>
        </div>
    </template>

    {{-- Empty State --}}
    <div class="empty-cart" x-show="cart.length === 0">
        <i class="fas fa-bag-shopping"></i>
        Keranjang masih kosong.
    </div>
</div>
