<div x-show="cart.length > 0">
    <p class="section-label">Metode Pembayaran</p>

    <template x-for="pay in paymentMethods" :key="pay">
        <label class="pay-option" :class="selectedPayment === pay ? 'selected' : ''">
            <input type="radio"
                   name="payment"
                   :value="pay"
                   x-model="selectedPayment">
            <span class="pay-label" x-text="pay"></span>
        </label>
    </template>
</div>
