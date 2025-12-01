<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

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

    
        if (!Hash::isHashed($admin->password)) {
            if ($req->password === $admin->password) {
                // Re-hash and update the password
                $admin->password = Hash::make($req->password);
                $admin->save();
            } else {
                return back()->withErrors(['password' => 'Credentials invalid']);
            }

        }elseif(!Hash::check($req->password, $admin->password)) {
            return back()->withErrors(['password' => 'Credentials invalid']);
        }
        
        Auth::guard('admin')->login($admin);
        $req->session()->regenerate();
        return redirect()->route('admin.dashboard');
    }

    public function logout(Request $req)
    {
        Auth::guard('admin')->logout();
        $req->session()->invalidate();
        $req->session()->regenerateToken();
        return redirect()->route('admin.login');
    }
}
