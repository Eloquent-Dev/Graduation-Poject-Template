<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function toggleDuty(Request $request){
        $user = $request->user();

        if(!$user->employee){
            return response()->json(['error'=> 'unauthorized'], 403);
        }

        $validated = $request->validate([
            'is_on_duty' => 'required|boolean'
        ]);

        $newStatus = $validated['is_on_duty'] ? 'on_duty' : 'off_duty';

        $employee = $user->employee;
        $employee->duty_status = $newStatus;
        $employee->save();

        return response()->json(['success'=> true,'status' => $newStatus]);
    }
}
