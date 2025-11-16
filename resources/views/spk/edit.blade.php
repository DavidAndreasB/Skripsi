@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <!-- Judul Halaman -->
    <h1 class="h3 mb-4 text-gray-800">Edit SPK</h1>

    <!-- Card Form Edit -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 bg-primary text-white">
            <h6 class="m-0 font-weight-bold">Form Edit Data SPK</h6>
        </div>
        <div class="card-body">
            <form action="{{ route('spk.update', $spk->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="no" class="form-label fw-semibold">No SPK</label>
                        <input type="text" name="no" id="no"
                               class="form-control" value="{{ old('no', $spk->no) }}" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="nama_barang" class="form-label fw-semibold">Nama Barang</label>
                        <input type="text" name="nama_barang" id="nama_barang"
                               class="form-control" value="{{ old('nama_barang', $spk->nama_barang) }}" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="rincian" class="form-label fw-semibold">Rincian</label>
                    <textarea name="rincian" id="rincian" rows="4" class="form-control" required>{{ old('rincian', $spk->rincian) }}</textarea>
                    <small class="text-muted">Gunakan Shift + Enter untuk baris baru.</small>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="quantity" class="form-label fw-semibold">Quantity</label>
                        <input type="number" name="quantity" id="quantity"
                               class="form-control" value="{{ old('quantity', $spk->quantity) }}" required>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="tanggal" class="form-label fw-semibold">Tanggal</label>
                        <input type="date" name="tanggal" id="tanggal"
                               class="form-control" value="{{ old('tanggal', $spk->tanggal) }}" required>
                    </div>
                </div>

                <div class="d-flex justify-content-end mt-4">
                    <a href="{{ route('spk.index') }}" class="btn btn-secondary me-2">
                        <i class="fas fa-arrow-left"></i> Kembali
                    </a>
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save"></i> Update
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
@endsection
