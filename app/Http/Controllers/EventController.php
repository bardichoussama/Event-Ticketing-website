<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\EventService;


class EventController extends Controller
{
    protected $eventService;

    public function __construct(EventService $eventService)
    {
        $this->eventService = $eventService;
    }
 
    public function index(Request $request)
    {
        $events = $this->eventService->getEvents($request->all());
        return response()->json($events);
    }
    
}

