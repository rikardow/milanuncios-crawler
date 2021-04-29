<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::view('/', 'home');

Auth::routes();

Route::get('/details', [App\Http\Controllers\AdDetailsController::class, 'index'])->name('details');
