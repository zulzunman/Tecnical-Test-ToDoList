<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChecklistController;
use App\Http\Controllers\ItemController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/checklists', [ChecklistController::class, 'index']);
    Route::post('/checklists', [ChecklistController::class, 'store']);
    Route::get('/checklists/{id}', [ChecklistController::class, 'show']);
    Route::delete('/checklists/{id}', [ChecklistController::class, 'destroy']);

    Route::get('/checklist/{checklistId}/item', [ItemController::class, 'index']);
    Route::post('/checklist/{checklistId}/item', [ItemController::class, 'store']);
    Route::get('/checklist/{checklistId}/item/{itemId}', [ItemController::class, 'show']);
    Route::put('/checklist/{checklistId}/item/{itemId}', [ItemController::class, 'updateStatus']);
    Route::delete('/checklist/{checklistId}/item/{itemId}', [ItemController::class, 'destroy']);
    Route::put('/checklist/{checklistId}/item/rename/{itemId}', [ItemController::class, 'rename']);
});
