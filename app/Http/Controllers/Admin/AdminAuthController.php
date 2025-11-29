<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminAuthController extends Controller
{
    public function showLogin()
    {
        return view('admin.auth.login');
    }

    public function login(Request $req)
    {
        $req->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        $admin = Admin::where('username', $req->username)->first();

        if (!$admin) {
            return back()->withErrors(['username' => 'Credentials invalid']);
        }

    
        if (Hash::needsRehash($admin->password)) {

            if ($req->password === $admin->password) {
                $admin->update([
                    'password' => Hash::make($req->password)
                ]);
            } else {
                return back()->withErrors(['password' => 'Wrong password']);
            }

        } else {
            if (!Hash::check($req->password, $admin->password)) {
                return back()->withErrors(['password' => 'Wrong password']);
            }
        }

        // Set sesi
        session()->forget('user_id');
        session(['admin_id' => $admin->id]);

        return redirect()->route('admin.dashboard');
    }

    public function logout()
    {
        session()->forget('admin_id');
        return redirect()->route('admin.login');
    }
}
