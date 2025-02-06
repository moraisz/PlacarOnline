<?php

use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ApiController::class, 'competitions'])->name("competitions");
Route::get('/competitions/{code}', [ApiController::class, 'competition'])->name("competitions.competition");
