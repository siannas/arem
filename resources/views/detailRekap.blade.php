@extends('layouts.layout')
@extends('layouts.sidebar')

@php
$role= Auth::user()->getRole->role;
@endphp

@section('title')
Detail Rekap
@endsection

@section('rekapStatus')
active
@endsection

@section('header')
Form Skrining
@endsection

@section('description')
Dashboard
@endsection

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Rekap Skrining</h1>

    <div class="card shadow">
        <div class="card-header bg-primary mb-3">
            <div class="row p-4 justify-content-between align-items-center">
                <div class="col-12 col-lg-auto mb-5 mb-lg-0 text-center text-lg-left">
                    <i class="fas fa-laugh-wink text-light mb-3" style="font-size:50px;"></i>
                    <h5 class="text-light">Aplikasi Remaja</h5>
                </div>
                <div class="col-12 col-lg-auto text-center text-lg-right text-light">
                    haha
                </div>
            </div>
        </div>
        <div class="card-body row">
        @foreach ($pertanyaan as $key => $ap)
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
                                <div class="col-12" style="margin-bottom:5px">
                                    <h5>{{ $p->pertanyaan }}</h5>
                                    <div class="chart-pie pt-4 pb-2">
                                        <canvas class="myPieChart"></canvas>
                                    </div>
                                    <div class="mt-4 text-center small">
                                        <span class="mr-2">
                                            <i class="fas fa-circle text-primary"></i> Direct
                                        </span>
                                        <span class="mr-2">
                                            <i class="fas fa-circle text-success"></i> Social
                                        </span>
                                        <span class="mr-2">
                                            <i class="fas fa-circle text-info"></i> Referral
                                        </span>
                                    </div>
                                </div>
                                
                            </div>
                        @elseif ($p->tipe === 2)
                            <div class="row" style="padding-top:20px">
                                <div class="col-12 col-md-4" style="margin-bottom:5px">
                                    <h5>{{ $p->pertanyaan }}</h5>
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
                                <div class="col-12 col-md-6" style="margin-bottom:5px">
                                    <h5>{{ $p->pertanyaan }}</h5>
                                    <div class="chart-pie pt-4 pb-2">
                                        <canvas class="myPieChart"></canvas>
                                    </div>
                                    <div class="mt-4 text-center small">
                                        @foreach ($p->opsi as $index => $o)
                                        @if (is_object($o))
                                        <span class="mr-2">
                                            <i class="fas fa-circle @if($index===0)text-primary @elseif($index===1)text-success @else text-info @endif"></i> {{ $o->{'0'} }}
                                        </span>
                                        @else
                                        <span class="mr-2">
                                            <i class="fas fa-circle @if($index===0)text-primary @elseif($index===1)text-success @else text-info @endif"></i> {{ $o }}
                                        </span>
                                        @endif
                                        @endforeach
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 pt-5">
                                
                                    <div class="form-group">
                                        <input type="text" class="form-control" value="Ini Jawaban 1" disabled>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control" value="Ini Jawaban 2" disabled>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control" value="Ini Jawaban 3" disabled>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control" value="Ini Jawaban 4" disabled>
                                    </div>
                                    <div class="form-group">
                                        <input type="text" class="form-control" value="Ini Jawaban 5" disabled>
                                    </div>
                                </div>
                            </div>
                        @elseif ($p->tipe === 4)
                            <div class="row" style="padding-top:20px">
                                <div class="col-12 col-md-5" style="margin-bottom:5px">
                                    <h5>{{ $p->pertanyaan }}</h5>
                                </div>
                                <div class="col-12 col-md-7">
                                    <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="inputGroupFile04" aria-describedby="inputGroupFileAddon04">
                                        <label class="custom-file-label" for="inputGroupFile04">Pilih file</label>
                                    </div>
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-primary" type="button" id="inputGroupFileAddon04">Upload</button>
                                    </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
        @endforeach
        
    </div>
        <div class="card-footer text-right">
            <a href="/rekap" class="btn btn-secondary"><i class="fas fa-fw fa-sign-out-alt"></i> Kembali</a>
        </div>
    </div>
</div>

@endsection

@section('script')

@endsection