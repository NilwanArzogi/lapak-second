<script>
    function cartSystem() {
        return {
            showCart:       false,
            orderSuccess:   false,
            cart:           [],
            customer:       { name: '', email: '', phone: '', alamat: '' }, // ← tambah alamat
            selectedPayment: '',
            locating:       false,
            locationStatus: '',
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

            // ─── Deteksi lokasi GPS → reverse geocode jadi alamat teks ───
            detectLocation() {
                if (!navigator.geolocation) {
                    this.locationStatus = '❌ Browser tidak mendukung GPS.';
                    return;
                }
                this.locating       = true;
                this.locationStatus = '📍 Mendeteksi lokasi...';

                navigator.geolocation.getCurrentPosition(
                    async (pos) => {
                        const { latitude, longitude } = pos.coords;
                        try {
                            // Nominatim (OpenStreetMap) — gratis, tanpa API key
                            const res  = await fetch(
                                `https://nominatim.openstreetmap.org/reverse?lat=${latitude}&lon=${longitude}&format=json&addressdetails=1`,
                                { headers: { 'Accept-Language': 'id' } }
                            );
                            const data = await res.json();
                            this.customer.alamat = data.display_name ?? `${latitude}, ${longitude}`;
                            this.locationStatus  = '✅ Lokasi berhasil dideteksi!';
                        } catch (e) {
                            // Fallback: koordinat langsung
                            this.customer.alamat = `${latitude}, ${longitude}`;
                            this.locationStatus  = '✅ Koordinat berhasil didapat.';
                        }
                        this.locating = false;
                        setTimeout(() => this.locationStatus = '', 3000);
                    },
                    (err) => {
                        this.locating       = false;
                        this.locationStatus = '❌ Izin lokasi ditolak. Isi manual ya.';
                        setTimeout(() => this.locationStatus = '', 4000);
                    },
                    { timeout: 10000 }
                );
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
                        alamat:  this.customer.alamat,  // ← kirim alamat
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

    /* Spinner animation untuk tombol GPS */
    const style = document.createElement('style');
    style.textContent = `@keyframes spin { to { transform: rotate(360deg); } }`;
    document.head.appendChild(style);
</script>
