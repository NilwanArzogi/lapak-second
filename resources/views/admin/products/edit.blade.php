@extends('layouts.admin')

@section('title', 'Edit Produk')
@section('page-title', 'Edit Produk')

@section('topbar-actions')
    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
@endsection

@section('content')

<div style="max-width:700px;">
    <div class="card">
        <div class="card-header">
            <div style="font-family:'Syne',sans-serif; font-weight:700; font-size:0.95rem;">
                Edit: {{ Str::limit($product->nama_barang, 40) }}
            </div>
        </div>
        <div class="card-body">

            @if($errors->any())
                <div class="alert alert-error">
                    <i class="fas fa-circle-exclamation"></i>
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label class="form-label">Nama Barang</label>
                    <input type="text" name="nama_barang"
                           class="form-input @error('nama_barang') is-invalid @enderror"
                           value="{{ old('nama_barang', $product->nama_barang) }}" required>
                    @error('nama_barang') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">Harga (Rp)</label>
                        <input type="number" name="harga"
                               class="form-input @error('harga') is-invalid @enderror"
                               value="{{ old('harga', $product->harga) }}" min="0" required>
                        @error('harga') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="form-group">
                        <label class="form-label">Kondisi</label>
                        <select name="kondisi" class="form-select" required>
                            <option value="baru"  {{ old('kondisi', $product->kondisi) === 'baru'  ? 'selected' : '' }}>Baru</option>
                            <option value="bekas" {{ old('kondisi', $product->kondisi) === 'bekas' ? 'selected' : '' }}>Bekas</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Deskripsi <span style="color:var(--muted); font-weight:400;">(opsional)</span></label>
                    <textarea name="deskripsi" class="form-textarea">{{ old('deskripsi', $product->deskripsi) }}</textarea>
                </div>

                <div class="form-group">
                    <label class="form-label">Ganti Foto <span style="color:var(--muted); font-weight:400;">(kosongkan jika tidak ingin mengganti)</span></label>

                    {{-- Foto saat ini --}}
                    @if($product->gambar)
                        <div style="margin-bottom:0.75rem;">
                            <div style="font-size:0.75rem; color:var(--muted); margin-bottom:0.4rem;">Foto saat ini:</div>
                            <img src="{{ asset('storage/' . $product->gambar) }}"
                                 style="height:100px; border-radius:12px; object-fit:cover; border:1px solid var(--border);">
                        </div>
                    @endif

                    <input type="file" name="gambar" accept="image/*"
                           class="form-input @error('gambar') is-invalid @enderror"
                           onchange="previewImage(this)">
                    @error('gambar') <div class="invalid-feedback">{{ $message }}</div> @enderror

                    <div id="preview-wrap" style="display:none; margin-top:0.75rem;">
                        <div style="font-size:0.75rem; color:var(--muted); margin-bottom:0.4rem;">Preview foto baru:</div>
                        <img id="preview-img" style="height:100px; border-radius:12px; object-fit:cover; border:1px solid var(--border);">
                    </div>
                </div>

                <div style="display:flex; gap:0.75rem; padding-top:0.5rem;">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-floppy-disk"></i> Simpan Perubahan
                    </button>
                    <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    function previewImage(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = e => {
                document.getElementById('preview-img').src = e.target.result;
                document.getElementById('preview-wrap').style.display = 'block';
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endpush
