@extends('layouts.layout')
@extends('layouts.sidebar')

@php
$role= Auth::user()->getRole->role;
@endphp

@section('title')
Profil
@endsection

@section('header')
Profil
@endsection

@section('description')
Profil
@endsection

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    
    <ul class="nav nav-tabs" style="position:relative; z-index:10;">
        <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="{{url('/profil')}}">Profil</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{url('/imunisasi')}}">Imunisasi</a>
        </li>
    </ul>
    <!-- <h1 class="h3 mb-2 text-gray-800">Profil</h1> -->

    @include('form.alert')
    <!-- Profil -->
    <div class="row mt-4">

        <form action="{{route('profil.upload')}}" method="post" enctype="multipart/form-data" id="photo-form" style="display: none;">
            @csrf
            <input type="file" id="photo" name="file" hidden>
        </form>
        <div class="col-xl-4">
            <div class="card mb-4 mb-xl-0">
                <div class="card-header font-weight-bold text-primary">Foto Profil</div>
                <div class="card-body text-center">
                    <img class="img-account-profile rounded-circle mb-2" src="{{ isset($profil->foto) ? $profil->foto : asset('public/img/undraw_profile.svg')}}" alt="" style="height:10rem;">
                    @if(isset($profil->foto))
                    <form action="{{route('profil.hapus')}}" method="post">
                    @csrf
                    @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-circle btn-danger" style="position: relative; top: -150px; right: -60px"><i class="fas fa-times"></i></button>
                    </form>
                    @endif
                    <div class="small font-italic text-muted mb-4">JPG atau PNG tidak lebih dari 1 MB</div>
                    <button class="btn btn-primary" type="button" id="trigger-photo">Upload Foto</button>
                </div>
            </div>
        </div>
        <div class="col-xl-8">
            <div class="card mb-4">
                <form action="{{route('profil.update')}}" method="post">
                @csrf
                @method('PUT')
                    <div class="card-header font-weight-bold text-primary">Detail Profil</div>
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
                                    <select id="gender" name="gender" class="form-control" required>
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
                                <input class="form-control" id="telp" name="telp" type="tel" placeholder="Masukkan no HP" value="@if(is_null($profil)==false){{$profil->telp}}@endif" maxlength="16">
                            </div>
                            <!-- Form Group (birthday)-->
                            <div class="col-md-6">
                                <label class="small mb-1" for="tanggal_lahir">Tanggal Lahir</label>
                                <input class="form-control" id="tanggal_lahir" type="date" name="tanggal_lahir" value="@if(is_null($profil)==false){{$profil->tanggal_lahir}}@endif" required>
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

@section('script')
<script>
    const inputFilter = function($this, inputFilter) {
    return $this.on("keyup", function() {
      if (inputFilter(this.value)) {
				var val = this.value;
        val = val.replace(/-/g, '');
        var vals = val.match(/.{1,4}/g).join('-');        
        this.value = vals;
        this.oldValue = vals;
        this.oldSelectionStart = this.selectionStart;
        this.oldSelectionEnd = this.selectionEnd;
      } else if (this.hasOwnProperty("oldValue")) {      
        this.value = this.oldValue;
        this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
      } else {
        this.value = "";
      }
    });
  };

inputFilter($("#telp"), function(value) {
    return /^[\d-]*$/.test(value);    // Allow digits only, using a RegExp
  });

$("#trigger-photo").click(function(){
    $("#photo").click();
});

document.getElementById("photo").onchange = function() {
    document.getElementById("photo-form").submit();
};
</script>
@endsection