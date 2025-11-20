<?php

namespace App\Http\Controllers;

use App\Models\Spk;
use App\Models\SpkItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // Wajib ada
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class SpkController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware('admin', only: ['create', 'store', 'edit', 'update', 'destroy']),
        ];
    }

    public function index()
    {
        $spk = Spk::with('items')->latest()->get();
        return view('spk.index', compact('spk'));
    }

    public function create()
    {
        return view('spk.create');
    }

    // === BAGIAN INI YANG MEMPERBAIKI ERROR TIDAK TERSIMPAN ===
    public function store(Request $request)
    {
        $request->validate([
            'no_spk' => 'required|string|unique:spks,no_spk',
            'tanggal' => 'required|date',
            'nama_pemesan' => 'required|string',
            'judul_proyek' => 'required|string',
            'items' => 'required|array|min:1', // Validasi agar minimal ada 1 baris
        ]);

        DB::transaction(function () use ($request) {
            // 1. Simpan Header
            $spk = Spk::create([
                'no_spk' => $request->no_spk,
                'tanggal' => $request->tanggal,
                'nama_pemesan' => $request->nama_pemesan,
                'judul_proyek' => $request->judul_proyek,
                'status' => 'Diproses',
                'created_by' => auth()->id(),
            ]);

            // 2. Simpan Rincian Item (Looping)
            foreach ($request->items as $item) {
                SpkItem::create([
                    'spk_id' => $spk->id,
                    'nama_barang' => $item['nama_barang'],
                    'rincian' => $item['rincian'],
                    'quantity' => $item['quantity'],
                ]);
            }
        });

        return redirect()->route('spk.index')->with('success', 'SPK dan Rincian Item berhasil disimpan.');
    }
    // ==========================================================

    public function show(Spk $spk)
    {
        $spk->load(['items', 'creator']);
        return view('spk.show', compact('spk'));
    }

    public function edit(Spk $spk)
    {
        $spk->load('items');
        return view('spk.edit', compact('spk'));
    }

    public function update(Request $request, Spk $spk)
    {
        // Validasi & Update Header
        $request->validate([
            'no_spk' => 'required|string|unique:spks,no_spk,' . $spk->id,
            'tanggal' => 'required|date',
            'items' => 'required|array|min:1',
        ]);

        DB::transaction(function () use ($request, $spk) {
            $spk->update([
                'no_spk' => $request->no_spk,
                'tanggal' => $request->tanggal,
                'nama_pemesan' => $request->nama_pemesan,
                'judul_proyek' => $request->judul_proyek,
                'status' => $request->status ?? $spk->status,
            ]);

            // Hapus item lama, ganti baru (Sinkronisasi)
            $spk->items()->delete();

            foreach ($request->items as $item) {
                SpkItem::create([
                    'spk_id' => $spk->id,
                    'nama_barang' => $item['nama_barang'],
                    'rincian' => $item['rincian'],
                    'quantity' => $item['quantity'],
                ]);
            }
        });

        return redirect()->route('spk.index')->with('success', 'Data SPK diperbarui.');
    }

    public function destroy(Spk $spk)
    {
        $spk->delete();
        return redirect()->route('spk.index')->with('success', 'SPK dihapus.');
    }
}