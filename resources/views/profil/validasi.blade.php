@extends('layouts.layout')
@extends('layouts.sidebar')

@php
$user = Auth::user()->id_role;
@endphp

@section('title')
Validasi Imunisasi
@endsection

@section('validasiImunStatus')
active
@endsection

@section('header')
Validasi Data Imunisasi
@endsection

@section('content')
<div class="container-fluid">
    <div class="modal fade" id="lihat" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Validasi</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6" style="max-height:65vh; overflow:hidden;">
                        <label><b>Bukti</b></label>
                        <img id="bukti" name="bukti" alt="">
                        
                    </div>
                    <div class="col-md-6">
                    <form>
                        <div class="form-group">
                            <label><b>Nama</b></label>
                            <input type="text" class="form-control" id="namaSiswa" readonly>
                        </div>
                        <div class="form-group">
                            <label><b>Sekolah</b></label>
                            <input type="text" class="form-control" id="sekolah" readonly>
                        </div>
                        <div class="form-group">
                            <label><b>Vaksin</b></label>
                            <input type="text" class="form-control" id="vaksin" readonly>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label><b>Tanggal</b></label>
                                    <input type="text" class="form-control" id="tanggal" readonly>
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label><b>Pemberi Vaksin</b></label>
                                    <input type="text" class="form-control" id="nama" readonly>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label><b>Lokasi Vaksin</b></label>
                            <input type="text" class="form-control" id="lokasi" readonly>
                        </div>
                    </form>
                    </div>
                </div>
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                @if($user == 4)
                <form method="post" id="id" name="id">@csrf @method('PUT')<button type="submit" class="btn btn-primary">Validasi</button></form>
                @endif
            </div>
            </div>
        </div>
    </div>
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Validasi Data Imunisasi</h1>
    @include('form.alert')
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Data Imunisasi Siswa</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Nama</th>
                            <th>Sekolah</th>
                            <th>Vaksin</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Tanggal</th>
                            <th>Nama</th>
                            <th>Sekolah</th>
                            <th>Vaksin</th>
                            <th>Aksi</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach($imunisasi as $unit)
                        <tr>
                            <td>{{ $unit->tanggal }}</td>
                            <td>{{ $unit->getUser->nama }}</td>
                            <td>{{ $unit->getSekolah[0]->nama }}</td>
                            <td>Dosis {{$unit->dosis}}: {{ $unit->vaksin }} (ID Batch: {{$unit->nomor}})</td>
                            <td><button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#lihat" 
                            data-vaksin="Dosis {{$unit->dosis}}: {{ $unit->vaksin }} (ID Batch: {{$unit->nomor}})" 
                            data-tanggal="{{$unit->tanggal}}" data-nama="{{$unit->nama}}" data-siswa="{{$unit->getUser->nama}}"
                            data-sekolah="{{$unit->getSekolah[0]->nama}}" data-lokasi="{{$unit->lokasi}}"
                            data-bukti="{{$unit->bukti}}" data-id="{{route('imunisasi.validasi', [$unit->id_user])}}">Lihat</button></td>
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
    var siswa = button.data('siswa')
    var sekolah = button.data('sekolah')
    var vaksin = button.data('vaksin')
    var tanggal = button.data('tanggal') 
    var nama = button.data('nama')
    var lokasi = button.data('lokasi')
    var bukti = button.data('bukti')
    var id = button.data('id')
    
    // Update isi modal
    var modal = $(this)
    modal.find('#namaSiswa').val(siswa)
    modal.find('#sekolah').val(sekolah)
    modal.find('#vaksin').val(vaksin)
    modal.find('#tanggal').val(tanggal)
    modal.find('#nama').val(nama)
    modal.find('#lokasi').val(lokasi)
    $("#bukti").attr("src", bukti)
    $("#id").attr("action", id)
    
})

</script>
@endsection