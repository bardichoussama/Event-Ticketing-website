<?php
namespace App\Repositories;

use App\Models\Ticket;
use App\Models\Reservation;

class TicketRepository
{
    public function createTickets($reservationId, $regularTickets, $discountTickets)
    {
        // Create regular tickets
        for ($i = 0; $i < $regularTickets; $i++) {
            Ticket::create([
                'reservation_id' => $reservationId,
                'tariff_type' => 'regular',
                'seat' => $this->getNextAvailableSeat($reservationId),
            ]);
        }
        
        // Create discount tickets
        for ($i = 0; $i < $discountTickets; $i++) {
            Ticket::create([
                'reservation_id' => $reservationId,
                'tariff_type' => 'discount',
                'seat' => $this->getNextAvailableSeat($reservationId),
            ]);
        }
    }
    public function countTicketsForRecurrence($recurrenceId)
    {
        return Ticket::whereHas('reservation', function ($query) use ($recurrenceId) {
            $query->where('recurrence_id', $recurrenceId);
        })->count();
    }
    
    private function getNextAvailableSeat($reservationId)
    {
   
        $reservation = Reservation::find($reservationId);
        $recurrenceId = $reservation->recurrence_id;
        
        $takenSeats = Ticket::whereHas('reservation', function ($query) use ($recurrenceId) {
            $query->where('recurrence_id', $recurrenceId);
        })->pluck('seat')->toArray();
        
        $seat = 1;
        while (in_array($seat, $takenSeats)) {
            $seat++;
        }
        
        return $seat;
    }
}
