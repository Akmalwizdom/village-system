<?php

namespace App\Http\Controllers;

use App\Models\Resident;
use App\Models\Complaint;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $isAdmin = $user->role_id == 1;
        
        // Statistics data
        $stats = [
            'total_residents' => Resident::count(),
            'male_residents' => Resident::where('gender', 'male')->count(),
            'female_residents' => Resident::where('gender', 'female')->count(),
            'active_residents' => Resident::where('status', 'active')->count(),
        ];
        
        // Complaint statistics
        $complaintStats = [
            'new' => Complaint::where('status', 'new')->count(),
            'processing' => Complaint::where('status', 'processing')->count(),
            'completed' => Complaint::where('status', 'completed')->count(),
            'total' => Complaint::count(),
        ];
        
        // Recent complaints (for admin: all, for user: own)
        if ($isAdmin) {
            $recentComplaints = Complaint::with('resident')
                ->latest()
                ->take(5)
                ->get();
        } else {
            $resident = $user->resident;
            $recentComplaints = $resident 
                ? Complaint::where('resident_id', $resident->id)->latest()->take(5)->get()
                : collect();
        }
        
        // User statistics (admin only)
        $userStats = null;
        if ($isAdmin) {
            $userStats = [
                'total' => User::count(),
                'approved' => User::where('status', 'approved')->count(),
                'pending' => User::where('status', 'submitted')->count(),
            ];
        }
        
        return view('pages.dashboard', compact(
            'stats', 
            'complaintStats', 
            'recentComplaints', 
            'userStats',
            'isAdmin'
        ));
    }
}
