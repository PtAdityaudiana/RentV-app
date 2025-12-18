<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Vehicle;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function store(Request $req)
    {
        $req->validate([
            'vehicle_id' => 'required|numeric',
            'start_date' => 'required|date',
            'end_date'   => 'required|date|after:start_date',
        ]);

       $user = Auth::guard('user')->user();

        $vehicle = Vehicle::find($req->vehicle_id);
        if (!$vehicle) {
            return back()->withErrors(['vehicle' => 'Vehicle not found']);
        }

        if ($vehicle->status !== 'available') {
            return back()->withErrors(['vehicle' => 'Vehicle not available']);
        }

        
        Booking::create([
            'user_id'       => $user->id,
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
        $user = Auth::guard('user')->user();

       
        $bookings = Booking::with('vehicle')
            ->where('user_id', $user->id)
            ->orderByDesc('id')
            ->get();

        return view('user.bookingshistory', compact('bookings'));
    }

    public function cancel($id){
        $user = Auth::guard('user')->user();

        $bookings = Booking::where('id', $id)
            ->where('status', 'pending')
            ->first();

        if(!$bookings){
            return back()->withErrors(['booking' => 'Booking tidak ditemukan']);
        }

        if($bookings->status !== 'pending'){
            return back()->withErrors(['booking' => 'Hanya booking dengan status pending yang bisa dibatalkan']);
        }

        $bookings->status = 'canceled';
        $bookings->save();

        return back()->with('success', 'Booking berhasil dibatalkan');
    }

}
