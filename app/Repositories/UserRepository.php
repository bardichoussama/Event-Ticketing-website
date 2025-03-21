<?php

namespace App\Repositories;

use App\Models\User;
use App\Interfaces\IUserRepository;
use Illuminate\Support\Facades\Hash;

class UserRepository implements IUserRepository {

    public function update($id, array $data)
    {
        $user = User::find($id);

        if (!$user) {
            throw new \Exception("User not found.");
        }

        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->phone = $data['phone'] ?? $user->phone;

        // Handle Image Upload
        if (!empty($data['img'])) {
            // Delete old image if it exists
            if ($user->img && file_exists(public_path('assets/imgs/' . $user->img))) {
                unlink(public_path('assets/imgs/' . $user->img));
            }

            // Move new image to public folder
            $image = $data['img'];
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('assets/imgs'), $imageName);
            $user->img = $imageName;
        }

        // Handle password update securely
        if (!empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }

        $user->save();
        return $user;
    }
}