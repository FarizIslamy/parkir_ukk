<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tb_transaksi', function (Blueprint $table) {
            $table->id('id_parkir');
            $table->integer('id_kendaraan');
            $table->integer('id_tarif');
            $table->integer('id_area')->nullable();
            $table->integer('id_user');
            $table->dateTime('waktu_masuk');
            $table->dateTime('waktu_keluar')->nullable(); // Nullable karena pas masuk belum tahu kapan keluar
            $table->integer('biaya_total')->nullable();   // Nullable, diisi pas keluar
            $table->integer('durasi_jam')->nullable();    // Tambahan buat simpan lama parkir
            
            // Status Transaksi
            $table->enum('status', ['masuk', 'keluar']);
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_transaksi');
    }
};