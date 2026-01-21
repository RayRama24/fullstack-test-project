<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\VisitController;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/patients', [PatientController::class, 'store']);
Route::post('/visits', [VisitController::class, 'store']);

Route::get('/patients', [PatientController::class, 'index']);
Route::get('/patients/{rm}', [PatientController::class, 'showByRm']);

