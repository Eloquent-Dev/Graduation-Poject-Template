<?php

namespace App\Http\Controllers\oAuth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Str;

class GoogleController extends Controller
{
    public function handleGoogleCallback(){
        try{
            /** @var \Laravel\Socialite\Two\User $googleUser */
        $googleUser = Socialite::driver('google')->user();

        $existingUser = User::where('email', $googleUser->getEmail())->first();

        if($existingUser){
            Auth::login($existingUser);

            return redirect('/');
        }

        session([
            'pending_user' =>[
                'name' => $googleUser->getName(),
                'email' => $googleUser->getEmail(),
                'google_id' => $googleUser->getId(),
            ],
            'needs_oauth_completion' => true
        ]);

        return redirect('/');
        }catch(\Exception $e){
            return redirect('/')->with('Google login failed. Please try again.');
        }

    }

    public function redirectToGoogle(){
        return Socialite::driver('google')->redirect();
    }

    public function finishRegistration(Request $request){
        $request->validate([
            'national-no' => 'required|unique:users,national_no|size:10',
            'phone_full' => ['required' , 'string', 'regex:/^\+?[0-9]{8,15}$/', 'unique:users,phone'],
        ],[],
        [
            'national-no' => 'National Number',
            'phone_full' => 'phone number',
        ]);

        $googleData = session('pending_user');

        $user = User::create([
            'name' => $googleData['name'],
            'national_no' => $request->input('national-no'),
            'email' => $googleData['email'],
            'phone' => $request->phone_full,
            'password' => bcrypt(Str::random(24)),
        ]);

        session()->forget('pending_user');
        session()->forget('needs_oauth_completion');

        Auth::login($user);

        return redirect('/')->with('success','Account Successfully created!');
    }
}
