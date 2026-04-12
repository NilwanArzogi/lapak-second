{{--
    Search Bar Component
    Usage: @include('components.search-bar')
    Requires: Alpine.js, api.js
--}}

<div class="search-bar-wrap" x-data="searchBar()">

    <div class="search-bar" :class="focused ? 'focused' : ''">

        {{-- Icon kiri --}}
        <i class="fas fa-search search-icon-left"
           :style="focused ? 'color:var(--accent)' : 'color:var(--muted)'"></i>

        {{-- Input --}}
        <input type="text"
               x-model="query"
               @focus="focused = true"
               @blur="focused = false; showDropdown = suggestions.length > 0"
               @input="onInput()"
               @keydown.enter="doSearch()"
               @keydown.escape="clear()"
               @keydown.arrow-down.prevent="moveSuggestion(1)"
               @keydown.arrow-up.prevent="moveSuggestion(-1)"
               placeholder="Cari produk elektronik..."
               autocomplete="off"
               id="main-search-input">

        {{-- Loading spinner --}}
        <i x-cloak x-show="loading"
           class="fas fa-spinner fa-spin"
           style="color:var(--muted); font-size:0.8rem; flex-shrink:0;"></i>

        {{-- Clear button --}}
        <button x-cloak x-show="query.length > 0 && !loading"
                @click="clear()"
                style="background:none; border:none; color:var(--muted); cursor:pointer; padding:0.2rem; display:flex; align-items:center; font-size:0.8rem; flex-shrink:0; transition:color 0.2s;"
                onmouseover="this.style.color='var(--red)'"
                onmouseout="this.style.color='var(--muted)'">
            <i class="fas fa-xmark"></i>
        </button>

        {{-- Search button --}}
        <button class="search-btn" @click="doSearch()">
            <i class="fas fa-arrow-right" style="color:#0a0a0f; font-size:0.85rem;"></i>
        </button>

    </div>

    {{-- Dropdown Suggestions --}}
    <div x-cloak x-show="showDropdown && suggestions.length > 0"
         class="search-dropdown"
         @click.outside="showDropdown = false">

        <template x-for="(item, i) in suggestions" :key="item.id">
            <div class="suggestion-item"
                 :class="activeSuggestion === i ? 'active' : ''"
                 @click="selectSuggestion(item)"
                 @mouseenter="activeSuggestion = i">

                <div class="suggestion-img">
                    <template x-if="item.gambar">
                        <img :src="item.gambar" :alt="item.nama_barang"
                             style="width:100%; height:100%; object-fit:cover; border-radius:8px;">
                    </template>
                    <template x-if="!item.gambar">
                        <i class="fas fa-image" style="color:var(--muted); font-size:0.9rem;"></i>
                    </template>
                </div>

                <div style="flex:1; min-width:0;">
                    <div class="suggestion-name" x-text="item.nama_barang"></div>
                    <div class="suggestion-price" x-text="item.harga_label"></div>
                </div>

                <span class="suggestion-badge"
                      :class="item.kondisi === 'baru' ? 'badge-baru' : 'badge-bekas'"
                      x-text="item.kondisi">
                </span>
            </div>
        </template>

        {{-- Lihat semua hasil --}}
        <div class="suggestion-footer" @click="doSearch()">
            <i class="fas fa-search" style="font-size:0.75rem;"></i>
            Lihat semua hasil untuk "<span x-text="query"></span>"
        </div>

    </div>

    {{-- No results --}}
    <div x-cloak x-show="showDropdown && suggestions.length === 0 && query.length >= 2 && !loading"
         class="search-dropdown" style="padding:1rem 1.25rem; text-align:center; color:var(--muted); font-size:0.85rem;">
        <i class="fas fa-box-open" style="display:block; font-size:1.5rem; margin-bottom:0.5rem; opacity:0.4;"></i>
        Produk "<span x-text="query"></span>" tidak ditemukan.
    </div>

</div>
