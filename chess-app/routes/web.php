<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Page1Controller;
use App\Http\Controllers\Page2Controller;
use App\Http\Controllers\Page3Controller;
use App\Http\Controllers\Page4Controller;
use App\Http\Controllers\Page5Controller;

Route::get('/page1', [Page1Controller::class, 'showPage1'])->name('page1');
Route::post('/page1', [Page1Controller::class, 'store'])->name('page1.store');

// Routes for Page2Controller
Route::get('/page2', [Page2Controller::class, 'showPage2'])->name('page2');

Route::get('/page3', [Page3Controller::class, 'showPage3'])->name('page3');
Route::get('/page3/feedback', [Page3Controller::class, 'getGameFeedback'])->name('page3.getGameFeedback');

// Routes for Page4Controller
Route::get('/page4', [Page4Controller::class, 'showPage4'])->name('page4');

// Routes for Page5Controller
Route::get('/page5', [Page5Controller::class, 'showPage5'])->name('page5');
Route::post('/api/get-wiki-data', [Page5Controller::class, 'getWikiData']);


Route::get('/', function () {
    return view('welcome');
});