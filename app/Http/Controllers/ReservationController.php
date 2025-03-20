<?php

namespace App\Http\Controllers;

use App\Services\ReservationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\TicketService;
use Exception;

class ReservationController extends Controller
{
    protected $reservationService;

    public function __construct(ReservationService $reservationService, TicketService $ticketService)
    {
        $this->reservationService = $reservationService;
        $this->ticketService = $ticketService;
    }

    public function store(Request $request)
    {
        $request->validate([
            'event_id' => 'required|exists:recurrences,id',
            'regular_tickets' => 'required|integer|min:0',
            'discount_tickets' => 'required|integer|min:0',
        ]);

        if (!Auth::check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $reservation = $this->reservationService->makeReservation(
            $request->event_id,
            $request->regular_tickets,
            $request->discount_tickets
        );

        $this->ticketService->generateAndSendTickets($reservation);

        return response()->json([
            'message' => 'Reservation successful!',
            'reservation_id' => $reservation->id
        ]);
    }
    public function getUserReservations($userId)
    {
        $reservations =  $this->reservationService->getUserReservations($userId);
        return response()->json($reservations);
    }

   
}