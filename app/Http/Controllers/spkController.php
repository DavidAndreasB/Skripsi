<?php

namespace App\Http\Controllers;

use App\Models\spk;
use Illuminate\Http\Request;

class spkController extends Controller
{
    /**
     * Tampilkan semua data 
     */
    public function index()
    {
         $spk = Spk::latest()->get();
        return view('spk.index', compact('spk'));
    }

    /**
     * Form tambah spk
     */
    public function create()
    {
        return view('spk.create');
    }

    /**
     * Simpan data baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'no' => 'required|string',
            'nama_barang' => 'required|string',
            'rincian' => 'required|string',
            'quantity' => 'required|integer',
            'tanggal' => 'required|date',
        ]);

        spk::create($request->all());

        return redirect()->route('spk.index')->with('success', 'spk berhasil ditambahkan');
    }

    /**
     * Form edit spk
     */
    public function edit(spk $spk)
    {
    return view('spk.edit', compact('spk'));
    }

    /**
     * Update data
     */
    public function update(Request $request, spk $spk)
    {
    $request->validate([
        'no' => 'required|string',
        'nama_barang' => 'required|string',
        'rincian' => 'required|string',
        'quantity' => 'required|integer',
        'tanggal' => 'required|date',
    ]);

    $spk->update($request->all());

    return redirect()->route('spk.index')->with('success', 'spk berhasil diupdate');
    }

    /**
     * Hapus data
     */
    public function destroy(spk $spk)
    {
    $spk->delete();
    return redirect()->route('spk.index')->with('success', 'spk berhasil dihapus');
    }
}
