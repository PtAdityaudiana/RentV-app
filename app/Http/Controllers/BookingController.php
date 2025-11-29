<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Vehicle;

class BookingController extends Controller
{
    public function store(Request $req)
    {
        $req->validate([
            'vehicle_id' => 'required|numeric',
            'start_date' => 'required|date',
            'end_date'   => 'required|date|after:start_date',
        ]);

        $userId = session('user_id');
        if (!$userId) {
            return redirect()->route('user.login')
                ->withErrors(['auth' => 'Please login']);
        }

        // Ambil vehicle
        $vehicle = Vehicle::find($req->vehicle_id);
        if (!$vehicle) {
            return back()->withErrors(['vehicle' => 'Vehicle not found']);
        }

        if ($vehicle->status !== 'available') {
            return back()->withErrors(['vehicle' => 'Vehicle not available']);
        }

        
        Booking::create([
            'user_id'       => $userId,
            'vehicle_id'    => $vehicle->id,
            'price_per_day' => $vehicle->price_per_day,
            'start_date'    => $req->start_date,
            'end_date'      => $req->end_date,
            'status'        => 'pending',
            'notes'         => $req->notes,
        ]);

        return redirect()
            ->route('user.bookingshistory')
            ->with('success', 'Booking created (pending approval)');
    }

    public function userBookings()
    {
        $userId = session('user_id');
        if (!$userId) {
            return redirect()->route('user.login');
        }

        // Load bookings dgn relasi kendaraan
        $bookings = Booking::with('vehicle')
            ->where('user_id', $userId)
            ->orderByDesc('id')
            ->get();

        return view('user.bookingshistory', compact('bookings'));
    }
}
