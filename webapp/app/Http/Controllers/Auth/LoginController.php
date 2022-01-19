<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/events';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function getUser()
    {
        return $request->user();
    }

    /**
     * Redirect the user to the Google authentication page.
    *
    * @return \Illuminate\Http\Response
    */
    public function redirectToProvider()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Obtain the user information from Google.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback()
    {
        $googleUser = Socialite::driver('google')->user();

        $user = User::where('google_id', $googleUser->id)->first();

        if ($user) {
            $user->update([
                'github_token' => $googleUser->token,
                'github_refresh_token' => $googleUser->refreshToken,
            ]);
            Auth::login($user);
            return redirect('/events');
        } else {
            /*
            username TEXT NOT NULL CONSTRAINT user_username_uk UNIQUE,
            password TEXT NOT NULL,
            birthdate DATE NOT NULL,
            */

            return view('auth.registerOAuth')->
                   with('name', $googleUser->name)->
                   with('email', $googleUser->email)->
                   with('password', $googleUser->email)->
                   with('google_id', $googleUser->id)->
                   with('google_token', $googleUser->token)->
                   with('google_refresh_token', $googleUser->refreshToken);
        }
    }
}
