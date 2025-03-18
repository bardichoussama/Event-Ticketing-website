<?php

namespace App\Interfaces;

interface ITicketRepository
{
    public function createTickets($reservationId, $regularTickets, $discountTickets);
    public function countTicketsForRecurrence($recurrenceId);
}