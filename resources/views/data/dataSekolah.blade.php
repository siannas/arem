@extends('layouts.layout')
@extends('layouts.sidebar')

@section('title')
Data Sekolah
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
    <h1 class="h3 mb-2 text-gray-800">Data Sekolah</h1>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Sekolah</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>NPSN</th>
                            <th>Nama Sekolah</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>NPSN</th>
                            <th>Nama Sekolah</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach($dataSekolah as $unit)
                        <tr>
                            <td>{{ $unit->username }}</td>
                            <td>{{ $unit->nama }}</td>
                            <td></td>
                            <td><form action="{{url('/data-sekolah/'.$unit->id)}}" method="GET"><button class="btn btn-sm btn-primary"><i class="fas fa-fw fa-eye"></i> Lihat</button></form></td>
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