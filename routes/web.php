<?php

use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Route;

/*Route::get('/', function () {*/
/*    return view('index');*/
/*});*/

Route::get('/', [ApiController::class, 'index'])->name("index");
