<?php

namespace App\Services;

use App\Models\Recurrence;
use App\Models\Ticket;
use App\Repositories\ReservationRepository;
use App\Repositories\TicketRepository;
use App\Repositories\EventRepository;
use Illuminate\Support\Facades\Auth;
use Exception;

class ReservationService
{
    protected $reservationRepository;
    protected $ticketRepository;
    protected $eventRepository;

    public function __construct(ReservationRepository $reservationRepository, TicketRepository $ticketRepository, EventRepository $eventRepository)
    {
        $this->reservationRepository = $reservationRepository;
        $this->ticketRepository = $ticketRepository;
        $this->eventRepository = $eventRepository;
    }

    public function makeReservation($eventId, $regularTickets, $discountTickets)
    {
        $user = Auth::user();
        $totalRequestedTickets = $regularTickets + $discountTickets;

        $recurrence = $this->eventRepository->findWithRoom($eventId);
        if (!$recurrence) {
            throw new Exception("Recurrence not found.");
        }

        $roomCapacity = $recurrence->room->capacity;
        $existingTickets = $this->ticketRepository->countTicketsForRecurrence($eventId);
        $availableSeats = $roomCapacity - $existingTickets;

        if ($availableSeats < $totalRequestedTickets) {
            throw new Exception("Not enough seats available. Only {$availableSeats} seats left.");
        }

        $reservation = $this->reservationRepository->createReservation([
            'user_id' => $user->id,
            'recurrence_id' => $eventId,
            'reservation_date' => now(),
        ]);

        $this->ticketRepository->createTickets($reservation->id, $regularTickets, $discountTickets);

        return $reservation;
    }

    public function getTicketAvailability($eventId)
    {
        $recurrence = Recurrence::with('room')->find($eventId);
        if (!$recurrence) {
            throw new Exception('Recurrence not found.');
        }

        $roomCapacity = $recurrence->room->capacity;
        $existingTickets = Ticket::where('reservation_id', $eventId)->count();
        $availableSeats = $roomCapacity - $existingTickets;

        return [
            'recurrence' => $recurrence,
            'available' => $availableSeats > 0,
            'availableSeats' => $availableSeats,
            'totalCapacity' => $roomCapacity
        ];
    }
}
