<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login()
    {
        if (Auth::check()) {
            return back()->with('success', 'Anda sudah masuk. Silakan keluar terlebih dahulu jika ingin masuk dengan akun lain.');
        }

        return view('pages.auth.login');
    }

    public function authenticate(Request $request)
    {
        if (Auth::check()) {
            return back()->with('success', 'Anda sudah masuk. Silakan keluar terlebih dahulu jika ingin masuk dengan akun lain.');
        }

        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ], [
            'email.required' => 'Email harus diisi',
            'email.email' => 'Format email tidak valid',
            'password.required' => 'Kata sandi harus diisi',
        ]);

        if (Auth::attempt(($credentials))) {
            $request->session()->regenerate();

            $userStatus = Auth::user()->status;

            if ($userStatus == 'submitted') {
                $this->_logout($request);
                return back()->withErrors([
                    'email' => 'Akun anda masih menunggu persutujuan admin',
                ]);
            } else if ($userStatus == 'rejected') {
                $this->_logout($request);
                return back()->withErrors([
                    'email' => 'Akun anda telah ditolak oleh admin',
                ]);
            }

            return redirect()->intended('dashboard');
        }

        return back()->withErrors([
            'email' => 'Terjadi kesalahan saat mencoba masuk. Periksa kembali email dan kata sandi Anda.',
        ])->onlyInput('email');
    }

    public function registerView()
    {
        if (Auth::check()) {
            return back()->with('success', 'Anda sudah masuk. Silakan keluar terlebih dahulu jika ingin masuk dengan akun lain.');
        }

        return view('pages.auth.register');
    }

    public function register(Request $request)
    {
        if (Auth::check()) {
            return back()->with('success', 'Anda sudah masuk. Silakan keluar terlebih dahulu jika ingin masuk dengan akun lain.');
        }

        $validated = $request->validate([
            'name' => ['required', 'string'],
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->role_id = 2; // Assuming 'User' role has ID 2
        $user->saveOrFail();

        return redirect('/')->with('success', 'Akun Anda telah dibuat. Silakan tunggu persetujuan dari admin.');
    }

    public function _logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
    }

    public function logout(Request $request)
    {
        if (!Auth::check()) {
            return redirect('/')->with('success', 'Anda sudah keluar.');
        }

        $this->_logout($request);

        return redirect('/');
    }
}
