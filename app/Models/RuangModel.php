<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RuangModel extends Model
{
    use HasFactory;

    protected $table = 'ruangs';
    protected $primaryKey = 'id_ruang';

    protected $fillable = [
        'nama_ruang',
        'kapasitas_maksimal',
        'deskripsi',
        'gambar',
        'status_ruang',
    ];

    // Relasi ke Fasilitas (1 ruangan punya 1 info fasilitas/kursi)
    public function fasilitas()
    {
        return $this->hasOne(FasilitasModel::class, 'id_ruang', 'id_ruang');
    }

    // Relasi ke Reservasi
    public function reservasis()
    {
        return $this->hasMany(ReservasiModel::class, 'id_ruang', 'id_ruang');
    }
}