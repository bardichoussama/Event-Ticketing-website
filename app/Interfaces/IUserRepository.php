<?php

namespace App\Interfaces;

interface IUserRepository
{
    public function createUser($data);
    public function getUserById($id);
    public function getUserByEmail($email);
}