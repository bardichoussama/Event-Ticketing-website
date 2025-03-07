<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserRepository
{
    public function __construct(User $user)
    {
        $this->user = $user;
    }
    public function all()
    {
        return $this->userModel::all();
    }
    public function update(User $user)
    {
        $this->userModel::update($user);
    }
}