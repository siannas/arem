@extends('layouts.layout')
@extends('layouts.sidebar')

@php
$role= Auth::user()->getRole->role;
@endphp

@section('title')
Import Data Siswa
@endsection

@section('header')
Import Data Siswa
@endsection

@section('description')
Import Data Siswa
@endsection

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Import Data Siswa</h1>

    @include('form.alert')
    <!-- Profil -->
    <div class="row">

        <div class="col-xl-6">
            <div class="card mb-4 mb-xl-0">
                <div class="card-header font-weight-bold text-primary">Import Data Siswa</div>
                <div class="card-body">
                    <div class="card text-white bg-gradient-primary mb-3">
                        <div class="card-body">
                            <h5 class="card-title"><i class="fas fa-info"></i> Catatan:</h5>
                            <p class="card-text">Silahkan import data dari excel, menggunakan format yang sudah disediakan <a href="{{url('/tis')}}" class="btn btn-sm btn-light">Download Format</a></p>
                            
                        </div>
                    </div>
                    <form action="{{route('data-siswa.import.preview')}}" enctype="multipart/form-data" method="POST" id="form">
                    @csrf
                    <div class="custom-file">
                        <input type="file" name="file" id="file" >
                        <label class="custom-file-label" for="file">Pilih file excel</label>
                    </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="card mb-4">
                <div class="card-header font-weight-bold text-primary">Preview Data Siswa</div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th style="width:45%">Username(NIK)</th>
                                    <th>Nama</th>
                                    <th>Kelas</th>
                                </tr>
                            </thead>
                            <tbody>
                            @if(session('siswa') and session('jumlah'))
                            @php
                            $cnt = 1;
                            @endphp
                            @foreach(session('siswa') as $key => $s)
                                @if($s['double'])
                                <tr class="bg-warning">
                                    <td>{{$cnt}}</td>
                                    <td>{{$s['nik']}}</td>
                                    <td>{{$s['nama']}}</td>
                                    <td>{{$s['kelas']}}</td>
                                </tr>
                                @else
                                <tr>
                                    <td>{{$cnt}}</td>
                                    @if ($s['nik']) 
                                    <td>{{$s['nik']}}</td>
                                    @else
                                    <td class="bg-danger text-white">kosong</td>
                                    @endif
                                    @if ($s['nama'] )
                                    <td>{{$s['nama']}}</td>
                                    @else
                                    <td class="bg-danger text-white">kosong</td>
                                    @endif
                                    @if ($s['kelas'] )
                                    <td>{{$s['kelas']}}</td>
                                    @else
                                    <td class="bg-danger text-white">kosong</td>
                                    @endif
                                </tr>
                                @endif
                                @php
                                $cnt += 1;
                                @endphp
                            @endforeach
                            @else
                            <tr>
                                <td class="text-center" colspan="4">Tidak Ada Data</td>
                            </tr>
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer text-right">
                    <form action="{{route('data-siswa.import.send')}}" method="POST" id="form-send">
                        @csrf
                        <a href="{{ url('/data-siswa') }}" class="btn btn-secondary" type="button">Kembali</a>
                        <button type="submit" class="btn btn-primary" {{ (session('siswa') and session('boleh_import')) ? '' : 'disabled' }} >Import</button>
                    </form >
                </div>
            
            </div>
        </div>
                        
    </div>
    
</div>
@endsection

@section('script')
<script>
@if (session('siswa'))
var siswa = @json(session('siswa'));
@endif
$(document).ready(function () {
    document.getElementById("file").onchange = function() {
        document.getElementById("form").submit();
    }

    $('#form-send').submit(function(e){
        $("<input />").attr("type", "hidden")
            .attr("name", "data")
            .attr("value", JSON.stringify(siswa))
            .appendTo("#form-send");
        return true;
    })
});
</script>
@endsection