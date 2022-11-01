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
                    <div class="form-group">
                        <label><b>Kelas</b></label>
                        <input type="text" id="kelas" name="kelas" class="form-control" placeholder="Kelas" required>
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
                <form id="formEdit" method="POST" action="{{route('siswa.edit')}}">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <input type="hidden" id="id" name="id">
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
                    <h5 class="text-center" id="peringatanKeluar"></h5>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tidak</button>
                    <button type="submit" class="btn btn-danger" onclick="$('#formKeluar').trigger('submit')">Ya</button>
                </div>
                <form id="formKeluar" method="POST"></form>
            </div>
        </div>
    </div>

    <!-- Modal Naik Kelas Siswa -->
    <div class="modal modal-danger fade" id="naik" tabindex="-1" role="dialog" aria-labelledby="Naik" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Naik Kelas Siswa</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h5 class="text-center" id="peringatanNaik"></h5>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tidak</button>
                    <button type="submit" class="btn btn-danger" onclick="$('#formNaik').trigger('submit')">Ya</button>
                </div>
                <form id="formNaik" method="POST"></form>
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
    
    <!-- DataTales -->
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
                    <!-- <button class="btn btn-sm btn-danger keluar" data-toggle="modal" data-target="#keluar"><i class="fas fa-fw fa-sign-out-alt" ></i> Keluarkan</button>
                    <button class="btn btn-sm btn-info naik" data-toggle="modal" data-target="#naik"><i class="fas fa-fw fa-sign-out-alt" ></i> Naik Kelas</button> -->
                </div>
                @endif
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="datatables" width="100%" cellspacing="0">
                    <thead>
                    </thead>
                    <tbody>
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
        // Lakukan cek pada tiap row
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

        // Jika user mengklik tombol keluarkan
        $('.keluar').on('click', function(e) {

            allVals = [];
            // Get id semua siswa di checked
            $(".sub_chk:checked").each(function() {
                allVals.push($(this).attr('data-id'));
            });

            // Jumlah siswa di checked
            var sum_siswa = allVals.length;
            var mainContainer = document.getElementById("peringatanKeluar");
            
            // Jika blm ada data siswa di checked
            if(allVals.length <=0){
                mainContainer.innerHTML = 'Pilih Siswa Terlebih Dahulu';
            }
            else{
                var join_selected_values = allVals.join(",");

                $('#jumlah').attr("value", sum_siswa);
                mainContainer.innerHTML = 'Yakin ingin mengeluarkan '+ sum_siswa + ' siswa ini dari Sekolah?';
            }
        });
        // Jika terjadi submit keluarkan
        $('#formKeluar').submit(async function(e){
            e.preventDefault();
            $('#keluar').modal('hide');
            $('#loading').modal('show');
            
            try {
                console.log(allVals);
                allVals.forEach(async unit =>{
                    const res = await myRequest.delete( '{{ route('siswa.keluar', ['id'=> '']) }}/'+unit)
                });
                myAlert('Siswa Berhasil Dikeluarkan Dari Sekolah','success');
            } catch(err) {
                myAlert(JSON.stringify(err['statusText']),'danger');
            }
            
            setTimeout(() => {
                $('#loading').modal('hide');
                location.reload(true);
            }, 1000);
        });

        $('.naik').on('click', function(e) {

            allVals = [];
            $(".sub_chk:checked").each(function() {
                allVals.push($(this).attr('data-id'));
            });
            var sum_siswa = allVals.length;
            var mainContainer = document.getElementById("peringatanNaik");

            if(allVals.length <=0){
                mainContainer.innerHTML = 'Pilih Siswa Terlebih Dahulu';
            }
            else{
                $('#jumlah').attr("value", sum_siswa);
                mainContainer.innerHTML = 'Yakin ingin membuat '+ sum_siswa + ' siswa ini naik kelas?';
            }
        });
        $('#formNaik').submit(async function(e){
            e.preventDefault();
            $('#naik').modal('hide');
            $('#loading').modal('show');

            try {
                // console.log(allVals);
                allVals.forEach(async unit =>{
                    const res = await myRequest.post( '{{ route('siswa.naik', ['id'=> '']) }}/'+unit,{_method:'PUT'});
                });
            } catch(err) {
                myAlert(JSON.stringify(err['statusText']),'danger');
            }
            
            setTimeout(() => {
                $('#loading').modal('hide');
                location.reload(true);
            }, 1000);    
        });

        oTable = $("#datatables").DataTable({
          bAutoWidth: false, 
          select:{
              className: 'dataTable-selector form-select'
          },
          responsive: true,
          processing: true,
          serverSide: true,
          ajax: {type: "POST", url: '{{route("siswa.data")}}', data:{'_token':@json(csrf_token())}},
          columns: [
              { data:'id', title:'ID', visible: false},
              { data:'nama', title:'Nama'},
              { data:'id_role', title:'ID Role', visible: false},
              { data:'username', title:'Username'},
              { data:'kelas', title:'Kelas'},
              { data:'tahun_ajaran', title:'Tahun Ajaran'},
              { data:'action', title:'Aksi'},
          ],
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

function edit(self){
    var tr = $(self).closest('tr');
    let idx = oTable.row(tr)[0]
    var data = oTable.data()[idx];
    
    var $modal = $('#editSiswa');
    $modal.find('#id').val(data['id'])
    $modal.find('#editUsername').val(data['username'])
    $modal.find('#editNama').val(data['nama'])
    $modal.find('#editKelas').val(data['kelas'])
    // $("#formEdit").attr("action", rute)

    $modal.modal('show');
}

// $('#editSiswa').on('show.bs.modal', function (event) {
//     // Button utk trigger kirim data ke modal
//     var button = $(event.relatedTarget)
    
//     // Ekstrak data dari atribut data-
//     var rute = button.data('rute')
//     var semua = button.data('semua')

//     // Update isi modal
//     // var modal = $(this)
//     modal.find('#editUsername').val(semua.username)
//     modal.find('#editNama').val(semua.nama)
//     modal.find('#editKelas').val(semua.kelas)
//     $("#formEdit").attr("action", rute)
// })

</script>
@endsection