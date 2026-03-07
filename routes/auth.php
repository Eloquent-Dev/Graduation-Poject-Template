<?php

use App\Http\Controllers\AuthController;

Route::middleware('auth')->group(function(){
    Route::post('logout',[AuthController::class,'logout'])->name('logout');
});
