<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CampaignController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::controller(CampaignController::class)->group(function () {
    Route::get('/campaigns', 'index');
    Route::post('/campaigns', 'store');
    Route::get('/campaigns/{campaign}', 'show');
    Route::put('/campaigns/{campaign}', 'update');
    Route::delete('/campaigns/{campaign}', 'destroy');
});
