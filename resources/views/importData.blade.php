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
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" name="file-dummy" id="file-dummy" onchange="myToggleButtonUpload('','upload')">
                        <label class="custom-file-label" for="file-dummy">Pilih file excel</label>
                    </div>
                        
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
                                <tr>
                                    <td>1</td>
                                    <td>3578900284760002</td>
                                    <td>Alesin Ijans</td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>3578900284760002</td>
                                    <td>Alesin Ijans</td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>3578900284760002</td>
                                    <td>Alesin Ijans</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer text-right">
                    <a href="{{ url('/data-siswa') }}" class="btn btn-secondary" type="button">Kembali</a>
                    <button type="submit" class="btn btn-primary">Import</button>
                </div>
            
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
    });
</script>
@endsection