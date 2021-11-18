@extends('layouts.layout')
@extends('layouts.sidebar')

@php
$role= Auth::user()->getRole->role;
@endphp

@section('title')
Data Siswa
@endsection

@section('siswaStatus')
active
@endsection

@section('showMaster')
show
@endsection

@section('header')
Validasi
@endsection

@section('content')


<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Data Siswa</h1>

    @include('form.alert')
    <!-- Modal Tambah Siswa -->
    <div class="modal modal-danger fade" id="tambahSiswa" tabindex="-1" role="dialog" aria-labelledby="Tambah Siswa" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Siswa</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{route('data-siswa.tambah')}}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label><b>Username(NIK)</b></label>
                        <input type="text" id="username" name="username" class="form-control" placeholder="Username(NIK)" maxlength="16" required>
                    </div>
                    <div class="form-group">
                        <label><b>Nama</b></label>
                        <input type="text" id="nama" name="nama" class="form-control" placeholder="Nama" required>
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

    <!-- Modal Edit Siswa -->
    <div class="modal modal-danger fade" id="editSiswa" tabindex="-1" role="dialog" aria-labelledby="Edit Siswa" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Data Siswa</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="formEdit" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <label><b>Username(NIK)</b></label>
                        <input type="text" id="editUsername" name="editUsername" class="form-control" placeholder="Username(NIK)" maxlength="16" required>
                    </div>
                    <div class="form-group">
                        <label><b>Nama</b></label>
                        <input type="text" id="editNama" name="editNama" class="form-control" placeholder="Nama" required>
                    </div>
                    <div class="form-group">
                        <label><b>Kelas</b></label>
                        <input type="text" id="editKelas" name="editKelas" class="form-control" placeholder="Kelas" required>
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

    <!-- Modal Keluarkan Siswa -->
    <div class="modal modal-danger fade" id="keluar" tabindex="-1" role="dialog" aria-labelledby="Delete" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Keluarkan Siswa</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h5 class="text-center" id="peringatan"></h5>
                </div>
                <form id="formKeluar" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tidak</button>
                        <button type="submit" class="btn btn-danger" onclick="$('#formKeluar').trigger('submit')">Ya</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Reset Password Siswa -->
    <div class="modal modal-danger fade" id="detail" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Siswa</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                <form id="resetPass" method="POST">
                    @csrf
                    @method('POST')
                    <h5 class="text-center">Yakin ingin me-<i>reset</i> Password Siswa?</h5>
                    <p class="text-center">Siswa dapat login menggunakan password berupa NIK.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-danger">Reset Password</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="row">
                <div class="col">
                    <h6 class="m-0 font-weight-bold text-primary">Data Siswa</h6>
                </div>
                @if($role=='Sekolah')
                <div class="col text-right">
                    <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#tambahSiswa">
                    Tambah
                    </button>
                    <a href="{{route('data-siswa.import')}}" type="button" class="btn btn-sm btn-success">Import</a>
                    <button class="btn btn-sm btn-danger keluar" data-toggle="modal" data-target="#keluar"><i class="fas fa-fw fa-sign-out-alt" ></i> Keluarkan</button>
                </div>
                @endif
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>NIK</th>
                            <th>Nama</th>
                            <th>Sekolah</th>
                            <th>Kelas</th>
                            <th>Aksi</th>
                            @if($role=='Sekolah')
                            <th><input type="checkbox" class="master"></th>
                            @endif
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>NIK</th>
                            <th>Nama</th>
                            <th>Sekolah</th>
                            <th>Kelas</th>
                            <th>Aksi</th>
                            @if($role=='Sekolah')
                            <th><input type="checkbox" class="master"></th>
                            @endif
                        </tr>
                    </tfoot>
                    <tbody>
                        
                        @foreach($dataSiswa as $unit)
                        <tr>
                            <td>{{ $unit->username }}</td>
                            <td>{{ $unit->nama }}</td>
                            <td>{{ $unit->getSekolah->isEmpty()?'-':$unit->getSekolah[0]->nama }}</td>
                            <td>{{ $unit->kelas }}</td>
                            <td><a href="{{url('/data-siswa/'.$unit->id)}}" class="btn btn-sm btn-primary" data-toggle="tooltip" data-placement="top" title="Lihat Detail Siswa"><i class="fas fa-fw fa-eye"></i></a>
                                @if($role==='Sekolah')
                                <button class="btn btn-sm btn-secondary" id="btnEdit" data-toggle="modal" data-target="#editSiswa" data-rute="{{ route('siswa.edit', [$unit->id]) }}" 
                                    data-semua="{{$unit}}" data-toggle="tooltip" data-placement="top" title="Edit Data Siswa"><i class="fas fa-fw fa-edit" ></i></button>
                                <button class="btn btn-sm btn-warning" id="btnReset" data-toggle="modal" data-target="#detail" data-rute="{{ route('admin.resetpassword', [$unit->id]) }}" 
                                    data-toggle="tooltip" data-placement="top" title="Ganti Password"><i class="fas fa-fw fa-key" ></i></button>
                                @endif
                            </td>
                            @if($role=='Sekolah')
                            <td><input type="checkbox" class="sub_chk" data-id="{{$unit->id}}"></td>
                            @endif
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
<script type="text/javascript">
    $(document).ready(function () {

        $('.master').on('click', function(e) {
         
         if($(this).is(':checked',true)){
            $(".sub_chk").prop('checked', true);
            $(".master").prop('checked', true);
         } 
         else {
            $(".sub_chk").prop('checked',false);
            $(".master").prop('checked', false);
         }
        });
        var allVals = [];
        $('.keluar').on('click', function(e) {

            allVals = [];
            $(".sub_chk:checked").each(function() {
                allVals.push($(this).attr('data-id'));
            });
            var sum_siswa = allVals.length;
            var mainContainer = document.getElementById("peringatan");
            
            if(allVals.length <=0){
                mainContainer.innerHTML = 'Pilih Siswa Terlebih Dahulu';
            }
            else{
                var join_selected_values = allVals.join(",");

                $('#jumlah').attr("value", sum_siswa);
                mainContainer.innerHTML = 'Yakin ingin mengeluarkan '+ sum_siswa + ' siswa ini dari Sekolah?';
            }
            
        });
        $('#formKeluar').submit(async function(e){
            e.preventDefault();
            $('#keluar').modal('hide');
            $('#loading').modal('show');
            
            try {
                console.log(allVals);
                allVals.forEach(async unit =>{
                    const res = await myRequest.delete( '{{ route('siswa.keluar', ['id'=> '']) }}/'+unit)
                    console.log(unit);
                });
                location.reload(true);
            } catch(err) {
                myAlert(JSON.stringify(err['statusText']),'danger');
            }

            setTimeout(() => {
                $('#loading').modal('hide');
            }, 1000);
        });
    });
</script>
<script>
$('#detail').on('show.bs.modal', function (event) {
    // Button utk trigger kirim data ke modal
    var button = $(event.relatedTarget)
    
    // Ekstrak data dari atribut data-
    var rute = button.data('rute')

    // Update isi modal
    var modal = $(this)
    $("#resetPass").attr("action", rute)
    
})

$('#editSiswa').on('show.bs.modal', function (event) {
    // Button utk trigger kirim data ke modal
    var button = $(event.relatedTarget)
    
    // Ekstrak data dari atribut data-
    var rute = button.data('rute')
    var semua = button.data('semua')

    // Update isi modal
    var modal = $(this)
    modal.find('#editUsername').val(semua.username)
    modal.find('#editNama').val(semua.nama)
    modal.find('#editKelas').val(semua.kelas)
    $("#formEdit").attr("action", rute)
})

</script>
@endsection