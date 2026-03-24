{{--
    Sidebar Filter Component
    Usage: @include('components.sidebar-filter')
--}}

<aside class="sidebar">
    <div class="sidebar-card">
        <p class="sidebar-title">Filter Kategori</p>

        <label class="filter-item">
            <input type="checkbox" name="kategori[]" value="smartphone">
            <span class="filter-label">Smartphone</span>
        </label>

        <label class="filter-item">
            <input type="checkbox" name="kategori[]" value="laptop">
            <span class="filter-label">Laptop & PC</span>
        </label>

        <label class="filter-item">
            <input type="checkbox" name="kategori[]" value="aksesoris">
            <span class="filter-label">Aksesoris</span>
        </label>

        <button class="apply-btn" type="submit">
            Terapkan Filter
        </button>
    </div>
</aside>
