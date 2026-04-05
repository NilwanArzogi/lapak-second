<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AffiliateLink;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'  => 'required|string|max:100',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role'  => 'required|in:buyer,seller,affiliate,admin',
        ]);

        $oldRole = $user->role;
        $user->update($request->only(['name', 'email', 'role']));

        // Jika role diubah ke affiliate, buat link referral otomatis
        if ($request->role === 'affiliate' && $oldRole !== 'affiliate') {
            AffiliateLink::firstOrCreate(
                ['user_id' => $user->id],
                [
                    'code'             => AffiliateLink::generateCode($user->name),
                    'commission_type'  => 'percent',
                    'commission_value' => 5.00,
                    'is_active'        => true,
                ]
            );
        }

        return redirect()->route('admin.users.index')
            ->with('success', "Role {$user->name} diubah ke {$request->role}!");
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Tidak bisa menghapus akun sendiri!');
        }
        $user->delete();
        return redirect()->route('admin.users.index')
            ->with('success', 'User berhasil dihapus!');
    }
}
