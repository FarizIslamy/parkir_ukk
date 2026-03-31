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
    Schema::create('tb_kendaraan', function (Blueprint $table) {
        $table->id('id_kendaraan');
        $table->string('plat_nomor', 15)->unique();
        $table->string('jenis_kendaraan', 20); // motor, mobil, lainnya
        $table->string('warna', 20)->nullable();
        $table->string('pemilik', 100)->nullable();
        $table->integer('id_user')->nullable(); // Opsional
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kendaraans');
    }
};
