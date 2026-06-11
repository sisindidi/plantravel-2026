<?php

use Illuminate\Support\Facades\Route;
use Livewire\Livewire;
use Illuminate\Support\Facades\Response;

/* NOTE: Do Not Remove
/ Livewire asset handling if using sub folder in domain
*/

Livewire::setUpdateRoute(function ($handle) {
    return Route::post(config('app.asset_prefix') . '/livewire/update', $handle);
});

Livewire::setScriptRoute(function ($handle) {
    return Route::get(config('app.asset_prefix') . '/livewire/livewire.js', $handle);
});
/*
/ END
*/
// Auth Routes
Route::get('/login', [\App\Http\Controllers\AuthController::class, 'showLoginForm'])->name('login')->middleware('guest');
Route::post('/login', [\App\Http\Controllers\AuthController::class, 'login'])->name('login.post')->middleware('guest');
Route::post('/logout', [\App\Http\Controllers\AuthController::class, 'logout'])->name('logout');

// Main Dashboard Route
Route::get('/', [\App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard')->middleware('auth');

// Custom Frontend Routes
Route::post('/trips', [\App\Http\Controllers\DashboardController::class, 'storeTrip'])->name('trips.store')->middleware('auth');
Route::post('/expenses', [\App\Http\Controllers\DashboardController::class, 'storeExpense'])->name('expenses.store')->middleware('auth');
Route::post('/itineraries', [\App\Http\Controllers\DashboardController::class, 'storeItinerary'])->name('itineraries.store')->middleware('auth');
Route::post('/packinglists', [\App\Http\Controllers\DashboardController::class, 'storePackinglist'])->name('packinglists.store')->middleware('auth');
Route::post('/destinations', [\App\Http\Controllers\DashboardController::class, 'storeDestination'])->name('destinations.store')->middleware('auth');

// Frontend Management Pages (CRUD)
Route::middleware('auth')->group(function () {
    Route::get('/my-trips', [\App\Http\Controllers\FrontendController::class, 'tripsIndex'])->name('frontend.trips');
    Route::put('/trips/{trip}', [\App\Http\Controllers\FrontendController::class, 'updateTrip'])->name('trips.update');
    Route::delete('/trips/{trip}', [\App\Http\Controllers\FrontendController::class, 'destroyTrip'])->name('trips.destroy');

    Route::get('/budget', [\App\Http\Controllers\FrontendController::class, 'expensesIndex'])->name('frontend.expenses');
    Route::put('/expenses/{expense}', [\App\Http\Controllers\FrontendController::class, 'updateExpense'])->name('expenses.update');
    Route::delete('/expenses/{expense}', [\App\Http\Controllers\FrontendController::class, 'destroyExpense'])->name('expenses.destroy');

    Route::get('/itineraries-manage', [\App\Http\Controllers\FrontendController::class, 'itinerariesIndex'])->name('frontend.itineraries');
    Route::put('/itineraries/{itinerary}', [\App\Http\Controllers\FrontendController::class, 'updateItinerary'])->name('itineraries.update');
    Route::delete('/itineraries/{itinerary}', [\App\Http\Controllers\FrontendController::class, 'destroyItinerary'])->name('itineraries.destroy');

    Route::get('/checklists', [\App\Http\Controllers\FrontendController::class, 'packinglistsIndex'])->name('frontend.packinglists');
    Route::put('/packinglists/{packinglist}', [\App\Http\Controllers\FrontendController::class, 'updatePackinglist'])->name('packinglists.update');
    Route::patch('/packinglists/{packinglist}/toggle', [\App\Http\Controllers\FrontendController::class, 'togglePackinglist'])->name('packinglists.toggle');
    Route::delete('/packinglists/{packinglist}', [\App\Http\Controllers\FrontendController::class, 'destroyPackinglist'])->name('packinglists.destroy');

    Route::get('/wishlists', [\App\Http\Controllers\FrontendController::class, 'destinationsIndex'])->name('frontend.destinations');
    Route::put('/destinations/{destination}', [\App\Http\Controllers\FrontendController::class, 'updateDestination'])->name('destinations.update');
    Route::delete('/destinations/{destination}', [\App\Http\Controllers\FrontendController::class, 'destroyDestination'])->name('destinations.destroy');
});
