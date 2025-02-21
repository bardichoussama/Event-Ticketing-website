<?php
namespace App\Repositories;

use App\Models\Ticket;

class TicketRepository
{
    protected $ticket;

    // Inject the Ticket model
    public function __construct(Ticket $ticket)
    {
        $this->ticket = $ticket;
    }

    public function createTickets($reservationId, $regularTickets, $discountTickets)
    {
        $tickets = [];

        for ($i = 0; $i < $regularTickets; $i++) {
            $tickets[] = [
                'reservation_id' => $reservationId,
                'tariff_type' => 'regular',
                'seat' => $i + 1,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        for ($i = 0; $i < $discountTickets; $i++) {
            $tickets[] = [
                'reservation_id' => $reservationId,
                'tariff_type' => 'discount',
                'seat' => $i + $regularTickets + 1,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        $this->ticket->insert($tickets); 
    }
}

