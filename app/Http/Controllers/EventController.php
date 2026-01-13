<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class EventController extends Controller
{
    /**
     * Display calendar and event list.
     */
    public function index(Request $request)
    {
        $month = $request->get('month', Carbon::now()->format('Y-m'));
        $date = Carbon::parse($month);

        // Events for calendar
        $events = Event::with('creator')
            ->inMonth($date->year, $date->month)
            ->orderBy('start_date')
            ->get();

        // Upcoming events
        $upcomingEvents = Event::upcoming()->take(5)->get();

        // Calendar data for JS
        $calendarEvents = $events->map(function ($event) {
            return [
                'id' => $event->id,
                'title' => $event->title,
                'start' => $event->start_date->format('Y-m-d H:i:s'),
                'end' => $event->end_date ? $event->end_date->format('Y-m-d H:i:s') : null,
                'allDay' => $event->is_all_day,
                'color' => $event->category_color,
                'url' => route('event.show', $event->id),
            ];
        });

        return view('pages.event.index', compact('events', 'upcomingEvents', 'calendarEvents', 'date', 'month'));
    }

    /**
     * Show the form for creating a new event.
     */
    public function create()
    {
        $this->authorizeAdmin();
        $categories = Event::CATEGORIES;
        
        return view('pages.event.create', compact('categories'));
    }

    /**
     * Store a newly created event.
     */
    public function store(Request $request)
    {
        $this->authorizeAdmin();

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'required|in:' . implode(',', array_keys(Event::CATEGORIES)),
            'location' => 'nullable|string|max:255',
            'start_date' => 'required|date',
            'start_time' => 'nullable|date_format:H:i',
            'end_date' => 'nullable|date',
            'end_time' => 'nullable|date_format:H:i',
            'is_all_day' => 'boolean',
        ]);

        $isAllDay = $request->boolean('is_all_day');
        
        $startDate = Carbon::parse($request->start_date);
        if (!$isAllDay && $request->start_time) {
            $startDate->setTimeFromTimeString($request->start_time);
        }

        $endDate = null;
        if ($request->end_date) {
            $endDate = Carbon::parse($request->end_date);
            if (!$isAllDay && $request->end_time) {
                $endDate->setTimeFromTimeString($request->end_time);
            }
        }

        Event::create([
            'title' => $request->title,
            'description' => $request->description,
            'category' => $request->category,
            'location' => $request->location,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'is_all_day' => $isAllDay,
            'created_by' => Auth::id(),
        ]);

        return redirect()->route('event.index')
            ->with('success', 'Kegiatan berhasil ditambahkan.');
    }

    /**
     * Display the specified event.
     */
    public function show(Event $event)
    {
        $event->load('creator');
        
        return view('pages.event.show', compact('event'));
    }

    /**
     * Show the form for editing an event.
     */
    public function edit(Event $event)
    {
        $this->authorizeAdmin();
        $categories = Event::CATEGORIES;
        
        return view('pages.event.edit', compact('event', 'categories'));
    }

    /**
     * Update the specified event.
     */
    public function update(Request $request, Event $event)
    {
        $this->authorizeAdmin();

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'required|in:' . implode(',', array_keys(Event::CATEGORIES)),
            'location' => 'nullable|string|max:255',
            'start_date' => 'required|date',
            'start_time' => 'nullable|date_format:H:i',
            'end_date' => 'nullable|date',
            'end_time' => 'nullable|date_format:H:i',
            'is_all_day' => 'boolean',
        ]);

        $isAllDay = $request->boolean('is_all_day');
        
        $startDate = Carbon::parse($request->start_date);
        if (!$isAllDay && $request->start_time) {
            $startDate->setTimeFromTimeString($request->start_time);
        }

        $endDate = null;
        if ($request->end_date) {
            $endDate = Carbon::parse($request->end_date);
            if (!$isAllDay && $request->end_time) {
                $endDate->setTimeFromTimeString($request->end_time);
            }
        }

        $event->update([
            'title' => $request->title,
            'description' => $request->description,
            'category' => $request->category,
            'location' => $request->location,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'is_all_day' => $isAllDay,
        ]);

        return redirect()->route('event.index')
            ->with('success', 'Kegiatan berhasil diperbarui.');
    }

    /**
     * Remove the specified event.
     */
    public function destroy(Event $event)
    {
        $this->authorizeAdmin();

        $event->delete();

        return redirect()->route('event.index')
            ->with('success', 'Kegiatan berhasil dihapus.');
    }

    /**
     * Get events for API (calendar).
     */
    public function getEvents(Request $request)
    {
        $start = $request->get('start');
        $end = $request->get('end');

        $events = Event::whereBetween('start_date', [$start, $end])
            ->get()
            ->map(function ($event) {
                return [
                    'id' => $event->id,
                    'title' => $event->title,
                    'start' => $event->start_date->toIso8601String(),
                    'end' => $event->end_date ? $event->end_date->toIso8601String() : null,
                    'allDay' => $event->is_all_day,
                    'color' => $event->category_color,
                    'url' => route('event.show', $event->id),
                ];
            });

        return response()->json($events);
    }

    /**
     * Check if user is admin.
     */
    private function authorizeAdmin()
    {
        if (Auth::user()->role_id != 1) {
            abort(403);
        }
    }
}
