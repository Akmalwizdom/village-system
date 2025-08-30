<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ComplaintController extends Controller
{
    public function index()
    {
        if (!Auth::user()->resident) {
            // Pengguna ini login, tapi tidak terdaftar sebagai penduduk.
            abort(403, 'Akses ditolak: Akun Anda tidak terhubung dengan data penduduk.');
        }

        $residentId = Auth::user()->resident->id;
        $complaints = Complaint::where('resident_id', Auth::user()->resident->id)->paginate(5);

        return view('pages.complaint.index', compact('complaints'));
    }

    public function create()
    {
        return view('pages.complaint.create');
    }

    public function store(Request $request)
    {
        if (!Auth::user()->resident) {
            abort(403, 'Akses ditolak: Akun Anda tidak terhubung dengan data penduduk.');
        }
        $request->validate([
            'title' => ['required', 'max:255'],
            'content' => ['required', 'max:2000'],
            'photo_proof' => ['nullable', 'image', 'mimes:jpg,png,jpeg', 'max:2048'],
        ]);

        $complaint = new Complaint();
        $complaint->resident_id = Auth::user()->resident->id;
        $complaint->title = $request->input('title');
        $complaint->content = $request->input('content');

        if ($request->hasFile('photo_proof')) {
            $filePath = $request->file('photo_proof')->store('public/uploads');
            $complaint->photo_proof = $filePath;
        }
        $complaint->save();

        return redirect('/complaint')->with('success', 'Aduan berhasil dibuat.');
    }

    public function edit($id)
    {
        $complaint = Complaint::findOrFail($id);
        return view('pages.complaint.edit', compact('complaint'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => ['required', 'max:255'],
            'content' => ['required', 'max:2000'],
            'photo_proof' => ['nullable', 'image', 'mimes:jpg,png,jpeg', 'max:2048'],
        ]);

        $complaint = Complaint::findOrFail($id);
        $complaint->title = $request->input('title');
        $complaint->content = $request->input('content');

        if ($request->hasFile('photo_proof')) {
            if (isset($complaint->photo_proof)) {
                Storage::delete($complaint->photo_proof);
            }
            $filePath = $request->file('photo_proof')->store('public/uploads');
            $complaint->photo_proof = $filePath;
        }
        $complaint->save();

        return redirect('/complaint')->with('success', 'Aduan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $complaint = Complaint::findOrFail($id);
        $complaint->delete();

        return redirect('/complaint')->with('success', 'Aduan berhasil dihapus.');
    }
}
