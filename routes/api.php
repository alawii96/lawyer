<?php

use App\Http\Controllers\ReservationsController;
use App\Http\Controllers\PaymentsController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ServicesController;
use App\Http\Controllers\ContractsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::resource('orders', OrderController::class);
Route::resource('reservations', ReservationsController::class);
Route::resource('payments', PaymentsController::class);
Route::resource('services', ServicesController::class);
Route::resource('contracts', ContractsController::class);

Route::get('/fill-data-pdfs', [\App\Http\Controllers\FillPDFController::class,'process']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


