<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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

        $user = User::where('email', $req->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'Credentials not match']);
        }

        // Jika db masih plaintext
        if (Hash::needsRehash($user->password)) {

            if ($req->password === $user->password) {
                // hash plaintext
                $user->update([
                    'password' => Hash::make($req->password)
                ]);
            } else {
                return back()->withErrors(['email' => 'Credentials not match']);
            }

        } else {
            // check hash
            if (!Hash::check($req->password, $user->password)) {
                return back()->withErrors(['email' => 'Credentials not match']);
            }
        }

        // Set session
        session()->forget('admin_id');
        session(['user_id' => $user->id]);

        return redirect()->route('user.dashboard');
    }

    public function logout()
    {
        session()->forget('user_id');
        return redirect()->route('landing');
    }
}
