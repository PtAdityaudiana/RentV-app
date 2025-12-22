<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use Illuminate\Http\Request;


class VehicleController extends Controller
{
    public function index()
    {
        $vehicles = Vehicle::where('status', 'available')->get();

    return response()->json([
        'status' => true,
        'message' => 'Daftar kendaraan yang statusnya avaiable berhasil diambil',
        'data'    => $vehicles
    ]);
    }

    public function show($id)
    {
        $vehicle = Vehicle::find($id);

        if (!$vehicle || $vehicle->status !== 'available') {
            return response()->json([
                'status' => false,
                'message' => 'Vehicle yang diharapkan tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Detail kendaraan berdasarkan id berhasil diambil',
            'data' => $vehicle
        ]);
    }

    public function vehiclesStore(Request $req){
        $req->validate([
            'type'          => 'required',
            'brand'         => 'required',
            'plate_number'  => 'required',
            'price_per_day' => 'required|numeric|min:0'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status'  => false,
                'message' => 'Validasi error',
                'errors'  => $validator->errors()
            ], 422);
        }

        $photo = $req->hasFile('photo')
            ? $req->file('photo')->store('vehicles', 'public')
            : null;
        
        Vehicle::create([
            'type'          => $req->type,
            'brand'         => $req->brand,
            'model'         => $req->model,
            'plate_number'  => $req->plate_number,
            'color'         => $req->color,
            'year'          => $req->year,
            'photo_path'    => $photo,
            'price_per_day' => $req->price_per_day,
            'status'        => $req->status ?? 'available',
            'notes'         => $req->notes
        ]);

        return response()->json([ 
            'status' => true,
            'message' => 'Vehicle added',
            'data'    => $vehicle
        ]);
    }

    public function storeDummy(){
        $vehicle = Vehicle::create([
            'type'         => 'motor',
            'brand'        => 'Dummy',
            'model'        => 'Avanza',
            'plate_number' => 'B 1234 TEST',
            'color'        => 'White',
            'year'         => 2022,
            'photo_path'    => NULL,
            'price_per_day'=> 350000,
            'status'       => 'available',
            'notes'        => 'Dummy data for API testing'
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Dummy vehicles created',
            'data'    => $vehicle
        ]);
    }

    public function delete($id){
        $vehicle = Vehicle::find($id);

        if (!$vehicle) {
            return response()->json([
                'status' => false,
                'message' => 'Vehicle tidak ditemukan'
            ], 404);
        }

        $vehicle->delete();

        return response()->json([
            'status' => true,
            'message' => 'Vehicle berhasil dihapus',
            'data'    => NULL
        ]);
    }
}
