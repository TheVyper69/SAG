<?php

use Illuminate\Support\Facades\Route;



Route::get('/pdf', function () {
    return view('pdf');
});

Route::get('/', function () {
    return view('welcome');
});