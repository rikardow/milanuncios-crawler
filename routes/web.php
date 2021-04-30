<?php

use App\Http\Controllers\AdDetailsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SearchController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/details/{id}', [AdDetailsController::class, 'index'])->name('details');

Route::get('/search', [SearchController::class, 'index'])->name('search');
