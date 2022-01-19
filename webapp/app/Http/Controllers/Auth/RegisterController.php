<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Validation\Rules\Password;
use App\Http\Requests\RegisterOAuthRequest;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'username' => 'required|string|max:255|unique:users',
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'birthdate' => 'required|date|before:today',
            'password' => [
                'required',
                'string',
                'confirmed',
                Password::min(8)
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
            ]
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'username' => $data['username'],
            'name' => $data['name'],
            'email' => $data['email'],
            'profile_pic' => 'profile_pictures/default.png',
            'birthdate' => date('Y-m-d', strtotime($data['birthdate'])),
            'password' => bcrypt($data['password']),
        ]);
    }

    public function showOAuthRegistrationForm(){
        return view('auth.registerOAuth');
    }

    public function registerOAuth(RegisterOAuthRequest $request)
    {
        if (!$request->session()->exists('name') ||
            !$request->session()->exists('email') ||
            !$request->session()->exists('google_id') ||
            !$request->session()->exists('google_token') ||
            !$request->session()->exists('google_refresh_token')) return redirect('/login');

        $user = User::create([
            'username' => $request->input('username'),
            'email' => $request->session()->pull('email'),
            'profile_pic' => 'profile_pictures/default.png',
            'name' => $request->session()->pull('name'),
            'birthdate' => $request->input('birthdate'),
            'google_id' => $request->session()->pull('google_id'),
            'google_token' => $request->session()->pull('google_token'),
            'google_refresh_token' => $request->session()->pull('google_refresh_token')
        ]);

        Auth::login($user);

        return redirect('user/' . $user->id);
    }
}
