<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DispatcherController;

Route::middleware(['auth'])->prefix('dispatcher')->name('dispatcher.')->group(function(){
    Route::get('/complaints',[DispatcherController::class,'index'])
    ->name('complaints.index');

    Route::get('/complaints/{complaint}',[DispatcherController::class,'show'])
    ->name('complaints.show');
});

