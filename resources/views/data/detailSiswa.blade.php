@extends('layouts.layout')
@extends('layouts.sidebar')

@section('title')
Detail Siswa
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
    <h1 class="h3 mb-2 text-gray-800">Detail Data Siswa</h1>
    <div class="card shadow">
        <div class="card-header bg-primary mb-3">
            <div class="row p-4 justify-content-between align-items-center">
                <div class="col-12 col-lg-auto mb-5 mb-lg-0 text-center text-lg-left">
                    <i class="fas fa-laugh-wink text-light mb-3" style="font-size:50px;"></i>
                    <h5 class="text-light">e-Ning Tasiah</h5>
                </div>
                <div class="col-12 col-lg-auto text-center text-lg-right">
                    <h5 class="card-title text-light mb-3"><b>{{ $siswa->nama }}</b></h5>
                    <h6 class="card-subtitle text-gray-300 mb-2">NIK {{ $siswa->username }}</h6>
                    
                </div>
            </div>
        </div>
        <div class="card-body">
            @foreach ($allJawaban as $key => $jawaban)
            <div class="card shadow mb-4">
                <!-- Card Header - Accordion -->
                <a href="#collapse-card-{{$key}}" class="d-block card-header py-3" data-toggle="collapse"
                    role="button" aria-expanded="false" aria-controls="collapse-card-{{$key}}">
                    <h6 class="m-0 font-weight-bold text-primary">{{$jawaban->getSekolah->nama}} | Tahun Ajaran {{ $siswa->tahun_ajaran }} 
                    @if($jawaban->validasi_puskesmas===1)
                    <div class="badge bg-success text-white rounded-pill">Tervalidasi Puskesmas</div>
                    @elseif($jawaban->validasi_puskesmas===-1)
                    <div class="badge bg-info text-white rounded-pill">Dirujuk</div>
                    @elseif($jawaban->validasi_puskesmas===2)
                    <div class="badge bg-success text-white rounded-pill">Sudah Dirujuk</div>
                    @elseif($jawaban->validasi_sekolah===1)
                    <div class="badge bg-success text-white rounded-pill">Tervalidasi Sekolah</div>
                    @elseif($jawaban->validasi_sekolah===0)
                    <div class="badge bg-warning text-white rounded-pill">Belum Tervalidasi Sekolah</div>
                    @endif
                    </h6>
                </a>
                @php
                    $formulir = $jawaban->getFormulir;
                    $formId = $formulir->id;
                    $allPertanyaan = $formulir->pertanyaan;
                @endphp
                <!-- Card Content - Collapse -->
                <div class="collapse" id="collapse-card-{{$key}}">
                @foreach ($allPertanyaan as $key => $ap)
                @php
                    $json = json_decode($ap->json);
                @endphp
                    <div class="card-body">
                        <h6 class="card-subtitle mb-3"><b>{{ $ap->judul }}</b></h6>
                        @foreach ($json->pertanyaan as $p)
                            @if ($p->tipe === 1)
                                <div class="row" style="padding-top:20px">
                                    <div class="col-12 col-md-5" style="margin-bottom:5px">
                                        {{ $p->pertanyaan }}
                                    </div>
                                    <div class="col-12 col-md-7" style="padding:0">
                                        <div class="row" style="margin:0px">
                                            <input type="hidden" name="{{ $formId.$p->id }}" value="" /> 
                                            @foreach ($p->opsi as $index => $o)
                                            <label class="radio-inline col-6 col-md-4">
                                                <input class="invalid" type="radio" name="{{ $formId.$p->id }}" id="{{ $formId.$p->id.'__'.$index }}" value="{{ $o }}"> {{ $o }}
                                            </label>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @elseif ($p->tipe === 2)
                                <div class="row" style="padding-top:20px">
                                    <div class="col-12 col-md-5" style="margin-bottom:5px">
                                        {{ $p->pertanyaan }}
                                    </div>
                                    <div class="col-12 col-md-7">
                                        <div class="input-group">
                                            <input type="text" class="form-control invalid" placeholder="" name="{{ $formId.$p->id }}" value="Belum mengisi">
                                            @if (isset($p->suffix))
                                                <div class="input-group-append">
                                                    <div class="input-group-text" >{{ $p->suffix }}</div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @elseif ($p->tipe === 3)
                                <div class="row" style="padding-top:30px" id="98s7dfy-container">
                                    <div class="col-12 col-md-5" style="margin-bottom:5px">
                                        {{ $p->pertanyaan }}
                                    </div>
                                    <div class="col-12 col-md-7" style="padding:0">
                                        <div class="row" style="margin:0px">
                                            @foreach ($p->opsi as $index => $o)
                                                <input type="hidden" name="{{ $formId.$p->id }}" value="" /> 
                                                @if (is_object($o))
                                                    <label class="radio-inline col-6 col-md-4">
                                                        <input class="invalid" type="radio" name="{{$formId.$p->id }}" id="{{$formId.$p->id.'__'.$index }}" value="{{ $o->{'0'} }}"> {{ $o->{'0'} }}
                                                    </label>
                                                @else
                                                    <label class="radio-inline col-6 col-md-4">
                                                        <input class="invalid" type="radio" name="{{$formId.$p->id }}" id="{{$formId.$p->id.'__'.$index }}" value="{{ $o }}"> {{ $o }}
                                                    </label>
                                                @endif
                                            @endforeach
                                            @foreach ($p->opsi as $index => $o)
                                                @if (is_object($o) and $o->{'if-selected'}->tipe === 2 )
                                                    <div class="col-12 collapse" style="flex:1" id="{{ $formId.$o->{'if-selected'}->id }}-container">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control invalid" name="{{$formId.$o->{'if-selected'}->id }}" id="{{$formId.$o->{'if-selected'}->id }}" placeholder="{{ $o->{'if-selected'}->pertanyaan }}" disabled>
                                                            @if (isset($o->{'if-selected'}->suffix))
                                                                <div class="input-group-append">
                                                                    <div class="input-group-text" >{{ $o->{'if-selected'}->suffix }}</div>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                @foreach ($p->opsi as $index => $o)
                                    @if (is_object($o) and $o->{'if-selected'}->tipe === 1 )
                                        <div class="row collapse" style="padding-top:20px" id="{{$formId.$o->{'if-selected'}->id }}-container">
                                            <div class="col-12 col-md-5" style="margin-bottom:5px">
                                                {{ $o->{'if-selected'}->pertanyaan }}
                                            </div>
                                            <div class="col-12 col-md-7" style="padding:0">
                                                <div class="row" style="margin:0px">
                                                    @foreach ($o->{'if-selected'}->opsi as $index2 => $o2)
                                                    <label class="radio-inline col-6 col-md-4">
                                                        <input class="invalid" type="radio" name="{{$formId.$o->{'if-selected'}->id }}" id="{{$formId.$o->{'if-selected'}->id.'__'.$index2 }}" value="{{ $o2 }}" > {{ $o2 }}
                                                    </label>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            @elseif ($p->tipe === 4)
                                <div class="row" style="padding-top:20px">
                                    <div class="col-12 col-md-5" style="margin-bottom:5px">
                                        {{ $p->pertanyaan }}
                                    </div>
                                    <div class="col-12 col-md-7">
                                        <div class="input-group">
                                        <input type="text" name="{{$formId.$p->id }}" id="{{$formId.$p->id }}" hidden readonly>
                                        <div class="input-group-append" id="{{$formId.$p->id }}-btn-container">
                                            <button id="{{$formId.$p->id }}-btn-upload" class="btn btn-outline-primary" type="button" onclick="myUpload('{{$formId.$p->id }}-file-dummy','{{$formId.$p->id }}')" hidden>Upload</button>
                                            <button id="{{$formId.$p->id }}-btn-loading" class="btn btn-outline-primary" hidden>
                                                <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                            </button>
                                            <a id="{{$formId.$p->id }}-btn-link" type="button" class="btn btn-outline-primary" onclick="" href="" target="_blank" hidden>
                                                Link
                                            </a>
                                            <button id="{{$formId.$p->id }}-btn-danger" type="button" class="btn btn-outline-danger" onclick="" hidden>
                                                Gagal
                                            </button>
                                            <p style="color:red;" id="{{$formId.$p->id }}-alert">Belum mengisi</p>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                        <hr>
                    </div>
                @endforeach
                </div>
            </div>
            @endforeach
        </div>
        
    </div>
