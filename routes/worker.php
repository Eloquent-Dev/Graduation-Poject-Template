<?php

use App\Http\Controllers\WorkerController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth','role:worker,supervisor'])->group(function(){
    Route::get('my-assignments',[WorkerController::class,'assignments'])
    ->name('worker.assignments');

    Route::patch('my-assignments/{jobOrder}/status',[WorkerController::class,'updateStatus'])
    ->name('worker.assignments.status');

    Route::patch('worker/duty-status',[WorkerController::class,'toggleDuty'])
    ->name('worker.duty.toggle');

    Route::get('my-assignments/{jobOrder}',[WorkerController::class,'show'])
    ->name('worker.assignments.show');
});
