<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReservasiModel extends Model
{
    use HasFactory;

    protected $table = 'reservasis';
    protected $primaryKey = 'id_reservasi';

    protected $fillable = [
        'id_ruang',
        'user_id',
        'nama_pengaju',
        'asal_unit_divisi',
        'jumlah_peserta',
        'hubungi_leader_cs',
        'tanggal_pinjam',
        'jam_mulai',
        'jam_selesai',
        'status_reservasi',
    ];

    public function ruang()
    {
        return $this->belongsTo(RuangModel::class, 'id_ruang', 'id_ruang');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id')->withDefault([
            'name' => 'Pengguna Terhapus / Tamu',
        ]);
    }
}
