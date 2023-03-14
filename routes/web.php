<?php

use App\Http\Controllers\CallStatsController;
use Illuminate\Support\Facades\Route;

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


Route::get('/', [CallStatsController::class,'index']);

Route::post('/call-details', [CallStatsController::class,'process'])->name('upload');

