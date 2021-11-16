@extends('layouts.layout')
@extends('layouts.sidebar')

@php
$user = Auth::user()->id_role;
@endphp

@section('title')
Data Rujukan
@endsection

@section('rujukanStatus')
active
@endsection

@section('showSkrining')
show
@endsection

@section('header')
Data Rujukan
@endsection

@section('content')
<div class="container-fluid">
    <div class="modal fade" id="lihat" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Keterangan Rujukan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><b>Nama</b></label>
                            <input type="text" class="form-control" id="namaSiswa" readonly>
                        </div>
                        <div class="form-group">
                            <label><b>Keterangan Skrining</b></label>
                            <textarea class="form-control" name="keterangan" id="keterangan" rows="4" readonly></textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><b>Sekolah</b></label>
                            <input type="text" class="form-control" id="sekolah" readonly>
                        </div>
                        <form method="post" id="id" name="id">@csrf @method('PUT')
                        <div class="form-group">
                            <label><b>Keterangan Rujukan</b></label>
                            <textarea class="form-control" name="keterangan2" id="keterangan2" rows="4"></textarea>
                        </div>
                    </div>
                </div>
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                @if($user == 4)
                <button type="submit" class="btn btn-primary">Validasi</button>
                @endif
                </form>
            </div>
            </div>
        </div>
    </div>
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Data Rujukan Siswa</h1>
    @include('form.alert')
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Rujukan Siswa</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Sekolah</th>
                            <th>Kelas</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Nama</th>
                            <th>Sekolah</th>
                            <th>Kelas</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach($rujukan as $unit)
                        <tr>
                            <td>{{ $unit->getUser->nama }}</td>
                            <td>{{ $unit->getSekolah->nama }}</td>
                            <td>{{ $unit->getUser->kelas }}</td>
                            <td>{{ $unit->updated_at }}</td>
                            <td><button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#lihat" 
                            data-siswa="{{$unit->getUser->nama}}" data-sekolah="{{$unit->getSekolah->nama}}"
                            data-id="{{route('validasi.rujukan', [$unit->id])}}" data-semua="{{$unit}}"><i class="fas fa-fw fa-eye"></i></button></td>
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
<script>
    $('#lihat').on('show.bs.modal', function (event) {
    // Button utk trigger kirim data ke modal
    var button = $(event.relatedTarget)
    
    // Ekstrak data dari atribut data-
    var id = button.data('id')
    var siswa = button.data('siswa')
    var sekolah = button.data('sekolah')
    var semua = button.data('semua')

    // Update isi modal
    var modal = $(this)
    modal.find('#namaSiswa').val(siswa)
    modal.find('#sekolah').val(sekolah)
    modal.find('#tanggal').val(semua.tanggal)
    modal.find('#kesimpulan').val(semua.validasi_puskesmas)
    modal.find('#keterangan').val(semua.keterangan)
    $("#bukti").attr("src", semua.bukti)
    $("#id").attr("action", id)
    
})
</script>
@endsection