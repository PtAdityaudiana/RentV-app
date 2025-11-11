<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    public function store(Request $req)
    {
        $req->validate([
            'vehicle_id'=>'required|numeric',
            'start_date'=>'required|date',
            'end_date'=>'required|date|after:start_date'
        ]);

        $userId = session('user_id');
        if (!$userId) return redirect()->route('user.login')->withErrors(['auth'=>'Please login']);

        
        $v = DB::select("SELECT * FROM vehicles WHERE id = ? LIMIT 1", [$req->vehicle_id]);
        if (count($v) === 0) return back()->withErrors(['vehicle'=>'Vehicle not found']);
        if ($v[0]->status !== 'available') return back()->withErrors(['vehicle'=>'Vehicle not available']);

        DB::insert("INSERT INTO bookings (user_id,vehicle_id,start_date,end_date,status,notes,created_at,updated_at) VALUES (?,?,?,?,? ,?, NOW(), NOW())", [
            $userId, $req->vehicle_id, $req->start_date, $req->end_date, 'pending', $req->notes
        ]);

        return redirect()->route('user.bookingshistory')->with('success','Booking created (pending approval)');
    }

    public function userBookings()
    {
        $userId = session('user_id');
        if (!$userId) return redirect()->route('user.login');

        $bookings = DB::select("
            SELECT b.*, v.brand, v.model, v.plate_number
            FROM bookings b
            JOIN vehicles v ON v.id = b.vehicle_id
            WHERE b.user_id = ?
            ORDER BY b.id DESC
        ", [$userId]);

        return view('user.bookingshistory', compact('bookings'));
    }
}
