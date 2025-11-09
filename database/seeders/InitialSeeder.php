<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class InitialSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now()->toDateTimeString();

        
        DB::table('admins')->insert([
            ['username'=>'admin','password'=>'admin123','created_at'=>$now,'updated_at'=>$now],
            ['username'=>'admin2','password'=>'admin234','created_at'=>$now,'updated_at'=>$now],
        ]);

       
        DB::table('users')->insert([
            ['name'=>'Demo User','email'=>'user@example.com','password'=>'user123','phone'=>'081234567890','created_at'=>$now,'updated_at'=>$now],
            ['name'=>'Budi','email'=>'budi@example.com','password'=>'budi123','phone'=>'08111111111','created_at'=>$now,'updated_at'=>$now],
            ['name'=>'Siti','email'=>'siti@example.com','password'=>'siti123','phone'=>'08222222222','created_at'=>$now,'updated_at'=>$now],
        ]);

        
        DB::table('vehicles')->insert([
            ['type'=>'mobil','brand'=>'Toyota','model'=>'Avanza','plate_number'=>'B 1234 AB','color'=>'White','year'=>2018,'photo_path'=>null,'status'=>'available','notes'=>'Bagus untuk 7 penumpang','created_at'=>$now,'updated_at'=>$now],
            ['type'=>'mobil','brand'=>'Daihatsu','model'=>'Xenia','plate_number'=>'B 5678 CD','color'=>'Silver','year'=>2017,'photo_path'=>null,'status'=>'available','notes'=>null,'created_at'=>$now,'updated_at'=>$now],
            ['type'=>'motor','brand'=>'Honda','model'=>'Vario 150','plate_number'=>'B 9999 EF','color'=>'Black','year'=>2020,'photo_path'=>null,'status'=>'available','notes'=>null,'created_at'=>$now,'updated_at'=>$now],
            ['type'=>'motor','brand'=>'Yamaha','model'=>'NMax','plate_number'=>'B 8888 GH','color'=>'Blue','year'=>2021,'photo_path'=>null,'status'=>'maintenance','notes'=>'Service bulan depan','created_at'=>$now,'updated_at'=>$now],
        ]);

       
        DB::table('bookings')->insert([
            [
                'user_id'=>1,
                'vehicle_id'=>1,
                'start_date'=>Carbon::now()->addDays(1)->format('Y-m-d 09:00:00'),
                'end_date'=>Carbon::now()->addDays(3)->format('Y-m-d 17:00:00'),
                'status'=>'approved',
                'notes'=>'Booking untuk outing kampus',
                'created_at'=>$now,'updated_at'=>$now
            ],
            [
                'user_id'=>2,
                'vehicle_id'=>3,
                'start_date'=>Carbon::now()->addDays(2)->format('Y-m-d 08:00:00'),
                'end_date'=>Carbon::now()->addDays(2)->addHours(6)->format('Y-m-d H:i:s'),
                'status'=>'pending',
                'notes'=>'Perlu motor untuk antar paket',
                'created_at'=>$now,'updated_at'=>$now
            ],
        ]);
    }
}
