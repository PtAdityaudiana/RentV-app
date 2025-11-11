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

    // crud usr
    
}
