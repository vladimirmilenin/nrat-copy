<?php

use App\Http\Controllers\Document\DocumentController;
use Illuminate\Support\Facades\Route;



Route::prefix('{lang}')
->whereIn('lang', ['ua', 'en'])
->group(function(){

    Route::get('/', function(){
        abort(500);
        // return 'home 2 ' . app()->getLocale();
    })->name('index');

    Route::get('/document/{registrationNumber}', DocumentController::class)->middleware('check.regnumber');

});

Route::get('/', function () {
    abort(500);
    // return 'home 1 ' . app()->getLocale();
});

