<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    public function index()
    {
        $events = Event::where('start_date', '>=', now()->subDays(30))
            ->orderBy('start_date', 'desc')
            ->paginate(9);

        return view('pages.announcement.index', compact('events'));
    }
}
