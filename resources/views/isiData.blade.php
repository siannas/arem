@extends('layouts.layout')
@extends('layouts.sidebar')

@section('title')
Validasi Data
@endsection

@section('isiDataStatus')
active
@endsection

@section('showSkrining')
show
@endsection

@section('header')
Validasi
@endsection

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Data Skrining</h1>
    @include('form.alert')
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="row">
                <div class="col">
                    <h6 class="m-0 font-weight-bold text-primary">Data Skrining Siswa</h6>        
                </div>
                <div class="col text-right">
                    <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#tambahSiswa">
                    Import
                    </button>
                    <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#tambahSiswa">
                    Download
                    </button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <form action="#" class="mb-4" id="filter-form">
                <div class="row">
                    <div class="col-sm-4 col-md-3 my-1">
                        <select class="form-control" required name="formulir" required onchange="filterFormulirOnChange(this)">
                            <option value="" disabled selected>Formulir</option>
                            @foreach($formulir as $f)
                                @if($f->kelas[0]==='1')
                                <option value="{{$f->id}}_1">SD/MI {{$f->tahun_ajaran}}</option>
                                @else
                                <option value="{{$f->id}}_7">SMP/SMA/SMK {{$f->tahun_ajaran}}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-4 col-md-3 my-1">
                        <select class="form-control" required name="sekolah" onchange="setState('sekolah',this.value,true)" required>
                            <option value="" disabled selected>Sekolah</option>
                        </select>
                    </div>
                    <div class="col-sm-4 col-md-2 my-1">
                        <select class="form-control" name="kelas" onchange="setState('kelas',this.value,true)">
                            <option value="" disabled selected>Kelas</option>
                        </select>
                    </div>
                    <div class="col-sm-4 col-md-2 my-1" id="pertanyaan-container">
                        <select class="form-control" required name="pertanyaan" id="multiple-checkboxes" multiple="multiple">
                        </select>
                    </div>
                </div>
                <button type="submit" class="btn btn-sm btn-success my-1">
                    Filter
                </button>
            </form>
            <div class="table-responsive">
                <table class="table table-bordered" id="filteredTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <!-- <th>Sekolah</th> -->
                            <th>Kelas</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Nama</th>
                            <!-- <th>Sekolah</th> -->
                            <th>Kelas</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </tfoot>
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
const sd = @json($sd);
const smpsma = @json($smpsma);
const str_kelas_sd = '<option value="" disabled selected>Pilih Kelas</option><option value="all">Semua Kelas</option><option value="1">Kelas 1</option><option value="2">Kelas 2</option><option value="3">Kelas 3</option><option value="4">Kelas 4</option><option value="5">Kelas 5</option><option value="6">Kelas 6</option>';
const str_kelas_smp_sma = '<option value="" disabled selected>Pilih Kelas</option><option value="all">Semua Kelas</option><option value="7">Kelas 7</option><option value="8">Kelas 8</option><option value="9">Kelas 9</option><option value="10">Kelas 10</option><option value="11">Kelas 11</option><option value="12">Kelas 12</option>';

//simple state alike
var state={};
const setState=function(key, value, saveToSS=false){
    state[key]=value;
    if(saveToSS) sessionStorage.setItem('state_/isi-data', JSON.stringify(state));
}

const filterFormulirOnChange = async function(e){
    $('#loading').modal('show');
    var val = e.value.split('_') //ambil [tahun, kelas]
    var str = '<option value="" disabled selected>Sekolah</option>';
    
    var dt;
    if(val[1]==='1'){ //sd
        dt=sd;
        $('select[name=kelas]').empty().html(str_kelas_sd);
    }else{ //smp sma
        dt=smpsma;
        $('select[name=kelas]').empty().html(str_kelas_smp_sma);
    }
    dt.forEach(e => {
        str+=`<option value="${e.id}_${e.kelas}">${e.nama}</option>`;
    });
    $('select[name=sekolah]').empty().html(str);

    // ambil daftar pertanyaan dan set ke multiple select pertanyaan
    try {
        var str3='';
        var j;
        const res = await myRequest.get( '{{ route("formulir.pertanyaan", [""]) }}'+'/'+val[0] )
        res.forEach(e => {
            j=JSON.parse(e.json).pertanyaan;
            j.forEach(e2 => {
                if('diisi-petugas' in e2 && e2.tipe===2){
                    str3+=`<option value="${e2.id}">${e2.pertanyaan}</option>`;
                }
            })
        });
        pertanyaanMultipleSelect(str3)
    } catch(err) {
        myAlert(JSON.stringify(err['statusText']),'danger');
    }

    //data form state reset
    state={};
    setState('formulir', $('select[name=formulir]')[0].value, true);

    //reset dropdown pertanyaan ke semula
    var $form = $('#filter-form').clone();
    var $pertanyaan=$form.find('#multiple-checkboxes').clone();
    $form.find('#pertanyaan-container').empty().append($pertanyaan);
    sessionStorage.setItem('filtered-form', $form[0].innerHTML);

    setTimeout(() => {
        $('#loading').modal('hide');
    }, 1000);
}

