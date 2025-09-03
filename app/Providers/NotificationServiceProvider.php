<?php

namespace App\Providers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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
        View::composer('layouts.navbar', function ($view) {
            if (Auth::check()) {
                $user = Auth::user();
                // Ambil 5 notifikasi teratas yang belum dibaca
                $notifications = $user->unreadNotifications()->take(5)->get();
                $notificationCount = $user->unreadNotifications()->count();

                $view->with([
                    'notifications' => $notifications,
                    'notificationCount' => $notificationCount,
                ]);
            }
        });
    }
}