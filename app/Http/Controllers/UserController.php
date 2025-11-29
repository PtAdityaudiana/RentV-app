<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Vehicle;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    private function guard()
    {
        if (!session('user_id')) {
            return redirect()->route('user.login')->send();
        }
    }

    public function dashboard(Request $request)
    {
        $this->guard();

        $user = User::findOrFail(session('user_id'));

        $vehicles = Vehicle::where('status', 'available')
            ->when($request->q, function ($q) use ($request) {
                $q->where(function ($x) use ($request) {
                    $x->where('brand', 'like', "%{$request->q}%")
                      ->orWhere('model', 'like', "%{$request->q}%")
                      ->orWhere('plate_number', 'like', "%{$request->q}%");
                });
            })
            ->when($request->type, fn($q) => $q->where('type', $request->type))
            ->get();

        return view('user.dashboard', compact('user', 'vehicles'));
    }

    public function editProfile()
    {
        $this->guard();

        $user = User::findOrFail(session('user_id'));
        return view('user.profile', compact('user'));
    }

    public function updateProfile(Request $req)
    {
        $this->guard();

        $user = User::findOrFail(session('user_id'));

        $req->validate([
            'name' => 'required'
        ]);


        if ($req->has('delete_avatar') && $user->avatar_path) {
            Storage::disk('public')->delete($user->avatar_path);
            $user->avatar_path = null;
        }

        
        if ($req->hasFile('avatar')) {
            if ($user->avatar_path) {
                Storage::disk('public')->delete($user->avatar_path);
            }
            $user->avatar_path = $req->file('avatar')->store('avatars', 'public');
        }

        $user->name  = $req->name;
        $user->phone = $req->phone;

        if ($req->filled('password')) {
            $user->password = Hash::make($req->password);
        }

        $user->save();

        return back()->with('success', 'Profile updated');
    }


    public function bookings()
    {
        $this->guard();

        $user = User::findOrFail(session('user_id'));

        $bookings = Booking::with('vehicle')
            ->where('user_id', $user->id)
            ->orderByDesc('id')
            ->get();

        return view('user.bookingshistory', compact('user', 'bookings'));
    }
}
