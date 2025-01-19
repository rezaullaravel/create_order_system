<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{

    //login form
    public function loginForm(){
        if(Auth::check()){
            return redirect('dashboard');
        }
        return view('login');
    }

    //post login
    public function postLogin(Request $request){
        $pass = Hash::make(12345678);

        $request->validate([
            'email'=>'required|email',
            'password'=>'required',
        ],[
            'email.required'=>'The email can not be empty.',
            'password.required'=>'The password can not be empty.'
        ]);

        if(Auth::attempt(['email'=>$request->email,'password'=>$request->password])){
            if(Session::get('previous_url')){
                return redirect(Session::get('previous_url'));
            }
            return redirect()->route('dashboard');
        } else {
            return redirect()->back()->with('error_message','Oops! your credential does not match our records...');
        }
    }//end method
    //dashboard
    public function dashboard(){
        return view('panel.dashboard');
    }

    //logout
    public function logout(){
        Session::flush();
        Auth::logout();
        return redirect('/');
    }
}
