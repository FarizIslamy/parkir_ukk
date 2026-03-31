<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tarif extends Model
{
    use HasFactory;

    // --- BARIS INI PENTING (Solusi Error Kamu) ---
    // Memberi tahu Laravel nama tabel yang benar
    protected $table = 'tb_tarif'; 
    
    // Memberi tahu primary key yang benar (bukan id, tapi id_tarif)
    protected $primaryKey = 'id_tarif';

    // Agar bisa diisi semua kolom
    protected $guarded = [];
}