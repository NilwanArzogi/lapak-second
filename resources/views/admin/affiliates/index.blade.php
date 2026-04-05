@extends('layouts.admin')

@section('title', 'Kelola Afiliator')
@section('page-title', 'Kelola Afiliator')

@section('content')

<div class="card">
    <div class="card-header">
        <div style="font-family:'Syne',sans-serif; font-weight:700;">
            Daftar Afiliator
            <span style="font-family:'DM Sans',sans-serif; font-weight:400; color:var(--muted); font-size:0.8rem; margin-left:0.5rem;">
                {{ $links->total() }} afiliator
            </span>
        </div>
    </div>

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>#</th><th>Afiliator</th><th>Kode</th>
                    <th>Atur Komisi</th><th>Total Order</th>
                    <th>Total Komisi</th><th>Status</th><th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($links as $link)
                <tr>
                    <td style="color:var(--muted);">{{ $loop->iteration }}</td>
                    <td>
                        <div style="font-weight:600;">{{ $link->user->name }}</div>
                        <div style="font-size:0.75rem;color:var(--muted);">{{ $link->user->email }}</div>
                    </td>
                    <td>
                        <code style="background:var(--surface);padding:0.2rem 0.5rem;border-radius:6px;font-size:0.82rem;">
                            {{ $link->code }}
                        </code>
                    </td>
                    {{-- Atur tipe + nilai komisi --}}
                    <td>
                        <form method="POST" action="{{ route('admin.affiliates.update', $link) }}"
                              style="display:flex;align-items:center;gap:0.4rem;">
                            @csrf @method('PUT')
                            <input type="hidden" name="is_active" value="{{ $link->is_active ? 1 : 0 }}">
                            <select name="commission_type"
                                    style="padding:0.35rem 0.4rem;border:1.5px solid var(--border);border-radius:8px;font-size:0.78rem;background:var(--surface);color:var(--text);">
                                <option value="percent" {{ $link->commission_type==='percent'?'selected':'' }}>% Persen</option>
                                <option value="flat"    {{ $link->commission_type==='flat'?'selected':'' }}>Rp Flat</option>
                            </select>
                            <input type="number" name="commission_value"
                                   value="{{ $link->commission_value }}" step="500" min="0"
                                   style="width:80px;padding:0.35rem 0.5rem;border:1.5px solid var(--border);border-radius:8px;font-size:0.82rem;background:var(--surface);color:var(--text);">
                            <button type="submit" class="btn btn-primary btn-sm">
                                <i class="fas fa-check"></i>
                            </button>
                        </form>
                        <div style="font-size:0.72rem;color:var(--accent);margin-top:0.3rem;">
                            Saat ini: <strong>{{ $link->commissionLabel() }}</strong> / transaksi
                        </div>
                    </td>
                    <td style="text-align:center;font-weight:600;">{{ $link->commissions_count }}</td>
                    <td style="font-family:'Syne',sans-serif;font-weight:700;color:var(--accent);">
                        Rp {{ number_format($link->commissions_sum_commission_amount ?? 0, 0, ',', '.') }}
                    </td>
                    <td>
                        <form method="POST" action="{{ route('admin.affiliates.update', $link) }}">
                            @csrf @method('PUT')
                            <input type="hidden" name="commission_type"  value="{{ $link->commission_type }}">
                            <input type="hidden" name="commission_value" value="{{ $link->commission_value }}">
                            <input type="hidden" name="is_active"        value="{{ $link->is_active ? 0 : 1 }}">
                            <button type="submit" style="font-size:0.68rem;font-weight:700;font-family:'Syne',sans-serif;text-transform:uppercase;padding:0.25rem 0.65rem;border-radius:100px;border:none;cursor:pointer;
                                {{ $link->is_active ? 'background:#f0fdf4;color:#16a34a;border:1px solid #bbf7d0;' : 'background:#fef2f2;color:#dc2626;border:1px solid #fecaca;' }}">
                                {{ $link->is_active ? '● Aktif' : '● Nonaktif' }}
                            </button>
                        </form>
                    </td>
                    <td>
                        <a href="{{ route('admin.affiliates.commissions', $link) }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-list"></i> Detail
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" style="text-align:center;padding:3rem;color:var(--muted);">
                        <i class="fas fa-link" style="font-size:2rem;opacity:0.3;display:block;margin-bottom:0.75rem;"></i>
                        Belum ada afiliator. Ubah role user ke <strong>Affiliate</strong> di menu Pengguna.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($links->hasPages())
        <div style="padding:1rem 1.5rem;border-top:1px solid var(--border);">{{ $links->links() }}</div>
    @endif
</div>
@endsection
