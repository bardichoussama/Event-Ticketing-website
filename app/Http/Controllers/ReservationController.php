<?php

namespace App\Http\Controllers;

use App\Services\ReservationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Exception;

class ReservationController extends Controller
{
    protected $reservationService;

    public function __construct(ReservationService $reservationService)
    {
        $this->reservationService = $reservationService;

    }

    public function store(Request $request)
    {
        
        $request->validate([
            'event_id' => 'required|exists:recurrences,id',
            'regular_tickets' => 'required|integer|min:0',
            'discount_tickets' => 'required|integer|min:0',
        ]);

        $reservation = $this->reservationService->makeReservation(
            $request->event_id,
            $request->regular_tickets,
            $request->discount_tickets
        );
        return response()->json([
            'message' => 'Reservation successful!',
            'reservation_id' => $reservation->id
        ]);  
    }
    public function getUserReservations($userId)
    {
        try {
            $reservations = $this->reservationService->getUserReservations($userId);
            return response()->json($reservations);
        } catch (\Exception $e) {
            // Log the error
            \Log::error('Reservation error: ' . $e->getMessage() . ' in ' . $e->getFile() . ' on line ' . $e->getLine());
            
            // Return a more helpful error response
            return response()->json([
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ], 500);
        }
    }
   
}