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
    Schema::create('tb_area_parkir', function (Blueprint $table) {
        $table->id('id_area'); // Primary Key
        
        // Contoh: "Lantai 1", "Parkiran Utara", "Basement"
        $table->string('nama_area', 50); 
        
        // Kapasitas Total
        $table->integer('kapasitas'); 
        
        // Jumlah yang sedang terisi (Default 0)
        $table->integer('terisi')->default(0); 
        
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('area_parkirs');
    }
};
