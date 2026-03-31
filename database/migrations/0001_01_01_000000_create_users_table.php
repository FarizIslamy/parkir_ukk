<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. TABEL USER (Sesuai Soal)
        Schema::create('tb_user', function (Blueprint $table) {
            $table->id('id_user'); // Primary Key
            $table->string('username')->unique();
            $table->string('password');
            $table->enum('role', ['admin', 'petugas', 'owner']);
            $table->timestamps();
        });

        // 2. TABEL SESSION (Wajib ada karena kamu pilih SESSION_DRIVER=database)
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tb_user');
        Schema::dropIfExists('sessions');
    }
};