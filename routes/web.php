<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CampaignFrontendController;
use Illuminate\Support\Facades\Session;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('welcome');



Route::group(['prefix' => 'campaign'], function () {
    Route::get('/{campaign}', [CampaignFrontendController::class, 'display'])->name('campaign.display');
    Route::post('/{campaign}/submit', [CampaignFrontendController::class, 'submit'])->name('campaign.submit');
});

Route::get('participations/index', [CampaignFrontendController::class, 'index'])->middleware('auth')->name('campaign.index');
