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
<!-- Modal -->
<div class="modal fade" id="importModal" tabindex="-1" aria-labelledby="importModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <form id="form-import-input" action="{{route('formulir.pertanyaan.import')}}" enctype="multipart/form-data" method="POST">
        @csrf
        <div class="modal-header">
            <h5 class="modal-title" id="importModalLabel">Import Input Data</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body" id="importModalBody">
            <div class="input-group mb-3">
                <div class="custom-file">
                    <input type="file" name="file" class="custom-file-input" id="inputGroupFile" onchange="document.getElementById('form-import-input').submit()">
                    <label class="custom-file-label" for="inputGroupFile">Pilih file</label>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
        </form>
        </div>
    </div>
</div>
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
                    <button type="button" class="btn btn-sm btn-success" data-toggle="modal" data-target="#importModal">
                    Import
                    </button>
                    <form class="d-inline-block" method="POST" action='{{ route("formulir.pertanyaan.download") }}'  onsubmit="return downloadFiltered(event,this)">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-primary" >
                        Download
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <div class="card-body">
            <form action="#" id="filter-form">
                <div class="row">
                    <div class="col-sm-4 col-md-3">
                        <select class="form-control" required name="formulir" required onchange="filterFormulirOnChange(this)" data-size='7'>
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
                    <div class="col-sm-4 col-md-4" style="padding-left:0; padding-right:0;">
                        <select class="form-control" required name="sekolah" onchange="setState('sekolah',this.value,true)">
                            <option value="" disabled selected>Sekolah</option>
                        </select>
                    </div>
                    <div class="col-sm-4 col-md-2">
                        <select class="form-control" name="kelas" onchange="setState('kelas',this.value,true)">
                            <option value="" disabled selected>Kelas</option>
                        </select>
                    </div>
                    <div class="col-sm-4 col-md-2" id="pertanyaan-container" style="padding-left:0; padding-right:0;">
                        <select class="form-control" required name="pertanyaan" id="multiple-checkboxes" multiple="multiple">
                        </select>
                    </div>
                    <div class="col-sm-4 col-md-1">
                        <button type="submit" class="btn btn-success" style="width:100%;">Filter</button>
                    </div>
                </div>
            </form>
            
        </div>
    </div>
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="filteredTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th >NIK</th>
                            <th >Nama</th>
                            <th >Kelas</th>
                            <th >Tanggal</th>
                            <th width="200px">
                                <select class="" name="status" multiple onchange="statusFilterChanged(this)">
                                    <option value="Belum Mengisi" >Belum Mengisi</option>
                                    <option value="Tervalidasi Puskesmas" >Tervalidasi Puskesmas</option>
                                    <option value="Dirujuk" >Dirujuk</option>
                                    <option value="Sudah Dirujuk" >Sudah Dirujuk</option>
                                    <option value="Tervalidasi Sekolah" >Tervalidasi Sekolah</option>
                                    <option value="Belum Tervalidasi Sekolah" >Belum Tervalidasi Sekolah</option>
                                </select>
                            </th>
                            @if(Auth::user()->id_role!='Puskesmas')
                            <th width="0" >Aksi</th>
                            @endif
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th >NIK</th>
                            <th>Nama</th>
                            <th>Kelas</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                            @if(Auth::user()->id_role!='Puskesmas')
                            <th>Aksi</th>
                            @endif
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
                    str3+=`<option value="${e2.id}_${e2.pertanyaan}">${e2.pertanyaan}</option>`;
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
        buttonClass: 'form-control',
        buttonWidth: '100%',
        enableResetButton: false,
        enableFiltering: false,
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

var table;

const statusFilterChanged=function(self){
    $self=$(self);
    searchStr=$self.val().join('|')
    table.column(4).search( searchStr , true, false).draw();
}

const onImportData = async function(e,self){
    var $this = $(self);

}

