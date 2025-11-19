<?php

namespace App\Http\Controllers;

use App\Models\Spk;
use App\Models\SpkItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class spkController extends Controller implements HasMiddleware
{
    /**
     * Konfigurasi Middleware
     * index (daftar) dan show (detail) TIDAK dimasukkan ke sini
     * agar bisa diakses oleh Operator dan QC.
     */
    public static function middleware(): array
    {
        return [
            // Hanya Admin yang boleh melakukan aksi perubahan data
            new Middleware('admin', only: ['create', 'store', 'edit', 'update', 'destroy']),
        ];
    }

    /**
     * Menampilkan Daftar SPK (Bisa diakses semua user login)
     */
    public function index()
    {
        // Mengambil data SPK terbaru beserta item-nya untuk menghitung jumlah barang
        $spk = Spk::with('items')->latest()->get();
        return view('spk.index', compact('spk'));
    }

    /**
     * Menampilkan Halaman Detail SPK (Bisa diakses semua user login)
     * -- INI YANG SEBELUMNYA HILANG --
     */
    public function show(Spk $spk)
    {
        // Memuat relasi items (barang) dan creator (pembuat)
        $spk->load(['items', 'creator']);
        return view('spk.show', compact('spk'));
    }

    /**
     * Form Tambah SPK (Hanya Admin)
     */
    public function create()
    {
        return view('spk.create');
    }

    /**
     * Simpan SPK Baru (Hanya Admin)
     */
    public function store(Request $request)
    {
        $request->validate([
            'no_spk'       => 'required|string|unique:spks,no_spk',
            'tanggal'      => 'required|date',
            'nama_pemesan' => 'required|string',
            'judul_proyek' => 'required|string',
            'items'              => 'required|array|min:1',
            'items.*.nama_barang'=> 'required|string',
            'items.*.rincian'    => 'required|string',
            'items.*.quantity'   => 'required|integer|min:1',
        ]);

        DB::transaction(function () use ($request) {
            $spk = Spk::create([
                'no_spk'       => $request->no_spk,
                'tanggal'      => $request->tanggal,
                'nama_pemesan' => $request->nama_pemesan,
                'judul_proyek' => $request->judul_proyek,
                'status'       => 'Diproses',
                'created_by'   => auth()->id(),
            ]);

            foreach ($request->items as $item) {
                SpkItem::create([
                    'spk_id'      => $spk->id,
                    'nama_barang' => $item['nama_barang'],
                    'rincian'     => $item['rincian'],
                    'quantity'    => $item['quantity'],
                ]);
            }
        });

        return redirect()->route('spk.index')->with('success', 'SPK berhasil dibuat.');
    }

    /**
     * Form Edit SPK (Hanya Admin)
     */
    public function edit(Spk $spk)
    {
        $spk->load('items');
        return view('spk.edit', compact('spk'));
    }

    /**
     * Update SPK (Hanya Admin)
     */
    public function update(Request $request, Spk $spk)
    {
        // 1. Validasi Input
        $request->validate([
            'no_spk'       => 'required|string|unique:spks,no_spk,' . $spk->id,
            'tanggal'      => 'required|date',
            'nama_pemesan' => 'required|string',
            'judul_proyek' => 'required|string',
            'status'       => 'required|in:Draft,Diproses,Selesai', // Validasi status
            
            'items'              => 'required|array|min:1',
            'items.*.nama_barang'=> 'required|string',
            'items.*.rincian'    => 'required|string',
            'items.*.quantity'   => 'required|integer|min:1',
        ]);

        // 2. Gunakan Transaction
        DB::transaction(function () use ($request, $spk) {
            
            // A. Update Header SPK
            $spk->update([
                'no_spk'       => $request->no_spk,
                'tanggal'      => $request->tanggal,
                'nama_pemesan' => $request->nama_pemesan,
                'judul_proyek' => $request->judul_proyek,
                'status'       => $request->status,
            ]);

            // B. Sinkronisasi Item (Hapus Lama -> Buat Baru)
            // Ini cara terbersih untuk menangani edit (termasuk jika user menghapus baris di form)
            $spk->items()->delete(); 

            // C. Buat Ulang Item dari Form
            foreach ($request->items as $item) {
                SpkItem::create([
                    'spk_id'      => $spk->id,
                    'nama_barang' => $item['nama_barang'],
                    'rincian'     => $item['rincian'],
                    'quantity'    => $item['quantity'],
                ]);
            }
        });

    return redirect()->route('spk.index')->with('success', 'Data SPK beserta rinciannya berhasil diperbarui.');
}}