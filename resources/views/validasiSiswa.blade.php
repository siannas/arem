@extends('layouts.layout')
@extends('layouts.sidebar')

@section('title')
Detail Siswa
@endsection

@section('validasiStatus')
active
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
                    <h5 class="text-light">Aplikasi Remaja</h5>
                </div>
                <div class="col-12 col-lg-auto text-center text-lg-right">
                    <h5 class="card-title text-light mb-3"><b>{{ $siswa->nama }}</b></h5>
                    <h6 class="card-subtitle text-gray-300 mb-2">NIK {{ $siswa->username }}</h6>
                    <h6 class="card-subtitle text-gray-300">Tahun Ajaran {{ $siswa->tahun_ajaran }}</h6>
                </div>
            </div>
        </div>
        <div class="card-body row">
        @foreach ($allPertanyaan as $key => $ap)
        @php
            $json = json_decode($ap->json);
        @endphp
        <form action="#" class="col-lg-12" id="form-{{$key}}">

            <!-- Basic Card Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">{{ $ap->judul }}</h6>
                </div>
                <div class="card-body">
                    @foreach ($json->pertanyaan as $p)
                        @if ($p->tipe === 1)
                            <div class="row" style="padding-top:20px">
                                <div class="col-12 col-md-5" style="margin-bottom:5px">
                                    {{ $p->pertanyaan }}
                                </div>
                                <div class="col-12 col-md-7" style="padding:0">
                                    <div class="row" style="margin:0px">
                                        <input type="hidden" name="{{ $p->id }}" value="" /> 
                                        @foreach ($p->opsi as $index => $o)
                                        <label class="radio-inline col-6 col-md-4">
                                            <input class="invalid" type="radio" name="{{ $p->id }}" id="{{ $p->id.'__'.$index }}" value="{{ $o }}"> {{ $o }}
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
                                        <input type="text" class="form-control invalid" placeholder="" name="{{ $p->id }}" value="Belum mengisi">
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
                                            <input type="hidden" name="{{ $p->id }}" value="" /> 
                                            @if (is_object($o))
                                                <label class="radio-inline col-6 col-md-4">
                                                    <input class="invalid" type="radio" name="{{ $p->id }}" id="{{ $p->id.'__'.$index }}" value="{{ $o->{'0'} }}"> {{ $o->{'0'} }}
                                                </label>
                                            @else
                                                <label class="radio-inline col-6 col-md-4">
                                                    <input class="invalid" type="radio" name="{{ $p->id }}" id="{{ $p->id.'__'.$index }}" value="{{ $o }}"> {{ $o }}
                                                </label>
                                            @endif
                                        @endforeach
                                        @foreach ($p->opsi as $index => $o)
                                            @if (is_object($o) and $o->{'if-selected'}->tipe === 2 )
                                                <div class="col-12 collapse" style="flex:1" id="{{ $o->{'if-selected'}->id }}-container">
                                                    <div class="input-group">
                                                        <input type="text" class="form-control invalid" name="{{ $o->{'if-selected'}->id }}" id="{{ $o->{'if-selected'}->id }}" placeholder="{{ $o->{'if-selected'}->pertanyaan }}" disabled>
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
                                    <div class="row collapse" style="padding-top:20px" id="{{ $o->{'if-selected'}->id }}-container">
                                        <div class="col-12 col-md-5" style="margin-bottom:5px">
                                            {{ $o->{'if-selected'}->pertanyaan }}
                                        </div>
                                        <div class="col-12 col-md-7" style="padding:0">
                                            <div class="row" style="margin:0px">
                                                @foreach ($o->{'if-selected'}->opsi as $index2 => $o2)
                                                <label class="radio-inline col-6 col-md-4">
                                                    <input class="invalid" type="radio" name="{{ $o->{'if-selected'}->id }}" id="{{ $o->{'if-selected'}->id.'__'.$index2 }}" value="{{ $o2 }}" > {{ $o2 }}
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
                                    <input type="text" name="{{ $p->id }}" id="{{ $p->id }}" hidden readonly>
                                    <div class="input-group-append" id="{{ $p->id }}-btn-container">
                                        <button id="{{ $p->id }}-btn-upload" class="btn btn-outline-primary" type="button" onclick="myUpload('{{ $p->id }}-file-dummy','{{ $p->id }}')" hidden>Upload</button>
                                        <button id="{{ $p->id }}-btn-loading" class="btn btn-outline-primary" hidden>
                                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                        </button>
                                        <a id="{{ $p->id }}-btn-link" type="button" class="btn btn-outline-primary" onclick="" href="" target="_blank" hidden>
                                            Link
                                        </a>
                                        <button id="{{ $p->id }}-btn-danger" type="button" class="btn btn-outline-danger" onclick="" hidden>
                                            Gagal
                                        </button>
                                        <p style="color:red;" id="{{ $p->id }}-alert">Belum mengisi</p>
                                    </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </form>
        @endforeach
    </div>
        <div class="card-footer text-right">
            <button class="btn btn-warning"><i class="fas fa-fw fa-check"></i> Validasi</button>
            <a href="/validasi" class="btn btn-secondary"><i class="fas fa-fw fa-sign-out-alt"></i> Kembali</a>
        </div>
    </div>
</div>

@endsection

@section('script')
<script>
var myData = {}
var myTempData = {}

var myPertanyaanOnChange = function(id, value){
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
        const idPertanyaanBaru = myData[keyNew]['id'];
        const idContainer = idPertanyaanBaru+"-container";
        myTempData[keyAktif] = $('#'+idContainer );
        myTempData[keyAktif].find(':input').prop('disabled', false);
        myTempData[keyAktif].collapse('show');
    }
}

@foreach ($json->pertanyaan as $p)
myData[@json($p->id)] = @json($p);
@if ($p->tipe === 3)
    $('input[name={{ $p->id }}]:radio').change(function(){
        myPertanyaanOnChange(@json($p->id), this.value);
    });
    @foreach ($p->opsi as $index => $o)
    @if (is_object($o))
        myData["{{ $p->id.$o->{'0'} }}"] = @json($o->{'if-selected'});
    @endif
    @endforeach
@endif
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
@if($jawaban)
const jawabans = @json(json_decode($jawaban->json));

for(var id in jawabans){
    var val = jawabans[id];
    if(!val.length) continue;
    var $jwb = $('input[name="'+id+'"]').filter(':not([type=hidden])');
    var type = $jwb.attr('type');
    switch (type) {
        case 'text':
            $jwb.val(val);
            if(val.substr(0,4) === 'http'){ //jika berupa link file
                $('#'+id+'-btn-link').attr('href',val);
                myToggleButtonUpload(id,'link');
                $('#'+id+'-file-dummy').next().text(val)
            }
            $jwb.removeClass('invalid');
            break;
        case 'radio':
            $jwb.removeClass('invalid')
            $jwb = $jwb.filter('[value="'+val+'"]')
            $jwb.prop("checked", true);
            myPertanyaanOnChange(id, val);    
            break;
    }
}
@endif

//menjadikan inputan siswa tidak bisa diubah-ubah admin
$('input[type="text"]').attr('readonly', true);
$('input[type="radio"]:not(:checked)').attr('disabled', true);
})
</script>
@endsection