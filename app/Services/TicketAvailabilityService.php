<?php

namespace App\Services;

use App\Repositories\EventRepository;
use App\Repositories\TicketRepository;
use App\Repositories\ReservationRepository;
use Exception;

class TicketAvailabilityService
{
    protected $eventRepository;
    protected $ticketRepository;
    protected $reservationRepository;

    public function __construct(EventRepository $eventRepository, TicketRepository $ticketRepository, ReservationRepository $reservationRepository)
    {
        $this->eventRepository = $eventRepository;
        $this->ticketRepository = $ticketRepository;
        $this->reservationRepository = $reservationRepository;
    }

    public function getTicketAvailability($eventId)
    {
        $recurrence = $this->eventRepository->findWithRoom($eventId);
        if (!$recurrence) {
            throw new Exception('Recurrence not found.');
        }

        // Get room capacity
        $roomCapacity = $recurrence->room->capacity;

        // Get the number of existing tickets booked
        $existingTickets = $this->ticketRepository->countTicketsForRecurrence($eventId);

        // Calculate available seats
        $availableSeats = $roomCapacity - $existingTickets;

        return [
            'event' => $recurrence,
            'available' => $availableSeats > 0,
            'availableSeats' => $availableSeats,
            'totalCapacity' => $roomCapacity
        ];
    }
}
