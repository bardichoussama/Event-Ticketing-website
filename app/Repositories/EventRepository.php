<?php

namespace App\Repositories;

use App\Models\Recurrence;
use App\Interfaces\IEventRepository;

class EventRepository implements IEventRepository
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
        $query = $this->model->with('event');

        if (!empty($filters['name'])) {
            $query->whereHas('event', function($q) use ($filters) {
                $q->where('title', 'LIKE', '%' . $filters['name'] . '%');
            });
        }

        if (!empty($filters['start_date']) && !empty($filters['end_date'])) {
            $query->whereBetween('event_timestamp', [
                $filters['start_date'],
                $filters['end_date']
            ]);
        }
          // Filter by event category
          if (!empty($filters['category'])) {
            $query->whereHas('event', function($q) use ($filters) {
                $q->where('category_id', $filters['category']);
            });
        }
        if (!empty($filters['event_timing'])) {
            $currentDate = now();
            if ($filters['event_timing'] == 'upcoming') {
                $query->where('event_timestamp', '>', $currentDate);
            } elseif ($filters['event_timing'] == 'past') {
                $query->where('event_timestamp', '<', $currentDate);
            }
        }

   

        return $query->get();
    }
    public function findRecurrenceById( $id)
    {
         return $this->model->with('event')->find($id);
    }
    public function findRecurrenceWithRoom($id){
        
{
    return $this->model->with('event', 'room')->find($id);
}

}
}