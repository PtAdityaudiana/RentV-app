<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tambahkan kolom ke tabel vehicles jika belum ada
        if (!Schema::hasColumn('vehicles', 'price_per_day')) {
            Schema::table('vehicles', function (Blueprint $table) {
                $table->decimal('price_per_day', 10, 3)
                      ->after('year')
                      ->default(0);
            });
        }

        // Tambahkan kolom ke tabel bookings jika belum ada
        if (!Schema::hasColumn('bookings', 'price_per_day')) {
            Schema::table('bookings', function (Blueprint $table) {
                $table->decimal('price_per_day', 10, 3)
                      ->after('vehicle_id')
                      ->default(0);
            });
        }
    }

    public function down(): void
    {
        // Hapus kolom hanya jika ada
        if (Schema::hasColumn('vehicles', 'price_per_day')) {
            Schema::table('vehicles', function (Blueprint $table) {
                $table->dropColumn('price_per_day');
            });
        }

        if (Schema::hasColumn('bookings', 'price_per_day')) {
            Schema::table('bookings', function (Blueprint $table) {
                $table->dropColumn('price_per_day');
            });
        }
    }
};
