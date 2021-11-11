@extends('layouts.layout')
@extends('layouts.sidebar')

@section('title')
Validasi Data
@endsection

@section('validasiStatus')
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
    <h1 class="h3 mb-2 text-gray-800">Validasi Data Skrining</h1>
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
                            <th>Sekolah</th>
                            <th>Kelas</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Nama</th>
                            <th>Sekolah</th>
                            <th>Kelas</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach($siswa as $unit)
                        <tr>
                            <td>{{ $unit->getUser->nama }}</td>
                            <td>{{ $unit->getSekolah->nama }}</td>
                            <td>{{ $unit->getUser->kelas }}</td>
                            <td>{{ $unit->updated_at }}</td>
                            <td><a href="{{url('/validasi/'.$unit->id)}}" class="btn btn-sm btn-primary"><i class="fas fa-fw fa-eye"></i></button></td>
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