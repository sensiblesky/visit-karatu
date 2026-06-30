<?php

namespace App\Http\Controllers;

use App\Models\Event;

class EventController extends Controller
{
    public function index()
    {
        $events = Event::with('location')->orderBy('starts_at')->paginate(12);
        return view('events.index', compact('events'));
    }
}
