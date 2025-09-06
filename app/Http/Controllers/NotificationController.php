<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Menampilkan halaman semua notifikasi.
     * (Fungsi ini untuk halaman 'Lihat Semua Notifikasi')
     */
    public function index()
    {
        $notifications = Auth::user()->notifications()->paginate(10);
        Auth::user()->unreadNotifications->markAsRead();
        return view('pages.notifications', compact('notifications'));
    }

    /**
     * Menandai satu notifikasi sebagai telah dibaca via API.
     */
    public function markAsRead(Request $request, $id)
    {
        $notification = Auth::user()->notifications()->where('id', $id)->first();
        if ($notification) {
            $notification->markAsRead();
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false], 404);
    }

    /**
     * Menandai semua notifikasi sebagai telah dibaca via API.
     */
    public function markAllAsRead(Request $request)
    {
        Auth::user()->unreadNotifications->markAsRead();
        return response()->json(['success' => true]);
    }
}