<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB; // Import DB facade
use Illuminate\Support\Facades\Hash; // Import Hash facade for password hashing

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->timestamps();
        });

        // **Seed initial admin user data directly in migration (as requested)**
        DB::table('admins')->insert([
            'name' => 'Super Admin', // You can set a default name
            'email' => 'ssdrc@mail.com',
            'password' => Hash::make('SSDRC123456'), // Hash the password
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admins');
    }
};