<div x-cloak x-show="showCart" class="drawer-overlay">
    {{-- Backdrop --}}
    <div class="drawer-bg" @click="showCart = false"></div>

    {{-- Drawer Panel --}}
    <div class="drawer">

        {{-- Header --}}
        <div class="drawer-header">
            <div class="drawer-title">
                Keranjang
                <span style="color:var(--muted); font-weight:400;"
                      x-text="cart.length > 0 ? '(' + cart.length + ')' : ''">
                </span>
            </div>
            <button class="drawer-close" @click="showCart = false">
                <i class="fas fa-xmark"></i>
            </button>
        </div>

        {{-- Body --}}
        <div class="drawer-body">
            @include('partials.cart-items')
            @include('partials.buyer-form')
            @include('partials.payment-methods')
        </div>

        {{-- Footer --}}
        <div class="drawer-footer">
            <div class="total-row">
                <span class="total-label">Total Pembayaran</span>
                <span class="total-value"
                      x-text="'Rp ' + total.toLocaleString('id-ID')">
                </span>
            </div>
            {{-- Tambahkan !customer.alamat ke disabled --}}
            <button class="checkout-btn"
                    @click="checkout()"
                    :disabled="cart.length === 0 || !customer.name || !customer.phone || !customer.alamat || !selectedPayment">
                <i class="fas fa-circle-check"></i>
                Konfirmasi Pesanan
            </button>
        </div>

    </div>
</div>
