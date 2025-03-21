<?php

namespace App\Services;

use App\Interfaces\IUserRepository;

class UserService {
    protected $userRepository;
    
    public function __construct(IUserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function updateUser($id, array $data)
    {
        return $this->userRepository->update($id, $data);
    }
}