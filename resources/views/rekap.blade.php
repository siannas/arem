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

@section('showSkrining')
show
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
    <h1 class="h3 mb-2 text-gray-800">Rekap Skrining</h1>
    @include('form.alert')
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="row">
                <div class="col align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Rekap Skrining</h6>
                </div>   
            </div>
            
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Tahun Ajaran</th>
                            <th>Jenjang</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Tahun Ajaran</th>
                            <th>Jenjang</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach($rekap as $unit)
                        <tr>
                            <td>{{ $unit->tahun_ajaran }}</td>
                            @if($unit->kelas==='1,2,3,4,5,6')
                            <td>SD/MI</td>
                            @elseif($unit->kelas==='7,8,9,10,11,12')
                            <td>SMP/MTS dan SMA/SMK/MA</td>
                            @endif
                            @if($unit->status===1)
                            <td><div class="badge bg-success text-white rounded-pill">Aktif</div></td>
                            @else
                            <td><div class="badge bg-warning text-white rounded-pill">Non Aktif</div></td>
                            @endif
                            <td>
                                <div class="row m-1">
                                    <a href="{{url('/rekap/'.$unit->id.'?for='.Auth::user()->id)}}" class="btn btn-sm btn-primary"><i class="fas fa-fw fa-eye"></i> Lihat</a>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection