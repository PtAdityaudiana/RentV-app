<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    protected function guard() {
        if (!session('admin_id')) abort(403, 'Unauthorized');
    }

    public function dashboard()
    {
        $this->guard();
        $pending = DB::select("SELECT COUNT(*) as cnt FROM bookings WHERE status = 'pending'")[0]->cnt;
        $vehicles = DB::select("SELECT COUNT(*) as cnt FROM vehicles")[0]->cnt;
        $users = DB::select("SELECT COUNT(*) as cnt FROM users")[0]->cnt;
        return view('admin.dashboard', compact('pending','vehicles','users'));
    }

    // Bookings
    public function bookingsIndex()
    {
        $this->guard();
        $bookings = DB::select("SELECT b.*, u.name as user_name, v.brand, v.model FROM bookings b JOIN users u ON u.id = b.user_id JOIN vehicles v ON v.id = b.vehicle_id ORDER BY b.id DESC");
        return view('admin.bookings.index', compact('bookings'));
    }

    public function bookingApprove($id)
    {
        $this->guard();
        $bk = DB::select("SELECT * FROM bookings WHERE id = ? LIMIT 1", [$id]);
        if (count($bk)===0) abort(404);
        $booking = $bk[0];

       
        DB::update("UPDATE bookings SET status='approved', updated_at=NOW() WHERE id = ?", [$id]);

       
        DB::update("UPDATE vehicles SET status='unavailable', updated_at=NOW() WHERE id = ?", [$booking->vehicle_id]);

        return back()->with('success','Booking approved');
    }

    public function bookingReject($id)
    {
        $this->guard();
        DB::update("UPDATE bookings SET status='rejected', updated_at=NOW() WHERE id = ?", [$id]);
        return back()->with('success','Booking rejected');
    }
    
}
