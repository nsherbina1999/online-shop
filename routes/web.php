<?php

use App\Http\Controllers\DeliveryController;
use App\Http\Requests\SendParcelRequest;
use App\Services\NovaPoshtaService;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/send-parcel', [DeliveryController::class, 'sendParcel']);
