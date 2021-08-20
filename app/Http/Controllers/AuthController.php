<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    function login()
    {

        \request()->validate([
            'email' => 'required|string',
            'password' => 'required|min:8'
        ]);

        //retrieve login data

        $loginData = \request()->only(['email', 'password']);

        if (auth()->attempt($loginData)){
           return redirect()->route('home');
        }
        session()->flash('message', 'Incorrect Email or Password');
        return redirect()->back();
    }

    function loginPage()
    {
        return view('auth.login');

}
