<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function store(Request $req)
    {
        $data = $req->validate([
            'vehicle_id' => 'required|exists:vehicles,id',
            'start_date' => 'required|date',
            'end_date'   => 'required|date|after:start_date',
            'notes'      => 'nullable|string'
        ]);

        $vehicle = Vehicle::find($data['vehicle_id']);

        if ($vehicle->status !== 'available') {
            return response()->json([
                'status' => false,
                'message' => 'Vehicle not available'
            ], 409);
        }

        $booking = Booking::create([
            'user_id'       => Auth::guard('user')->id(),
            'vehicle_id'    => $vehicle->id,
            'price_per_day' => $vehicle->price_per_day,
            'start_date'    => $data['start_date'],
            'end_date'      => $data['end_date'],
            'status'        => 'pending',
            'notes'         => $data['notes'] ?? null,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Booking created',
            'data'    => $booking
        ], 201);
    }

    public function cancel($id){
        {
            $booking = Booking::find($id);
    
            if (!$booking) {
                return response()->json([
                    'status' => false,
                    'message' => 'Booking tidak ditemukan'
                ], 404);
            }
    
            if ($booking->status !== 'pending') {
                return response()->json([
                    'status' => false,
                    'message' => 'hanya booking dengan status pending yang dapat di cancel'
                ], 422);
            }
    
            $booking->update(['status' => 'canceled']);
    
            return response()->json([
                'status' => true,
                'message' => 'Booking berhasil di cancel',
                'data'    => $booking
            ]);
        }
    }

    public function userBookings($id)
    {
        $bookings = Booking::with('vehicle') 
            ->where('user_id', $id)
            ->orderByDesc('id')
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'User bookings diambil berdasarkan user id',
            'data'    => $bookings
        ]);
    }
}
