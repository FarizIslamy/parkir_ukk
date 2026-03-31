<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kendaraan extends Model
{
    use HasFactory;
    protected $table = 'tb_kendaraan';      // Sambung ke tabel tb_kendaraan
    protected $primaryKey = 'id_kendaraan'; // Primary key
    protected $guarded = [];                // Boleh isi semua
}