<?php

use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('layouts.app');
// });
Route::get('/', function () {
    return view('components.home.index'); // Trỏ tới file resources/views/home/index.blade.php
})->name('home');
