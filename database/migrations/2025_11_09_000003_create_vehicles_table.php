<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        DB::unprepared(<<<'SQL'
CREATE TABLE IF NOT EXISTS `vehicles` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `type` ENUM('motor','mobil') NOT NULL,
  `brand` VARCHAR(100) NOT NULL,
  `model` VARCHAR(100) NULL,
  `plate_number` VARCHAR(50) NOT NULL UNIQUE,
  `color` VARCHAR(50) NULL,
  `year` SMALLINT NULL,
  `photo_path` VARCHAR(255) NULL,
  `status` ENUM('available','maintenance','unavailable') NOT NULL DEFAULT 'available',
  `notes` TEXT NULL,
  `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
SQL
        );
    }

    public function down(): void
    {
        DB::unprepared('DROP TABLE IF EXISTS `vehicles`;');
    }
};
