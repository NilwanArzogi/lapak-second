<script>
    function cartSystem() {
        return {
            showCart:      false,
            orderSuccess:  false,
            cart:          [],
            customer:      { name: '', email: '', phone: '' },
            selectedPayment: '',
            paymentMethods: [
                'Transfer Bank (BCA / Mandiri)',
                'E-Wallet (OVO / DANA / GoPay)',
                'QRIS (Otomatis)',
            ],

            get total() {
                return this.cart.reduce((sum, item) => sum + item.harga, 0);
            },

            addToCart(product) {
                this.cart.push({ ...product });
                showToast(product.name + ' ditambahkan');
            },

            removeFromCart(index) {
                this.cart.splice(index, 1);
            },

            checkout() {
                fetch("{{ route('checkout') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': "{{ csrf_token() }}",
                    },
                    body: JSON.stringify({
                        nama:    this.customer.name,
                        email:   this.customer.email,
                        phone:   this.customer.phone,
                        items:   this.cart,
                        total:   this.total,
                        payment: this.selectedPayment,
                    }),
                })
                .then(r => {
                    if (r.ok) { this.orderSuccess = true; }
                    else      { alert('Terjadi kesalahan saat menyimpan pesanan.'); }
                })
                .catch(e => console.error('Checkout error:', e));
            },
        };
    }

    function showToast(msg) {
        const toast = document.getElementById('toast');
        const label = document.getElementById('toast-msg');
        label.textContent = msg;
        toast.classList.add('show');
        setTimeout(() => toast.classList.remove('show'), 2200);
    }
</script>
