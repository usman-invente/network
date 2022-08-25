<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;

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
    protected $redirectTo = RouteServiceProvider::HOME;

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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
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
       
         User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'role_id' => 2,
            'image' => 'icon-employee-6.jpg',
            'password' => Hash::make($data['password']),

        ]);
        $details = [
            'template'  => 'welcome',
            'subject'   => 'Account info!',
            'email'     =>  $data['email'],
            'user_name'      => $data['name'],
            'url' => env('APP_URL') . '/login'
        ];


        Mail::to(env('MAIL_USERNAME'))->send(new  \App\Mail\WelcomeMailToAdmin($details));
    }

    protected function registered()
    {
        return redirect('/login')->with('success', 'Thank you for registering. Please wait to be approved');
    }
}
