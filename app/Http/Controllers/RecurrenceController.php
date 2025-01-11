<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recurrence;

class RecurrenceController extends Controller
{
    public function index()
    {
       
        $events = [
            ['id' => 1, 'name' => 'Event 1', 'date' => '2025-01-01'],
            ['id' => 2, 'name' => 'Event 2', 'date' => '2025-01-02'],
        ];

        return response()->json($events);
    
    }
}
