<?php

namespace App\Http\Controllers;

use App\Models\Letter;
use App\Models\LetterTemplate;
use App\Models\Resident;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class LetterController extends Controller
{
    /**
     * Display a listing of letters.
     */
    public function index()
    {
        $user = Auth::user();
        
        if ($user->role_id == 1) {
            // Admin sees all letters
            $letters = Letter::with(['template', 'resident', 'approver'])
                ->latest()
                ->paginate(10);
        } else {
            // User sees only their own letters
            $resident = $user->resident;
            $letters = $resident 
                ? Letter::with(['template', 'resident'])
                    ->where('resident_id', $resident->id)
                    ->latest()
                    ->paginate(10)
                : collect();
        }

        return view('pages.letter.index', compact('letters'));
    }

    /**
     * Show the form for creating a new letter.
     */
    public function create()
    {
        $user = Auth::user();
        $resident = $user->resident;
        
        if (!$resident) {
            return redirect()->back()->with('error', 'Anda harus terdaftar sebagai penduduk untuk mengajukan surat.');
        }

        $templates = LetterTemplate::active()->get();
        
        return view('pages.letter.create', compact('templates', 'resident'));
    }

    /**
     * Store a newly created letter.
     */
    public function store(Request $request)
    {
        $request->validate([
            'letter_template_id' => 'required|exists:letter_templates,id',
            'purpose' => 'required|string|max:500',
        ]);

        $user = Auth::user();
        $resident = $user->resident;
        
        if (!$resident) {
            return redirect()->back()->with('error', 'Anda harus terdaftar sebagai penduduk.');
        }

        $letter = Letter::create([
            'letter_template_id' => $request->letter_template_id,
            'resident_id' => $resident->id,
            'purpose' => $request->purpose,
            'status' => 'pending',
        ]);

        return redirect()->route('letter.index')
            ->with('success', 'Pengajuan surat berhasil dibuat dengan nomor: ' . $letter->letter_number);
    }

    /**
     * Display the specified letter.
     */
    public function show(Letter $letter)
    {
        $this->authorizeView($letter);
        
        $letter->load(['template', 'resident', 'approver']);
        
        // Generate content if approved and not yet generated
        if ($letter->status === 'approved' && !$letter->generated_content) {
            $letter->generated_content = $letter->generateContent();
            $letter->save();
        }

        return view('pages.letter.show', compact('letter'));
    }

    /**
     * Approve a letter (Admin only).
     */
    public function approve(Letter $letter)
    {
        $user = Auth::user();
        
        if ($user->role_id != 1) {
            abort(403);
        }

        // Generate content with QR placeholder
        $content = $letter->generateContent();

        $letter->update([
            'status' => 'approved',
            'generated_content' => $content,
            'approved_by' => $user->id,
            'approved_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Surat berhasil disetujui.');
    }

    /**
     * Reject a letter (Admin only).
     */
    public function reject(Request $request, Letter $letter)
    {
        $user = Auth::user();
        
        if ($user->role_id != 1) {
            abort(403);
        }

        $request->validate([
            'rejection_reason' => 'required|string|max:500',
        ]);

        $letter->update([
            'status' => 'rejected',
            'rejection_reason' => $request->rejection_reason,
        ]);

        return redirect()->back()->with('success', 'Surat ditolak.');
    }

    /**
     * Download letter as PDF.
     */
    public function download(Letter $letter)
    {
        $this->authorizeView($letter);
        
        if ($letter->status !== 'approved') {
            return redirect()->back()->with('error', 'Surat belum disetujui.');
        }

        $letter->load(['template', 'resident']);
        
        // Generate QR Code as base64 image
        $qrCode = base64_encode(QrCode::format('png')
            ->size(100)
            ->generate($letter->getVerificationUrl()));
        
        // Replace QR placeholder in content
        $content = str_replace(
            '{{qr_code}}', 
            '<img src="data:image/png;base64,' . $qrCode . '" style="width: 100px; height: 100px;">', 
            $letter->generated_content
        );

        $pdf = Pdf::loadView('pages.letter.pdf', [
            'letter' => $letter,
            'content' => $content,
        ]);

        $filename = $letter->template->code . '_' . str_replace('/', '-', $letter->letter_number) . '.pdf';
        
        return $pdf->download($filename);
    }

    /**
     * Preview letter (HTML).
     */
    public function preview(Letter $letter)
    {
        $this->authorizeView($letter);
        
        if ($letter->status !== 'approved') {
            return redirect()->back()->with('error', 'Surat belum disetujui.');
        }

        $letter->load(['template', 'resident']);
        
        // Generate QR Code as base64 image
        $qrCode = base64_encode(QrCode::format('png')
            ->size(100)
            ->generate($letter->getVerificationUrl()));
        
        // Replace QR placeholder in content
        $content = str_replace(
            '{{qr_code}}', 
            '<img src="data:image/png;base64,' . $qrCode . '" style="width: 100px; height: 100px;">', 
            $letter->generated_content
        );

        return view('pages.letter.preview', [
            'letter' => $letter,
            'content' => $content,
        ]);
    }

    /**
     * Verify letter by QR code (Public).
     */
    public function verify($qrCode)
    {
        $letter = Letter::with(['template', 'resident', 'approver'])
            ->where('qr_code', $qrCode)
            ->first();

        return view('pages.letter.verify', compact('letter'));
    }

    /**
     * Check if user can view this letter.
     */
    private function authorizeView(Letter $letter)
    {
        $user = Auth::user();
        
        // Admin can view all
        if ($user->role_id == 1) {
            return true;
        }
        
        // User can only view their own
        $resident = $user->resident;
        if (!$resident || $letter->resident_id !== $resident->id) {
            abort(403);
        }
        
        return true;
    }
}
