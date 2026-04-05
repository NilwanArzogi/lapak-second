/**
 * api.js — Fetch helper untuk Lapak Second
 * Letakkan file ini di: public/js/api.js
 * Lalu include di blade: <script src="{{ asset('js/api.js') }}"></script>
 */

const API = {
    base: '/api/v1',

    // Ambil CSRF token dari meta tag
    csrfToken() {
        return document.querySelector('meta[name="csrf-token"]')?.content ?? '';
    },

    // Base fetch wrapper
    async request(url, options = {}) {
        const res = await fetch(this.base + url, {
            headers: {
                'Content-Type': 'application/json',
                'Accept':       'application/json',
                'X-CSRF-TOKEN': this.csrfToken(),
                ...options.headers,
            },
            ...options,
        });

        const data = await res.json();

        if (!res.ok) {
            throw { status: res.status, message: data.message ?? 'Terjadi kesalahan.' };
        }

        return data;
    },

    // ─── PRODUK ────────────────────────────────────────────────────
    /**
     * Ambil daftar produk
     * @param {Object} params - { search, kondisi, sort, per_page, page }
     */
    async getProducts(params = {}) {
        const query = new URLSearchParams(params).toString();
        return this.request(`/products?${query}`);
    },

    /**
     * Ambil detail produk
     * @param {number} id
     */
    async getProduct(id) {
        return this.request(`/products/${id}`);
    },

    // ─── PESANAN ───────────────────────────────────────────────────
    /**
     * Ambil riwayat pesanan user yang login
     * @param {Object} params - { status, per_page, page }
     */
    async getOrders(params = {}) {
        const query = new URLSearchParams(params).toString();
        return this.request(`/orders?${query}`);
    },

    /**
     * Ambil detail pesanan
     * @param {number} id
     */
    async getOrder(id) {
        return this.request(`/orders/${id}`);
    },

    // ─── AFILIASI ──────────────────────────────────────────────────
    /**
     * Ambil statistik komisi afiliator
     */
    async getAffiliateStats() {
        return this.request('/affiliate/stats');
    },
};


// ─── Contoh penggunaan (bisa dihapus) ────────────────────────────────────────

/*

// 1. Ambil semua produk
const result = await API.getProducts({ search: 'laptop', kondisi: 'baru' });
console.log(result.data);   // array produk
console.log(result.meta);   // info pagination

// 2. Ambil detail produk id=1
const product = await API.getProduct(1);
console.log(product.data.nama_barang);

// 3. Riwayat pesanan user yang login
const orders = await API.getOrders({ status: 'sukses' });
console.log(orders.data);

// 4. Detail pesanan
const order = await API.getOrder(5);
console.log(order.data.items);

// 5. Statistik afiliasi
const stats = await API.getAffiliateStats();
console.log(stats.data.stats.total_earned);
console.log(stats.data.riwayat);

*/
