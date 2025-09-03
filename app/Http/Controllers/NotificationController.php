<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\DatabaseNotification;

class NotificationController extends Controller
{
    /**
     * Tandai notifikasi sebagai sudah dibaca.
     */
    public function markAsRead(DatabaseNotification $notification)
    {
        // Pastikan pengguna yang login adalah pemilik notifikasi
        if (Auth::id() === $notification->notifiable_id) {
            $notification->markAsRead();
            return response()->json(['success' => true]);
        }

        return response()->json(['error' => 'Unauthorized'], 403);
    }
}