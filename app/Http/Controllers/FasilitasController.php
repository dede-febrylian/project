<?php

namespace App\Http\Controllers;

use App\Models\FasilitasModel;
use App\Models\RuangModel;
use Illuminate\Http\Request;

class FasilitasController extends Controller
{
    public function index()
    {
        $fasilitas = FasilitasModel::with('ruang')->get();
        return view('admin.fasilitas.index', compact('fasilitas'));
    }

    public function create()
    {
        $ruangans = RuangModel::all();
        return view('admin.fasilitas.create', compact('ruangans'));
    }

    public function store(Request $request)
    {
        FasilitasModel::create([
            'id_ruang'     => $request->id_ruang,
            'jumlah_kursi' => $request->jumlah_kursi,
            'keterangan'   => $request->keterangan,
        ]);

        return redirect()->back()->with('success', 'Data fasilitas kursi berhasil ditambahkan!');
    }

    public function show(string $id)
    {
        $fasilitas = FasilitasModel::with('ruang')->findOrFail($id);
        return view('admin.fasilitas.show', compact('fasilitas'));
    }

    public function edit(string $id)
    {
        $fasilitas = FasilitasModel::findOrFail($id);
        $ruangans  = RuangModel::all();
        return view('admin.fasilitas.edit', compact('fasilitas', 'ruangans'));
    }

    public function update(Request $request, string $id)
    {
        $fasilitas = FasilitasModel::findOrFail($id);
        $fasilitas->update([
            'id_ruang'     => $request->id_ruang,
            'jumlah_kursi' => $request->jumlah_kursi,
            'keterangan'   => $request->keterangan,
        ]);

        return redirect()->back()->with('success', 'Data fasilitas kursi berhasil diperbarui!');
    }

    public function destroy(string $id)
    {
        $fasilitas = FasilitasModel::findOrFail($id);
        $fasilitas->delete();

        return redirect()->back()->with('success', 'Data fasilitas berhasil dihapus!');
    }
}