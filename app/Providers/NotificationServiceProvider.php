<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Models\Role;

class NotificationServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Ganti 'layouts.navbar' dengan path view navbar Anda yang sebenarnya
        View::composer('layouts.navbar', function ($view) {
            if (Auth::check()) {
                $user = Auth::user();

                // 2. Tambahkan kondisi untuk memeriksa apakah user adalah penduduk
                if ($user->role_id == Role::ROLE_USER) {
                    // Ambil 5 notifikasi teratas yang belum dibaca
                    $notifications = $user->unreadNotifications()->take(5)->get();
                    $notificationCount = $user->unreadNotifications()->count();

                    // Kirim data notifikasi ke view
                    $view->with([
                        'notifications' => $notifications,
                        'notificationCount' => $notificationCount,
                    ]);
                }
            }
        });
    }
}