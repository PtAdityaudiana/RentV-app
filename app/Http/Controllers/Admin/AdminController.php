<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Vehicle;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{


    public function dashboard()
    {
        
        $pending   = Booking::where('status', 'pending')->count();
        $vehicles  = Vehicle::count();
        $users     = User::count();

        $bookings = Booking::with(['user', 'vehicle'])
            ->orderByDesc('id')
            ->get();

        return view('admin.dashboard', compact('pending','vehicles','users','bookings'));
    }

    // status control
    public function bookingApprove($id)
    {
        $booking = Booking::findOrFail($id);

        $booking->update(['status' => 'approved']);
        $booking->vehicle->update(['status' => 'unavailable']);

        return back()->with('success', 'Booking approved');
    }

    public function bookingReject($id)
    {
        Booking::findOrFail($id)->update([
            'status' => 'rejected'
        ]);

        return back()->with('success', 'Booking rejected');
    }

    public function bookingReturn($id)
    {
        $booking = Booking::findOrFail($id);

        $booking->update(['status' => 'returned']);
        $booking->vehicle->update(['status' => 'maintenance']);

        return back()->with('success', 'Vehicle marked as returned');
    }

    public function bookingLate($id)
    {
        Booking::findOrFail($id)->update([
            'status' => 'late'
        ]);
        
        return back()->with('success', 'Booking marked as late');
    }

    # user crud
    public function usersIndex()
    {
        $users = User::orderBy('id')->get();
        return view('admin.users.index', compact('users'));
    }

    public function usersCreate()
    {
        
        return view('admin.users.create');
    }

    public function usersStore(Request $req)
    {  
        $req->validate([
            'name'     => 'required',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|min:3'
        ]);

        User::create([
            'name'      => $req->name,
            'email'     => $req->email,
            'password'  => Hash::make($req->password),
            'phone'     => $req->phone
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', 'User created');
    }

    public function usersEdit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    public function usersUpdate(Request $req, $id)
    {
        $req->validate([
            'name'  => 'required',
            'email' => 'required|email'
        ]);

        $user = User::findOrFail($id);

        $user->update([
            'name'  => $req->name,
            'email' => $req->email,
            'phone' => $req->phone
        ]);

     
        if ($req->filled('password')) {
            $user->update([
                'password' => Hash::make($req->password)
            ]);
        }

        return redirect()->route('admin.users.index')
            ->with('success','User updated');
    }

    public function usersDelete($id)
    {
        User::destroy($id);
        return back()->with('success','User deleted');
    }

    // vehicle crud
    public function vehiclesIndex()
    {
        $vehicles = Vehicle::orderBy('id')->get();
        return view('admin.vehicles.index', compact('vehicles'));
    }

    public function vehiclesCreate()
    {
        return view('admin.vehicles.create');
    }

    public function vehiclesStore(Request $req)
    {
        $req->validate([
            'type'          => 'required',
            'brand'         => 'required',
            'plate_number'  => 'required',
            'price_per_day' => 'required|numeric|min:0'
        ]);

        $photo = $req->hasFile('photo')
            ? $req->file('photo')->store('vehicles', 'public')
            : null;

        Vehicle::create([
            'type'          => $req->type,
            'brand'         => $req->brand,
            'model'         => $req->model,
            'plate_number'  => $req->plate_number,
            'color'         => $req->color,
            'year'          => $req->year,
            'photo_path'    => $photo,
            'price_per_day' => $req->price_per_day,
            'status'        => $req->status ?? 'available',
            'notes'         => $req->notes
        ]);

        return redirect()->route('admin.vehicles.index')
            ->with('success','Vehicle added');
    }

    public function vehiclesEdit($id)
    {
        $vehicle = Vehicle::findOrFail($id);
        return view('admin.vehicles.edit', compact('vehicle'));
    }

    public function vehiclesUpdate(Request $req, $id)
    {
        $req->validate([
            'type'          => 'required',
            'brand'         => 'required',
            'plate_number'  => 'required',
            'price_per_day' => 'required|numeric|min:0'
        ]);

        $vehicle = Vehicle::findOrFail($id);

        $photo = $req->hasFile('photo')
            ? $req->file('photo')->store('vehicles', 'public')
            : $vehicle->photo_path;

        $vehicle->update([
            'type'          => $req->type,
            'brand'         => $req->brand,
            'model'         => $req->model,
            'plate_number'  => $req->plate_number,
            'color'         => $req->color,
            'year'          => $req->year,
            'photo_path'    => $photo,
            'price_per_day' => $req->price_per_day,
            'status'        => $req->status,
            'notes'         => $req->notes
        ]);

        return redirect()->route('admin.vehicles.index')
            ->with('success','Vehicle updated');
    }

    public function vehiclesDelete($id)
    {
        Vehicle::destroy($id);
        return back()->with('success','Vehicle deleted');
    }
}
