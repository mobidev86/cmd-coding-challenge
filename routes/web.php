<?php

use App\Livewire\QuoteRequestForm;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('quote-request');
});

// Test route to verify calendar page works
Route::get('/test-calendar', function () {
    return 'Calendar test route works!';
});

// Route::get('/', function () {
//     return view('welcome');
// });
