<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        
        DB::statement("
            ALTER TABLE bookings 
            MODIFY status ENUM(
                'pending',
                'approved',
                'rejected',
                'late',
                'returned',
                'canceled'
            ) NOT NULL DEFAULT 'pending'
        ");
    }

    public function down(): void
    {
       
        DB::statement("
            ALTER TABLE bookings 
            MODIFY status ENUM(
                'pending',
                'approved',
                'rejected',
                'ongoing',
                'completed',
                'late',
                'returned'
            ) NOT NULL DEFAULT 'pending'
        ");
    }
};
