<?php

use App\Http\Controllers\Api\AttendanceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\MachineController;
use App\Http\Controllers\Api\ManufacturingController;
use App\Http\Controllers\Api\OperatorController;
use App\Http\Controllers\Api\ProcessController;
use App\Http\Controllers\Api\ProcessCycleController;
use App\Http\Controllers\Api\WeeklyProductionController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Protected routes
Route::middleware('auth:api')->group(function () {
    Route::get('/profile', [AuthController::class, 'profile']);
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/operators', [OperatorController::class, 'index']);
    Route::post('/operators', [OperatorController::class, 'store']);
    Route::get('/operators/{id}', [OperatorController::class, 'show']);
    Route::put('/operators/{id}', [OperatorController::class, 'update']);
    Route::delete('/operators/{id}', [OperatorController::class, 'destroy']);

    Route::get('/machines', [MachineController::class, 'index']);
    Route::post('/machines', [MachineController::class, 'store']);
    Route::get('/machines/{id}', [MachineController::class, 'show']);
    Route::put('/machines/{id}', [MachineController::class, 'update']);
    Route::delete('/machines/{id}', [MachineController::class, 'destroy']);

    Route::get('/processes', [ProcessController::class, 'index']);
    Route::post('/processes', [ProcessController::class, 'store']);
    Route::put('/processes/{id}', [ProcessController::class, 'update']);
    Route::delete('/processes/{id}', [ProcessController::class, 'destroy']);
    Route::get('/processes/{id}', [ProcessController::class, 'show']);

    Route::get('/process-cycles', [ProcessCycleController::class, 'index']);
    Route::get('/process-cycles/{id}', [ProcessCycleController::class, 'show']);
    Route::post('/process-cycles', [ProcessCycleController::class, 'store']);
    Route::put('/process-cycles/{id}', [ProcessCycleController::class, 'update']);
    Route::delete('/process-cycles/{id}', [ProcessCycleController::class, 'destroy']);

    Route::get('/manufacturing', [ManufacturingController::class, 'index']);
    Route::post('/manufacturing', [ManufacturingController::class, 'store']);
    Route::get('/manufacturing/{id}', [ManufacturingController::class, 'show']);
    Route::put('/manufacturing/{id}', [ManufacturingController::class, 'update']);
    Route::delete('/manufacturing/{id}', [ManufacturingController::class, 'destroy']);

    Route::get('/weekly-production', [WeeklyProductionController::class, 'index']);
    Route::post('/weekly-production', [WeeklyProductionController::class, 'store']);
    Route::get('/weekly-production/{id}', [WeeklyProductionController::class, 'show']);
    Route::put('/weekly-production/{id}', [WeeklyProductionController::class, 'update']);
    Route::delete('/weekly-production/{id}', [WeeklyProductionController::class, 'destroy']);

    Route::get('/attendance', [AttendanceController::class, 'index']);
    Route::post('/attendance', [AttendanceController::class, 'store']);
    Route::get('/attendance/{id}', [AttendanceController::class, 'show']);
    Route::put('/attendance/{id}', [AttendanceController::class, 'update']);
    Route::delete('/attendance/{id}', [AttendanceController::class, 'destroy']);
});

// Route::middleware('auth.api')->get('/secure-data', function () {
//     return ['message' => 'Access granted'];
// });
