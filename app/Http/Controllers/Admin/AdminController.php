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
        
        // Ambil daftar booking sekalian tampil di dashboard
        $bookings = DB::select("
            SELECT b.*, u.name as user_name, v.brand, v.model
            FROM bookings b
            JOIN users u ON u.id = b.user_id
            JOIN vehicles v ON v.id = b.vehicle_id
            ORDER BY b.id DESC
        ");
        
        return view('admin.dashboard', compact('pending','vehicles','users','bookings'));
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

    public function bookingReturn($id)
    {
        $this->guard();
        DB::update("UPDATE bookings SET status='returned', updated_at=NOW() WHERE id = ?", [$id]);
        $vehicle = DB::select("SELECT vehicle_id FROM bookings WHERE id = ?", [$id])[0];
        DB::update("UPDATE vehicles SET status='available', updated_at=NOW() WHERE id = ?", [$vehicle->vehicle_id]);
        return back()->with('success','Vehicle marked as returned');
    }

    public function bookingLate($id)
    {
        $this->guard();
        DB::update("UPDATE bookings SET status='late', updated_at=NOW() WHERE id = ?", [$id]);
        return back()->with('success','Booking marked as late');
    }

    // USERS CRUD
    public function usersIndex()
    {
        $this->guard();
        $users = DB::select("SELECT * FROM users ORDER BY id ASC");
        return view('admin.users.index', compact('users'));
    }

    public function usersCreate()
    {
        $this->guard();
        return view('admin.users.create');
    }

    public function usersStore(Request $req)
    {
        $this->guard();
        $req->validate(['name'=>'required','email'=>'required|email','password'=>'required']);
        DB::insert("INSERT INTO users (name,email,password,phone,created_at,updated_at) VALUES (?,?,?,?,NOW(),NOW())", [
            $req->name, $req->email, $req->password, $req->phone
        ]);
        return redirect()->route('admin.users.index')->with('success','User created');
    }

    public function usersEdit($id)
    {
        $this->guard();
        $user = DB::select("SELECT * FROM users WHERE id = ? LIMIT 1", [$id]);
        if (count($user)===0) abort(404);
        $user = $user[0];
        return view('admin.users.edit', compact('user'));
    }

    public function usersUpdate(Request $req,$id)
    {
        $this->guard();
        $req->validate(['name'=>'required','email'=>'required|email']);
        DB::update("UPDATE users SET name=?, email=?, phone=?, updated_at=NOW() WHERE id = ?", [
            $req->name, $req->email, $req->phone, $id
        ]);
        if ($req->filled('password')) {
            DB::update("UPDATE users SET password = ? WHERE id = ?", [$req->password, $id]);
        }
        return redirect()->route('admin.users.index')->with('success','User updated');
    }

    public function usersDelete($id)
    {
        $this->guard();
        DB::delete("DELETE FROM users WHERE id = ?", [$id]);
        return back()->with('success','User deleted');
    }

    // VEHICLES CRUD
    public function vehiclesIndex()
    {
        $this->guard();
        $vehicles = DB::select("SELECT * FROM vehicles ORDER BY id DESC");
        return view('admin.vehicles.index', compact('vehicles'));
    }

    public function vehiclesCreate()
    {
        $this->guard();
        return view('admin.vehicles.create');
    }

    public function vehiclesStore(Request $req)
    {
        $this->guard();
        $req->validate([
            'type'=>'required',
            'brand'=>'required',
            'plate_number'=>'required',
            'price_per_day'=>'required|numeric|min:0'
        ]);

        $photo = null;
        if ($req->hasFile('photo')) {
            $photo = $req->file('photo')->store('vehicles','public');
        }

        DB::insert("INSERT INTO vehicles (type,brand,model,plate_number,color,year,photo_path,price_per_day,status,notes,created_at,updated_at) VALUES (?,?,?,?,?,?,?,?,?,?,NOW(),NOW())", [
            $req->type, $req->brand, $req->model, $req->plate_number, $req->color, $req->year, $photo, $req->price_per_day, $req->status ?? 'available', $req->notes
        ]);
        return redirect()->route('admin.vehicles.index')->with('success','Vehicle added');
    }

    public function vehiclesEdit($id)
    {
        $this->guard();
        $v = DB::select("SELECT * FROM vehicles WHERE id = ? LIMIT 1", [$id]);
        if (count($v)===0) abort(404);
        $vehicle = $v[0];
        return view('admin.vehicles.edit', compact('vehicle'));
    }

    public function vehiclesUpdate(Request $req,$id)
    {
        $this->guard();
        $req->validate([
            'type'=>'required',
            'brand'=>'required',
            'plate_number'=>'required',
            'price_per_day'=>'required|numeric|min:0'
        ]);

        if ($req->hasFile('photo')) {
            $photo = $req->file('photo')->store('vehicles','public');
            DB::update("UPDATE vehicles SET type=?, brand=?, model=?, plate_number=?, color=?, year=?, photo_path=?, price_per_day=?, status=?, notes=?, updated_at=NOW() WHERE id = ?", [
                $req->type, $req->brand, $req->model, $req->plate_number, $req->color, $req->year, $photo, $req->price_per_day, $req->status, $req->notes, $id
            ]);
        } else {
            DB::update("UPDATE vehicles SET type=?, brand=?, model=?, plate_number=?, color=?, year=?, price_per_day=?, status=?, notes=?, updated_at=NOW() WHERE id = ?", [
                $req->type, $req->brand, $req->model, $req->plate_number, $req->color, $req->year, $req->price_per_day, $req->status, $req->notes, $id
            ]);
        }

        return redirect()->route('admin.vehicles.index')->with('success','Vehicle updated');
    }

    public function vehiclesDelete($id)
    {
        $this->guard();
        DB::delete("DELETE FROM vehicles WHERE id = ?", [$id]);
        return back()->with('success','Vehicle deleted');
    }
}
