<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class SiteController extends Controller
{
    public function landing()
    {
        $vehicles = DB::select("SELECT * FROM vehicles WHERE status = 'available' ORDER BY id DESC LIMIT 6");
        return view('landing', compact('vehicles'));
    }
}
