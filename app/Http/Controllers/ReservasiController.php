<?php

namespace App\Http\Controllers;

use App\Models\ReservasiModel;
use App\Models\RuangModel;
use Illuminate\Http\Request;

class ReservasiController extends Controller
{
    /**
     * Display a listing of the resource.
     * Digunakan untuk Admin melihat seluruh riwayat atau Kalender Agenda Publik.
     */
    public function index()
    {
        $reservasis = ReservasiModel::with(['ruang', 'user'])->latest()->get();
        return view('reservasi.index', compact('reservasis'));
    }

    /**
     * Show the form for creating a new resource.
     * Halaman form pengajuan reservasi ruangan untuk user yang sudah login.
     */
    public function create()
    {
        // Hanya mengambil ruangan yang tidak dalam status maintenance
        $ruangans = RuangModel::where('status_ruang', '!=', 'maintenance')->get();
        return view('reservasi.create', compact('ruangans'));
    }

    /**
     * Store a newly created resource in storage.
     * Memproses pengajuan reservasi & memvalidasi bentrok jadwal otomatis.
     */
    public function store(Request $request)
    {
        // Cek bentrok jadwal
        $isBentrok = ReservasiModel::where('id_ruang', $request->id_ruang)
            ->where('tanggal_pinjam', $request->tanggal_pinjam)
            ->where('status_reservasi', 'berhasil')
            ->where(function ($query) use ($request) {
                $query->whereBetween('jam_mulai', [$request->jam_mulai, $request->jam_selesai])
                    ->orWhereBetween('jam_selesai', [$request->jam_mulai, $request->jam_selesai])
                    ->orWhere(function ($q) use ($request) {
                        $q->where('jam_mulai', '<=', $request->jam_mulai)
                            ->where('jam_selesai', '>=', $request->jam_selesai);
                    });
            })
            ->exists();

        $data = [
            'id_ruang'          => $request->id_ruang,
            'user_id' => $request->user()->id,
            'nama_pengaju'      => $request->user()->name,
            'asal_unit_divisi'  => $request->user()->unit,
            'jumlah_peserta'    => $request->jumlah_peserta,
            'hubungi_leader_cs' => $request->has('hubungi_leader_cs'),
            'tanggal_pinjam'    => $request->tanggal_pinjam,
            'jam_mulai'         => $request->jam_mulai,
            'jam_selesai'       => $request->jam_selesai,
        ];

        // Kalau bentrok → simpan dengan status 'terbatal_otomatis'
        if ($isBentrok) {
            $data['status_reservasi'] = 'terbatal_otomatis';
            ReservasiModel::create($data);

            return redirect()->back()->with('error', 'Peminjaman gagal! Waktu yang diajukan sudah terisi oleh unit lain.');
        }

        // Kalau tidak bentrok → 'berhasil'
        $data['status_reservasi'] = 'berhasil';
        ReservasiModel::create($data);

        return redirect()->back()->with('success', 'Reservasi ruangan berhasil diajukan!');
    }

    /**
     * Display the specified resource.
     * Menampilkan detail satu data reservasi.
     */
    public function show(string $id)
    {
        $reservasi = ReservasiModel::with(['ruang', 'user'])->findOrFail($id);
        return view('reservasi.show', compact('reservasi'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $reservasi = ReservasiModel::findOrFail($id);
        $ruangans  = RuangModel::all();
        return view('reservasi.edit', compact('reservasi', 'ruangans'));
    }

    /**
     * Update the specified resource in storage.
     * Mengubah data reservasi atau statusnya (misal dari Admin).
     */
    public function update(Request $request, string $id)
    {
        $reservasi = ReservasiModel::findOrFail($id);
        $reservasi->update([
            'id_ruang'          => $request->id_ruang,
            'nama_pengaju'      => $request->nama_pengaju,
            'asal_unit_divisi'  => $request->asal_unit_divisi,
            'jumlah_peserta'    => $request->jumlah_peserta,
            'hubungi_leader_cs' => $request->has('hubungi_leader_cs'),
            'tanggal_pinjam'    => $request->tanggal_pinjam,
            'jam_mulai'         => $request->jam_mulai,
            'jam_selesai'       => $request->jam_selesai,
            'status_reservasi'  => $request->status_reservasi ?? $reservasi->status_reservasi,
        ]);

        return redirect()->back()->with('success', 'Data reservasi berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     * Menghapus riwayat reservasi (bila diperlukan oleh Admin).
     */
    public function destroy(string $id)
    {
        $reservasi = ReservasiModel::findOrFail($id);
        $reservasi->delete();

        return redirect()->back()->with('success', 'Data reservasi berhasil dihapus!');
    }
}
