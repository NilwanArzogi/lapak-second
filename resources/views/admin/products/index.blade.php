@extends('layouts.admin')

@section('title', 'Kelola Produk')
@section('page-title', 'Kelola Produk')

@section('topbar-actions')
    <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Tambah Produk
    </a>
@endsection

@section('content')

<div class="card">
    <div class="card-header">
        <div style="font-family:'Syne',sans-serif; font-weight:700; font-size:0.95rem;">
            Daftar Produk
            <span style="font-family:'DM Sans',sans-serif; font-weight:400; color:var(--muted); font-size:0.8rem; margin-left:0.5rem;">
                {{ $products->total() }} produk
            </span>
        </div>
    </div>

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Gambar</th>
                    <th>Nama Barang</th>
                    <th>Harga</th>
                    <th>Kondisi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                <tr>
                    <td style="color:var(--muted);">{{ $loop->iteration + ($products->currentPage() - 1) * $products->perPage() }}</td>

                    <td>
                        @if($product->gambar)
                            <img src="{{ asset('storage/' . $product->gambar) }}"
                                 alt="{{ $product->nama_barang }}" class="img-thumb">
                        @else
                            <div class="img-placeholder"><i class="fas fa-image"></i></div>
                        @endif
                    </td>

                    <td>
                        <div style="font-weight:600; color:var(--text);">{{ $product->nama_barang }}</div>
                        @if($product->deskripsi)
                            <div style="font-size:0.78rem; color:var(--muted); margin-top:0.15rem;">
                                {{ Str::limit($product->deskripsi, 50) }}
                            </div>
                        @endif
                    </td>

                    <td style="font-family:'Syne',sans-serif; font-weight:700; color:var(--accent);">
                        Rp {{ number_format($product->harga, 0, ',', '.') }}
                    </td>

                    <td>
                        <span class="badge {{ $product->kondisi === 'baru' ? 'badge-green' : 'badge-orange' }}">
                            {{ $product->kondisi }}
                        </span>
                    </td>

                    <td>
                        <div style="display:flex; gap:0.4rem;">
                            <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-secondary btn-sm">
                                <i class="fas fa-pen"></i> Edit
                            </a>
                            <button onclick="confirmDelete('{{ route('admin.products.destroy', $product) }}')"
                                    class="btn btn-danger btn-sm">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align:center; padding:3rem; color:var(--muted);">
                        <i class="fas fa-box-open" style="font-size:2rem; opacity:0.3; display:block; margin-bottom:0.75rem;"></i>
                        Belum ada produk. <a href="{{ route('admin.products.create') }}" style="color:var(--accent);">Tambah sekarang</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($products->hasPages())
        <div style="padding:1rem 1.5rem; border-top:1px solid var(--border);">
            {{ $products->links() }}
        </div>
    @endif
</div>

{{-- Delete Confirm Modal --}}
<div id="delete-modal" style="display:none;" class="modal-overlay">
    <div class="modal-box">
        <div class="modal-icon"><i class="fas fa-trash"></i></div>
        <div class="modal-title">Hapus Produk?</div>
        <p class="modal-desc">Produk yang dihapus tidak bisa dikembalikan.</p>
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
