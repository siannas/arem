@extends('layouts.layout')
@extends('layouts.sidebar')

@php
$role= Auth::user()->getRole->role;
@endphp

@section('title')
Rekap Skrining
@endsection

@section('rekapStatus')
active
@endsection

@section('header')
Rekap Skrining
@endsection

@section('description')
Dashboard
@endsection

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Profil</h1>

    @include('form.alert')
    <!-- Profil -->
    <div class="row">

        <div class="col-xl-4">
            <div class="card mb-4 mb-xl-0">
                <div class="card-header font-weight-bold text-primary">Foto Profil</div>
                <div class="card-body text-center">
                    <img class="img-account-profile rounded-circle mb-2" src="{{ asset('public/img/undraw_profile.svg')}}" alt="" style="height:10rem">
                    <div class="small font-italic text-muted mb-4">JPG atau PNG tidak lebih dari 1 MB</div>
                    <button class="btn btn-primary" type="button">Upload Foto</button>
                </div>
            </div>
        </div>
        <div class="col-xl-8">
            <div class="card mb-4">
                <form action="{{route('profil.update')}}" method="post">
                @csrf
                @method('PUT')
                    <div class="card-header font-weight-bold text-primary">Detail Akun</div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="small mb-1" for="Username">Username (NIK)</label>
                            <input class="form-control" id="Username" type="text" value="{{Auth::user()->username}}" readonly>
                        </div>
                        
                        <div class="mb-3">
                            <label class="small mb-1" for="Name">Nama</label>
                            <input class="form-control" id="Name" type="text" value="{{Auth::user()->nama}}" readonly>
                        </div>
                        <!-- Form Row -->
                        <div class="row gx-3 mb-3">
                            <!-- Form Group (organization name)-->
                            <div class="col-md-6">
                                <label class="small mb-1" for="JnsKelamin">Jenis Kelamin</label>
                                <div class="input-group">
                                    <select id="gender" name="gender" class="form-control">
                                        <option selected disabled>Pilih Jenis Kelamin</option>
                                        <option value="L" @if(is_null($profil)==false && $profil->gender=="L") selected @endif>Laki-laki</option>
                                        <option value="P" @if(is_null($profil)==false && $profil->gender=="P") selected @endif>Perempuan</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <label class="small mb-1" for="inputEmail">Alamat Email</label>
                                <input class="form-control" id="email" name="email" type="email" placeholder="Masukkan alamat email" value="@if(is_null($profil)==false){{$profil->email}}@endif">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="small mb-1" for="inputAlamat">Alamat</label>
                            <input class="form-control" id="alamat" name="alamat" type="text" placeholder="Masukkan alamat" value="@if(is_null($profil)==false){{$profil->alamat}}@endif">
                        </div>
                        
                        <div class="row gx-3 mb-3">
                            <div class="col-md-6">
                                <label class="small mb-1" for="inputNoHP">Nomor HP</label>
                                <input class="form-control" id="telp" name="telp" type="tel" placeholder="Masukkan no HP" value="@if(is_null($profil)==false){{$profil->telp}}@endif">
                            </div>
                            <!-- Form Group (birthday)-->
                            <div class="col-md-6">
                                <label class="small mb-1" for="inputTglLahir">Tanggal Lahir</label>
                                <input class="form-control" id="tanggal_lahir" type="date" name="tanggal_lahir" value="@if(is_null($profil)==false){{$profil->tanggal_lahir}}@endif">
                            </div>
                        </div>
                        
                    </div>
                    <div class="card-footer text-right">
                        <a href="{{ url('/') }}" class="btn btn-secondary" type="button">Kembali</a>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
                        
    </div>
    
</div>

@endsection