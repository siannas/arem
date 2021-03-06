@extends('layouts.layout')
@extends('layouts.sidebar')

@php
$role= Auth::user()->getRole->role;
@endphp

@if($role==='Siswa')
@section('title')
Jenis Pemeriksaan
@endsection

@section('header')
Jenis Pemeriksaan
@endsection

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Jenis Pemeriksaan</h1>
    <div class="row">

        <!-- Earnings (Annual) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="font-weight-bold text-success text-uppercase mb-1">2. Riwayat Imunisasi</div>
                                <a href="{{url('/form')}}" class="btn btn-success btn-icon-split btn-md">
                                    <span class="icon text-white-50">
                                        <i class="fas fa-flag"></i>
                                    </span>
                                    <span class="text">Isi Form</span>
                                </a>
                            </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @foreach($pertanyaan as $unit)
        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="font-weight-bold text-primary text-uppercase mb-1">{{ $unit->judul }}</div>
                            <a href="{{url('/formulir/user/'.$unit->id)}}" class="btn btn-primary btn-icon-split btn-md">
                                <span class="icon text-white-50">
                                    <i class="fas fa-flag"></i>
                                </span>
                                <span class="text">Isi Form</span>
                            </a>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

</div>
@endsection

@elseif($role==='Kota')

@section('title')
Jenis Pemeriksaan
@endsection

@section('formStatus')
active
@endsection

@section('header')
Jenis Pemeriksaan
@endsection

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Jenis Pemeriksaan</h1>
    @include('form.alert')
    <div class="row">

        @foreach($pertanyaan as $unit)
        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center" style="position:relative; height:100%;">
                        <div class="col mr-2" style="height:100%;">
                            <div class="font-weight-bold text-primary text-uppercase mb-1">{{ $unit->judul }}</div>
                            <button type="button" class="btn" data-toggle="modal" data-target="#hapus{{ $unit->id }}"disabled>.</button>
                                <div style="position:absolute; bottom:0;">
                                    <a href="{{url('/pertanyaan/'.$unit->id)}}" class="btn btn-primary"><i class="fas fa-pen"></i> Edit</a>
                                    @if ($total==0)
                                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#hapus{{ $unit->id }}"><i class="fas fa-fw fa-trash-alt"></i> Hapus</button>
                                    @endif
                                </div>
                            <div class="modal modal-danger fade" id="hapus{{ $unit->id }}" tabindex="-1" role="dialog" aria-labelledby="Delete" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Hapus</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                        <form action="{{ route('pertanyaan.destroy', [$unit->id]) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <h5 class="text-center">Yakin Ingin Hapus?</h5>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tidak</button>
                                            <button type="submit" class="btn btn-danger">Ya</button>
                                        </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                                    
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach

        <!-- Earnings (Monthly) Card Example -->
        @if ($total==0)
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center text-center" style="height:100%">
                        <div class="col mr-2">
                            <form action="{{route('pertanyaan.store', [$formulir->id])}}" method="POST">
                            @csrf
                            <button class="btn btn-primary btn-icon-split btn-md">
                                <span class="icon text-white-50">
                                    <i class="fas fa-plus"></i>
                                </span>
                                <span class="text">Tambah</span>
                            </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>

</div>
@endsection
@endif