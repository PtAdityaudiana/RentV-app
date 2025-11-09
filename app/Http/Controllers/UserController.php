<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function dashboard()
    {
        $userId = session('user_id');
        if (!$userId) return redirect()->route('user.login');

        $user = DB::select("SELECT * FROM users WHERE id = ? LIMIT 1", [$userId])[0];
        $bookings = DB::select("SELECT b.*, v.brand, v.model FROM bookings b JOIN vehicles v ON v.id = b.vehicle_id WHERE b.user_id = ? ORDER BY b.id DESC", [$userId]);

        return view('user.dashboard', compact('user','bookings'));
    }

    public function updateProfile(Request $req)
    {
        $userId = session('user_id');
        if (!$userId) return redirect()->route('user.login');

        $req->validate(['name'=>'required']);

        $avatarPath = null;
        if ($req->hasFile('avatar')) {
            $avatarPath = $req->file('avatar')->store('avatars','public');
        }

        // update
        if ($avatarPath) {
            DB::update("UPDATE users SET name=?, phone=?, avatar_path=?, updated_at=NOW() WHERE id = ?", [
                $req->name, $req->phone, $avatarPath, $userId
            ]);
        } else {
            DB::update("UPDATE users SET name=?, phone=?, updated_at=NOW() WHERE id = ?", [
                $req->name, $req->phone, $userId
            ]);
        }

        if ($req->filled('password')) {
            DB::update("UPDATE users SET password = ? WHERE id = ?", [$req->password, $userId]);
        }

        return back()->with('success','Profile updated');
    }
}
