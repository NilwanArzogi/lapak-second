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
@endphp

<div style="display:grid; grid-template-columns:1fr 320px; gap:1.5rem; max-width:900px;">

    {{-- Left: Item List --}}
    <div>
        <div class="card">
            <div class="card-header">
                <div style="font-family:'Syne',sans-serif; font-weight:700;">Item Pesanan</div>
            </div>
            <div class="card-body" style="padding:0;">
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
    </div>

    {{-- Right: Info --}}
    <div style="display:flex; flex-direction:column; gap:1rem;">

        <div class="card">
            <div class="card-header">
                <div style="font-family:'Syne',sans-serif; font-weight:700;">Info Pembeli</div>
            </div>
            <div class="card-body">
                <div style="margin-bottom:0.75rem;">
                    <div style="font-size:0.72rem; text-transform:uppercase; letter-spacing:0.08em; color:var(--muted); margin-bottom:0.2rem;">Nama</div>
                    <div style="font-weight:600;">{{ $order->nama_pembeli }}</div>
                </div>
                <div style="margin-bottom:0.75rem;">
                    <div style="font-size:0.72rem; text-transform:uppercase; letter-spacing:0.08em; color:var(--muted); margin-bottom:0.2rem;">Email</div>
                    <div>{{ $order->email ?? '-' }}</div>
                </div>
                <div>
                    <div style="font-size:0.72rem; text-transform:uppercase; letter-spacing:0.08em; color:var(--muted); margin-bottom:0.2rem;">No. HP</div>
                    <div>{{ $order->nomor_hp }}</div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <div style="font-family:'Syne',sans-serif; font-weight:700;">Info Pesanan</div>
            </div>
            <div class="card-body">
                <div style="margin-bottom:0.75rem;">
                    <div style="font-size:0.72rem; text-transform:uppercase; letter-spacing:0.08em; color:var(--muted); margin-bottom:0.2rem;">Metode Bayar</div>
                    <div style="font-weight:500;">{{ $order->metode_pembayaran }}</div>
                </div>
                <div style="margin-bottom:0.75rem;">
                    <div style="font-size:0.72rem; text-transform:uppercase; letter-spacing:0.08em; color:var(--muted); margin-bottom:0.2rem;">Tanggal</div>
                    <div>{{ $order->created_at->format('d M Y, H:i') }}</div>
                </div>
                <div>
                    <div style="font-size:0.72rem; text-transform:uppercase; letter-spacing:0.08em; color:var(--muted); margin-bottom:0.5rem;">Status</div>
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
