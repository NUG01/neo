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

Route::group(['middleware' => 'auth'], function () {
    Route::get('participations/index', [CampaignFrontendController::class, 'index'])->name('campaign.index');
});

Route::get('campaign/{campaign}', [CampaignFrontendController::class, 'display'])->name('campaign.display');
Route::post('campaign/{campaign}/submit', [CampaignFrontendController::class, 'submit'])->name('campaign.submit');




Route::get('/step/{step}', [CampaignFrontendController::class, 'session'])->name('session');
