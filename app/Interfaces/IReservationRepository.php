<?php

namespace App\Interfaces;

interface IReservationRepository
{
    public function createReservation($data);
    public function getUserReservations($userId);
}