<?php

namespace App\Http\Controllers;
use App\Models\Reservation;

use Illuminate\Http\Request;

class TestReservation extends Controller
{
    public function index()
    {
        $reservations = Reservation::with('user','recurrence')->get();
    
        return view('index',compact('reservations'));
    }
}
