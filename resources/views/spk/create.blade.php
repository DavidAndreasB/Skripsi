@extends('layouts.sbadmin')

@section('content')
<div class="container-fluid">

    <h1 class="h3 mb-4 text-gray-800">Tambah SPK</h1>

    <div class="card shadow mb-4">
        <div class="card-header py-3 bg-success text-white">
            <h6 class="m-0 font-weight-bold">Form Tambah Data SPK</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('spk.store') }}" method="POST">
                @csrf

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="no" class="form-label fw-semibold">No SPK</label>
                        <input type="text" name="no" id="no" class="form-control" placeholder="Contoh: VT.029.V.15.1" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="nama_barang" class="form-label fw-semibold">Nama Barang</label>
                        <input type="text" name="nama_barang" id="nama_barang" class="form-control" placeholder="Masukkan nama barang" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="rincian" class="form-label fw-semibold">Rincian</label>
                    <textarea name="rincian" id="rincian" rows="4" class="form-control" placeholder="Masukkan rincian pekerjaan" required></textarea>
                    <small class="text-muted">Gunakan Shift + Enter untuk baris baru.</small>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="quantity" class="form-label fw-semibold">Quantity</label>
                        <input type="number" name="quantity" id="quantity" class="form-control" placeholder="Masukkan jumlah" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="tanggal" class="form-label fw-semibold">Tanggal</label>
                        <input type="date" name="tanggal" id="tanggal" class="form-control" required>
                    </div>
                </div>

                <div class="d-flex justify-content-end mt-4">
                    <a href="{{ route('spk.index') }}" class="btn btn-secondary me-2">
                        <i class="fas fa-arrow-left"></i> Batal
                    </a>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection