<?php

namespace App\Services;

use App\Repositories\EventRepository;

class EventService
{
    protected $eventRepository;

    public function __construct(EventRepository $eventRepository)
    {
        $this->eventRepository = $eventRepository;
    }

    public function getEvents(array $filters = [])
    {
        if (empty($filters)) {
            return $this->eventRepository->getAllEvents();
        }

        return $this->eventRepository->getFilteredEvents($filters);
    }
}