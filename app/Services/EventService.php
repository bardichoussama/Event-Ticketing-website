<?php

namespace App\Services;

 use App\Interfaces\IEventRepository;


class EventService
{
    protected $eventRepository;

    public function __construct(IEventRepository $eventRepository)
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

    public function getEventDetails(int $recurrenceId)
    {
        return $this->eventRepository->findRecurrenceById($recurrenceId);
    }
}
