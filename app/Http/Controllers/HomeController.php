<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Artisan;
use App\Models\User;
use Hash;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        Artisan::call('cache:clear');
        return view('home');
    }

    public function account()
    {
        if (Auth::user()) {
            return view('account');
        }
    }
    public function chnage_password(Request $request)
    {
        if (Auth::user()) {
            #Match The Old Password
            if (!Hash::check($request->old_password, auth()->user()->password)) {
                return back()->with("error", "Current Password is not matched with existting one.Please enter right password or reset password from login page");
            }

            #Update the new Password
            User::whereId(auth()->user()->id)->update([
                'password' => Hash::make($request->password)
            ]);




            return back()->with("message", "Password changed successfully!");
        }
    }
    public function chnage_profile(Request $request)
    {
        if (Auth::user()) {
            $input = $request->except(['_token']);
            $filename = "";
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $name = time() . '.' . $image->getClientOriginalExtension();
                $destinationPath = public_path('/upload/profile/');
                $image->move($destinationPath, $name);
                $input['image']  =  $name;
            }
            if (!empty($request->name)) {
                $input['name'] = $request->name;
            }
            User::where('id',   Auth::user()->id)->update($input);

           
            return back()->with("status", "Profile changed successfully!");
        }
    }
}
