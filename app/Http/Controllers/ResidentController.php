<?php

namespace App\Http\Controllers;

use App\Models\Resident;
use App\Exports\ResidentExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;

class ResidentController extends Controller
{
    public function index()
    {
        $perPage = request('per_page', 10);
        $residents = Resident::with('user')->paginate($perPage);

        return view('pages.resident.index', [
            'residents' => $residents,
        ]);
    }

    public function create()
    {
        return view('pages.resident.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nik'=> ['required', 'min:16', 'max:16'],
            'name' => ['required', 'max:100'],
            'gender' => ['required', Rule::in(['male', 'female'])],
            'birth_date' => ['required', 'string'],
            'birth_place' => ['required', 'max:100'],
            'address' => ['required', 'max:700'],
            'religion' => ['nullable', 'max:50'],
            'marital_status' => ['required', Rule::in(['single', 'married', 'divorced', 'widowed'])],
            'occupation' => ['nullable', 'max:100'],
            'phone' => ['nullable', 'max:15'],
            'status' => ['required', Rule::in(['active', 'moved', 'deceased'])],
        ]);

        Resident::create($validatedData);

        return redirect('/resident')->with('success', 'Berhasil menambahkan data');
    }

    public function edit($id)
    {
        $resident = Resident::findOrFail($id);

        return view('pages.resident.edit', [
            'resident' => $resident,
        ]);
    }
    
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'nik'=> ['required', 'min:16', 'max:16'],
            'name' => ['required', 'max:100'],
            'gender' => ['required', Rule::in(['male', 'female'])],
            'birth_date' => ['required', 'string'],
            'birth_place' => ['required', 'max:100'],
            'address' => ['required', 'max:700'],
            'religion' => ['nullable', 'max:50'],
            'marital_status' => ['required', Rule::in(['single', 'married', 'divorced', 'widowed'])],
            'occupation' => ['nullable', 'max:100'],
            'phone' => ['nullable', 'max:15'],
            'status' => ['required', Rule::in(['active', 'moved', 'deceased'])],
        ]);

        Resident::findOrFail($id)->update($validatedData);

        return redirect('/resident')->with('success', 'Berhasil memperbarui data');
    }

    public function destroy($id)
    {
        $resident = Resident::findOrFail($id);
        $resident->delete();

        return redirect('/resident')->with('success', 'Berhasil menghapus data');
    }

    public function exportExcel()
    {
        return Excel::download(new ResidentExport, 'data_penduduk_' . date('Y-m-d') . '.xlsx');
    }

    public function exportPdf()
    {
        $totalResidents = Resident::where('status', 'active')->count();
        $maleCount = Resident::where('status', 'active')->where('gender', 'male')->count();
        $femaleCount = Resident::where('status', 'active')->where('gender', 'female')->count();
        
        $religionData = Resident::where('status', 'active')
            ->select('religion', DB::raw('count(*) as total'))
            ->groupBy('religion')
            ->orderByDesc('total')
            ->get();
        
        $occupationData = Resident::where('status', 'active')
            ->select('occupation', DB::raw('count(*) as total'))
            ->groupBy('occupation')
            ->orderByDesc('total')
            ->limit(10)
            ->get();
        
        $maritalData = Resident::where('status', 'active')
            ->select('marital_status', DB::raw('count(*) as total'))
            ->groupBy('marital_status')
            ->get();
        
        $maritalLabels = [
            'single' => 'Belum Menikah',
            'married' => 'Menikah',
            'divorced' => 'Cerai',
            'widowed' => 'Duda/Janda'
        ];
        
        $pdf = PDF::loadView('pages.resident.pdf', compact(
            'totalResidents',
            'maleCount',
            'femaleCount',
            'religionData',
            'occupationData',
            'maritalData',
            'maritalLabels'
        ));
        
        return $pdf->download('laporan_penduduk_' . date('Y-m-d') . '.pdf');
    }
}
