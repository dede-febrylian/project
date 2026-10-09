<?php

namespace App\Http\Controllers;

use App\Models\RuangModel;
use App\Models\FasilitasModel;
use App\Models\ReservasiModel;
use Illuminate\Http\Request;
use Carbon\Carbon;

class RuangController extends Controller
{
    /**
     * Display a listing of the resource.
     * Menampilkan Dashboard utama dengan status real-time ruangan & fasilitas kursi.
     */
    public function index()
    {
        $today = Carbon::today()->toDateString();
        $currentTime = Carbon::now()->toTimeString();

        // Ambil semua data ruangan beserta fasilitas kursinya
        $ruangans = RuangModel::with('fasilitas')->get()->map(function ($ruang) use ($today, $currentTime) {

            $isBeingUsed = ReservasiModel::where('id_ruang', $ruang->id_ruang)
                ->where('tanggal_pinjam', $today)
                ->where('status_reservasi', 'berhasil')
                ->where('jam_mulai', '<=', $currentTime)
                ->where('jam_selesai', '>=', $currentTime)
                ->exists();

            if ($ruang->status_ruang !== 'maintenance') {
                $ruang->status_realtime = $isBeingUsed ? 'digunakan' : 'tersedia';
            } else {
                $ruang->status_realtime = 'maintenance';
            }

            return $ruang;
        });

        return view('dashboard', compact('ruangans'));
    }

    public function adminIndex()
    {
        $ruangans = RuangModel::with('fasilitas')->latest()->get();
        return view('admin.ruang.index', compact('ruangans'));
    }

    /**
     * Show the form for creating a new resource.
     * Halaman form tambah ruangan untuk Admin.
     */
    public function create()
    {
        return view('admin.ruang.create');
    }

    /**
     * Store a newly created resource in storage.
     * Menyimpan data ruangan baru beserta informasi fasilitas kursinya.
     */
    public function store(Request $request)
    {
        // 1. Simpan Data Ruangan
        $ruang = RuangModel::create([
            'nama_ruang'         => $request->nama_ruang,
            'kapasitas_maksimal' => $request->kapasitas_maksimal,
            'deskripsi'          => $request->deskripsi,
            'status_ruang'       => $request->status_ruang ?? 'tersedia',
        ]);

        // 2. Simpan Data Fasilitas Kursi Terkait
        FasilitasModel::create([
            'id_ruang'     => $ruang->id_ruang,
            'jumlah_kursi' => $request->jumlah_kursi,
            'keterangan'   => $request->keterangan_kursi,
        ]);

        return redirect()->back()->with('success', 'Ruangan berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     * Menampilkan detail satu ruangan beserta fasilitasnya.
     */
    public function show(string $id)
    {
        $ruang = RuangModel::with('fasilitas')->findOrFail($id);
        return view('admin.ruang.show', compact('ruang'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $ruang = RuangModel::with('fasilitas')->findOrFail($id);
        return view('admin.ruang.edit', compact('ruang'));
    }

    /**
     * Update the specified resource in storage.
     * Memperbarui data ruangan dan fasilitas kursinya.
     */
    public function update(Request $request, string $id)
    {
        $ruang = RuangModel::findOrFail($id);

        // Update data ruangan
        $ruang->update([
            'nama_ruang'         => $request->nama_ruang,
            'kapasitas_maksimal' => $request->kapasitas_maksimal,
            'deskripsi'          => $request->deskripsi,
            'status_ruang'       => $request->status_ruang,
        ]);

        // Update data fasilitas kursi jika ada
        if ($ruang->fasilitas) {
            $ruang->fasilitas->update([
                'jumlah_kursi' => $request->jumlah_kursi,
                'keterangan'   => $request->keterangan_kursi,
            ]);
        }

        return redirect()->back()->with('success', 'Data ruangan berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     * Menghapus data ruangan dari database.
     */
    public function destroy(string $id)
    {
        $ruang = RuangModel::findOrFail($id);
        $ruang->delete();

        return redirect()->back()->with('success', 'Ruangan berhasil dihapus!');
    }
}
