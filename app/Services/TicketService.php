<?php
// app/Services/TicketService.php
namespace App\Services;

use App\Models\Ticket;
use App\Models\Reservation;
use App\Mail\TicketMail;
use Illuminate\Support\Facades\Mail;

class TicketService
{
    // public function generateAndSendTickets(Reservation $reservation)
    // {
    //     // Get all the details needed for the ticket
    //     $user = $reservation->user;
    //     $recurrence = $reservation->recurrence;
    //     $event = $recurrence->event;
    //     $room = $recurrence->room;
        
    //     // Load relationship to get the count of tickets
    //     $ticketCount = Ticket::where('reservation_id', $reservation->id)->count();
        
    //     // Get regular and discount tickets from the reservation
    //     $regularTickets = Ticket::where('reservation_id', $reservation->id)
    //                             ->where('tariff_type', 'regular')
    //                             ->get();
                                
    //     $discountTickets = Ticket::where('reservation_id', $reservation->id)
    //                              ->where('tariff_type', 'discount')
    //                              ->get();
        
    //     // Prepare event details
    //     $eventDetails = [
    //         'title' => $event->title,
    //         'description' => $event->description,
    //         'date' => $recurrence->event_timestamp->format('F j, Y, g:i a'),
    //         'address' => $event->address,
    //         'userName' => $user->name,
    //         'room' => $room->description,
    //         'category' => $event->category->name
    //     ];
        
    //     // Send email for each ticket
    //     foreach ($regularTickets as $ticket) {
    //         Mail::to($user->email)->send(new TicketMail($ticket, $eventDetails));
    //     }
        
    //     foreach ($discountTickets as $ticket) {
    //         Mail::to($user->email)->send(new TicketMail($ticket, $eventDetails));
    //     }
        
    //     return $ticketCount;
    // }
}