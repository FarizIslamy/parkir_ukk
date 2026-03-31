<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'tb_transaksi'; // Sesuai nama tabel
    protected $primaryKey = 'id_parkir'; // Sesuai primary key
    protected $guarded = [];

    // Relasi ke Kendaraan
    public function kendaraan() {
        return $this->belongsTo(Kendaraan::class, 'id_kendaraan', 'id_kendaraan');
    }

    // Relasi ke User
    public function petugas() {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    // Relasi ke Area
    public function area() {
        return $this->belongsTo(AreaParkir::class, 'id_area', 'id_area');
    }
}