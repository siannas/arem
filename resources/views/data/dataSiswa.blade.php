@extends('layouts.layout')
@extends('layouts.sidebar')

@php
$role= Auth::user()->getRole->role;
@endphp

@section('title')
Data Siswa
@endsection

@section('siswaStatus')
active
@endsection

@section('header')
Validasi
@endsection

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Data Siswa</h1>

    @include('form.alert');
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Siswa</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>NIK</th>
                            <th>Nama</th>
                            @if($role==='Kelurahan'||$role==='Puskesmas'||$role==='Kecamatan'||$role==='Kota')
                            <th>Sekolah</th>
                            @endif
                            <th>Status</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>NIK</th>
                            <th>Nama</th>
                            @if($role==='Kelurahan'||$role==='Puskesmas'||$role==='Kecamatan'||$role==='Kota')
                            <th>Sekolah</th>
                            @endif
                            <th>Status</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        
                        @foreach($dataSiswa as $unit)
                        <tr>
                            <td>{{ $unit->username }}</td>
                            <td>{{ $unit->nama }}</td>
                            @if($role==='Kelurahan'||$role==='Puskesmas'||$role==='Kecamatan'||$role==='Kota')
                                @if($unit->kelas===1)
                                <td>SD/MI</td>
                                @elseif($unit->kelas===7)
                                <td>SMP/MTS dan SMA/SMK/MA</td>
                                @endif
                            @endif
                            <td>
                                @if($unit->validasi===1)
                                <div class="badge bg-success text-white rounded-pill">Tervalidasi</div>
                                @elseif($unit->validasi===0)
                                <div class="badge bg-warning text-white rounded-pill">Belum Tervalidasi</div>
                                @else
                                <div class="badge bg-danger text-white rounded-pill">Belum Mengisi</div>
                                @endif
                            </td>
                            <td>{{ $unit->updated_at }}</td>
                            <td><a href="{{url('/data-siswa/'.$unit->id)}}" class="btn btn-sm btn-primary"><i class="fas fa-fw fa-eye"></i></a>
                                @if($role==='Sekolah')
                                <button class="btn btn-sm btn-danger"><i class="fas fa-fw fa-sign-out-alt" data-toggle="modal" data-target="#keluar{{ $unit->id }}"></i></button>
                                <div class="modal modal-danger fade" id="keluar{{ $unit->id }}" tabindex="-1" role="dialog" aria-labelledby="Delete" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Keluarkan Siswa</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                            <form action="{{ route('siswa.keluar', [$unit->id]) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <h5 class="text-center">Yakin Ingin Mengeluarkan Siswa dari Sekolah?</h5>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tidak</button>
                                                <button type="submit" class="btn btn-danger">Ya</button>
                                            </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
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

@endsection