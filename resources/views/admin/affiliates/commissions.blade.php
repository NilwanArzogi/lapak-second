@extends('layouts.admin')

@section('title', 'Komisi Afiliator')
@section('page-title', 'Komisi — ' . $link->user->name)

@section('topbar-actions')
    <a href="{{ route('admin.affiliates.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
@endsection

@section('content')

{{-- Info afiliator --}}
<div class="card" style="margin-bottom:1.5rem; padding:1.25rem 1.5rem;">
    <div style="display:flex; align-items:center; gap:1rem; flex-wrap:wrap;">
        <div style="flex:1;">
            <div style="font-family:'Syne',sans-serif; font-weight:700; font-size:1rem;">{{ $link->user->name }}</div>
            <div style="font-size:0.8rem; color:var(--muted);">
                Kode: <code style="background:var(--surface); padding:0.15rem 0.4rem; border-radius:5px;">{{ $link->code }}</code>
                &nbsp;·&nbsp; Rate: <strong style="color:var(--accent);">{{ $link->commission_rate }}%</strong>
            </div>
        </div>
        <div style="text-align:right;">
            <div style="font-size:0.72rem; color:var(--muted); text-transform:uppercase; letter-spacing:0.08em;">Total Komisi</div>
            <div style="font-family:'Syne',sans-serif; font-weight:800; font-size:1.5rem; color:var(--accent);">
                Rp {{ number_format($link->commissions->sum('commission_amount'), 0, ',', '.') }}
            </div>
        </div>
    </div>
</div>

{{-- Tabel komisi --}}
<div class="card">
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Tanggal</th>
                    <th>Total Order</th>
                    <th>Komisi</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($link->commissions()->with('order')->latest()->get() as $commission)
                <tr>
                    <td style="color:var(--muted);">{{ $loop->iteration }}</td>
                    <td style="font-size:0.8rem; color:var(--text-2);">
                        {{ $commission->created_at->format('d M Y, H:i') }}
                    </td>
                    <td>Rp {{ number_format($commission->order_total, 0, ',', '.') }}</td>
                    <td style="font-family:'Syne',sans-serif; font-weight:700; color:var(--accent);">
                        Rp {{ number_format($commission->commission_amount, 0, ',', '.') }}
                    </td>
                    <td>
                        <span class="badge {{ match($commission->status) { 'approved' => 'badge-green', 'paid' => 'badge-blue', default => 'badge-orange' } }}">
                            {{ $commission->status }}
                        </span>
                    </td>
                    <td>
                        <div style="display:flex; gap:0.4rem;">
                            @if($commission->status === 'pending')
                                <form method="POST" action="{{ route('admin.affiliates.approve', $commission) }}">
                                    @csrf @method('PATCH')
                                    <button class="btn btn-secondary btn-sm" type="submit">
                                        <i class="fas fa-check"></i> Approve
                                    </button>
                                </form>
                            @endif
                            @if($commission->status === 'approved')
                                <form method="POST" action="{{ route('admin.affiliates.pay', $commission) }}">
                                    @csrf @method('PATCH')
                                    <button class="btn btn-primary btn-sm" type="submit">
                                        <i class="fas fa-money-bill-wave"></i> Bayar
                                    </button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align:center; padding:3rem; color:var(--muted);">
                        Belum ada komisi dari afiliator ini.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
