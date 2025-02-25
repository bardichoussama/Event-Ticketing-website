<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recurrence;

class RecurrencesController extends Controller
{
    // public function index(Request $request)
    // {
    //     $events = Recurrence::with('event');  // Eager load the related 'event'
    //     $filters = $request->all();
    
    //     // Filter by event title if 'name' is provided
    //     if (!empty($filters['name'])) {
    //         $events->whereHas('event', function ($query) use ($filters) {
    //             $query->where('title', 'like', '%' . $filters['name'] . '%');
    //         });
    //     }
    
    //     // Filter by date range if both 'start_date' and 'end_date' are provided
    //     if (!empty($filters['start_date']) && !empty($filters['end_date'])) {
    //         $events->whereHas('event.recurrences', function ($query) use ($filters) {
    //             // Ensure that the date format matches what is expected in the database
    //             $query->whereBetween('event_timestamp', [
    //                 $filters['start_date'],
    //                 $filters['end_date']
    //             ]);
    //         });
    //     }
    
    //     // Fetch the filtered events and include the necessary relationships
    //     $events = $events->get();
    
    //     return response()->json($events);
    // }
    
}

