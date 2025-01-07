<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ButtonController;
use App\Http\Controllers\PageController;

Route::get('/page1', [PageController::class, 'showPage1']);
Route::post('/games', [PageController::class, 'store'])->name('games.store');

Route::get('/buttons', [ButtonController::class, 'showButtons']);
Route::get('/page2', [ButtonController::class, 'page2']);
Route::get('/page3', [ButtonController::class, 'page3']);
Route::get('/page4', [ButtonController::class, 'page4']);
Route::get('/page5', [ButtonController::class, 'page5']);


Route::get('/', function () {
    return view('welcome');
});



