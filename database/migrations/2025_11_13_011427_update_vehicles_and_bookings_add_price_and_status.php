<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // --- Vehicles ---
        Schema::table('vehicles', function (Blueprint $table) {
            if (!Schema::hasColumn('vehicles', 'price_per_day')) {
                $table->decimal('price_per_day', 10, 3)->nullable()->after('year');
            }
        });

        // --- Bookings ---
        Schema::table('bookings', function (Blueprint $table) {
            if (!Schema::hasColumn('bookings', 'price_per_day')) {
                $table->decimal('price_per_day', 10, 3)->nullable()->after('vehicle_id');
            }

            // Karena ENUM sudah ada di DB, kita pastikan migration-nya bisa mereplikasi itu di server baru.
            // Di MySQL/MariaDB, kita perlu alter secara manual karena enum tidak bisa "extend" otomatis.
            if (Schema::hasColumn('bookings', 'status')) {
                DB::statement("ALTER TABLE bookings MODIFY status 
                    ENUM('pending','approved','rejected','ongoing','completed','late','returned') 
                    NOT NULL DEFAULT 'pending'");
            }
        });
    }

    public function down(): void
    {
        // Saat rollback, hapus kolom tambahan ini (optional)
        Schema::table('vehicles', function (Blueprint $table) {
            if (Schema::hasColumn('vehicles', 'price_per_day')) {
                $table->dropColumn('price_per_day');
            }
        });

        Schema::table('bookings', function (Blueprint $table) {
            if (Schema::hasColumn('bookings', 'price_per_day')) {
                $table->dropColumn('price_per_day');
            }

            // Kembalikan enum ke versi lama jika ingin rollback
            DB::statement("ALTER TABLE bookings MODIFY status 
                ENUM('pending','approved','rejected','ongoing','completed') 
                NOT NULL DEFAULT 'pending'");
        });
    }
};
