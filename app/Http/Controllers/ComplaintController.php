<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

class ComplaintController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->role_id == 1) {
            $complaints = Complaint::with('resident')->latest()->paginate(10);
        } else {
            if (!$user->resident) {
                abort(403, 'Akses ditolak: Akun Anda tidak terhubung dengan data penduduk.');
            }

            $complaints = Complaint::where('resident_id', $user->resident->id)->latest()->paginate(5);
        }

        return view('pages.complaint.index', compact('complaints'));
    }

    public function create()
    {
        if (Auth::user()->role_id == 1) {
            abort(403, 'Akses ditolak: Admin tidak dapat membuat aduan.');
        }
        return view('pages.complaint.create');
    }

    public function store(Request $request)
    {
        if (Auth::user()->role_id == 1) {
            abort(403, 'Akses ditolak: Admin tidak dapat membuat aduan.');
        }

        if (!Auth::user()->resident) {
            abort(403, 'Akses ditolak: Akun Anda tidak terhubung dengan data penduduk.');
        }

        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string', 'max:2000'],
            'photo_proof' => ['nullable', 'image', 'mimes:jpg,png,jpeg', 'max:2048'],
        ]);

        $data = $request->only(['title', 'content']);
        $data['resident_id'] = Auth::user()->resident->id;

        if ($request->hasFile('photo_proof')) {
            $data['photo_proof'] = $request->file('photo_proof')->store('public/uploads');
        }

        Complaint::create($data);

        return redirect('/complaint')->with('success', 'Aduan berhasil dibuat.');
    }

    public function edit($id)
    {
        if (Auth::user()->role_id == 1) {
            abort(403, 'Akses ditolak: Admin tidak dapat mengubah aduan.');
        }

        $complaint = Complaint::where('id', $id)
                              ->where('resident_id', Auth::user()->resident->id)
                              ->firstOrFail();
                              
        return view('pages.complaint.edit', compact('complaint'));
    }

    public function update(Request $request, $id)
    {
        if (Auth::user()->role_id == 1) {
            abort(403, 'Akses ditolak: Admin tidak dapat mengubah aduan.');
        }

        $complaint = Complaint::where('id', $id)
                              ->where('resident_id', Auth::user()->resident->id)
                              ->firstOrFail();

        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'content' => ['required', 'string', 'max:2000'],
            'photo_proof' => ['nullable', 'image', 'mimes:jpg,png,jpeg', 'max:2048'],
        ]);

        $complaint->title = $request->input('title');
        $complaint->content = $request->input('content');

        if ($request->hasFile('photo_proof')) {
            // Hapus foto lama jika ada
            if ($complaint->photo_proof) {
                Storage::delete($complaint->photo_proof);
            }
            $complaint->photo_proof = $request->file('photo_proof')->store('public/uploads');
        }
        $complaint->save();

        return redirect('/complaint')->with('success', 'Aduan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        if (Auth::user()->role_id == 1) {
            abort(403, 'Akses ditolak: Admin tidak dapat menghapus aduan.');
        }
        
        $complaint = Complaint::where('id', $id)
                              ->where('resident_id', Auth::user()->resident->id)
                              ->firstOrFail();

        if ($complaint->photo_proof) {
            Storage::delete($complaint->photo_proof);
        }

        $complaint->delete();

        return redirect('/complaint')->with('success', 'Aduan berhasil dihapus.');
    }

    public function updateStatus(Request $request, $id)
    {
        if (Auth::user()->role_id != 1) {
            abort(403, 'Akses ditolak: Hanya admin yang dapat mengubah status aduan.');
        }
        $request->validate([
            'status' => ['required', 'string', Rule::in(['new', 'processing', 'completed'])],
        ]);

        $complaint = Complaint::findOrFail($id);

        $complaint->status = $request->input('status');
        $complaint->save();

        return redirect('/complaint')->with('success', 'Status aduan berhasil diperbarui.');
    }
}