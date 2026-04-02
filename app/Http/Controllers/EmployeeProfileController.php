<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\validation\Rule;

class EmployeeProfileController extends Controller
{
    public function show(Request $request){
        $user = auth()->user();
        return view('profile.employee.show',compact('user'));
    }

    public function edit(Request$request){
        $user = auth()->user();
        return view('profile.employee.edit',compact('user'));

    }

    public function update(Request $request){
        $user = auth()->user();

        $validated = $request->validate([
            'edit_name' =>['required','string','max:255'],
            'edit_phone' =>['nullable','string','max:20'],
            'edit_national_no' =>['nullable', Rule::unique('users','national_no')->ignore($user->id), 'size:10'],
            'edit_email' => ['required', 'string', 'email', Rule::unique('users','email')->ignore($user->id), 'max:255'],
            'edit_job_title' => ['nullable', 'string', 'max:255'],
        ]);

        $user->update([
            'name' => $validated['edit_name'],
            'phone' => $validated['edit_phone'],
            'national_no' => $validated['edit_national_no'],
            'email' => $validated['edit_email'],
        ]);

        if($user->role === 'admin'){
            $user->employee()->update([
                'job_title' => $validated['edit_job_title'],
            ]);
        }
        else{
            $user->employee()->update([
            'pending_job_title' => $validated['edit_job_title'],
        ]);
        }



        return redirect()->route('employee.profile.show')->with('success', 'Profile updated successfully.');
    }

    public function updatePassword(Request $request){
        $user = auth()->user();

        $rules = [
            'new_password' => ['required','confirmed', \Illuminate\Validation\Rules\Password::defaults()],
        ];

        if($user->password){
            $rules['current_password'] = ['required', 'current_password'];
        }

        $validated = $request->validate($rules);

        $user->update([
            'password' => bcrypt($validated['new_password']),
        ]);

        return redirect()->route('employee.profile.show')->with('success', 'Password updated successfully.');
    }
}
