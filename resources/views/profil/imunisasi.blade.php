@extends('layouts.layout')
@extends('layouts.sidebar')

@php
$role= Auth::user()->getRole->role;
@endphp

@section('title')
Imunisasi
@endsection

@section('header')
Imunisasi
@endsection

@section('description')
Imunisasi
@endsection

@section('content')
<div class="container-fluid" style="min-height:75vh">
    <!-- Page Heading -->
    
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link" href="{{url('/profil')}}">Profil</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" href="{{url('/imunisasi')}}">Imunisasi</a>
        </li>
    </ul>
    <!-- <h1 class="h3 mb-2 text-gray-800">Profil</h1> -->

    @include('form.alert')
    <!-- Profil -->
    <div class="modal fade" id="tambah" tabindex="-1" aria-labelledby="tambah" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambah">Tambah Imunisasi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-6">
                                <label><b>Tanggal Pemberian</b></label>
                                <input type="date" id="tanggal" name="tanggal" class="form-control" required>
                            </div>
                            <div class="col-md-6 ">
                                <label><b>Nama Vaksin</b></label>
                                <input type="text" id="vaksin" name="vaksin" class="form-control" placeholder="Nama Vaksin" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-6">
                                <label><b>Dosis</b></label>
                                <input type="text" id="dosis" name="dosis" class="form-control" placeholder="Dosis Ke" required>
                            </div>
                            <div class="col-6">
                                <label><b>No. Batch</b></label>
                                <input type="text" id="nomor" name="nomor" class="form-control" placeholder="No. Batch Vaksin" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label><b>Pemberi Vaksin</b></label>
                        <input type="text" id="nama" name="nama" class="form-control" placeholder="Nama Pemberi Vaksin">
                    </div>
                    <div class="form-group">
                        <label><b>Lokasi Vaksin</b></label>
                        <input type="text" id="lokasi" name="lokasi" class="form-control" placeholder="Lokasi Vaksin">
                    </div>
                    <div class="form-group">
                        <label><b>Upload Foto Bukti</b></label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" name="bukti" id="bukti" required>
                            <label class="custom-file-label" for="bukti">Pilih file</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
            </div>
        </div>
    </div>
    <div class="card shadow h-100 mt-4">
        <div class="card-header font-weight-bold text-primary">
            <div class="row">
                <div class="col">Riwayat Imunisasi</div>
                <div class="col text-right"><button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#tambah">Tambah</button></div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Tanggal Pemberian</th>
                            <th>Jenis Vaksin</th>
                            <th>Dosis</th>
                            <th>No. Batch Vaksin</th>
                            <th>Petugas</th>
                            <th>Lokasi</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Tanggal Pemberian</th>
                            <th>Jenis Vaksin</th>
                            <th>Dosis</th>
                            <th>No. Batch Vaksin</th>
                            <th>Petugas</th>
                            <th>Lokasi</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        <tr>
                            <td>20-10-2021</td>
                            <td>Moderna</td>
                            <td>1</td>
                            <td>21DA32</td>
                            <td>Agus Zaenal</td>
                            <td>Dinas Kesehatan</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
</div>

@endsection

@section('script')
<script src="https://cdn.jsdelivr.net/npm/bs-custom-file-input/dist/bs-custom-file-input.min.js"></script>
<script>
$(document).ready(function () {
    bsCustomFileInput.init()
})
</script>
@endsection