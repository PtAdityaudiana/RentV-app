<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showRegister(){ 
        return view('user.register'); 
    }

    public function showLogin(){ 
        return view('user.login'); 
    }

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

        //HASH password user baru
        $hashed = Hash::make($req->password);

        DB::insert(
            "INSERT INTO users (name,email,password,phone,created_at,updated_at) 
             VALUES (?,?,?,?,NOW(),NOW())",
            [$req->name, $req->email, $hashed, $req->phone]
        );

        return redirect()->route('user.login')
            ->with('success', 'Registration successful! Please log in.');
    }

    public function login(Request $req)
    {
        $req->validate(['email'=>'required|email','password'=>'required']);

        $user = DB::select("SELECT * FROM users WHERE email = ? LIMIT 1", [$req->email]);

        if (count($user) === 0) {
            return back()->withErrors(['email'=>'Credentials not match']);
        }

        $user = $user[0];

        // Jika password di tabel belum hash
        if (Hash::needsRehash($user->password)) {

            if ($req->password === $user->password) {
                // Auto hash
                DB::update("UPDATE users SET password = ? WHERE id = ?", [
                    Hash::make($req->password),
                    $user->id
                ]);
            } else {
                return back()->withErrors(['email'=>'Credentials not match']);
            }

        } else {
            //Jika sudah hash bisa login normal
            if (!Hash::check($req->password, $user->password)) {
                return back()->withErrors(['email'=>'Credentials not match']);
            }
        }

        // session
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
