<?php

namespace App\Http\Controllers;

use App\Models\Resident;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function accountRequestView(Request $request)
    {
        $request->validate([
            'status' => 'sometimes|in:submitted,approved,rejected',
        ]);

        $residents = Resident::where('user_id', null)->get();

        $users = User::query()
            ->when($request->status, function ($query, $status) {
                return $query->where('status', $status);
            })->latest()->get();

        return view('pages.account-request.index', [
            'users' => $users,
            'residents' => $residents,
        ]);
    }

    public function accountRequestApproval($id, Request $request)
    {
        // Validasi input dari form
        $request->validate([
            'status' => 'required|in:approved,rejected',
            // Jika statusnya 'approved', resident_id wajib diisi
            'resident_id' => 'required_if:status,approved|exists:residents,id',
        ]);

        $user = User::findOrFail($id);
        $user->status = $request->status;
        $user->save();

        // Jika disetujui, update kolom 'user_id' di tabel residents
        if ($request->status == 'approved') {
            $resident = Resident::find($request->resident_id);
            if ($resident) {
                $resident->user_id = $user->id;
                $resident->save();
            }
        }

        return back()->with('success', 'Permintaan akun berhasil diperbarui.');
    }

    public function accountListView()
    {
        $perPage = request('per_page', 10);
        $users = User::with('resident')->paginate($perPage);
        
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
