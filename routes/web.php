<?php

use App\Http\Controllers\Document\DocumentController;
use App\Http\Controllers\FileDownloadController;
use Illuminate\Support\Facades\Route;
use Psy\VersionUpdater\Downloader\FileDownloader;

Route::prefix('{lang}')
->whereIn('lang', ['ua', 'en'])
->group(function(){

    Route::get('/', function(){
        abort(500);
        // return 'home 2 ' . app()->getLocale();
    })->name('index');

    Route::get('/document/{registrationNumber}', DocumentController::class)->middleware('check.regnumber')->name('document');

});


Route::get('/', function () {
    return redirect()->route('index', ['lang' => 'ua']);
    // abort(500);
    // return 'home 1 ' . app()->getLocale();
});

Route::prefix('download/{dir_type}')
->whereIn('dir_type', ['okd'])
->group(function(){
    Route::controller(FileDownloadController::class)
    ->group(function(){
        Route::get('/card/{hash}/{filename}', 'downloadCard')->name('downloadCard');
    });
});

