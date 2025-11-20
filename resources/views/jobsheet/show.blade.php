@extends('layouts.sbadmin')

@section('content')
<div class="container-fluid">

    {{-- Header --}}
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Jobsheet: {{ $spk->no_spk }}</h1>
        <a href="{{ route('jobsheet.index') }}" class="btn btn-secondary btn-sm"><i class="fas fa-arrow-left"></i> Kembali</a>
    </div>

    {{-- Info Proyek --}}
    <div class="card shadow mb-4 border-left-primary">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <strong>Judul Proyek:</strong> {{ $spk->judul_proyek }}<br>
                    <strong>Customer:</strong> {{ $spk->nama_pemesan }}
                </div>
                <div class="col-md-6 text-right">
                    @if(auth()->user()->isSuperAdmin())
                        <h4 class="text-success font-weight-bold">
                            Total Biaya: Rp {{ number_format($spk->jobsheets->sum('biaya'), 0, ',', '.') }}
                        </h4>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3 bg-success text-white">
                    <h6 class="m-0 font-weight-bold">Input Aktivitas Harian</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('jobsheet.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="spk_id" value="{{ $spk->id }}">

                        <div class="form-group">
                            <label>Tanggal Pengerjaan</label>
                            <input type="date" name="tanggal" class="form-control" value="{{ date('Y-m-d') }}" required>
                        </div>

                        <div class="form-group">
                            <label>Jenis Mesin / Pekerjaan</label>
                            <select name="jenis_pekerjaan" class="form-control" required>
                                <option value="" disabled selected>-- Pilih Mesin --</option>
                                @foreach(\App\Models\JobSheet::TARIF_MESIN as $mesin => $tarif)
                                    <option value="{{ $mesin }}">{{ $mesin }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Jam Mulai</label>
                                <input type="time" name="jam_mulai" class="form-control" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Jam Selesai</label>
                                <input type="time" name="jam_selesai" class="form-control" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Keterangan (Opsional)</label>
                            <textarea name="keterangan" class="form-control" rows="2" placeholder="Contoh: Bubut As Roda"></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary btn-block">
                            <i class="fas fa-save"></i> Simpan Aktivitas
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Riwayat Pengerjaan</h6>
                </div>
                <div class="card-body">
                {{-- BLOK UNTUK MENAMPILKAN ERROR VALIDASI --}}
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                {{-- BLOK UNTUK MENAMPILKAN SUKSES --}}
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

<form action="{{ route('jobsheet.store') }}" method="POST">
    {{-- ... form Anda selanjutnya ... --}}
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" width="100%" cellspacing="0">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Mesin / Pekerjaan</th>
                                    <th>Waktu (Durasi)</th>
                                    <th>Operator</th>
                                    @if(auth()->user()->isSuperAdmin())
                                    <th>Aksi</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($spk->jobsheets->sortByDesc('created_at') as $log)
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($log->tanggal)->format('d/m/y') }}</td>
                                    <td>
                                        <strong>{{ $log->jenis_pekerjaan }}</strong><br>
                                        <small class="text-muted">{{ $log->keterangan }}</small>
                                    </td>
                                    <td>
                                        {{ \Carbon\Carbon::parse($log->jam_mulai)->format('H:i') }} - 
                                        {{ \Carbon\Carbon::parse($log->jam_selesai)->format('H:i') }}
                                        <br>
                                        <span class="badge badge-info">{{ number_format($log->total_jam, 1) }} Jam</span>
                                    </td>
                                    <td>{{ $log->operator->username }}</td>
                                    @if(auth()->user()->isSuperAdmin())
                                    <td class="text-center">
                                        <form action="{{ route('jobsheet.destroy', $log->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger btn-sm" onclick="return confirm('Hapus?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                    </td>
                                    @endif
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted">Belum ada data.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection