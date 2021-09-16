@extends('layouts.layout')
@extends('layouts.sidebar')

@section('title')
Daftar Form Skrining
@endsection

@section('formStatus')
active
@endsection

@section('header')
Validasi
@endsection

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Daftar Form Skrining</h1>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Form Skrining</h6>
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
                        @foreach($formulir as $unit)
                        <tr>
                            <td>{{ $unit->tahun_ajaran }}</td>
                            @if($unit->kelas==='1,2,3,4,5,6')
                            <td>SD</td>
                            @elseif($unit->kelas==='7,8,9')
                            <td>SMP</td>
                            @elseif($unit->kelas==='10,11,12')
                            <td>SMA</td>
                            @endif

                            @if($unit->status===1)
                            <td><div class="badge bg-success text-white rounded-pill">Aktif</div></td>
                            @else
                            <td><div class="badge bg-warning text-white rounded-pill">Non Aktif</div></td>
                            @endif
                            <td>
                                <div class="row m-1">
                                    <form action="{{route('formulir.show', [$unit->id])}}" method="GET" class="mr-1"><button class="btn btn-sm btn-primary"><i class="fas fa-fw fa-eye"></i></button></form>
                                    <form action="{{route('formulir.update', [$unit->id])}}" method="POST" class="mr-1">
                                    @csrf
                                        <button class="btn btn-sm btn-warning"><i class="fas fa-fw fa-edit"></i></button>
                                    </form>
                                    <form action="/formulir/duplicate/{{ $unit->id }}" method="POST" class="mr-1">
                                    @csrf
                                        <button class="btn btn-sm btn-secondary"><i class="fas fa-fw fa-copy"></i></button>
                                    </form>
                                    <form action="{{route('formulir.destroy', [$unit->id])}}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                        <button class="btn btn-sm btn-danger"><i class="fas fa-fw fa-trash-alt"></i></button>
                                    </form>
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

@section('script')

@endsection