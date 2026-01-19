<?php

use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('layouts.app');
// });
Route::get('/', function () {
    return view('welcome'); // Trỏ tới file resources/views/home/index.blade.php
})->name('home');