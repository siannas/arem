@extends('layouts.layout')
@extends('layouts.sidebar')

@section('title')
Detail Siswa
@endsection

@section('siswaStatus')
active
@endsection

@section('header')
Validasi
@endsection

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Detail Data Siswa</h1>
    <div class="card">
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
        <div class="card-body">
            <h6 class="card-subtitle mb-3"><b>1. Riwayat Kesehatan</b></h6>
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
            <div class="mb-5"><hr></div>
            <h6 class="card-subtitle mb-3"><b>2. Riwayat Imunisasi</b></h6>
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
            <div class="mb-5"><hr></div>
        </div>
        <div class="card-footer text-right">
            <button class="btn btn-warning"><i class="fas fa-fw fa-check"></i> Validasi</button>
            <a href="/data-siswa" class="btn btn-secondary"><i class="fas fa-fw fa-sign-out-alt"></i> Kembali</a>
        </div>
    </div>
</div>

@endsection