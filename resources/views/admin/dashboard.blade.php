@extends('layouts.app')

@section('title', 'Dashboard Admin — Lapak Second')

@section('content')

<div style="max-width:1400px; margin:0 auto; padding: 0 2rem 4rem;">

    {{-- ── Page Header ── --}}
    <div style="padding: 2.5rem 0 2rem; display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:1rem; border-bottom:1px solid var(--border); margin-bottom:2rem;">
        <div>
            <div style="font-size:0.7rem; font-weight:600; text-transform:uppercase; letter-spacing:0.15em; color:var(--accent); margin-bottom:0.4rem;">
                <i class="fas fa-gauge-high"></i> &nbsp;Admin Panel
            </div>
            <h1 style="font-family:'Syne',sans-serif; font-weight:800; font-size:2rem; letter-spacing:-0.03em;">
                Dashboard Pesanan
            </h1>
        </div>

        {{-- Logout --}}
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" style="
                display:flex; align-items:center; gap:0.5rem;
                padding:0.7rem 1.25rem; border-radius:12px;
                background:transparent; border:1px solid var(--border);
                color:var(--muted); font-family:'DM Sans',sans-serif;
                font-size:0.85rem; cursor:pointer; transition:all 0.2s;"
                onmouseover="this.style.borderColor='#ff4d6d'; this.style.color='#ff8fa3'; this.style.background='rgba(255,77,109,0.1)';"
                onmouseout="this.style.borderColor='var(--border)'; this.style.color='var(--muted)'; this.style.background='transparent';">
                <i class="fas fa-arrow-right-from-bracket"></i> Keluar
            </button>
        </form>
    </div>

    {{-- ── Stats Cards ── --}}
    @php
        $totalPesanan  = $orders->count();
        $totalRevenue  = $orders->sum('total_harga');
        $sukses        = $orders->where('status', 'sukses')->count();
    @endphp

    <div style="display:grid; grid-template-columns:repeat(auto-fit, minmax(200px,1fr)); gap:1rem; margin-bottom:2rem;">

        {{-- Total Pesanan --}}
        <div style="background:var(--surface); border:1px solid var(--border); border-radius:18px; padding:1.5rem;">
            <div style="font-size:0.7rem; text-transform:uppercase; letter-spacing:0.12em; color:var(--muted); margin-bottom:0.75rem;">
                <i class="fas fa-bag-shopping"></i> &nbsp;Total Pesanan
            </div>
            <div style="font-family:'Syne',sans-serif; font-weight:800; font-size:2.25rem; letter-spacing:-0.03em;">
                {{ $totalPesanan }}
            </div>
        </div>

        {{-- Total Revenue --}}
        <div style="background:var(--surface); border:1px solid rgba(200,255,62,0.15); border-radius:18px; padding:1.5rem;">
            <div style="font-size:0.7rem; text-transform:uppercase; letter-spacing:0.12em; color:var(--muted); margin-bottom:0.75rem;">
                <i class="fas fa-money-bill-wave"></i> &nbsp;Total Revenue
            </div>
            <div style="font-family:'Syne',sans-serif; font-weight:800; font-size:1.75rem; letter-spacing:-0.03em; color:var(--accent);">
                Rp {{ number_format($totalRevenue, 0, ',', '.') }}
            </div>
        </div>

        {{-- Pesanan Sukses --}}
        <div style="background:var(--surface); border:1px solid var(--border); border-radius:18px; padding:1.5rem;">
            <div style="font-size:0.7rem; text-transform:uppercase; letter-spacing:0.12em; color:var(--muted); margin-bottom:0.75rem;">
                <i class="fas fa-circle-check"></i> &nbsp;Sukses
            </div>
            <div style="font-family:'Syne',sans-serif; font-weight:800; font-size:2.25rem; letter-spacing:-0.03em; color:#4ade80;">
                {{ $sukses }}
            </div>
        </div>

        {{-- Login sebagai --}}
        <div style="background:var(--surface); border:1px solid var(--border); border-radius:18px; padding:1.5rem;">
            <div style="font-size:0.7rem; text-transform:uppercase; letter-spacing:0.12em; color:var(--muted); margin-bottom:0.75rem;">
                <i class="fas fa-user-shield"></i> &nbsp;Login Sebagai
            </div>
            <div style="font-family:'Syne',sans-serif; font-weight:700; font-size:1rem;">
                {{ auth()->user()->name }}
            </div>
            <div style="font-size:0.75rem; color:var(--accent); margin-top:0.2rem;">Administrator</div>
        </div>

    </div>

    {{-- ── Orders Table ── --}}
    <div style="background:var(--surface); border:1px solid var(--border); border-radius:20px; overflow:hidden;">

        {{-- Table Header --}}
        <div style="padding:1.25rem 1.5rem; border-bottom:1px solid var(--border); display:flex; justify-content:space-between; align-items:center;">
            <h2 style="font-family:'Syne',sans-serif; font-weight:700; font-size:1rem;">
                Daftar Pesanan Masuk
            </h2>
            <span style="font-size:0.75rem; color:var(--muted);">
                {{ $totalPesanan }} pesanan
            </span>
        </div>

        {{-- Table --}}
        <div style="overflow-x:auto;">
            <table style="width:100%; border-collapse:collapse; font-size:0.85rem;">
                <thead>
                    <tr style="border-bottom:1px solid var(--border);">
                        <th style="padding:0.85rem 1.5rem; text-align:left; font-size:0.7rem; text-transform:uppercase; letter-spacing:0.1em; color:var(--muted); font-weight:600; white-space:nowrap;">#</th>
                        <th style="padding:0.85rem 1rem; text-align:left; font-size:0.7rem; text-transform:uppercase; letter-spacing:0.1em; color:var(--muted); font-weight:600; white-space:nowrap;">Pembeli</th>
                        <th style="padding:0.85rem 1rem; text-align:left; font-size:0.7rem; text-transform:uppercase; letter-spacing:0.1em; color:var(--muted); font-weight:600; white-space:nowrap;">Kontak</th>
                        <th style="padding:0.85rem 1rem; text-align:left; font-size:0.7rem; text-transform:uppercase; letter-spacing:0.1em; color:var(--muted); font-weight:600; white-space:nowrap;">Item</th>
                        <th style="padding:0.85rem 1rem; text-align:left; font-size:0.7rem; text-transform:uppercase; letter-spacing:0.1em; color:var(--muted); font-weight:600; white-space:nowrap;">Total</th>
                        <th style="padding:0.85rem 1rem; text-align:left; font-size:0.7rem; text-transform:uppercase; letter-spacing:0.1em; color:var(--muted); font-weight:600; white-space:nowrap;">Pembayaran</th>
                        <th style="padding:0.85rem 1rem; text-align:left; font-size:0.7rem; text-transform:uppercase; letter-spacing:0.1em; color:var(--muted); font-weight:600; white-space:nowrap;">Status</th>
                        <th style="padding:0.85rem 1.5rem; text-align:left; font-size:0.7rem; text-transform:uppercase; letter-spacing:0.1em; color:var(--muted); font-weight:600; white-space:nowrap;">Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                    <tr style="border-bottom:1px solid var(--border); transition:background 0.15s;"
                        onmouseover="this.style.background='var(--surface-2)'"
                        onmouseout="this.style.background='transparent'">

                        {{-- No --}}
                        <td style="padding:1rem 1.5rem; color:var(--muted);">{{ $loop->iteration }}</td>

                        {{-- Nama --}}
                        <td style="padding:1rem;">
                            <div style="font-family:'Syne',sans-serif; font-weight:600; color:var(--white);">
                                {{ $order->nama_pembeli }}
                            </div>
                            <div style="font-size:0.75rem; color:var(--muted);">{{ $order->email }}</div>
                        </td>

                        {{-- Kontak --}}
                        <td style="padding:1rem; color:var(--muted); white-space:nowrap;">
                            <i class="fas fa-phone" style="font-size:0.7rem; margin-right:0.3rem;"></i>
                            {{ $order->nomor_hp }}
                        </td>

                        {{-- Items --}}
                        <td style="padding:1rem; max-width:220px;">
                            @php
                                $items = is_array($order->item_pesanan)
                                    ? $order->item_pesanan
                                    : json_decode($order->item_pesanan, true);
                            @endphp
                            @if($items)
                                @foreach($items as $item)
                                    <div style="font-size:0.78rem; color:var(--white); white-space:nowrap; overflow:hidden; text-overflow:ellipsis; max-width:200px;">
                                        {{ $item['name'] ?? $item['nama'] ?? '-' }}
                                    </div>
                                @endforeach
                            @else
                                <span style="color:var(--muted);">-</span>
                            @endif
                        </td>

                        {{-- Total --}}
                        <td style="padding:1rem; white-space:nowrap;">
                            <span style="font-family:'Syne',sans-serif; font-weight:700; color:var(--accent);">
                                Rp {{ number_format($order->total_harga, 0, ',', '.') }}
                            </span>
                        </td>

                        {{-- Metode Pembayaran --}}
                        <td style="padding:1rem; color:var(--muted); font-size:0.8rem; max-width:140px;">
                            {{ $order->metode_pembayaran }}
                        </td>

                        {{-- Status --}}
                        <td style="padding:1rem;">
                            <span style="
                                display:inline-flex; align-items:center; gap:0.35rem;
                                font-size:0.68rem; font-weight:700; font-family:'Syne',sans-serif;
                                letter-spacing:0.08em; text-transform:uppercase;
                                padding:0.3rem 0.7rem; border-radius:100px;
                                {{ $order->status === 'sukses'
                                    ? 'background:rgba(74,222,128,0.12); color:#4ade80; border:1px solid rgba(74,222,128,0.25);'
                                    : 'background:rgba(255,160,50,0.12); color:#ffaa33; border:1px solid rgba(255,160,50,0.25);' }}
                            ">
                                <span style="width:5px;height:5px;border-radius:50%;background:currentColor;display:inline-block;"></span>
                                {{ $order->status }}
                            </span>
                        </td>

                        {{-- Tanggal --}}
                        <td style="padding:1rem 1.5rem; color:var(--muted); font-size:0.78rem; white-space:nowrap;">
                            {{ $order->created_at->format('d M Y, H:i') }}
                        </td>

                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" style="padding:4rem; text-align:center; color:var(--muted);">
                            <i class="fas fa-inbox" style="font-size:2rem; opacity:0.3; display:block; margin-bottom:0.75rem;"></i>
                            Belum ada pesanan masuk.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</div>

@endsection
