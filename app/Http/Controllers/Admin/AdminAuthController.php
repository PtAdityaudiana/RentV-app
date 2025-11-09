<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminAuthController extends Controller
{
    public function showLogin(){ return view('admin.auth.login'); }

    public function login(Request $req)
    {
        $req->validate(['username'=>'required','password'=>'required']);
        $admin = DB::select("SELECT * FROM admins WHERE username = ? LIMIT 1", [$req->username]);
        if (count($admin) === 0 || $admin[0]->password !== $req->password) {
            return back()->withErrors(['username'=>'Credentials invalid'])->withInput();
        }
        session(['admin_id' => $admin[0]->id]);
        return redirect()->route('admin.dashboard');
    }

    public function logout()
    {
        session()->forget('admin_id');
        return redirect()->route('admin.login');
    }
}
