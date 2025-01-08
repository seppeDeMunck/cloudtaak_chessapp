<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Page1Controller;
use App\Http\Controllers\Page2Controller;
use App\Http\Controllers\Page3Controller;
use App\Http\Controllers\Page4Controller;
use App\Http\Controllers\Page5Controller;

Route::get('/page1', [Page1Controller::class, 'showPage1'])->name('page1');
Route::post('/games', [Page1Controller::class, 'store'])->name('games.store');

// Routes for Page2Controller
Route::get('/page2', [Page2Controller::class, 'showPage2']);

// Routes for Page3Controller
Route::get('/page3', [Page3Controller::class, 'showPage3']);

// Routes for Page4Controller
Route::get('/page4', [Page4Controller::class, 'showPage4'])->name('page4');

Route::get('/page5', [Page5Controller::class, 'showPage5']);

// Default route