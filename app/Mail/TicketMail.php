<?php
// app/Mail/TicketMail.php
namespace App\Mail;

use App\Models\Ticket;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Barryvdh\DomPDF\Facade\Pdf; 


class TicketMail extends Mailable
{
    use Queueable, SerializesModels;

    public $ticket;
    public $eventDetails;

    public function __construct(Ticket $ticket, $eventDetails)
    {
        $this->ticket = $ticket;
        $this->eventDetails = $eventDetails;
    }

    public function build()
    {
        return $this->view('emails.ticket')
                    ->subject('Your Event Ticket')
                    ->attachData(
                        $this->generateTicketPDF(),
                        'ticket-' . $this->ticket->id . '.pdf',
                        [
                            'mime' => 'application/pdf',
                        ]
                    );
    }
    
    private function generateTicketPDF()
    {
        // Generate PDF using a library like DOMPDF or FPDF
        $pdf = app('dompdf.wrapper');
        $pdf->loadView('emails.ticket-pdf', [
            'ticket' => $this->ticket,
            'eventDetails' => $this->eventDetails
        ]);
        
        return $pdf->output();
    }
}