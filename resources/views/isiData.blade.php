@extends('layouts.layout')
@extends('layouts.sidebar')

@section('title')
Validasi Data
@endsection

@section('isiDataStatus')
active
@endsection

@section('showSkrining')
show
@endsection

@section('header')
Validasi
@endsection

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Isi Data Skrining</h1>
    @include('form.alert')
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Skrining Siswa</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <!-- <th>Sekolah</th> -->
                            <th>Kelas</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Nama</th>
                            <!-- <th>Sekolah</th> -->
                            <th>Kelas</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach($siswa as $unit)
                        <tr>
                            <td>{{ $unit->nama }}</td>
                            <td>{{ $unit->kelas }}</td>
                            <td>{{ $unit->jawabans->isEmpty() ? '-' : $unit->jawabans[0]->updated_at }}</td>
                            <td>
                                @if($unit->jawabans->isEmpty())
                                <div class="badge bg-danger text-white rounded-pill">Belum Mengisi</div>
                                @elseif($unit->validasi_sekolah===1)
                                <div class="badge bg-success text-white rounded-pill">Tervalidasi Sekolah</div>
                                @elseif($unit->validasi_sekolah===0)
                                <div class="badge bg-warning text-white rounded-pill">Belum Tervalidasi Sekolah</div>
                                @endif
                            </td>
                            <td><a href="{{url('/isi-data/'.$id_formulir.'/'.$unit->id)}}" class="btn btn-sm btn-warning"><i class="fas fa-fw fa-pen"></i></button></td>
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