@extends('layouts.sbadmin') {{-- Ini kuncinya: Menggunakan layout SB Admin --}}

@section('content')
<div class="container-fluid">

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
    </div>

    <div class="row">
        <div class="col-lg-12 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Selamat Datang, {{ Auth::user()->username }}!</h6>
                </div>
                <div class="card-body">
                    <div class="text-center">
                        <img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 25rem;"
                             src="{{ asset('sbadmin2/img/undraw_posting_photo.svg') }}" alt="...">
                    </div>
                    <p>Anda telah berhasil login ke sistem Venus Tekindo.</p>
                    <p class="mb-0">Peran Anda saat ini adalah: 
                        @if(Auth::user()->isSuperAdmin())
                            <span class="badge badge-danger">Super Admin</span> - Anda memiliki akses penuh untuk mengelola user dan sistem.
                        @elseif(Auth::user()->isQualityControl())
                            <span class="badge badge-warning">Quality Control</span> - Anda memiliki akses ke modul QC.
                        @else
                            <span class="badge badge-info">Operator</span> - Anda memiliki akses operasional standar.
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>

    @if(Auth::user()->isSuperAdmin())
    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total User</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ \App\Models\User::count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

</div>
@endsection