function pertanyaanMultipleSelect(str_html=null){
    if(str_html) $('#multiple-checkboxes').html(str_html);
    $('#multiple-checkboxes').multiselect('destroy').multiselect({
        buttonClass: 'btn btn-outline-secondary',
        enableResetButton: true,
        enableFiltering: true,
        includeSelectAllOption: true,
        buttonText: function(options, select) {
            setState('pertanyaan',select.val(),true);
            if (options.length === 0) {
                return 'Pilih Pertanyaan';
            }
            else{
                return options.length+' Pertanyaan';
            }
        }
    });
}

$(document).ready(function() {  

    //regenerate tabelnya
    var data=sessionStorage.getItem('filtered');
    var table = $('#filteredTable').DataTable({
        stateSave: true,
        data: data?JSON.parse(data):[]
    });

    //masukin inputan form sebelumnya
    if(sessionStorage.hasOwnProperty('filtered-form')){
        $('#filter-form').html(sessionStorage.getItem('filtered-form'));
        state=JSON.parse(sessionStorage.getItem('state_/isi-data'));
        $('#multiple-checkboxes').val(state['pertanyaan']);
        $('select[name=formulir]').val(state['formulir']);
        $('select[name=sekolah]').val(state['sekolah']);
        if('kelas' in state) $('select[name=kelas]').val(state['kelas']);
    }
    pertanyaanMultipleSelect();

    //saat tombol filter ditekan
    $('#filter-form').submit(async function(e){
        $('#loading').modal('show');
        e.preventDefault();
        var obj = $(this);
        var all= {};
        $.each(obj, function(i, val) {
            Object.assign(all,getFormData($(val)));
        });
        
        try {
            const res = await myRequest.post( '{{ route("formulir.pertanyaan.filtered") }}', all);
            var str='';
            var badge='';
            var new_res=[];
            const id_formulir=all['formulir'].split('_')[0];
            
            res.forEach(e => {
                if(e.jawabans.length === 0){
                    badge='<div class="badge bg-danger text-white rounded-pill">Belum Mengisi</div>';
                }else if(e.jawabans[0].validasi_puskesmas===1){
                    badge='<div class="badge bg-success text-white rounded-pill">Tervalidasi Puskesmas</div>';
                }else if(e.jawabans[0].validasi_puskesmas===-1){
                    badge='<div class="badge bg-info text-white rounded-pill">Dirujuk</div>';
                }else if(e.jawabans[0].validasi_puskesmas===2){
                    badge='<div class="badge bg-success text-white rounded-pill">Sudah Dirujuk</div>';
                }else if(e.jawabans[0].validasi_sekolah===1){
                    badge='<div class="badge bg-success text-white rounded-pill">Tervalidasi Sekolah</div>';
                }else if(e.jawabans[0].validasi_sekolah===0){
                    badge='<div class="badge bg-warning text-white rounded-pill">Belum Tervalidasi Sekolah</div>';
                }

                new_res.push([
                    e.nama,
                    e.kelas,
                    e.jawabans.length === 0 ? '-' : e.jawabans[0].updated_at ,
                    badge,
                    `<a href="{{url('/isi-data')}}/${id_formulir}/${e.id}" class="btn btn-sm btn-warning"><i class="fas fa-fw fa-pen"></i></button></td>`
                ]);
            });
            table.clear();
            table.rows.add( new_res ).draw();
            sessionStorage.setItem('filtered', JSON.stringify(new_res));

        } catch(err) {
            myAlert(JSON.stringify(err['statusText']),'danger');
        }

        setTimeout(() => {
            $('#loading').modal('hide');
        }, 1000);
    })
});  
</script>  
@endsection