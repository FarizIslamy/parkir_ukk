<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AreaParkir extends Model
{
    use HasFactory;

    protected $table = 'tb_area_parkir';   // Nama tabel custom
    protected $primaryKey = 'id_area';     // Primary key custom
    protected $guarded = [];               // Izinkan semua kolom diisi
}