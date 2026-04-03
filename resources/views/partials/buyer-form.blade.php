<div x-show="cart.length > 0">
    <p class="section-label">Informasi Pembeli</p>

    <input type="text"
           x-model="customer.name"
           placeholder="Nama Lengkap"
           class="form-input">

    <input type="email"
           x-model="customer.email"
           placeholder="Alamat Email"
           class="form-input">

    <input type="tel"
           x-model="customer.phone"
           placeholder="Nomor HP / WhatsApp"
           class="form-input">

    {{-- Alamat dengan tombol deteksi lokasi --}}
    <div style="position:relative;">
        <textarea x-model="customer.alamat"
                  placeholder="Alamat lengkap pengiriman..."
                  class="form-input"
                  rows="3"
                  style="resize:none; padding-right:3rem;"></textarea>

        {{-- Tombol deteksi lokasi GPS --}}
        <button type="button"
                @click="detectLocation()"
                title="Deteksi lokasi otomatis"
                style="position:absolute; right:0.75rem; top:0.75rem;
                       width:32px; height:32px; border-radius:8px;
                       background:var(--accent-glow); border:1px solid rgba(200,255,62,0.3);
                       color:var(--accent); cursor:pointer; display:flex;
                       align-items:center; justify-content:center;
                       font-size:0.85rem; transition:all 0.2s;"
                :style="locating ? 'animation: spin 1s linear infinite' : ''"
                onmouseover="this.style.background='var(--accent)'; this.style.color='var(--ink)';"
                onmouseout="this.style.background='var(--accent-glow)'; this.style.color='var(--accent)';">
            <i class="fas" :class="locating ? 'fa-spinner' : 'fa-location-crosshairs'"></i>
        </button>
    </div>

    {{-- Status lokasi --}}
    <div x-show="locationStatus"
         x-text="locationStatus"
         style="font-size:0.75rem; color:var(--muted); margin-top:0.4rem; margin-bottom:0.75rem;">
    </div>
</div>
