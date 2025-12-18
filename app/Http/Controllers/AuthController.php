<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showRegister()
    {
        return view('user.register');
    }

    public function showLogin()
    {
        return view('user.login');
    }

    public function register(Request $req)
    {
        $req->validate([
            'name'=>'required',
            'email'=>'required|email|unique:users,email',
            'password'=>'required|min:3'
        ]);

        $user = User::create([
            'name'      => $req->name,
            'email'     => $req->email,
            'phone'     => $req->phone,
            'password'  => Hash::make($req->password),
        ]);

        return redirect()->route('user.login')
            ->with('success', 'Registration successful! Please log in.');
    }

    public function login(Request $req)
    {
        $req->validate([
            'email'=>'required|email',
            'password'=>'required'
        ]);

        $credentials = $req->only('email', 'password');

        if (Auth::guard('user')->attempt($credentials)) {
            Auth::guard('admin')->logout();
            $req->session()->regenerate();
            return redirect()->route('user.dashboard');
        }
        
        return back()->withErrors(['email' => 'Credentials not match']);
    }

    public function logout(Request $req)
    {
        Auth::guard('user')->logout();
        $req->session()->invalidate();
        $req->session()->regenerateToken();

        return redirect()->route('landing');
    }
}
