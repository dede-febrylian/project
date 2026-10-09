<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FasilitasModel extends Model
{
    use HasFactory;

    protected $table = 'fasilitas';
    protected $primaryKey = 'id_fasilitas';

    protected $fillable = [
        'id_ruang',
        'jumlah_kursi',
        'keterangan',
    ];

    public function ruang()
    {
        return $this->belongsTo(RuangModel::class, 'id_ruang', 'id_ruang');
    }
}