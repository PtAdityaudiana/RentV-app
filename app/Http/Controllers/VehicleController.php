<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VehicleController extends Controller
{
    public function index(Request $req)
    {
        $sql = "SELECT * FROM vehicles WHERE 1=1";
        $params = [];

        if ($req->filled('q')) {
            $sql .= " AND (brand LIKE ? OR model LIKE ? OR plate_number LIKE ?)";
            $like = "%{$req->q}%";
            $params[] = $like; $params[] = $like; $params[] = $like;
        }

        if ($req->filled('type')) {
            $sql .= " AND type = ?";
            $params[] = $req->type;
        }

        $sql .= " ORDER BY id DESC";
        $vehicles = DB::select($sql, $params);

        return view('vehicles.index', compact('vehicles'));
    }

    public function show($id)
    {
        $vehicle = DB::select("SELECT * FROM vehicles WHERE id = ? LIMIT 1", [$id]);
        if (count($vehicle) === 0) abort(404);
        $vehicle = $vehicle[0];
        return view('vehicles.show', compact('vehicle'));
    }
}
