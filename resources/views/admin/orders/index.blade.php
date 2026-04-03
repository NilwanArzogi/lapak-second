@extends('layouts.admin')

@section('title', 'Kelola Pesanan')
@section('page-title', 'Kelola Pesanan')

@section('content')

<div class="card">
    <div class="card-header">
        <div style="font-family:'Syne',sans-serif; font-weight:700; font-size:0.95rem;">
            Daftar Pesanan
            <span style="font-family:'DM Sans',sans-serif; font-weight:400; color:var(--muted); font-size:0.8rem; margin-left:0.5rem;">
                {{ $orders->total() }} pesanan
            </span>
        </div>
    </div>

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Pembeli</th>
                    <th>Item</th>
                    <th>Total</th>
                    <th>Pembayaran</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                <tr>
                    <td style="color:var(--muted);">{{ $loop->iteration }}</td>

                    <td>
                        <div style="font-weight:600;">{{ $order->nama_pembeli }}</div>
                        <div style="font-size:0.75rem; color:var(--muted);">{{ $order->nomor_hp }}</div>
                    </td>

                    <td style="font-size:0.8rem; color:var(--text-2);">
                        @php
                            $items = is_array($order->item_pesanan)
                                ? $order->item_pesanan
                                : json_decode($order->item_pesanan, true);
                        @endphp
                        {{ count($items ?? []) }} item
                    </td>

                    <td style="font-family:'Syne',sans-serif; font-weight:700; color:var(--accent);">
                        Rp {{ number_format($order->total_harga, 0, ',', '.') }}
                    </td>

                    <td style="font-size:0.8rem; color:var(--text-2); max-width:120px;">
                        {{ Str::limit($order->metode_pembayaran, 20) }}
                    </td>

                    <td>
                        {{-- Inline status update --}}
                        <form method="POST" action="{{ route('admin.orders.update', $order) }}">
                            @csrf @method('PUT')
                            <select name="status" class="form-select"
                                    style="padding:0.35rem 0.6rem; font-size:0.78rem; width:auto;"
                                    onchange="this.form.submit()">
                                <option value="sukses"     {{ $order->status === 'sukses'     ? 'selected' : '' }}>Sukses</option>
                                <option value="pending"    {{ $order->status === 'pending'    ? 'selected' : '' }}>Pending</option>
                                <option value="dibatalkan" {{ $order->status === 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                            </select>
                        </form>
                    </td>

                    <td style="font-size:0.78rem; color:var(--muted); white-space:nowrap;">
                        {{ $order->created_at->format('d M Y') }}
                    </td>

                    <td>
                        <div style="display:flex; gap:0.4rem;">
                            <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-secondary btn-sm">
                                <i class="fas fa-eye"></i>
                            </a>
                            <button onclick="confirmDelete('{{ route('admin.orders.destroy', $order) }}')"
                                    class="btn btn-danger btn-sm">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" style="text-align:center; padding:3rem; color:var(--muted);">
                        <i class="fas fa-inbox" style="font-size:2rem; opacity:0.3; display:block; margin-bottom:0.75rem;"></i>
                        Belum ada pesanan masuk.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($orders->hasPages())
        <div style="padding:1rem 1.5rem; border-top:1px solid var(--border);">
            {{ $orders->links() }}
        </div>
    @endif
</div>

{{-- Delete Modal --}}
<div id="delete-modal" style="display:none;" class="modal-overlay">
    <div class="modal-box">
        <div class="modal-icon"><i class="fas fa-trash"></i></div>
        <div class="modal-title">Hapus Pesanan?</div>
        <p class="modal-desc">Data pesanan yang dihapus tidak bisa dikembalikan.</p>
        <div class="modal-actions">
            <button onclick="closeModal()" class="btn btn-secondary">Batal</button>
            <form id="delete-form" method="POST">
                @csrf @method('DELETE')
                <button type="submit" class="btn btn-danger">Ya, Hapus</button>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    function confirmDelete(url) {
        document.getElementById('delete-form').action = url;
        document.getElementById('delete-modal').style.display = 'flex';
    }
    function closeModal() {
        document.getElementById('delete-modal').style.display = 'none';
    }
</script>
@endpush
