<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FeatureController;

Route::get('/', [FeatureController::class, 'index'])->name('index');
Route::resource('features', FeatureController::class);
