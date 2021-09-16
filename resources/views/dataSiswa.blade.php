@extends('layouts.layout')
@extends('layouts.sidebar')

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
                            <th>Kelas</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>NIK</th>
                            <th>Nama</th>
                            <th>Kelas</th>
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
                            <td>{{ $unit->kelas }}</td>
                            <td></td>
                            <td>{{ $unit->created_at }}</td>
                            <td><form action="/data-siswa/{{ $unit->id }}" method="GET"><button class="btn btn-sm btn-primary"><i class="fas fa-fw fa-eye"></i> Lihat</button></td></form>
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