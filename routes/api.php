<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\RecurrencesController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TicketAvailabilityController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\UserController;

Route::post('/register', [RegisteredUserController::class, 'store']);
Route::middleware('guest')->post('/login', [AuthenticatedSessionController::class, 'store']);
Route::middleware('auth:sanctum')->post('/logout', [AuthenticatedSessionController::class, 'destroy']);
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return response()->json($request->user());
});

Route::get('/events',[EventController::class,'index']);
Route::get('/events/{id}',[EventController::class,'show']);
Route::get('/categories',[CategoryController::class,'index']);
Route::get('/tickets/availability/{eventId}', [TicketAvailabilityController::class, 'checkAvailability']);
Route::middleware('auth:sanctum')->post('/reservations', [ReservationController::class, 'store']);
Route::middleware('auth:sanctum')->get('/reservations/{userId}', [ReservationController::class, 'getUserReservations']);
Route::middleware('auth:sanctum')->post('/user/update', [UserController::class, 'updateProfile']);
