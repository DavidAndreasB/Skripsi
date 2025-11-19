@extends('layouts.sbadmin')

@section('content')
<div class="container-fluid">

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detail Surat Perintah Kerja</h1>
        <div>
            <a href="{{ route('spk.index') }}" class="btn btn-secondary btn-sm shadow-sm">
                <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali
            </a>
            {{-- Tombol Print (Placeholder untuk pengembangan selanjutnya) --}}
            <button onclick="window.print()" class="btn btn-primary btn-sm shadow-sm">
                <i class="fas fa-print fa-sm text-white-50"></i> Cetak SPK
            </button>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">No. SPK: {{ $spk->no_spk }}</h6>
            <span class="badge badge-{{ $spk->status == 'Selesai' ? 'success' : ($spk->status == 'Diproses' ? 'warning' : 'secondary') }} px-3 py-2">
                Status: {{ $spk->status }}
            </span>
        </div>
        <div class="card-body">
            
            <div class="row mb-4">
                <div class="col-md-6">
                    <table class="table table-borderless table-sm">
                        <tr>
                            <th style="width: 30%">Tanggal</th>
                            <td>: {{ \Carbon\Carbon::parse($spk->tanggal)->translatedFormat('d F Y') }}</td>
                        </tr>
                        <tr>
                            <th>Nama Pemesan</th>
                            <td>: {{ $spk->nama_pemesan }}</td>
                        </tr>
                        <tr>
                            <th>Judul Proyek</th>
                            <td>: <strong>{{ $spk->judul_proyek }}</strong></td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table table-borderless table-sm">
                        <tr>
                            <th style="width: 30%">Dibuat Oleh</th>
                            <td>: {{ $spk->creator->username ?? 'Admin' }}</td>
                        </tr>
                        <tr>
                            <th>Waktu Input</th>
                            <td>: {{ $spk->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <hr>

            <h6 class="font-weight-bold text-secondary mb-3">Rincian Item Pekerjaan / Barang:</h6>
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="thead-dark">
                        <tr>
                            <th style="width: 5%" class="text-center">No</th>
                            <th style="width: 30%">Nama Barang</th>
                            <th style="width: 50%">Rincian Spesifikasi</th>
                            <th style="width: 15%" class="text-center">Quantity</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($spk->items as $item)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td class="font-weight-bold">{{ $item->nama_barang }}</td>
                            {{-- nl2br agar enter di textarea tetap muncul sebagai baris baru --}}
                            <td>{!! nl2br(e($item->rincian)) !!}</td>
                            <td class="text-center font-weight-bold">{{ $item->quantity }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted">Tidak ada item rincian.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="row mt-5">
                <div class="col-md-4 text-center">
                    <p>Penerima Tugas</p>
                    <br><br><br>
                    <p>( .................................... )</p>
                </div>
                <div class="col-md-4 offset-md-4 text-center">
                    <p>Hormat Kami,</p>
                    <br><br><br>
                    <p><strong>PT. Venus Tekindo</strong></p>
                </div>
            </div>

        </div>
    </div>

</div>
@endsection