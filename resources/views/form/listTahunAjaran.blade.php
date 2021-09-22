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
<!-- Modal -->
<div class="modal fade" id="tambah" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Tambah Form Skrining</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="form-group">
            <label><b>Tahun Ajaran</b></label>
            <div class="row">
                <div class="col">
                    <input type="text" id="tahun1" class="form-control" placeholder="Tahun 1" oninput="hitungTahun('tahun1', 'tahun2')">
                </div>
                -
                <div class="col">
                    <input type="text" id="tahun2" class="form-control" placeholder="Tahun 2" disabled>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label><b>Jenjang</b></label>
            <div class="input-group">
                <select id="jenjang" class="form-control">
                    <option selected disabled>Pilih Jenjang</option>
                    <option value="1">SD</option>
                    <option value="2">SMP</option>
                    <option value="3">SMA</option>
                </select>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
        <button type="button" class="btn btn-primary">Simpan</button>
      </div>
    </div>
  </div>
</div>

<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Daftar Form Skrining</h1>
    
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @elseif (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <p>Error</p>
            <small>{{ session('error') }}</small>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="row">
                <div class="col align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Daftar Form Skrining</h6>
                </div>   
                @if($role==='Kota')
                <div class="col text-right">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#tambah">
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
                                    @if($role==='Kota')
                                    <form action="{{route('formulir.show', [$unit->id])}}" method="GET" class="mr-1"><button class="btn btn-sm btn-primary"><i class="fas fa-fw fa-eye"></i></button></form>
                                    <button type="button" class="btn btn-sm btn-warning mr-1" data-toggle="modal" data-target="#edit"><i class="fas fa-fw fa-edit"></i></button>
                                    <form action="/formulir/duplicate/{{ $unit->id }}" method="POST" class="mr-1">
                                    @csrf
                                        <button class="btn btn-sm btn-secondary"><i class="fas fa-fw fa-copy"></i></button>
                                    </form>
                                    <button class="btn btn-sm btn-danger"><i class="fas fa-fw fa-trash-alt" data-toggle="modal" data-target="#delete{{ $unit->id }}"></i></button>
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
                                    <form action="/formulir/user/{{ $unit->id }}" method="GET" class="mr-1"><button class="btn btn-sm btn-primary"><i class="fas fa-fw fa-eye"></i> Lihat</button></form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        <div class="modal fade" id="edit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Edit Form Skrining</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                    <div class="form-group">
                                        <label><b>Tahun Ajaran</b></label>
                                        <div class="row">
                                            <div class="col">
                                                <input type="text" id="tahun1{{ $unit->id }}" class="form-control" placeholder="Tahun 1" oninput="hitungTahun('tahun1{{$unit->id}}', 'tahun2{{$unit->id}}')">
                                            </div>
                                            -
                                            <div class="col">
                                                <input type="text" id="tahun2{{ $unit->id }}" class="form-control" placeholder="Tahun 2" disabled>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label><b>Jenjang</b></label>
                                        <div class="input-group">
                                            <select id="jenjang" class="form-control">
                                                <option selected disabled>Pilih Jenjang</option>
                                                <option value="1">SD</option>
                                                <option value="2">SMP</option>
                                                <option value="3">SMA</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="custom-control custom-switch mt-4">
                                        <input type="checkbox" class="custom-control-input" id="customSwitch1">
                                        <label class="custom-control-label" for="customSwitch1">Aktifkan</label>
                                    </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                <button type="button" class="btn btn-primary">Simpan</button>
                            </div>
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
          
@endsection

@section('script')
<script>
function hitungTahun(id1, id2){
    console.log(id1)
    var tahun = document.getElementById(id1);
    var tot = 0;

    if(parseInt(tahun.value))
        tot = parseInt(tahun.value)+1;
    
    document.getElementById(id2).value = tot;
}

</script>
@endsection