@extends('layouts.sbadmin')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Edit SPK</h1>

    <form action="{{ route('spk.update', $spk->id) }}" method="POST">
        @csrf
        @method('PUT')
        {{-- TOMBOL KEMBALI (POSISI ATAS) --}}
        <div>
            <a href="{{ route('spk.index') }}" class="btn btn-secondary btn-sm shadow-sm">
                <i class="fas fa-arrow-left fa-sm text-white-50"></i> Kembali
            </a>
        </div>
        <div class="card shadow mb-4">
            <div class="card-header py-3 bg-warning text-white">
                <h6 class="m-0 font-weight-bold">1. Edit Header SPK</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>No SPK</label>
                            <input type="text" name="no_spk" class="form-control" value="{{ old('no_spk', $spk->no_spk) }}" required>
                        </div>
                        <div class="form-group">
                            <label>Tanggal</label>
                            <input type="date" name="tanggal" class="form-control" value="{{ old('tanggal', $spk->tanggal) }}" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Nama Pemesan</label>
                            <input type="text" name="nama_pemesan" class="form-control" value="{{ old('nama_pemesan', $spk->nama_pemesan) }}" required>
                        </div>
                        <div class="form-group">
                            <label>Judul Proyek</label>
                            <input type="text" name="judul_proyek" class="form-control" value="{{ old('judul_proyek', $spk->judul_proyek) }}" required>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Status Pengerjaan</label>
                            <select name="status" class="form-control">
                                <option value="Diproses" {{ $spk->status == 'Diproses' ? 'selected' : '' }}>Diproses</option>
                                <option value="Selesai" {{ $spk->status == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                                <option value="Draft" {{ $spk->status == 'Draft' ? 'selected' : '' }}>Draft</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">2. Edit Rincian Item</h6>
                <button type="button" class="btn btn-sm btn-success" id="add-row">
                    <i class="fas fa-plus"></i> Tambah Baris
                </button>
            </div>
            <div class="card-body p-0">
                <table class="table table-striped mb-0">
                    <thead class="bg-light text-center">
                        <tr>
                            <th width="25%">Nama Barang</th>
                            <th width="50%">Rincian (Bisa Banyak Baris)</th>
                            <th width="15%">Quantity</th>
                            <th width="10%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="items-table">
                        {{-- LOOP DATA ITEM YANG SUDAH ADA --}}
                        @foreach ($spk->items as $index => $item)
                        <tr class="item-row">
                            <td class="align-top">
                                <input type="text" name="items[{{ $index }}][nama_barang]" class="form-control" value="{{ $item->nama_barang }}" required>
                            </td>
                            <td>
                                <textarea name="items[{{ $index }}][rincian]" class="form-control" rows="3" required>{{ $item->rincian }}</textarea>
                            </td>
                            <td class="align-top">
                                <input type="number" name="items[{{ $index }}][quantity]" class="form-control text-center" value="{{ $item->quantity }}" min="1" required>
                            </td>
                            <td class="align-top text-center">
                                {{-- Tombol hapus hanya aktif jika baris lebih dari 1 (diatur JS) --}}
                                <button type="button" class="btn btn-danger btn-sm remove-row"><i class="fas fa-trash"></i></button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mb-5">
            <button type="submit" class="btn btn-warning btn-lg btn-block shadow-sm text-white">
                <i class="fas fa-save fa-sm text-white-50"></i> Update Perubahan
            </button>
        </div>
    </form>
</div>

{{-- JAVASCRIPT UNTUK MENAMBAH BARIS DINAMIS --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Hitung jumlah baris awal dari data yang ada
        let rowIdx = {{ count($spk->items) }};
        
        // Fungsi Tambah Baris
        document.getElementById('add-row').addEventListener('click', function () {
            let html = `
                <tr class="item-row">
                    <td class="align-top">
                        <input type="text" name="items[${rowIdx}][nama_barang]" class="form-control" placeholder="Nama Item Baru" required>
                    </td>
                    <td>
                        <textarea name="items[${rowIdx}][rincian]" class="form-control" rows="3" placeholder="Rincian Baru" required></textarea>
                    </td>
                    <td class="align-top">
                        <input type="number" name="items[${rowIdx}][quantity]" class="form-control text-center" placeholder="1" min="1" required>
                    </td>
                    <td class="align-top text-center">
                        <button type="button" class="btn btn-danger btn-sm remove-row"><i class="fas fa-trash"></i></button>
                    </td>
                </tr>
            `;
            document.getElementById('items-table').insertAdjacentHTML('beforeend', html);
            rowIdx++;
        });

        // Fungsi Hapus Baris
        document.getElementById('items-table').addEventListener('click', function (e) {
            if (e.target.closest('.remove-row')) {
                // Cek sisa baris agar tidak habis total
                if (document.querySelectorAll('.item-row').length > 1) {
                    e.target.closest('tr').remove();
                } else {
                    alert("Minimal harus menyisakan satu baris item.");
                }
            }
        });
    });
</script>
@endsection