<?php

use App\Http\Controllers\Document\DocumentController;
use Illuminate\Support\Facades\Route;


Route::get('/document/{registrationNumber}', DocumentController::class)->middleware('check.regnumber');


Route::get('/', function () {
    return view('home');
});
