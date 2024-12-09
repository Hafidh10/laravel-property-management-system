<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PropertyController;

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/api/properties', [PropertyController::class, 'list']);
// Route::post('/api/properties/', [PropertyController::class, 'store']);

