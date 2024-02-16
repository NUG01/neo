<?php

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Define routes for displaying campaign steps and handling form submissions
Route::get('campaign/{campaign}', [CampaignFrontendController::class, 'display'])->name('campaign.display');
Route::post('campaign/{campaign}/submit', [CampaignFrontendController::class, 'submit'])->name('campaign.submit');
