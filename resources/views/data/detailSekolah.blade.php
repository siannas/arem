@extends('layouts.layout')
@extends('layouts.sidebar')

@section('title')
Detail Sekolah
@endsection

@section('sekolahStatus')
active
@endsection

@section('showMaster')
show
@endsection

@section('header')
Validasi
@endsection

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Detail Data Sekolah</h1>
    <div class="card">
        <div class="card-header bg-primary mb-3">
            <div class="row p-4 justify-content-between align-items-center">
                <div class="col-12 col-lg-auto mb-5 mb-lg-0 text-center text-lg-left">
                    <i class="fas fa-laugh-wink text-light mb-3" style="font-size:50px;"></i>
                    <h5 class="text-light">e-Ning Tasiah</h5>
                </div>
                <div class="col-12 col-lg-auto text-center text-lg-right">
                    <h5 class="card-title text-light mb-3"><b>{{ $sekolah->nama }}</b></h5>
                    <h6 class="card-subtitle text-gray-300 mb-2">NPSN {{ $sekolah->username }}</h6>
                </div>
            </div>
        </div>
        <div class="card-body">
            <h6 class="card-subtitle mb-3"><b>Siswa</b></h6>
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>NIK</th>
                            <th>Nama</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>NIK</th>
                            <th>Nama</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach($siswa as $unit)
                        <tr>
                            <td>{{ $unit->username }}</td>
                            <td>{{ $unit->nama }}</td>
                            <td>
                                @if($unit->validasi_sekolah===1)
                                <div class="badge bg-success text-white rounded-pill">Tervalidasi</div>
                                @elseif($unit->validasi_sekolah===0)
                                <div class="badge bg-warning text-white rounded-pill">Belum Tervalidasi</div>
                                @else
                                <div class="badge bg-danger text-white rounded-pill">Belum Mengisi</div>
                                @endif
                            </td>
                            <td>{{ $unit->created_at }}</td>
                            <td><form action="{{url('/data-siswa/'.$unit->id)}}" method="GET"><button class="btn btn-sm btn-primary"><i class="fas fa-fw fa-eye"></i> Lihat</button></form></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
        <div class="card-footer text-right">
            <a href="{{url('/data-sekolah')}}" class="btn btn-secondary"><i class="fas fa-fw fa-sign-out-alt"></i> Kembali</a>
        </div>
    </div>
</div>

@endsection