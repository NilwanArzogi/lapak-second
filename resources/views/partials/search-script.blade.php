{{--
    Tambahkan script ini ke dalam resources/views/partials/scripts.blade.php
    Letakkan SEBELUM penutup </script> atau buat script baru setelahnya
--}}

<script>
function searchBar() {
    return {
        query:            '',
        focused:          false,
        loading:          false,
        showDropdown:     false,
        suggestions:      [],
        activeSuggestion: -1,
        debounceTimer:    null,

        // ── Trigger saat user mengetik ──────────────────────────────────
        onInput() {
            this.activeSuggestion = -1;
            clearTimeout(this.debounceTimer);

            if (this.query.trim().length < 2) {
                this.suggestions  = [];
                this.showDropdown = false;
                return;
            }

            this.loading = true;
            this.debounceTimer = setTimeout(() => this.fetchSuggestions(), 350);
        },

        // ── Fetch saran produk dari API ─────────────────────────────────
        async fetchSuggestions() {
            try {
                const params = new URLSearchParams({ search: this.query.trim(), per_page: 5 });
                const res = await fetch(`/api/v1/products?${params}`, {
                    headers: {
                        'Accept':       'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content ?? '',
                    }
                });
                const data = await res.json();
                this.suggestions  = data.data ?? [];
                this.showDropdown = true;
            } catch (e) {
                this.suggestions = [];
            } finally {
                this.loading = false;
            }
        },

        // ── Pilih saran dari dropdown ───────────────────────────────────
        selectSuggestion(product) {
            this.query        = product.nama_barang;
            this.showDropdown = false;
            this.doSearch();
        },

        // ── Navigasi keyboard (panah atas/bawah) ───────────────────────
        moveSuggestion(dir) {
            if (!this.showDropdown) return;
            const max = this.suggestions.length;
            this.activeSuggestion = (this.activeSuggestion + dir + max) % max;
        },

        // ── Eksekusi pencarian ──────────────────────────────────────────
        doSearch() {
            const q = this.query.trim();
            if (!q) return;

            this.showDropdown = false;

            // Update URL tanpa reload (History API)
            const url = new URL(window.location.href);
            url.searchParams.set('search', q);
            window.history.pushState({}, '', url);

            // Trigger event agar halaman produk merespons
            window.dispatchEvent(new CustomEvent('search-updated', { detail: { query: q } }));

            // Scroll ke grid produk
            const grid = document.getElementById('products-grid');
            if (grid) {
                grid.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        },

        // ── Bersihkan input ─────────────────────────────────────────────
        clear() {
            this.query            = '';
            this.suggestions      = [];
            this.showDropdown     = false;
            this.activeSuggestion = -1;

            const url = new URL(window.location.href);
            url.searchParams.delete('search');
            window.history.pushState({}, '', url);

            window.dispatchEvent(new CustomEvent('search-updated', { detail: { query: '' } }));

            document.getElementById('main-search-input')?.focus();
        },
    };
}
</script>
