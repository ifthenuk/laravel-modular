<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Page\Controllers\PageController;

Route::prefix('page')
    ->name('page.')
    ->middleware('auth') //add your middleware here
    ->group(function(){
        Route::get('/', [PageController::class, 'index'])->name('index');
      //add other route here
});