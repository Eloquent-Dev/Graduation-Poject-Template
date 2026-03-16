<?php

use App\Http\Controllers\SupervisorController;

Route::middleware(['auth','role:supervisor'])->group(function(){
    Route::get('job-orders/{jobOrder}/complete',[SupervisorController::class,'createCompletionReport'])
    ->name('supervisor.completion.create');

    Route::post('job-orders/{jobOrder}/complete',[SupervisorController::class,'storeCompletionReport'])
    ->name('supervisor.completion.store');
});
