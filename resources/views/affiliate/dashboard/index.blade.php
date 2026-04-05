@extends('layouts.affiliate')

@section('title', 'Dashboard Afiliator')
@section('page-title', 'Dashboard Afiliator')

@section('content')

{{-- ── Stats ── --}}
<div style="display:grid; grid-template-columns:repeat(auto-fit,minmax(180px,1fr)); gap:1rem; margin-bottom:1.5rem;">

    <div class="card" style="padding:1.25rem;">
        <div style="font-size:0.7rem; text-transform:uppercase; letter-spacing:0.1em; color:var(--muted); margin-bottom:0.6rem;">
            <i class="fas fa-bag-shopping" style="color:var(--accent);"></i> Total Order
        </div>
        <div style="font-family:'Syne',sans-serif; font-weight:800; font-size:2rem;">
            {{ $stats['total_order'] }}
        </div>
    </div>

    <div class="card" style="padding:1.25rem; border-color:#fde68a;">
        <div style="font-size:0.7rem; text-transform:uppercase; letter-spacing:0.1em; color:var(--muted); margin-bottom:0.6rem;">
            <i class="fas fa-clock" style="color:#f59e0b;"></i> Komisi Pending
        </div>
        <div style="font-family:'Syne',sans-serif; font-weight:800; font-size:1.5rem; color:#d97706;">
            Rp {{ number_format($stats['komisi_pending'], 0, ',', '.') }}
        </div>
    </div>

    <div class="card" style="padding:1.25rem; border-color:#bbf7d0;">
        <div style="font-size:0.7rem; text-transform:uppercase; letter-spacing:0.1em; color:var(--muted); margin-bottom:0.6rem;">
            <i class="fas fa-circle-check" style="color:#16a34a;"></i> Komisi Approved
        </div>
        <div style="font-family:'Syne',sans-serif; font-weight:800; font-size:1.5rem; color:#16a34a;">
            Rp {{ number_format($stats['komisi_approved'], 0, ',', '.') }}
        </div>
    </div>

    <div class="card" style="padding:1.25rem; border-color:#c7d2fe;">
        <div style="font-size:0.7rem; text-transform:uppercase; letter-spacing:0.1em; color:var(--muted); margin-bottom:0.6rem;">
            <i class="fas fa-money-bill-wave" style="color:var(--accent);"></i> Total Dibayar
        </div>
        <div style="font-family:'Syne',sans-serif; font-weight:800; font-size:1.5rem; color:var(--accent);">
            Rp {{ number_format($stats['komisi_paid'], 0, ',', '.') }}
        </div>
    </div>

</div>

{{-- ── Link Referral ── --}}
<div class="card" style="margin-bottom:1.5rem; padding:1.5rem;">
    <div style="font-family:'Syne',sans-serif; font-weight:700; margin-bottom:1rem; display:flex; align-items:center; gap:0.5rem;">
        <i class="fas fa-link" style="color:var(--accent);"></i>
        Link Referral Kamu
        <span style="font-size:0.65rem; padding:0.2rem 0.6rem; border-radius:100px;
                     {{ $link->is_active ? 'background:#f0fdf4; color:#16a34a; border:1px solid #bbf7d0;' : 'background:#fef2f2; color:#dc2626; border:1px solid #fecaca;' }}
                     font-weight:700; font-family:\'Syne\',sans-serif; text-transform:uppercase;">
            {{ $link->is_active ? 'Aktif' : 'Nonaktif' }}
        </span>
    </div>

    <div style="display:flex; gap:0.75rem; align-items:center; flex-wrap:wrap;">
        <div style="flex:1; min-width:200px; background:var(--surface); border:1.5px solid var(--border); border-radius:12px; padding:0.85rem 1rem; font-family:monospace; font-size:0.9rem; color:var(--text-2);">
            {{ $link->url }}
        </div>
        <button onclick="copyLink('{{ $link->url }}')"
                class="btn btn-primary">
            <i class="fas fa-copy" id="copy-icon"></i>
            <span id="copy-text">Salin Link</span>
        </button>
    </div>

    <div style="margin-top:0.75rem; font-size:0.82rem; color:var(--muted);">
        Kode: <strong style="color:var(--text); font-family:monospace;">{{ $link->code }}</strong>
        &nbsp;·&nbsp;
        Komisi: <strong style="color:var(--accent);">{{ $link->commission_rate }}%</strong> per transaksi
    </div>
</div>

{{-- ── Riwayat Komisi ── --}}
<div class="card">
    <div class="card-header">
        <div style="font-family:'Syne',sans-serif; font-weight:700;">Riwayat Komisi</div>
    </div>

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Tanggal</th>
                    <th>Total Order</th>
                    <th>Rate</th>
                    <th>Komisi</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($commissions as $commission)
                <tr>
                    <td style="color:var(--muted);">{{ $loop->iteration }}</td>
                    <td style="font-size:0.8rem; color:var(--text-2);">
                        {{ $commission->created_at->format('d M Y, H:i') }}
                    </td>
                    <td style="font-weight:600;">
                        Rp {{ number_format($commission->order_total, 0, ',', '.') }}
                    </td>
                    <td style="color:var(--muted);">{{ $commission->commission_rate }}%</td>
                    <td style="font-family:'Syne',sans-serif; font-weight:700; color:var(--accent);">
                        Rp {{ number_format($commission->commission_amount, 0, ',', '.') }}
                    </td>
                    <td>
                        @php
                            $badgeClass = match($commission->status) {
                                'approved' => 'badge-green',
                                'paid'     => 'badge-blue',
                                default    => 'badge-orange',
                            };
                        @endphp
                        <span class="badge {{ $badgeClass }}">{{ $commission->status }}</span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align:center; padding:3rem; color:var(--muted);">
                        <i class="fas fa-link" style="font-size:2rem; opacity:0.3; display:block; margin-bottom:0.75rem;"></i>
                        Belum ada komisi. Bagikan link referralmu!
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($commissions->hasPages())
        <div style="padding:1rem 1.5rem; border-top:1px solid var(--border);">
            {{ $commissions->links() }}
        </div>
    @endif
</div>

@endsection

@push('scripts')
<script>
    function copyLink(url) {
        navigator.clipboard.writeText(url).then(() => {
            document.getElementById('copy-icon').className = 'fas fa-check';
            document.getElementById('copy-text').textContent = 'Tersalin!';
            setTimeout(() => {
                document.getElementById('copy-icon').className = 'fas fa-copy';
                document.getElementById('copy-text').textContent = 'Salin Link';
            }, 2000);
        });
    }
</script>
@endpush
