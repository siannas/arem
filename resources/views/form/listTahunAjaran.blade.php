@extends('layouts.layout')
@extends('layouts.sidebar')

@php
$role= Auth::user()->getRole->role;
@endphp

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
<!-- Modal Tambah Formulir -->
<div class="modal fade" id="tambah" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tambah Form Skrining</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{route('formulir.store')}}" method="post">
        @csrf
        <div class="modal-body">
            <div class="form-group">
                <label><b>Tahun Ajaran</b></label>
                <div class="row">
                    <div class="col">
                        <input type="text" id="tahun1" name="tahun1" class="form-control" placeholder="Tahun 1" value="{{date('Y')}}" oninput="hitungTahun('tahun1', 'tahun2', 'tahun_ajaran')">
                    </div>
                    -
                    <div class="col">
                        <input type="text" id="tahun2" name="tahun2" class="form-control" placeholder="Tahun 2" value="{{date('Y')+1}}" disabled>
                    </div>
                    <input type="text" id="tahun_ajaran" name="tahun_ajaran" class="form-control" hidden>
                </div>
            </div>
            <div class="form-group">
                <label><b>Jenjang</b></label>
                <div class="input-group">
                    <select id="kelas" name="kelas" class="form-control">
                        <option selected disabled>Pilih Jenjang</option>
                        <option value="1,2,3,4,5,6">SD/MI</option>
                        <option value="7,8,9,10,11,12">SMP/MTS dan SMA/SMK/MA</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            <button type="submit" class="btn btn-primary">Simpan</button>
        </div>
      </form>
      
    </div>
  </div>
</div>

@if($role==='Kota')
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Daftar Form Skrining</h1>
    @include('form.alert')

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="row">
                <div class="col align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Daftar Form Skrining</h6>
                </div>
                @if($role==='Kota')
                <div class="col text-right">
                <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#tambah">
                Tambah
                </button>
                </div>
                @endif
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
                        @foreach($formulir as $unit)
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
                                    @if($role==='Kota')
                                    <form action="{{route('formulir.show', [$unit->id])}}" method="GET" class="mr-1"><button class="btn btn-sm btn-primary"><i class="fas fa-fw fa-eye"></i></button></form>
                                    <button type="button" class="btn btn-sm btn-warning mr-1" data-toggle="modal" data-target="#edit-{{$unit->id}}"><i class="fas fa-fw fa-edit"></i></button>
                                    <form action="{{url('/formulir/duplicate/'.$unit->id)}}" method="POST" class="mr-1">
                                    @csrf
                                        <button class="btn btn-sm btn-secondary"><i class="fas fa-fw fa-copy"></i></button>
                                    </form>
                                    <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#delete{{ $unit->id }}"><i class="fas fa-fw fa-trash-alt"></i></button>
                                    <div class="modal modal-danger fade" id="delete{{ $unit->id }}" tabindex="-1" role="dialog" aria-labelledby="Delete" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Hapus</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                <form action="{{ route('formulir.destroy', [$unit->id]) }}" method="POST">
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
                                    
                                    @elseif($role==='Siswa')
                                    <form action="{{url('/formulir/user/'.$unit->id)}}" method="GET" class="mr-1"><button class="btn btn-sm btn-primary"><i class="fas fa-fw fa-eye"></i> Lihat</button></form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        <!-- Modal Edit Formulir -->
                        <div class="modal fade" id="edit-{{$unit->id}}" tabindex="-1" aria-labelledby="edit-{{$unit->id}}ModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="edit-{{$unit->id}}ModalLabel">Edit Form Skrining</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form action="{{route('formulir.update', [$unit->id])}}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label><b>Tahun Ajaran</b></label>
                                            @php
                                            $tahun=explode('-', $unit->tahun_ajaran);
                                            $tahun1=$tahun[0];
                                            $tahun2=$tahun[1];
                                            @endphp
                                            <div class="row">
                                                <div class="col">
                                                    <input type="text" id="tahun1{{ $unit->id }}" class="form-control" value="{{$tahun1}}" oninput="hitungTahun('tahun1{{$unit->id}}', 'tahun2{{$unit->id}}', 'tahun_ajaran{{$unit->id}}')">
                                                </div>
                                                -
                                                <div class="col">
                                                    <input type="text" id="tahun2{{ $unit->id }}" class="form-control" value="{{$tahun2}}" disabled>
                                                </div>
                                                <input type="text" id="tahun_ajaran{{ $unit->id }}" name="tahun_ajaran" value="{{$unit->tahun_ajaran}}" class="form-control" hidden>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label><b>Jenjang</b></label>
                                            <div class="input-group">
                                                <select id="jenjang" class="form-control" name="kelas">
                                                    <option disabled>Pilih Jenjang</option>
                                                    <option value="1,2,3,4,5,6" @if($unit->kelas=="1,2,3,4,5,6") selected @endif>SD/MI</option>
                                                    <option value="7,8,9,10,11,12" @if($unit->kelas=="7,8,9,10,11,12") selected @endif>SMP/MTS dan SMA/SMK/MA</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="custom-control custom-switch mt-4">
                                            <input type="checkbox" class="custom-control-input" id="customSwitch{{$unit->id}}" @if($unit->status===1) checked @endif name="status">
                                            <label class="custom-control-label" for="customSwitch{{$unit->id}}">Aktifkan</label>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                    </div>
                                </form>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endif

