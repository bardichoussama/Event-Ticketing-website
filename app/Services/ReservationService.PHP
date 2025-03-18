<?php

namespace App\Services;

use App\Models\Recurrence;
use App\Models\Ticket;
use App\Repositories\TicketRepository;
use App\Interfaces\IReservationRepository;
use App\Interfaces\IEventRepository;

use Illuminate\Support\Facades\Auth;
use Exception;

class ReservationService {
    protected $reservationRepository;
    protected $ticketRepository;
    protected $eventRepository;

    public function __construct(IReservationRepository $reservationRepository, TicketRepository $ticketRepository, IEventRepository $eventRepository)
    {
        $this->reservationRepository = $reservationRepository;
        $this->ticketRepository = $ticketRepository;
        $this->eventRepository = $eventRepository;
    }


    public function makeReservation($eventId, $regularTickets, $discountTickets)
    {
        $user = Auth::user();
        $totalRequestedTickets = $regularTickets + $discountTickets;

        $recurrence = $this->eventRepository->findRecurrenceWithRoom($eventId);
        if (!$recurrence) {
            throw new Exception("Recurrence not found.");
        }
        if(now() > $recurrence->event_timestamp){
            throw new Exception("Event has already ended.");
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
    public function getUserReservations($userId)
    {
        $reservations = $this->reservationRepository->getUserReservations($userId);
        return $reservations->map(function ($reservation) {
            $regularTickets = $reservation->tickets->where('tariff_type', 'regular')->count();
            $discountTickets = $reservation->tickets->where('tariff_type', 'discount')->count();

            $regularPrice = $reservation->recurrence->event->regular_price;
            $discountPrice = $reservation->recurrence->event->discount_price;
            $totalPrice = ($regularTickets * $regularPrice) + ($discountTickets * $discountPrice);

            return [
                'user_id' => $reservation->user->id,
                'user_name' => $reservation->user->name,
                'user_email' => $reservation->user->email,
                'purchase_date' => $reservation->created_at,
                'reservation_id' => $reservation->id,
                'event_title' => $reservation->recurrence->event->title,
                'regular_price' => $regularPrice,
                'discount_price' => $discountPrice,
                'regular_tickets_count' => $regularTickets,
                'discount_tickets_count' => $discountTickets,
                'total_price' => $totalPrice,
                'event_date' => $reservation->recurrence->event_timestamp,
                'room_description' => $reservation->recurrence->room->description
            ];
        });
    }
    }
