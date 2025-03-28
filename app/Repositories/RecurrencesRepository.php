<?php

namespace App\Repositories;

use App\Models\Recurrence;

class EventRepository
{
    protected $model;

    public function __construct(Recurrence $model)
    {
        $this->model = $model;
    }

    public function getAllEvents()
    {
        return $this->model->with('event')->get();
    }

    public function getFilteredEvents(array $filters)
    {
        $query = $this->model->with('event');  // Changed from 'recurrences' to 'event'

        // Title should be searched in the events table, not recurrences
        if (!empty($filters['name'])) {
            $query->whereHas('event', function($q) use ($filters) {
                $q->where('title', 'LIKE', '%' . $filters['name'] . '%');
            });
        }

        // Date filtering on recurrences table
        if (!empty($filters['start_date']) && !empty($filters['end_date'])) {
            $query->whereBetween('event_timestamp', [
                $filters['start_date'],
                $filters['end_date']
            ]);
        }

        return $query->get();
    }
    public function reccurenceRooms($id)
    {
        return $this->with;
       
    }
}