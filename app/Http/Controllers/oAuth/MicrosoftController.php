<?php

namespace App\Http\Controllers\oAuth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Str;

class MicrosoftController extends Controller
{
    public function handleMicrosoftCallback(){
        try{
            /** @var \Laravel\Socialite\Two\User $microsoftUser */
        $microsoftUser = Socialite::driver('microsoft')->user();

        $existingUser = User::where('email', $microsoftUser->getEmail())->first();

        if($existingUser){
            Auth::login($existingUser);

            return redirect('/');
        }

        session([
            'pending_user' =>[
                'name' => $microsoftUser->getName(),
                'email' => $microsoftUser->getEmail(),
                'microsoft_id' => $microsoftUser->getId(),
            ],
            'needs_oauth_completion' => true
        ]);

        return redirect('/');
        }catch(\Exception $e){
            return redirect('/')->with('Microsoft login failed. Please try again.');
        }

    }

    public function redirectToMicrosoft(){
        return Socialite::driver('microsoft')->redirect();
    }
}
