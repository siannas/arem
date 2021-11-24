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

@section('ImunisasiStatus')
active
@endsection

@section('description')
Imunisasi
@endsection

@section('content')
<div class="container-fluid" style="min-height:75vh">
    <!-- Page Heading -->
    @if($role=='Siswa')
    <ul class="nav nav-tabs" style="position:relative; z-index:10;">
        <li class="nav-item">
            <a class="nav-link" href="{{url('/profil')}}">Profil</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" href="{{url('/imunisasi')}}">Imunisasi</a>
        </li>
    </ul>
    @endif
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
            <form action="{{route('imunisasi.simpan')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    @if($role=='Puskesmas')
                    <div class="form-group">
                        <label><b>Nama Siswa</b></label>
                        <div class="form-group" id="siswaParent">
                            <select id="id_user" name="id_user" class="form-control select2bs4">
                                <option selected disabled>Pilih Siswa</option>
                                @foreach($dataSiswa as $unit)
                                <option value="{{$unit->id}}">{{$unit->nama}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    @endif
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
                    @if($role=='Siswa')
                    <div class="form-group">
                        <label><b>Upload Foto Bukti</b></label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" name="bukti" id="bukti" required>
                            <label class="custom-file-label" for="bukti">Pilih file</label>
                        </div>
                    </div>
                    @endif
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
                @if($role=='Puskesmas'|$role=='Siswa')<div class="col text-right"><button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#tambah">Tambah</button></div>@endif
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            @if($role!='Siswa')
                            <th>Nama</th>
                            @endif
                            <th>Tanggal Pemberian</th>
                            <th>Vaksin</th>
                            @if($role=='Siswa')
                            <th>Petugas</th>
                            <th>Lokasi</th>
                            @endif
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            @if($role!='Siswa')
                            <th>Nama</th>
                            @endif
                            <th>Tanggal Pemberian</th>
                            <th>Vaksin</th>
                            @if($role=='Siswa')
                            <th>Petugas</th>
                            <th>Lokasi</th>
                            @endif
                            <th>Status</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach($imunisasi as $unit)
                        <tr>
                            @if($role!='Siswa')
                            <td>{{$unit->getUser->nama}}</td>
                            @endif
                            <td>{{$unit->tanggal}}</td>
                            <td>Dosis {{$unit->dosis}} {{$unit->vaksin}} (Batch: {{$unit->nomor}})</td>
                            @if($role=='Siswa')
                            <td>{{$unit->nama}}</td>
                            <td>{{$unit->lokasi}}</td>
                            @endif
                            <td>
                                @if($unit->validasi==1)
                                <div class="badge bg-success text-white rounded-pill">Tervalidasi</div>
                                @elseif($unit->validasi==0)
                                <div class="badge bg-warning text-white rounded-pill">Belum Tervalidasi</div>
                                @else
                                @endif
                            </td>
                        </tr>
                        @endforeach
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
<script>
$(document).ready(function() {
    $('#id_user').select2({
        width: '100%',
        dropdownParent: $("#siswaParent")
    });
});
</script>
@endsection