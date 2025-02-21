<?php
namespace App\Repositories;

use App\Models\Reservation;

class ReservationRepository
{
    public function __construct(Reservation $model)
    {
        $this->model = $model;
    }
    public function createReservation($data)
    {
        return $this->model->create($data);
    }
    
}
