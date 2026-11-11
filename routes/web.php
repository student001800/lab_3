<?php

use App\Http\Controllers\CityController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/cities');
Route::resource('cities', CityController::class);
