<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Vehicle;

class VehicleController extends Controller
{
    public function index(Request $req)
    {
        $vehicles = Vehicle::query()
            ->when($req->filled('q'), function ($query) use ($req) {
                $search = "%{$req->q}%";
                $query->where(function ($q) use ($search) {
                    $q->where('brand', 'LIKE', $search)
                      ->orWhere('model', 'LIKE', $search)
                      ->orWhere('plate_number', 'LIKE', $search);
                });
            })
            ->when($req->filled('type'), function ($query) use ($req) {
                $query->where('type', $req->type);
            })
            ->orderByDesc('id')
            ->get();

        return view('vehicles.index', compact('vehicles'));
    }

    public function show($id)
    {
        $vehicle = Vehicle::findOrFail($id);
        return view('vehicles.show', compact('vehicle'));
    }
}
