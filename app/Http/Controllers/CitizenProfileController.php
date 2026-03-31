<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CitizenProfileController extends Controller
{
    public function show()
    {
        $user = auth()->user();
        return view('profile.citizen.show', compact('user'));
    }

    public function edit()
    {
        $user = auth()->user();
        return view('profile.citizen.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();
        $validated = $request->validate([
            'name' => ['required|string|max:255'],
            'email' => ['required','email','unique:users,email,' . $user->id],
            'phone' => ['nullable','string','max:20'],
            'national_no' => ['nullable','string','max:10'],
        ]);

        $user->update($validated);

        return redirect()->route('citizen.profile.show')->with('success', 'Your profile updated successfully.');
    }

}