@if($role==='Siswa')
<div class="container-fluid" style="max-width:60rem;">
    <div class="row">
        <div class="col-xxl-4 col-xl-12 mb-4">
            <div class="card shadow h-100">
                <div class="card-body h-100 p-5">
                    <div class="row align-items-center">
                        <div class="col-xl-8 col-xxl-12">
                            <div class="text-center text-xl-start text-xxl-center mb-4 mb-xl-0 mb-xxl-4 mr-xl-4">
                                <h2 class="text-primary mb-4">Form Skrining Aktif</h2>
                                @if(count($formulir)!=0)
                                    @foreach($formulir as $unit)
                                    <form action="{{url('/formulir/user/'.$unit->id)}}" method="GET">
                                    <button type="submit" class="btn btn-primary shadow h-100 p-3 mb-3" style="width:100%">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="font-weight-bold text-light text-uppercase mb-1">
                                                    @if($unit->kelas==='1,2,3,4,5,6')
                                                    SD/MI
                                                    @elseif($unit->kelas==='7,8,9,10,11,12')
                                                    SMP/MTS dan SMA/SMK/MA
                                                    @endif
                                                </div>
                                                <div class="h5 mb-0 font-weight-bold text-light">Tahun Ajaran {{ $unit->tahun_ajaran }}</div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-pen fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </button>
                                    </form>
                                    @endforeach
                                @else
                                    <button class="btn btn-primary shadow h-100 p-3 mb-3" style="width:100%" disabled>
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="h5 mb-0 font-weight-bold text-light">Tidak Ada Form Skrining Aktif</div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-pen fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </button>
                                @endif
                            </div>
                        </div>
                        <div class="col-xl-4 col-xxl-12 text-center"><img class="img-fluid" src="{{asset('public/img/undraw_Setup_wizard_re_nday.svg')}}"></div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="row">
                <div class="col align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Riwayat Skrining</h6>
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
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Tahun Ajaran</th>
                            <th>Jenjang</th>
                            <th>Aksi</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach($riwayat as $unit)
                        <tr>
                            <td>{{ $unit->tahun_ajaran }}</td>
                            @if($unit->kelas==='1,2,3,4,5,6')
                            <td>SD/MI</td>
                            @elseif($unit->kelas==='7,8,9,10,11,12')
                            <td>SMP/MTS dan SMA/SMK/MA</td>
                            @endif
                            <td>
                                <div class="row m-1">
                                    <form action="{{url('/formulir/user/'.$unit->id)}}" method="GET" class="mr-1"><button class="btn btn-sm btn-primary"><i class="fas fa-fw fa-eye"></i> Lihat</button></form>
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
@endif

@endsection

@section('script')
<script>
function hitungTahun(id1, id2, id3){
    var tahun = document.getElementById(id1);
    var tot = 0;

    if(parseInt(tahun.value))
        tot = parseInt(tahun.value)+1;
    
    document.getElementById(id2).value = tot;
    concatTahun(id1, id2, id3);
}

function concatTahun(id1, id2, id3){
    var tahun1 = document.getElementById(id1);
    var tahun2 = document.getElementById(id2);
    console.log(tahun1);
    if(tahun1.value && tahun2.value)
        tahun_ajaran = tahun1.value + "-" + tahun2.value;
    
    document.getElementById(id3).value = tahun_ajaran;
}
</script>
@endsection