<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfilesController;
use App\Models\Profiles;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register(Request $request){
        if($request->isMethod('post')){
            $request->validate([
                'name' => 'required',
                'email' => 'required|email',
                'password' => 'required',
            ]);
            Profiles::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);                                          
             return redirect()->route ('login')->with('success', 'Register Successfully! Please login');
                 
        }
        return view ( 'user.register') ;

    }

    public function login(Request $request){
        if($request-> isMethod('post')){
            $request-> validate([
                "email" => "required|email",
                "password" => "required"
            ]);
            if(Auth::attempt([
                "email" => $request->email,
                "password" => $request->password
            ])){
                return redirect()->route("user.dashboard");

            } else{
            return redirect()->route('login')->with("error","Invalid Credentials");
                }
        }
        return view('user.login');
    }

    public function dashboard(){
        return view('user.dashboard');
    }
}
