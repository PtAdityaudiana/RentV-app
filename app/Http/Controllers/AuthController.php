<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function showRegister(){ return view('user.register'); }
    public function showLogin(){ return view('user.login'); }

    public function register(Request $req)
    {
        $req->validate([
            'name'=>'required',
            'email'=>'required|email',
            'password'=>'required|min:3'
        ]);

      
        $exists = DB::select("SELECT id FROM users WHERE email = ? LIMIT 1", [$req->email]);
        if (count($exists) > 0) {
            return back()->withErrors(['email'=>'Email already used'])->withInput();
        }

        DB::insert("INSERT INTO users (name,email,password,phone,created_at,updated_at) VALUES (?,?,?,?,NOW(),NOW())", [
            $req->name, $req->email, $req->password, $req->phone
        ]);

      
        $user = DB::select("SELECT id FROM users WHERE email = ? LIMIT 1", [$req->email])[0];
        return redirect()->route('user.login')->with('success', 'Registration successful! Please log in to continue.');
    }

    public function login(Request $req)
    {
        $req->validate(['email'=>'required|email','password'=>'required']);
        $user = DB::select("SELECT * FROM users WHERE email = ? LIMIT 1", [$req->email]);
        if (count($user) === 0 || $user[0]->password !== $req->password) {
            return back()->withErrors(['email'=>'Credentials not match'])->withInput();
        }
        session(['user_id' => $user[0]->id]);
        return redirect()->route('user.dashboard');
    }

    public function logout()
    {
        session()->forget('user_id');
        return redirect()->route('landing');
    }
}
