<div x-cloak x-show="orderSuccess" class="modal-overlay">
    {{-- Backdrop --}}
    <div class="modal-bg" @click="orderSuccess = false"></div>

    {{-- Card --}}
    <div class="modal-card">
        <div class="success-icon">
            <i class="fas fa-check"></i>
        </div>

        <div class="modal-title">Pesanan Masuk!</div>

        <p class="modal-desc">
            Terima kasih,
            <strong x-text="customer.name" style="color:var(--white)"></strong>.
            Pesananmu sedang kami proses. Kami akan segera menghubungimu.
        </p>

        <button class="modal-btn"
                @click="orderSuccess = false; cart = []; showCart = false;">
            Lanjut Belanja
        </button>
    </div>
</div>
