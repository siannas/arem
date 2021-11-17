@extends('layouts.layout')
@extends('layouts.sidebar')

@section('title')
Form Skrining
@endsection

@section('formStatus')
active
@endsection

@section('header')
Form Skrining
@endsection

@section('content')
@php
$role = Auth::user()->getRole->role;
@endphp
<div class="container-fluid">

<!-- Page Heading -->
<h1 class="h3 mb-2 text-gray-800">Form Skrining</h1>
@if($role==='Puskesmas')
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
                <h6 class="card-subtitle text-gray-300">Tahun Ajaran {{ $siswa->tahun_ajaran }}</h6>
            </div>
        </div>
    </div>
    <div class="card-body">
@endif
    @include('form.alert')
    <div class="row">
        @foreach ($allPertanyaan as $key => $ap)
        @php
            $json = json_decode($ap->json);
            $deskripsi = (property_exists($json, 'deskripsi') and !empty($json->deskripsi)) ? $json->deskripsi : null;
        @endphp
        <form action="#" class="col-lg-12" id="form-{{$key}}">

            <!-- Basic Card Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">{{ $ap->judul }}</h6>
                    @if(isset($deskripsi))
                    <p class="mb-0 mt-2">{{$deskripsi}}</p>
                    @endif
                </div>
                <div class="card-body">
                    @foreach ($json->pertanyaan as $p)
                        @php
                        $is_diisi_petugas = ( isset($p->{'diisi-petugas'}) and $p->{'diisi-petugas'});
                        @endphp
                        @if ($p->tipe === 1)
                            <div class="row" style="padding-top:20px">
                                <div class="col-12 col-md-5" style="margin-bottom:5px">
                                    {{ $p->pertanyaan }}
                                    @if ( $is_diisi_petugas) <span class="text-danger"><i>*diisi petugas</i></span> @endif
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
                                    @if ( $is_diisi_petugas) <span class="text-danger"><i>*diisi petugas</i></span> @endif
                                </div>
                                <div class="col-12 col-md-7">
                                    <div class="input-group">
                                        <input type="text" class="form-control invalid" placeholder="" name="{{ $p->id }}" onfocusout="myTextOnFocusOut(this, this.value)">
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
                                    @if ( $is_diisi_petugas) <span class="text-danger"><i>*diisi petugas</i></span> @endif
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
                                                        <input type="text" class="form-control invalid" name="{{ $o->{'if-selected'}->id }}" id="{{ $o->{'if-selected'}->id }}" placeholder="{{ $o->{'if-selected'}->pertanyaan }}"
                                                            onfocusout="myTextOnFocusOut(this, this.value)" disabled>
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
                                    @if ( $is_diisi_petugas) <span class="text-danger"><i>*diisi petugas</i></span> @endif
                                </div>
                                <div class="col-12 col-md-7">
                                    <div class="input-group">
                                    <input type="text" name="{{ $p->id }}" id="{{ $p->id }}" hidden readonly>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" name="{{ $p->id }}-file-dummy" id="{{ $p->id }}-file-dummy" onchange="myToggleButtonUpload('{{ $p->id }}','upload')">
                                        <label class="custom-file-label invalid" for="{{ $p->id }}-file-dummy">Pilih file</label>
                                    </div>
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
                                    </div>
                                    </div>
                                    <div id="{{ $p->id }}-alert">
                                        <p class="text-danger"><i>* File harus berformat .jpg/.jpeg/.png dan maksimal 512 KB</i></p>
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
@if($role==='Puskesmas')
    </div>
    <div class="card-footer text-right">
        <a href="{{ url()->previous() }}" class="btn btn-secondary"><i class="fas fa-fw fa-sign-out-alt"></i> Kembali</a>
    </div>
</div>
@endif
    <form action="#" id="mainform" hidden>
        @csrf
    </form>
    @if(is_null($jawaban) or ($role==='Siswa' and $jawaban->validasi_sekolah===0) or ($role==='Puskesmas' and $jawaban->validasi_puskesmas===0))
    <button class="btn btn-primary float" onclick="$('#mainform').trigger('submit')"><i class="fas fa-fw fa-save"></i></button>
    @endif    
    
</div>
@endsection

