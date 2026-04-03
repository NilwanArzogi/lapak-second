@extends('layouts.admin')

@section('title', 'Detail Pesanan')
@section('page-title', 'Detail Pesanan')

@section('topbar-actions')
    <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
@endsection

@section('content')

@php
    $items = is_array($order->item_pesanan)
        ? $order->item_pesanan
        : json_decode($order->item_pesanan, true);

    // Buat URL Google Maps dari alamat
    $mapsQuery   = urlencode($order->alamat ?? '');
    $mapsEmbedUrl = "https://maps.google.com/maps?q={$mapsQuery}&output=embed&hl=id";
    $mapsOpenUrl  = "https://www.google.com/maps/search/?api=1&query={$mapsQuery}";
@endphp

<div style="display:grid; grid-template-columns:1fr 340px; gap:1.5rem; align-items:start;">

    {{-- ── Kiri: Items + Peta ── --}}
    <div style="display:flex; flex-direction:column; gap:1.25rem;">

        {{-- Item List --}}
        <div class="card">
            <div class="card-header">
                <div style="font-family:'Syne',sans-serif; font-weight:700;">Item Pesanan</div>
            </div>
            <div style="padding:0;">
                @foreach($items ?? [] as $item)
                <div style="display:flex; justify-content:space-between; align-items:center; padding:1rem 1.5rem; border-bottom:1px solid var(--border);">
                    <div style="font-weight:500;">{{ $item['name'] ?? $item['nama'] ?? '-' }}</div>
                    <div style="font-family:'Syne',sans-serif; font-weight:700; color:var(--accent);">
                        Rp {{ number_format($item['harga'] ?? 0, 0, ',', '.') }}
                    </div>
                </div>
                @endforeach
                <div style="padding:1rem 1.5rem; display:flex; justify-content:space-between; font-family:'Syne',sans-serif; font-weight:800; font-size:1.05rem;">
                    <span>Total</span>
                    <span style="color:var(--accent);">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        {{-- Peta Lokasi --}}
        @if($order->alamat)
        <div class="card" style="overflow:hidden;">
            <div class="card-header">
                <div style="font-family:'Syne',sans-serif; font-weight:700; display:flex; align-items:center; gap:0.5rem;">
                    <i class="fas fa-map-location-dot" style="color:var(--accent);"></i>
                    Lokasi Pengiriman
                </div>
                <a href="{{ $mapsOpenUrl }}" target="_blank" class="btn btn-secondary btn-sm">
                    <i class="fas fa-arrow-up-right-from-square"></i> Buka Maps
                </a>
            </div>

            {{-- Alamat teks --}}
            <div style="padding:0.85rem 1.5rem; background:var(--surface); border-bottom:1px solid var(--border); display:flex; align-items:flex-start; gap:0.6rem;">
                <i class="fas fa-location-dot" style="color:var(--red); margin-top:0.15rem; flex-shrink:0;"></i>
                <span style="font-size:0.875rem; color:var(--text-2); line-height:1.5;">{{ $order->alamat }}</span>
            </div>

            {{-- Google Maps Embed --}}
            <div style="position:relative; height:300px; background:var(--surface);">
                <iframe
                    src="{{ $mapsEmbedUrl }}"
                    width="100%"
                    height="300"
                    style="border:0; display:block;"
                    allowfullscreen=""
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>
        </div>
        @endif

    </div>

    {{-- ── Kanan: Info Pembeli + Status ── --}}
    <div style="display:flex; flex-direction:column; gap:1rem;">

        {{-- Info Pembeli --}}
        <div class="card">
            <div class="card-header">
                <div style="font-family:'Syne',sans-serif; font-weight:700;">Info Pembeli</div>
            </div>
            <div class="card-body" style="display:flex; flex-direction:column; gap:0.85rem;">

                <div>
                    <div style="font-size:0.72rem; text-transform:uppercase; letter-spacing:0.08em; color:var(--muted); margin-bottom:0.2rem;">Nama</div>
                    <div style="font-weight:600;">{{ $order->nama_pembeli }}</div>
                </div>

                <div>
                    <div style="font-size:0.72rem; text-transform:uppercase; letter-spacing:0.08em; color:var(--muted); margin-bottom:0.2rem;">Email</div>
                    <div>{{ $order->email ?? '-' }}</div>
                </div>

                <div>
                    <div style="font-size:0.72rem; text-transform:uppercase; letter-spacing:0.08em; color:var(--muted); margin-bottom:0.2rem;">No. HP</div>
                    <div>
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $order->nomor_hp) }}"
                           target="_blank"
                           style="color:var(--accent); text-decoration:none; display:inline-flex; align-items:center; gap:0.4rem;">
                            <i class="fab fa-whatsapp" style="color:#25d366;"></i>
                            {{ $order->nomor_hp }}
                        </a>
                    </div>
                </div>

                @if($order->alamat)
                <div>
                    <div style="font-size:0.72rem; text-transform:uppercase; letter-spacing:0.08em; color:var(--muted); margin-bottom:0.2rem;">Alamat</div>
                    <div style="font-size:0.875rem; line-height:1.5; color:var(--text-2);">{{ $order->alamat }}</div>
                </div>
                @endif

            </div>
        </div>

        {{-- Info Pesanan --}}
        <div class="card">
            <div class="card-header">
                <div style="font-family:'Syne',sans-serif; font-weight:700;">Info Pesanan</div>
            </div>
            <div class="card-body" style="display:flex; flex-direction:column; gap:0.85rem;">

                <div>
                    <div style="font-size:0.72rem; text-transform:uppercase; letter-spacing:0.08em; color:var(--muted); margin-bottom:0.2rem;">Metode Bayar</div>
                    <div style="font-weight:500;">{{ $order->metode_pembayaran }}</div>
                </div>

                <div>
                    <div style="font-size:0.72rem; text-transform:uppercase; letter-spacing:0.08em; color:var(--muted); margin-bottom:0.2rem;">Tanggal</div>
                    <div>{{ $order->created_at->format('d M Y, H:i') }}</div>
                </div>

                <div>
                    <div style="font-size:0.72rem; text-transform:uppercase; letter-spacing:0.08em; color:var(--muted); margin-bottom:0.5rem;">Ubah Status</div>
                    <form method="POST" action="{{ route('admin.orders.update', $order) }}">
                        @csrf @method('PUT')
                        <div style="display:flex; gap:0.5rem;">
                            <select name="status" class="form-select" style="flex:1; font-size:0.85rem; padding:0.5rem 0.75rem;">
                                <option value="sukses"     {{ $order->status === 'sukses'     ? 'selected' : '' }}>✅ Sukses</option>
                                <option value="pending"    {{ $order->status === 'pending'    ? 'selected' : '' }}>⏳ Pending</option>
                                <option value="dibatalkan" {{ $order->status === 'dibatalkan' ? 'selected' : '' }}>❌ Dibatalkan</option>
                            </select>
                            <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>

    </div>
</div>

@endsection
