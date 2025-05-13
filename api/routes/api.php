<?php

use App\Models\Division;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\DivisionController;
use App\Http\Controllers\Api\PositionController;
use App\Http\Controllers\Api\EmployeeController;
use App\Http\Controllers\Api\EmployeeJobController;
use App\Http\Controllers\Api\AuthController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware('auth')->group(function () {
    Route::apiResource('/divisions', DivisionController::class);
    Route::get('/divisions/{id}/employees', [DivisionController::class, 'employees']);
    Route::get('/divisions/{id}/positions', [DivisionController::class, 'positions']);
    Route::apiResource('/positions', PositionController::class);
    Route::apiResource('/employees', EmployeeController::class);
    Route::get('/employees/active', [EmployeeController::class, 'active']);
    Route::apiResource('/employee-jobs', EmployeeJobController::class);
});