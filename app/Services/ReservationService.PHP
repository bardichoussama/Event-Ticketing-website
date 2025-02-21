<?php
namespace App\Services;

use App\Repositories\ReservationRepository;
use App\Repositories\TicketRepository;
use Illuminate\Support\Facades\Auth;

class ReservationService
{
    protected $reservationRepository;
    protected $ticketRepository;

    public function __construct(ReservationRepository $reservationRepository, TicketRepository $ticketRepository)
    {
        $this->reservationRepository = $reservationRepository;
        $this->ticketRepository = $ticketRepository;
    }

    public function makeReservation($eventId, $regularTickets, $discountTickets)
    {
        $user = Auth::user();

        $reservation = $this->reservationRepository->createReservation([
            'user_id' => $user->id,
            'recurrence_id' => $eventId,
            'reservation_date' => now(),
        ]);

        // Create tickets
        $this->ticketRepository->createTickets($reservation->id, $regularTickets, $discountTickets);

        return $reservation;
    }
}
