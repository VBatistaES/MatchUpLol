<?php

use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Request;

Route::get('/matchup', function () {
    return view('matchup');
});

Route::get('/home', function () {
    return view('home');
});

Route::get('/login', function () {
    return view('login');
});
