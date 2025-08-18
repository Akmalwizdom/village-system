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
}