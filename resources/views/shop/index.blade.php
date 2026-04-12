@extends('layouts.app')
@section('title', 'Lapak Second')
@section('content')

@include('components.hero')

<main class="main-layout">

    {{-- Sidebar --}}
    <aside class="sidebar">
        <div class="sidebar-card">
            <p class="sidebar-title">Filter Kategori</p>
            <label class="filter-item">
                <input type="radio" name="kondisi" value=""> <span class="filter-label">Semua</span>
            </label>
            <label class="filter-item">
                <input type="radio" name="kondisi" value="baru"> <span class="filter-label">Baru</span>
            </label>
            <label class="filter-item">
                <input type="radio" name="kondisi" value="bekas"> <span class="filter-label">Bekas</span>
            </label>

            <p class="sidebar-title" style="margin-top:1.25rem;">Urutkan</p>
            <select id="sort-select"
                    style="width:100%;padding:0.6rem 0.75rem;background:var(--surface-2);border:1px solid var(--border);border-radius:10px;color:var(--white);font-size:0.85rem;outline:none;font-family:'DM Sans',sans-serif;">
                <option value="terbaru">Terbaru</option>
                <option value="harga_asc">Harga Terendah</option>
                <option value="harga_desc">Harga Tertinggi</option>
            </select>
        </div>
    </aside>

    {{-- Konten produk --}}
    <div style="flex:1; min-width:0;">

        {{-- ★ Search Bar ★ --}}
        @include('components.search-bar')

        {{-- Info hasil --}}
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1rem;">
            <div id="result-info" style="font-size:0.82rem; color:var(--muted);">Memuat produk...</div>
            <div id="loading-spinner" style="display:none;">
                <i class="fas fa-spinner fa-spin" style="color:var(--accent);"></i>
            </div>
        </div>

        {{-- Grid produk --}}
        <div class="products-grid" id="products-grid"></div>

        {{-- Pagination --}}
        <div id="pagination" style="display:flex; gap:0.5rem; margin-top:1.5rem; flex-wrap:wrap;"></div>
    </div>

</main>

@include('partials.cart-drawer')
@include('partials.success-modal')
@include('partials.toast')

@push('scripts')
@include('partials.search-script')
<script>
let currentPage    = 1;
let currentSearch  = new URLSearchParams(window.location.search).get('search') ?? '';
let currentKondisi = '';
let currentSort    = 'terbaru';
let debounceTimer  = null;

// ── Render grid produk ────────────────────────────────────────────────────────
function renderProducts(products) {
    const grid = document.getElementById('products-grid');
    if (!products.length) {
        grid.innerHTML = `
            <div class="col-span-full" style="text-align:center;padding:4rem 0;color:var(--muted);">
                <i class="fas fa-box-open" style="font-size:2.5rem;opacity:0.3;display:block;margin-bottom:0.75rem;"></i>
                Produk tidak ditemukan.
            </div>`;
        return;
    }
    grid.innerHTML = products.map((p, i) => `
        <div class="product-card" style="animation-delay:${i * 60}ms">
            <div class="card-img-wrap">
                ${p.gambar
                    ? `<img src="${p.gambar}" alt="${p.nama_barang}" loading="lazy">`
                    : `<div style="width:100%;height:100%;background:var(--surface-2);display:flex;align-items:center;justify-content:center;color:var(--muted);font-size:2rem;"><i class="fas fa-image"></i></div>`
                }
                <span class="card-badge ${p.kondisi === 'baru' ? 'badge-baru' : 'badge-bekas'}">${p.kondisi}</span>
            </div>
            <div class="card-body">
                <div class="card-name" title="${p.nama_barang}">${p.nama_barang}</div>
                <div class="card-price">${p.harga_label}</div>
                <button class="add-btn" onclick='addToCart(${JSON.stringify({id:p.id, name:p.nama_barang, harga:p.harga})})'>
                    <i class="fas fa-plus"></i> Tambah ke Keranjang
                </button>
            </div>
        </div>
    `).join('');
}

// ── Render pagination ─────────────────────────────────────────────────────────
function renderPagination(meta) {
    const el = document.getElementById('pagination');
    if (meta.last_page <= 1) { el.innerHTML = ''; return; }
    let html = '';
    for (let i = 1; i <= meta.last_page; i++) {
        const active = i === meta.current_page;
        html += `<button onclick="goToPage(${i})"
            style="width:36px;height:36px;border-radius:8px;border:1px solid var(--border);
                   background:${active ? 'var(--accent)' : 'transparent'};
                   color:${active ? 'var(--ink)' : 'var(--muted)'};
                   font-size:0.82rem;cursor:pointer;transition:all 0.2s;
                   font-family:'Syne',sans-serif;font-weight:600;">${i}</button>`;
    }
    el.innerHTML = html;
}

// ── Load produk dari API ──────────────────────────────────────────────────────
async function loadProducts(page = 1) {
    const spinner = document.getElementById('loading-spinner');
    const info    = document.getElementById('result-info');
    spinner.style.display = 'block';

    try {
        const params = { page, per_page: 12, sort: currentSort };
        if (currentSearch)  params.search  = currentSearch;
        if (currentKondisi) params.kondisi = currentKondisi;

        const res  = await fetch('/api/v1/products?' + new URLSearchParams(params), {
            headers: { 'Accept': 'application/json' }
        });
        const data = await res.json();

        renderProducts(data.data ?? []);
        renderPagination(data.meta ?? {});

        info.textContent = data.meta?.total
            ? `${data.meta.total} produk ditemukan${currentSearch ? ' untuk "' + currentSearch + '"' : ''}`
            : 'Tidak ada produk ditemukan.';

        currentPage = page;
    } catch (e) {
        info.textContent = 'Gagal memuat produk.';
    } finally {
        spinner.style.display = 'none';
    }
}

function goToPage(page) {
    loadProducts(page);
    document.getElementById('products-grid').scrollIntoView({ behavior: 'smooth', block: 'start' });
}

// ── Bridge Alpine → Alpine cartSystem ────────────────────────────────────────
function addToCart(product) {
    const el = document.querySelector('[x-data]');
    if (el && el._x_dataStack) {
        el._x_dataStack[0].addToCart(product);
    }
}

// ── Dengarkan event dari search bar ──────────────────────────────────────────
window.addEventListener('search-updated', e => {
    currentSearch = e.detail.query;
    loadProducts(1);
});

// ── Filter kondisi ────────────────────────────────────────────────────────────
document.querySelectorAll('input[name="kondisi"]').forEach(radio => {
    radio.addEventListener('change', e => {
        currentKondisi = e.target.value;
        loadProducts(1);
    });
});

// ── Sort ──────────────────────────────────────────────────────────────────────
document.getElementById('sort-select').addEventListener('change', e => {
    currentSort = e.target.value;
    loadProducts(1);
});

// ── Init: set query dari URL jika ada ─────────────────────────────────────────
if (currentSearch) {
    // Isi input Alpine setelah DOM siap
    document.addEventListener('alpine:init', () => {});
    setTimeout(() => {
        const input = document.getElementById('main-search-input');
        if (input) input.value = currentSearch;
    }, 100);
}

loadProducts();
</script>
@endpush

@endsection
