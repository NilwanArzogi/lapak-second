@extends('layouts.admin')

@section('title', 'Kelola Pengguna')
@section('page-title', 'Kelola Pengguna')

@section('content')

<div class="card">
    <div class="card-header">
        <div style="font-family:'Syne',sans-serif; font-weight:700; font-size:0.95rem;">
            Daftar Pengguna
            <span style="font-family:'DM Sans',sans-serif; font-weight:400; color:var(--muted); font-size:0.8rem; margin-left:0.5rem;">
                {{ $users->total() }} pengguna
            </span>
        </div>
    </div>

    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Pengguna</th>
                    <th>Login Via</th>
                    <th>Role</th>
                    <th>Bergabung</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr>
                    <td style="color:var(--muted);">{{ $loop->iteration }}</td>

                    <td>
                        <div style="display:flex; align-items:center; gap:0.75rem;">
                            {{-- Avatar --}}
                            @if($user->avatar)
                                <img src="{{ $user->avatar }}" style="width:36px;height:36px;border-radius:10px;object-fit:cover;">
                            @else
                                <div style="width:36px;height:36px;border-radius:10px;background:var(--accent-gl);color:var(--accent);display:flex;align-items:center;justify-content:center;font-family:'Syne',sans-serif;font-weight:700;font-size:0.85rem;">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                            @endif
                            <div>
                                <div style="font-weight:600;">{{ $user->name }}</div>
                                <div style="font-size:0.75rem; color:var(--muted);">{{ $user->email }}</div>
                            </div>
                        </div>
                    </td>

                    <td>
                        @if($user->google_id)
                            <span class="badge badge-blue">
                                <i class="fab fa-google" style="font-size:0.65rem;"></i> Google
                            </span>
                        @else
                            <span class="badge badge-purple">
                                <i class="fas fa-envelope" style="font-size:0.65rem;"></i> Email
                            </span>
                        @endif
                    </td>

                    <td>
                        {{-- Inline role update --}}
                        <form method="POST" action="{{ route('admin.users.update', $user) }}">
                            @csrf @method('PUT')
                            <input type="hidden" name="name"  value="{{ $user->name }}">
                            <input type="hidden" name="email" value="{{ $user->email }}">
                            <select name="role" class="form-select"
                                    style="padding:0.35rem 0.6rem; font-size:0.78rem; width:auto;"
                                    onchange="this.form.submit()"
                                    {{ $user->id === auth()->id() ? 'disabled' : '' }}>
                                <option value="user"  {{ $user->role === 'user'  ? 'selected' : '' }}>User</option>
                                <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                            </select>
                        </form>
                    </td>

                    <td style="font-size:0.78rem; color:var(--muted); white-space:nowrap;">
                        {{ $user->created_at->format('d M Y') }}
                    </td>

                    <td>
                        @if($user->id !== auth()->id())
                            <button onclick="confirmDelete('{{ route('admin.users.destroy', $user) }}')"
                                    class="btn btn-danger btn-sm">
                                <i class="fas fa-trash"></i>
                            </button>
                        @else
                            <span style="font-size:0.75rem; color:var(--muted);">Kamu</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align:center; padding:3rem; color:var(--muted);">
                        Belum ada pengguna.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($users->hasPages())
        <div style="padding:1rem 1.5rem; border-top:1px solid var(--border);">
            {{ $users->links() }}
        </div>
    @endif
</div>

{{-- Delete Modal --}}
<div id="delete-modal" style="display:none;" class="modal-overlay">
    <div class="modal-box">
        <div class="modal-icon"><i class="fas fa-user-slash"></i></div>
        <div class="modal-title">Hapus Pengguna?</div>
        <p class="modal-desc">Akun pengguna yang dihapus tidak bisa dikembalikan.</p>
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
