@extends('layouts.layout')
@extends('layouts.sidebar')

@section('title')
Jenis Pemeriksaan
@endsection

@section('formStatus')
active
@endsection

@section('header')
Validasi
@endsection

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Jenis Pemeriksaan</h1>
    
    <div class="row">
        @foreach ($allPertanyaan as $key => $ap)
        @php
            $json = json_decode($ap->json);
        @endphp
        <div class="col-lg-12">

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
                                        @foreach ($p->opsi as $index => $o)
                                        <label class="radio-inline col-6 col-md-4">
                                            <input type="radio" name="{{ $p->id }}" id="{{ $p->id.'__'.$index }}" value="{{ $o }}"> {{ $o }}
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
                                        <input type="text" class="form-control" placeholder="" name="{{ $p->id }}" >
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
                                            @if (is_object($o))
                                                <label class="radio-inline col-6 col-md-4">
                                                    <input type="radio" name="{{ $p->id }}" id="{{ $p->id.'__'.$index }}" value="{{ $o->{'0'} }}"> {{ $o->{'0'} }}
                                                </label>
                                            @else
                                                <label class="radio-inline col-6 col-md-4">
                                                    <input type="radio" name="{{ $p->id }}" id="{{ $p->id.'__'.$index }}" value="{{ $o }}"> {{ $o }}
                                                </label>
                                            @endif
                                        @endforeach
                                        @foreach ($p->opsi as $index => $o)
                                            @if (is_object($o) and $o->{'if-selected'}->tipe === 2 )
                                                <div class="col-12 collapse" style="flex:1" id="{{ $o->{'if-selected'}->id }}-container">
                                                    <input type="text" class="form-control" name="{{ $o->{'if-selected'}->id }}" id="{{ $o->{'if-selected'}->id }}" placeholder="{{ $o->{'if-selected'}->pertanyaan }}">
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
                                                    <input type="radio" name="{{ $o->{'if-selected'}->id }}" id="{{ $o->{'if-selected'}->id.'__'.$index2 }}" value="{{ $o2 }}"> {{ $o2 }}
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
                                    <button type="button" class="btn btn-primary">Upload</button>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
        @endforeach
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
            myTempData[keyAktif] = null;
        }

        //cek jika jawaban menimbulkan pertanyaan baru
        const keyNew = (id+value);
        if( keyNew in myData ) { 
            const idPertanyaanBaru = myData[keyNew]['id'];
            const idContainer = idPertanyaanBaru+"-container";
            myTempData[keyAktif] = $('#'+idContainer );
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

</script>
@endsection