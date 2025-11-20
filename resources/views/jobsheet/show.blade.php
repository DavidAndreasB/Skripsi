@extends('layouts.sbadmin')

@section('content')
<div class="container-fluid">

    {{-- Header Halaman --}}
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Jobsheet: {{ $spk->no_spk }}</h1>
        <a href="{{ route('jobsheet.index') }}" class="btn btn-secondary btn-sm shadow-sm">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>

    {{-- Pesan Sukses/Error --}}
    @if (session('success'))
        <div class="alert alert-success border-left-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger border-left-danger">
            <ul class="mb-0 pl-3">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Info Proyek --}}
    <div class="card shadow mb-4 border-left-primary">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Informasi Proyek</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $spk->judul_proyek }}</div>
                    <div class="text-gray-600">{{ $spk->nama_pemesan }}</div>
                </div>
                <div class="col-md-6 text-md-right mt-3 mt-md-0">
                    @if(auth()->user()->isSuperAdmin())
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Biaya Produksi</div>
                        <div class="h4 mb-0 font-weight-bold text-gray-800">
                            Rp {{ number_format($spk->jobsheets->sum('biaya'), 0, ',', '.') }}
                        </div>
                        <small>Total Jam: {{ $spk->jobsheets->sum('total_jam') }} Jam</small>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        
        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3 bg-gradient-primary">
                    <h6 class="m-0 font-weight-bold text-white">Input Aktivitas Harian</h6>
                </div>
                <div class="card-body">
                    {{-- Pastikan Form ini tertutup dengan benar --}}
                    <form action="{{ route('jobsheet.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="spk_id" value="{{ $spk->id }}">

                        <div class="form-group">
                            <label class="small font-weight-bold">Tanggal Pengerjaan</label>
                            <input type="date" name="tanggal" class="form-control" value="{{ date('Y-m-d') }}" required>
                        </div>

                        <div class="form-group">
                            <label class="small font-weight-bold">Jenis Mesin / Pekerjaan</label>
                            <select name="jenis_pekerjaan" class="form-control" required>
                                <option value="" disabled selected>-- Pilih Mesin --</option>
                                {{-- Mengambil data tarif dari Model --}}
                                @foreach(\App\Models\JobSheet::TARIF_MESIN as $mesin => $tarif)
                                    <option value="{{ $mesin }}">{{ $mesin }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-6">
                                <label class="small font-weight-bold">Jam Mulai</label>
                                <input type="time" name="jam_mulai" class="form-control" required>
                            </div>
                            <div class="form-group col-6">
                                <label class="small font-weight-bold">Jam Selesai</label>
                                <input type="time" name="jam_selesai" class="form-control" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="small font-weight-bold">Keterangan (Opsional)</label>
                            <textarea name="keterangan" class="form-control" rows="2" placeholder="Contoh: Bubut As Roda"></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary btn-block">
                            <i class="fas fa-save fa-sm text-white-50"></i> Simpan Aktivitas
                        </button>
                    </form> 
                    {{-- END FORM INPUT (Pastikan tag penutup ini ada!) --}}
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Riwayat Pengerjaan</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" width="100%" cellspacing="0">
                            <thead class="thead-light">
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Aktivitas</th>
                                    <th>Durasi</th>
                                    <th>Operator</th>
                                    @if(auth()->user()->isSuperAdmin())
                                    <th width="10%">Aksi</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($spk->jobsheets->sortByDesc('created_at') as $log)
                                <tr>
                                    <td style="vertical-align: middle;">
                                        {{ \Carbon\Carbon::parse($log->tanggal)->format('d/m/y') }}
                                    </td>
                                    <td style="vertical-align: middle;">
                                        <span class="font-weight-bold text-dark">{{ $log->jenis_pekerjaan }}</span><br>
                                        <span class="small text-muted">{{ $log->keterangan }}</span>
                                    </td>
                                    <td style="vertical-align: middle;">
                                        <div class="small">{{ \Carbon\Carbon::parse($log->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($log->jam_selesai)->format('H:i') }}</div>
                                        <span class="badge badge-info">{{ number_format($log->total_jam, 1) }} Jam</span>
                                    </td>
                                    <td style="vertical-align: middle;">
                                        <i class="fas fa-user-circle text-gray-400"></i> {{ $log->operator->username ?? 'User' }}
                                    </td>
                                    
                                    @if(auth()->user()->isSuperAdmin())
                                    <td class="text-center" style="vertical-align: middle;">
                                        <form action="{{ route('jobsheet.destroy', $log->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus riwayat ini?')" title="Hapus Data">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </td>
                                    @endif
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">
                                        <img src="{{ asset('sbadmin2/img/undraw_posting_photo.svg') }}" style="height: 100px; opacity: 0.5;" class="mb-2"><br>
                                        Belum ada aktivitas pengerjaan untuk SPK ini.
                                    </td>
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