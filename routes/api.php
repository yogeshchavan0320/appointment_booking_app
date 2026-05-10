<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\DoctorController;
use App\Http\Controllers\Api\DoctorAvailabilityController;
use App\Http\Controllers\Api\DoctorAppointmentController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('doctors', DoctorController::class);

Route::prefix('doctors')->group(function () {
    Route::get('/{doctor}/availabilities', [DoctorAvailabilityController::class, 'index']);
    Route::post('/{doctor}/availabilities', [DoctorAvailabilityController::class, 'store']);
});

Route::prefix('doctors')->group(function () {
    Route::get('/{doctor}/available-slots', [DoctorAppointmentController::class, 'availableSlots']);
    Route::post('/{doctor}/book-appointment', [DoctorAppointmentController::class, 'book']);
});

Route::post('/appointments/{appointment}/cancel', [DoctorAppointmentController::class, 'cancel']);
Route::post('/appointments/{appointment}/reschedule', [DoctorAppointmentController::class, 'reschedule']);
