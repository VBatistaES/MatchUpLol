<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MatchupController;

Route::post('/matchup', [MatchupController::class, 'analyze']);