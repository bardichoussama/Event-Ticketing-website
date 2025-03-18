<?php
namespace App\Repositories;

use App\Models\Reservation;
use App\Interfaces\IReservationRepository;

class ReservationRepository  implements IReservationRepository
{
    public function __construct(Reservation $model)
    {
        $this->model = $model;
    }
    public function createReservation($data)
    {
        return $this->model->create($data);
    }
    public function getUserReservations($userId)
    {
        return $this->model->with([
            'user',
            'recurrence',
            'recurrence.room',
            'tickets'
        ])
        ->where('user_id', $userId)
        ->get();
    }
}