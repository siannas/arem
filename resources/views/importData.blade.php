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
                    <div class="card text-white bg-primary mb-3">
                        <div class="card-body">
                            <h5 class="card-title"><i class="fas fa-info"></i> Note:</h5>
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
                                </tr>
                            </thead>
                            <tbody>
                            @if(session('siswa') and session('jumlah'))
                            @php
                            $cnt = 1;
                            @endphp
                            @foreach(session('siswa') as $key => $s)
                                @if(empty($s['nik']) and empty($s['nama']))
                                @else
                                    @if($s['double'])
                                    <tr class="bg-warning">
                                        <td>{{$cnt}}</td>
                                        <td>{{$s['nik']}}</td>
                                        <td>{{$s['nama']}}</td>
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
                                    </tr>
                                    @endif
                                    @php
                                    $cnt += 1;
                                    @endphp
                                @endif
                            @endforeach
                            @else
                            <tr>
                                <td class="text-center" colspan="3">no data</td>
                            </tr>
                            @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer text-right">
                    <a href="{{ url('/data-siswa') }}" class="btn btn-secondary" type="button">Kembali</a>
                    <button type="submit" class="btn btn-primary" {{ (session('siswa') and session('boleh_import')) ? '' : 'disabled' }} >Import</button>
                </div>
            
            </div>
        </div>
                        
    </div>
    
</div>
@endsection

@section('script')
<script>
$(document).ready(function () {
    document.getElementById("file").onchange = function() {
        console.log('aye');
        document.getElementById("form").submit();
    }
});
</script>
@endsection