</div>

@endsection


@section('script')
<script>
var myData = {}
var myTempData = {}

var myPertanyaanOnChange = function(id, value, formId=''){
    myTempData['selected'+id] = value;
    const keyAktif = 'additional'+id; //key pertanyaan tamabahan yg sedang aktif

    //jika ada pertanyaan tambahan yang masih terbuka maka harus ditutup
    if(myTempData[keyAktif]) { 
        myTempData[keyAktif].collapse('hide');
        myTempData[keyAktif].find(':input').prop('disabled', true);
        myTempData[keyAktif] = null;
    }

    //cek jika jawaban menimbulkan pertanyaan baru
    const keyNew = (id+value);
    if( keyNew in myData ) { 
        const idPertanyaanBaru = formId+myData[keyNew]['id'];
        const idContainer = idPertanyaanBaru+"-container";
        myTempData[keyAktif] = $('#'+idContainer );
        myTempData[keyAktif].find(':input').prop('disabled', false);
        myTempData[keyAktif].collapse('show');
    }
}

@foreach ($allJawaban as $key => $jawaban)
    @php
        $formulir = $jawaban->getFormulir;
        $formId = $formulir->id;
        $allPertanyaan = $formulir->pertanyaan;
    @endphp

    @foreach ($allPertanyaan as $key => $ap)
    @php
        $json = json_decode($ap->json);
    @endphp
    @foreach ($json->pertanyaan as $p)
    myData[@json($p->id)] = @json($p);
    @if ($p->tipe === 3)
        console.log('{{$formId.$p->id}}');
        $('input[name={{ $formId.$p->id }}]:radio').change(function(){
            myPertanyaanOnChange('{{$formId.$p->id}}', this.value, '{{$formId}}');
        });
        @foreach ($p->opsi as $index => $o)
        @if (is_object($o))
            myData["{{ $formId.$p->id.$o->{'0'} }}"] = @json($o->{'if-selected'});
        @endif
        @endforeach
    @endif
    @endforeach
    @endforeach 
