<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\User;
use Redirect;

class LoginController extends Controller
{
    public function login()
    {
        return view('login');
    }
    public function prosesLogin(Request $request)
    {
        if (Auth::attempt(['email'=>$request->email,'password'=>$request->password]))
        {
            if (Auth::User()->role == "Admin")
            {
                return \Redirect::to('/admin/home');
            }
            elseif (Auth::User()->role == "Karyawan")
            {
                return \Redirect::to('/karyawan/home');
            }
        }
        else
        {
            \Session::flash('msg_login','Email Atau Password Salah!');
            return \Redirect::to('/');
        }
    }
    public function logout(){
        Auth::logout();
      return \Redirect::to('/');
    }
}