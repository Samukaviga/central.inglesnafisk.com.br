<?php

use App\Http\Controllers\Api\RegistrationController;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\UserController;


Route::post('/registrations', [RegistrationController::class, 'store']);
Route::get('/registrations/{registration}', [RegistrationController::class, 'show']);
Route::patch('/registrations/{registration}', [RegistrationController::class, 'update']);


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