const downloadFiltered= async function(e, self){
    // e.preventDefault();
    const $form = $(self);
    $('#loading').modal('show');

    if($form[0].checkValidity() === false){
        myAlert('Form Filter belum terisi sempurna, mohon dicek kembali','danger');
        
        setTimeout(() => {
            $('#loading').modal('hide');
        }, 1000);

        e.preventDefault();
        return false;
    }

    var col = table.columns([0,1],{search:'applied'}).data();

    if(col[0].length===0){
        myAlert('Daftar Siswa Kosong','danger');
        
        setTimeout(() => {
            $('#loading').modal('hide');
        }, 1000);

        e.preventDefault();
        return false;
    }

    var data = [col[0],col[1]]
    data = Object.assign({data:data}, state);
    
    for (const key in data) {
        var input = document.createElement("input");
        input.type = "hidden";
        input.name = key;
        input.value = JSON.stringify(data[key]);
        $form.append(input);
    }

    // var coba={};
    // var cos=0;
    // for ( var key in data ) {
    //     var cur,k,stack=[],sKey=[];
    //     cur=data[key];
    //     k=0;
    //     do {
    //         if(typeof cur === 'text' && stack.length===0){
    //             // var input = document.createElement("input");
    //             // input.type = "hidden";
    //             // input.name = key;
    //             // input.value = cur;
    //             // $form.appendChild(input);
    //             cur[key]=cur;
    //         }else if(typeof cur === 'object'){
    //             stack.push(cur)
    //             console.log('cur sdsd',cur);
    //             console.log('stack aye',stack,stack[stack.length-1]);
    //             console.log('nooo',stack[stack.length-1],stack.length);
    //             cur=stack[stack.length-1][k]; //ambil indeks pertama
    //             console.log('cur aye',cur);
    //             sKey.push(k);
    //             k=0;
    //             // if(sKey.length>1) sKey[sKey.length-2]+=1;
    //         }else{
    //             // var input = document.createElement("input");
    //             // input.type = "hidden";
    //             // input.name = key;
    //             // input.value = cur[key];
    //             // $form.appendChild(input);
    //             var pathKey= sKey.length>1? key+'['+sKey.slice(1).join('][')+']['+k+']': key+'['+k+']';
    //             console.log('skey2',sKey);
    //             console.log('stack2',stack);
    //             // return false;
    //             coba[pathKey]=cur;
    //             k+=1;
    //             if(k < stack[stack.length-1].length){
    //                 cur=stack[stack.length-1][k];
    //             }else{
    //                 k=sKey.pop()+1;
    //                 console.log('mau kosong',stack.length,Math.min(2, stack.length));
                    
    //                 for (let j = 0; j < Math.min(2, stack.length); j++) {
    //                     console.log('cnt',j);
    //                     cur=stack.pop();
    //                     console.log('cur new new',stack,k,cur);
    //                 }

    //                 console.log('kosong',cur);
    //                 console.log('coba',coba);
                    

    //                 cos++;
    //                 if(cos===2) return false;
    //             }
    //             console.log('coba',coba);
    //             console.log('cur new',cur);
                
    //         } 
    //     } while (stack.length);
        
    // }

    

    setTimeout(() => {
        $('#loading').modal('hide');
    }, 2000);
}

$(document).ready(function() {  

    //regenerate tabelnya
    var data=sessionStorage.getItem('filtered');
    table = $('#filteredTable').DataTable({
        stateSave: true,
        data: data?JSON.parse(data):[],
        "columns": [
            {"visible": false},
            null,
            null,
            null,
            { "orderable": false },
            { "searchable": false }
        ]
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
    $('select[name=status]').select2({
        width: '100%',
        placeholder: "Status",
    });
    table.column(4).search( '' , true, false).draw();
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
                    e.username,
                    e.nama,
                    e.kelas,
                    e.jawabans.length === 0 ? '-' : e.jawabans[0].updated_at ,
                    badge,
                    @if(Auth::user()->id_role==4)
                    `<a href="{{url('/data-skrining')}}/${id_formulir}/${e.id}" class="btn btn-sm btn-warning"><i class="fas fa-fw fa-pen"></i></button></td>`
                    @else
                    `<a href="{{url('/data-siswa')}}/${e.id}" class="btn btn-sm btn-primary"><i class="fas fa-fw fa-eye"></i></button></td>`
                    @endif
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