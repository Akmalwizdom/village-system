<?php

namespace App\Http\Controllers;

use App\Models\Resident;
use App\Models\Complaint;
use App\Models\FinanceTransaction;
use App\Models\Event;
use App\Exports\ResidentExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function index()
    {
        // Basic statistics
        $totalResidents = Resident::where('status', 'active')->count();
        $maleCount = Resident::where('status', 'active')->where('gender', 'male')->count();
        $femaleCount = Resident::where('status', 'active')->where('gender', 'female')->count();
        
        // Age distribution for pyramid
        $ageGroups = $this->getAgePyramidData();
        
        // Religion distribution
        $religionData = Resident::where('status', 'active')
            ->select('religion', DB::raw('count(*) as total'))
            ->groupBy('religion')
            ->orderByDesc('total')
            ->get();
        
        // Occupation distribution
        $occupationData = Resident::where('status', 'active')
            ->select('occupation', DB::raw('count(*) as total'))
            ->groupBy('occupation')
            ->orderByDesc('total')
            ->limit(10)
            ->get();
        
        // Marital status distribution
        $maritalData = Resident::where('status', 'active')
            ->select('marital_status', DB::raw('count(*) as total'))
            ->groupBy('marital_status')
            ->get();
        
        // Monthly trend - residents created
        $residentTrend = Resident::select(
                DB::raw("DATE_FORMAT(created_at, '%Y-%m') as month"),
                DB::raw('count(*) as total')
            )
            ->where('created_at', '>=', now()->subMonths(12))
            ->groupBy('month')
            ->orderBy('month')
            ->get();
        
        // Complaint trend
        $complaintTrend = Complaint::select(
                DB::raw("DATE_FORMAT(created_at, '%Y-%m') as month"),
                DB::raw('count(*) as total')
            )
            ->where('created_at', '>=', now()->subMonths(12))
            ->groupBy('month')
            ->orderBy('month')
            ->get();
        
        // Marital status labels
        $maritalLabels = [
            'single' => 'Belum Menikah',
            'married' => 'Menikah',
            'divorced' => 'Cerai',
            'widowed' => 'Duda/Janda'
        ];

        return view('pages.report.index', compact(
            'totalResidents',
            'maleCount',
            'femaleCount',
            'ageGroups',
            'religionData',
            'occupationData',
            'maritalData',
            'maritalLabels',
            'residentTrend',
            'complaintTrend'
        ));
    }

    private function getAgePyramidData()
    {
        $ageRanges = [
            '0-4', '5-9', '10-14', '15-19', '20-24', '25-29', 
            '30-34', '35-39', '40-44', '45-49', '50-54', '55-59', '60-64', '65+'
        ];
        
        $result = [];
        
        foreach ($ageRanges as $range) {
            if ($range === '65+') {
                $minAge = 65;
                $maxAge = 150;
            } else {
                [$minAge, $maxAge] = explode('-', $range);
            }
            
            $minDate = now()->subYears($maxAge + 1)->addDay();
            $maxDate = now()->subYears($minAge);
            
            $male = Resident::where('status', 'active')
                ->where('gender', 'male')
                ->whereBetween('birth_date', [$minDate, $maxDate])
                ->count();
                
            $female = Resident::where('status', 'active')
                ->where('gender', 'female')
                ->whereBetween('birth_date', [$minDate, $maxDate])
                ->count();
            
            $result[] = [
                'range' => $range,
                'male' => $male,
                'female' => $female
            ];
        }
        
        return $result;
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
        
        $pdf = PDF::loadView('pages.report.pdf', compact(
            'totalResidents',
            'maleCount',
            'femaleCount',
            'religionData',
            'occupationData',
            'maritalData',
            'maritalLabels'
        ));
        
        return $pdf->download('laporan_kependudukan_' . date('Y-m-d') . '.pdf');
    }
}
