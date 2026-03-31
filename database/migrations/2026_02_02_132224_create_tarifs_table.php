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
        Schema::create('tb_tarif', function (Blueprint $table) {
            // 1. Primary Key (Sesuai skema: id_tarif)
            $table->id('id_tarif'); 

            // 2. Jenis Kendaraan (Sesuai skema: varchar/string)
            // Kita pakai string dan unique agar tidak ada 2 harga untuk "Motor"
            $table->string('jenis_kendaraan', 50)->unique(); 
            
            // 3. Harga per jam (Sesuai skema: decimal/integer)
            // Kita pakai integer karena Rupiah tidak pakai koma
            $table->integer('tarif_per_jam'); 
            
            // 4. Created_at & Updated_at
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_tarif');
    }
};