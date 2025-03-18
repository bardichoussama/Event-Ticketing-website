<?php

namespace App\Interfaces;

interface IEventRepository
{
    public function getAllEvents();
    public function getFilteredEvents(array $filters);
    public function findRecurrenceById($id);
    public function findRecurrenceWithRoom($id);
}
