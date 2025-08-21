<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function accountRequestView(Request $request)
    {
        // Memulai query builder untuk model User
        $query = User::query();

        // Cek jika ada parameter 'status' di URL dan nilainya valid
        if ($request->has('status') && in_array($request->status, ['submitted', 'approved', 'rejected'])) {
            // Terapkan filter where ke query
            $query->where('status', $request->status);
        }

        // Ambil hasil query
        $users = $query->latest()->get();

        return view('pages.account-request.index', [
            'users' => $users,
        ]);
    }

    public function accountRequestApproval($id, Request $request)
    {
        $user = User::findOrFail($id);
        $user->status = $request->input('status') == 'approved' ? 'approved' : 'rejected';
        $user->save();

        return back()->with('success', 'Permintaan akun berhasil diperbarui.');
    }

    public function accountListView()
    {
        $users = User::where('role_id', 2)->get();
        return view('pages.account-list.index', [
            'users' => $users,
        ]);
    }

    public function deactivateAccount($id)
    {
        try {
            // Cari user berdasarkan ID
            $user = User::findOrFail($id);
            // Ubah status menjadi 'rejected' atau status lain yang menandakan nonaktif
            $user->status = 'rejected';
            $user->save();

            // Redirect kembali dengan pesan sukses
            return back()->with('success', 'Akun penduduk berhasil dinonaktifkan.');
        } catch (\Exception $e) {
            // Redirect kembali dengan pesan error jika terjadi masalah
            return back()->with('error', 'Gagal menonaktifkan akun: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            // Cari dan hapus user berdasarkan ID
            $user = User::findOrFail($id);
            $user->delete();

            // Redirect kembali dengan pesan sukses
            return back()->with('success', 'Akun penduduk berhasil dihapus.');
        } catch (\Exception $e) {
            // Redirect kembali dengan pesan error
            return back()->with('error', 'Gagal menghapus akun: ' . $e->getMessage());
        }
    }

    public function bulkDestroy(Request $request)
    {
        // Validasi input, pastikan 'ids' adalah array dan tidak kosong
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:users,id',
        ]);

        try {
            // Hitung jumlah ID yang akan dihapus
            $count = count($request->ids);
            // Hapus semua user yang ID-nya ada di dalam array 'ids'
            User::whereIn('id', $request->ids)->delete();

            // Redirect kembali dengan pesan sukses
            return back()->with('success', "$count akun penduduk berhasil dihapus.");
        } catch (\Exception $e) {
            // Redirect kembali dengan pesan error
            return back()->with('error', 'Gagal menghapus akun terpilih: ' . $e->getMessage());
        }
    }

    public function profileView()
    {
        return view('pages.profile.index');
    }

    public function updateProfile(Request $request, $id)
    {
        // Cari user berdasarkan ID
        $user = User::findOrFail($id);

        // Lakukan validasi terlebih dahulu
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
        ]);

        // Jika validasi berhasil, perbarui data user
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->save();

        return back()->with('success', 'Profil berhasil diperbarui.');
    }

    public function changePasswordView()
    {
        return view('pages.profile.change-password');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
        ]);

        $user = $request->user();

        if (!Hash::check($request->input('current_password'), $user->password)) {
            return back()->withErrors(['current_password' => 'Kata sandi saat ini tidak cocok.']);
        }

        $user->password = Hash::make($request->input('new_password'));
        $user->save();

        return back()->with('success', 'Kata sandi berhasil diperbarui.');
    }
}
