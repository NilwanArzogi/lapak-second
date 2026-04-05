<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) return $this->redirectByRole(Auth::user());
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|min:6',
        ]);

        if (Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            $request->session()->regenerate();
            return $this->redirectByRole(Auth::user());
        }

        return back()->withInput($request->only('email'))
                     ->withErrors(['email' => 'Email atau password salah.']);
    }

    public function showRegister()
    {
        if (Auth::check()) return $this->redirectByRole(Auth::user());
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:100',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'buyer', // default role
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('shop.index')
            ->with('success', 'Akun berhasil dibuat!');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')->with('success', 'Berhasil keluar.');
    }

    private function redirectByRole(User $user)
    {
        return match($user->role) {
            'admin'     => redirect()->route('admin.dashboard'),
            'seller'    => redirect()->route('admin.products.index'),
            'affiliate' => redirect()->route('affiliate.dashboard'),
            default     => redirect()->route('shop.index'),  // buyer
        };
    }
}
