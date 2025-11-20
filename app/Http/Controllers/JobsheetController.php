<?php

namespace App\Http\Controllers;

use App\Models\JobSheet;
use App\Models\Spk;
use Illuminate\Http\Request;
use Carbon\Carbon;

class JobsheetController extends Controller
{
    /**
     * Halaman 1: Daftar SPK Aktif
     */
    public function index()
    {
        $spks = Spk::where('status', 'Diproses')->latest()->get();
        return view('jobsheet.index', compact('spks'));
    }

    /**
     * Halaman 2: Input & History
     */
    public function show($spk_id)
    {
        $spk = Spk::with(['jobsheets.operator'])->findOrFail($spk_id);
        return view('jobsheet.show', compact('spk'));
    }

    /**
     * Simpan Aktivitas (STORE)
     */
    public function store(Request $request)
    {
        $request->validate([
            'spk_id' => 'required|exists:spks,id',
            'jenis_pekerjaan' => 'required',
            'tanggal' => 'required|date',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
        ]);

        // Hitung durasi (abs = nilai mutlak agar tidak minus)
        $mulai = Carbon::parse($request->jam_mulai);
        $selesai = Carbon::parse($request->jam_selesai);
        $totalJam = abs($selesai->diffInMinutes($mulai)) / 60; 

        JobSheet::create([
            'spk_id' => $request->spk_id,
            'operator_id' => auth()->id(),
            'tanggal' => $request->tanggal,
            'jenis_pekerjaan' => $request->jenis_pekerjaan,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
            'total_jam' => $totalJam,
            'keterangan' => $request->keterangan,
        ]);

        return back()->with('success', 'Aktivitas berhasil dicatat.');
    }

    /**
     * Hapus Aktivitas (DESTROY)
     */
    public function destroy($id)
    {
        $job = JobSheet::findOrFail($id);
        
        // Hanya Admin atau Pembuat data yang boleh hapus
        if(auth()->user()->isSuperAdmin() || auth()->id() == $job->operator_id){
             $job->delete();
             return back()->with('success', 'Data dihapus.');
        }
        
        return back()->with('error', 'Akses ditolak.');
    }
}