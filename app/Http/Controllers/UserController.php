<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function dashboard(Request $request)
{
    $user = DB::table('users')->where('id', session('user_id'))->first();

    // Ambil kendaraan yang statusnya masih available
    $query = "SELECT * FROM vehicles WHERE status = 'available'";
    $bindings = [];

    if ($request->q) {
        $query .= " AND (brand LIKE ? OR model LIKE ? OR plate_number LIKE ?)";
        $bindings = array_fill(0, 3, '%'.$request->q.'%');
    }

    if ($request->type) {
        $query .= " AND type = ?";
        $bindings[] = $request->type;
    }

    $vehicles = DB::select($query, $bindings);

    return view('user.dashboard', compact('user', 'vehicles'));
}


    public function updateProfile(Request $req)
    {
        $userId = session('user_id');
        if (!$userId) return redirect()->route('user.login');

        $req->validate(['name'=>'required']);

        $user = DB::selectOne("SELECT avatar_path FROM users WHERE id = ?", [$userId]);
        if ($req->has('delete_avatar') && $user->avatar_path) {

            // hapus file fisik di storage
            Storage::disk('public')->delete($user->avatar_path);
    
            // update path jadu null
            DB::update("UPDATE users SET avatar_path = NULL WHERE id = ?", [$userId]);
        }

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

    public function editProfile()
{
    $userId = session('user_id');
    if (!$userId) return redirect()->route('user.login');
    $user = DB::selectOne("SELECT * FROM users WHERE id = ?", [$userId]);
    return view('user.profile', compact('user'));
}

    public function bookings()
    {
        $userId = session('user_id');
        if (!$userId) return redirect()->route('user.login');

        $user = DB::select("SELECT * FROM users WHERE id = ? LIMIT 1", [$userId])[0];
        $bookings = DB::select("SELECT b.*, v.brand, v.model FROM bookings b JOIN vehicles v ON v.id = b.vehicle_id WHERE b.user_id = ? ORDER BY b.id DESC", [$userId]);

        return view('user.bookingshistory', compact('user','bookings'));
    }
}
