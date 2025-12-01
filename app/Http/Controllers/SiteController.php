<?php
namespace App\Http\Controllers;

use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SiteController extends Controller
{
    public function landing(Request $request)
    {
        $user = null;

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

        return view('landing', compact('vehicles'));
    }
}
