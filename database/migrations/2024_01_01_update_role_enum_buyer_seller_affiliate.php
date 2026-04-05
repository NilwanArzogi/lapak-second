<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Tambah role affiliate & buyer ke enum
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('buyer','seller','affiliate','admin') NOT NULL DEFAULT 'buyer'");

        // Update data lama: 'user' → 'buyer'
        DB::statement("UPDATE users SET role = 'buyer' WHERE role = 'user'");
    }

    public function down(): void
    {
        DB::statement("UPDATE users SET role = 'user' WHERE role = 'buyer'");
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('user','seller','admin') NOT NULL DEFAULT 'user'");
    }
};
