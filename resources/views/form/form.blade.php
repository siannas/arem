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

        <div class="col-lg">

            <!-- Basic Card Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">1. Riwayat Kesehatan</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-4">Alergi</div>
                        <div class="col">
                            <label class="radio-inline">
                            <input type="radio" name="inlineRadioOptions" id="inlineRadio1" value="option1"> Tidak
                            </label>
                        </div>
                        <div class="col">
                            <label class="radio-inline">
                            <input type="radio" name="inlineRadioOptions" id="inlineRadio2" value="option2"> Ya
                            </label>
                        </div>
                        <div class="col">
                            <input type="text" class="form-control" placeholder="Sebutkan">
                        </div>
                    </div>
                    <div class="row" style="padding-top:10px">
                        <div class="col-4">Pernah mengalami cedera</div>
                        <div class="col">
                            <label class="radio-inline">
                            <input type="radio" name="inlineRadioOptions2" id="inlineRadio1" value="option1"> Tidak
                            </label>
                        </div>
                        <div class="col">
                            <label class="radio-inline">
                            <input type="radio" name="inlineRadioOptions2" id="inlineRadio2" value="option2"> Ya
                            </label>
                        </div>
                        <div class="col">
                            <input type="text" class="form-control" placeholder="Sebutkan">
                        </div>
                    </div>
                    <div class="row" style="padding-top:10px">
                        <div class="col-4">Riwayat kejang berulang</div>
                        <div class="col">
                            <label class="radio-inline">
                            <input type="radio" name="inlineRadioOptions3" id="inlineRadio1" value="option1"> Tidak
                            </label>
                        </div>
                        <div class="col">
                            <label class="radio-inline">
                            <input type="radio" name="inlineRadioOptions3" id="inlineRadio2" value="option2"> Ya
                            </label>
                        </div>
                        <div class="col">
                            
                        </div>
                    </div>
                    <div class="row" style="padding-top:10px">
                        <div class="col-4">Riwayat pingsan</div>
                        <div class="col">
                            <label class="radio-inline">
                            <input type="radio" name="inlineRadioOptions4" id="inlineRadio1" value="option1"> Tidak
                            </label>
                        </div>
                        <div class="col">
                            <label class="radio-inline">
                            <input type="radio" name="inlineRadioOptions4" id="inlineRadio2" value="option2"> Ya
                            </label>
                        </div>
                        <div class="col">
                            
                        </div>
                    </div>
                </div>
                

            </div>


        </div>

    </div>


</div>
@endsection