<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    public function store(LoginRequest $request)
    {
        // Authenticate the user
        $request->authenticate();

        // Create a token for the user
        $user = Auth::user();
        $token = $user->createToken('auth_token')->plainTextToken;

        // Return a success response with the token
        return response()->json([
            'message' => 'Logged in successfully',
            'user' => $user,
            'token' => $token,
        ]);
    }

    public function destroy(Request $request)
    {
        // Delete the user's tokens (logout)
        $request->user()->tokens()->delete();

        // Return a success response
        return response()->json(['message' => 'Logged out successfully']);
    }
}