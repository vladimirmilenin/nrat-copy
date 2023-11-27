<?php

use App\Http\Controllers\Document\DocumentController;
use App\Http\Controllers\FileDownloadController;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\SearchController;
use Illuminate\Support\Facades\Route;
use Psy\VersionUpdater\Downloader\FileDownloader;

Route::prefix('{lang}')
->whereIn('lang', ['ua', 'en'])
->group(function(){

    Route::get('/', IndexController::class)->name('index');

    Route::get('/search', function(){
        return view('pages.search');
    })->name('search');

    Route::get('/foo', [SearchController::class, 'index'])->name('foo');

    Route::get('/document/{registrationNumber}', DocumentController::class)->middleware('check.regnumber')->name('document');

});

Route::get('/', IndexController::class)->name('home');

Route::prefix('download')
->group(function(){
    Route::controller(FileDownloadController::class)
    ->group(function(){
        Route::get('/card/{registrationNumber}', 'downloadCard')->name('downloadCard');
        Route::get('/file/{registrationNumber}/{filename}', 'downloadFile')->name('downloadFile');
    });
});

/* Redirect with lang */
Route::get('/foo', function(){
    return redirect()->route('foo', ['lang' => 'ua']);
});


