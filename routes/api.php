<?php

use App\Http\Controllers\ClientController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');




Route::get('clients', [ClientController::class, 'index']);
Route::post('/addClients', [ClientController::class, 'store']);
Route::patch('/clients/{id}', [ClientController::class, 'update']);
Route::patch('/clientsDemographic/{id}', [ClientController::class, 'updateDemoGraphic']);
Route::patch('/clientsBilling/{id}', [ClientController::class, 'updateBilling']);
Route::patch('/clientsDetailsReference/{id}', [ClientController::class, 'updateDetails']);
Route::post('clients/sharedFiles/{id}', [ClientController::class, 'updateSharedFile']);
Route::get('clients/getSharedFiles/{id}', [ClientController::class, 'getFilePath']);
Route::patch('clients/updateSettings/{id}', [ClientController::class, 'updateSettings']);
Route::get('/clientDetails/{id}', [ClientController::class, 'details']);
Route::delete('/delete/{id}', [ClientController::class, 'delete']);
