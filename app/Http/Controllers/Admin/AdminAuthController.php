<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminAuthController extends Controller
{
    public function showLogin(){ 
        return view('admin.auth.login'); 
    }

    public function login(Request $req)
    {
        $req->validate(['username'=>'required','password'=>'required']);

        $admin = DB::select("SELECT * FROM admins WHERE username = ? LIMIT 1", [$req->username]);

        if (count($admin) === 0) {
            return back()->withErrors(['username'=>'Credentials invalid']);
        }

        $admin = $admin[0];

        // Jika password belum hash 
        if (Hash::needsRehash($admin->password)) {

            if ($req->password === $admin->password) {
                // Autohash
                DB::update("UPDATE admins SET password = ? WHERE id = ?", [
                    Hash::make($req->password),
                    $admin->id
                ]);
            } else {
                return back()->withErrors(['password'=>'Wrong password']);
            }

        } else {
            // Jika sudah hash bisa login normal
            if (!Hash::check($req->password, $admin->password)) {
                return back()->withErrors(['password'=>'Wrong password']);
            }
        }

        // session
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
