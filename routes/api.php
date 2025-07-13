<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DivisionController;
use App\Http\Controllers\Api\EmployeeController;
use App\Http\Controllers\Api\NilaiController;
use App\Http\Middleware\Api\AuthMiddleware;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware(AuthMiddleware::class)->group(function () {
  Route::get('/divisions', [DivisionController::class, 'index']);

  Route::prefix('employees')->group(function () {
    Route::get('/', [EmployeeController::class, 'index']);
    Route::get('/{id}', [EmployeeController::class, 'show']);
    Route::post('/', [EmployeeController::class, 'store']);
    Route::put('/{id}', [EmployeeController::class, 'update']);
    Route::delete('/{id}', [EmployeeController::class, 'destroy']);
  });

  Route::post('/logout', [AuthController::class, 'logout']);
});

Route::get('/nilaiRT', [NilaiController::class, 'nilaiRT']);
Route::get('/nilaiST', [NilaiController::class, 'nilaiST']);
