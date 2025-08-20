<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

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
}