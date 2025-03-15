<?php

namespace App\Http\Controllers;

use App\Services\TicketAvailabilityService;
use Illuminate\Http\Request;
use Exception;

class TicketAvailabilityController extends Controller
{
    protected $ticketAvailabilityService;

    public function __construct(TicketAvailabilityService $ticketAvailabilityService)
    {
        $this->ticketAvailabilityService = $ticketAvailabilityService;
    }

    public function checkAvailability($eventId)
    {
        try {
            $result = $this->ticketAvailabilityService->getTicketAvailability($eventId);
            return response()->json($result);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
