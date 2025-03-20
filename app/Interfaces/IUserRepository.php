<?php

namespace App\Interfaces;

interface IUserRepository
{
    public function update($id, array $data);
}