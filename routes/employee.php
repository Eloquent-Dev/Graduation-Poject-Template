<?php

use App\Http\Controllers\EmployeeProfileController;

Route::middleware(['auth','role:admin,dispatcher,supervisor,worker'])->group(function(){
    Route::get('/employee/profile',[EmployeeProfileController::class,'show'])->name('employee.profile.show');
    Route::get('/employee/profile/edit',[EmployeeProfileController::class,'edit'])->name('employee.profile.edit');
    Route::patch('/employee/profile/update',[EmployeeProfileController::class,'update'])->name('employee.profile.update');
    Route::patch('/employee/profile/password/update',[EmployeeProfileController::class,'updatePassword'])->name('employee.profile.password.update');
});