@endforeach 

const myToggleButtonUpload = function(id, type){
    var button;
    const container = $('#'+id+'-btn-container');
    const active = container.find('button:not(button:hidden)');
    const alertInfo = $('#'+id+'-alert');
    alertInfo.attr('hidden',true);
    active.attr('disabled',true);
    active.attr('hidden',true);

    button = $('#'+id+'-btn-'+type);

    button.attr('disabled',false);
    button.attr('hidden',false);
}

$(document).ready(function () {
var jawabans;
var formId;
@foreach ($allJawaban as $key => $jawaban)
@php
    $formId = $jawaban->getFormulir->id;
@endphp
formId = @json($formId);
jawabans = @json(json_decode($jawaban->json));
console.log(jawabans);

for(var id in jawabans){
    var val = jawabans[id];
    if(!val.length) continue;
    var $jwb = $('input[name="'+formId+id+'"]').filter(':not([type=hidden])');
    var type = $jwb.attr('type');
    switch (type) {
        case 'text':
            $jwb.val(val);
            if(val.substr(0,4) === 'http'){ //jika berupa link file
                $('#'+formId+id+'-btn-link').attr('href',val);
                myToggleButtonUpload(formId+id,'link');
                $('#'+formId+id+'-file-dummy').next().text(val)
            }
            $jwb.removeClass('invalid');
            break;
        case 'radio':
            $jwb.removeClass('invalid')
            $jwb = $jwb.filter('[value="'+val+'"]')
            $jwb.prop("checked", true);
            myPertanyaanOnChange(formId+id, val, formId);    
            break;
    }
}
@endforeach

//menjadikan inputan siswa tidak bisa diubah-ubah admin
$('input[type="text"]').attr('readonly', true);
$('input[type="radio"]:not(:checked)').attr('disabled', true);
})
</script>
@endsection