@section('script')
<script>
    var myData = {}
    var myTempData = {}
    var myDiisiPetugas = {}

    var myPertanyaanOnChange = function(id, value){
        myTempData['selected'+id] = value;
        const keyAktif = 'additional'+id; //key pertanyaan tamabahan yg sedang aktif

        //jika ada pertanyaan tambahan yang masih terbuka maka harus ditutup
        if(myTempData[keyAktif]) { 
            myTempData[keyAktif].collapse('hide');
            myTempData[keyAktif].find(':input').prop('disabled', true);
            myTempData[keyAktif] = null;
        }else{
            var $jwb = $('input[name="'+id+'"]').filter(':not([type=hidden])');
            $jwb.removeClass('invalid');
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
    var myTextOnFocusOut = function(self, value){
        var $jwb = $(self);
        var filteredval = $jwb.val().trim();
        $jwb.val(filteredval);
        if(filteredval === ''){
            $jwb.addClass('invalid');
        }else{
            $jwb.removeClass('invalid');
        }
    }

    const myUpload = async function(id_dummy, id){
        myToggleButtonUpload(id,'loading');
        var input = $('#'+id_dummy);
        var formData = new FormData();
        formData.append('_token', "{{ csrf_token() }}");
        formData.append('file', input[0].files[0]);

        try {
            const res = await myRequest.upload( '{{ route('file.upload', ['id_user'=> $user, 'id_form'=>$formulir , 'id_pertanyaan'=> '']) }}/'+id , formData);
            $('#'+id+'-btn-link').attr('href',res);
            $('#'+id).val(res);
            const label = $('#'+id+'-file-dummy').next();
            label.removeClass('invalid');
            myToggleButtonUpload(id,'link');
        } catch (err) {
            myToggleButtonUpload(id,'danger');
        }
    }

    const myToggleButtonUpload = function(id, type){
        var button;
        const container = $('#'+id+'-btn-container');
        const active = container.find('button:not(button:hidden)');
        active.attr('disabled',true);
        active.attr('hidden',true);

        button = $('#'+id+'-btn-'+type);

        button.attr('disabled',false);
        button.attr('hidden',false);
        // -btn-upload
        // -btn-loading
        // -btn-link
        // -btn-danger
    }
</script>
<script src="https://cdn.jsdelivr.net/npm/bs-custom-file-input/dist/bs-custom-file-input.min.js"></script>
<script>
$(document).ready(function () {
    bsCustomFileInput.init()

    $('#mainform').submit(async function(e){
        e.preventDefault();
        $('#loading').modal('show');
        var obj = $("form[id^='form-']");
        var all= {};
        $.each(obj, function(i, val) {
            Object.assign(all,getFormData($(val)));
        });
        try {
            let data = {'json': JSON.stringify(all), 'user': @json($user->id)};
            const res = await myRequest.put( '{{ route('jawaban.store.update', ['formulir'=> $formulir]) }}' , data)
            myAlert('Berhasil menyimpan');
        } catch(err) {
            myAlert(JSON.stringify(err['statusText']),'danger');
        }

        setTimeout(() => {
            $('#loading').modal('hide');
        }, 1000);
    })

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
            if(val.substr(0,4) === 'http'){ //jika link file
                $('#'+id+'-btn-link').attr('href',val);
                myToggleButtonUpload(id,'link');
                const label = $('#'+id+'-file-dummy').next();
                label.text(val);
                label.removeClass('invalid');
            }
            $jwb.removeClass('invalid');
            break;
        case 'radio':
            $jwb.removeClass('invalid')
            $jwb = $jwb.filter('[value="'+val+'"]')
            $jwb.prop("checked", true);       
            console.log($jwb);
            myPertanyaanOnChange(id, val);    
            break;
    }
}
@endif

@foreach ($allPertanyaan as $key => $ap)
@php
    $json = json_decode($ap->json);
@endphp
@foreach ($json->pertanyaan as $p)
    myData[@json($p->id)] = @json($p);

    //diisi petugas? jangan biarkan siswa ngisi
    @php
    $is_diisi_petugas = ( isset($p->{'diisi-petugas'}) and $p->{'diisi-petugas'});
    @endphp
    @if ($role==='Siswa')
        @if($is_diisi_petugas)
            @if ($p->tipe === 1 or $p->tipe === 3)
                $('input[name={{ $p->id }}]:radio').attr('disabled', true).removeClass('invalid').removeAttr('onfocusout');
            @elseif ($p->tipe === 2)
                $('input[name={{ $p->id }}]:text').attr('readonly', true).removeClass('invalid').removeAttr('onfocusout');
            @elseif ($p->tipe === 4)
                $('input[name={{ $p->id }}]:file').attr('disable', true).removeClass('invalid').removeAttr('onchange');
            @endif
        @elseif ($p->tipe === 1)
            $('input[name={{ $p->id }}]:radio').change(function(){
                myPertanyaanOnChange(@json($p->id), this.value);
            });
        @elseif ($p->tipe === 3)
            $('input[name={{ $p->id }}]:radio').change(function(){
                myPertanyaanOnChange(@json($p->id), this.value);
            });
            @foreach ($p->opsi as $index => $o)
            @if (is_object($o))
                myData["{{ $p->id.$o->{'0'} }}"] = @json($o->{'if-selected'});
            @endif
            @endforeach
        @endif
    @elseif($role==='Puskesmas')
        @if($is_diisi_petugas)
        myDiisiPetugas[@json($p->id)]=@json($p->tipe);
        @if ($p->tipe === 1)
            $('input[name={{ $p->id }}]:radio').change(function(){
                myPertanyaanOnChange(@json($p->id), this.value);
            });
        @elseif ($p->tipe === 3)
            $('input[name={{ $p->id }}]:radio').change(function(){
                myPertanyaanOnChange(@json($p->id), this.value);
            });
            @foreach ($p->opsi as $index => $o)
            @if (is_object($o))
                myData["{{ $p->id.$o->{'0'} }}"] = @json($o->{'if-selected'});
            @endif
            @endforeach
        @endif
        @else
        //kita disable inputan khusus siswa, jika user puskesmas
        @if ($p->tipe === 1 or $p->tipe === 3)
            $('input[name={{ $p->id }}]:radio:not(:checked)').attr('disabled', true).removeClass('invalid');
        @elseif ($p->tipe === 2)
            $('input[name={{ $p->id }}]:text').attr('readonly', true).removeClass('invalid').removeAttr('onfocusout');
        @elseif ($p->tipe === 4)
            $('input[name={{ $p->id }}-file-dummy]:file').attr('disabled', true).removeAttr('onchange')
                .next().removeClass('invalid');
        @endif
        @endif
    @endif

@endforeach
@endforeach

    @if ($role==='Puskesmas')
        //do nothing
    @elseif(is_null($jawaban)==false && $jawaban->validasi_sekolah===1)
    $('input[type="text"]').attr('readonly', true);
    $('input[type="file"]').attr('disabled', true);
    $('input[type="radio"]:not(:checked)').attr('disabled', true);
    @endif
});
</script>

@endsection