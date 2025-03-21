<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UserService;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

     
        // Validate input
        $validatedData = $request->validate([
            "name"  => '|string|max:255',
            "email" => '|email|unique:users,email,' . $user->id,
            "phone" => '|string|min:6',
            "password" => 'sometimes|string|min:6',
            "img" => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048', // Image validation
        ]);

        try {
            // Pass the request data, including the image
            $updatedUser = $this->userService->updateUser($user->id, $validatedData);

            return response()->json([
                'success' => true,
                'message' => 'User updated successfully.',
                'user' => $updatedUser
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update user: ' . $e->getMessage()
            ], 500);
        }
    }
}