<?php

use App\Http\Controllers\HotelController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\RoomController;
use Illuminate\Support\Facades\Route;

Route::get('/hotels', [HotelController::class, 'index']);
Route::post('/hotels', [HotelController::class, 'store']);
Route::post('/reserve', [ReservationController::class, 'store']);


Route::get('/hotels/{hotel}/rooms', [RoomController::class, 'index']);
