@extends('layouts.layout')
@extends('layouts.sidebar')

@php
$role= Auth::user()->getRole->role;
@endphp

@section('title')
Dashboard
@endsection

@section('dashboardStatus')
active
@endsection

@section('header')
Dashboard
@endsection

@section('description')
Dashboard
@endsection

@if($role==='Siswa')
@section('content')
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800" style="z-index:10;">Dashboard</h1>
        <p class="d-none d-sm-inline-block shadow-sm bg-primary p-2 mb-0 text-white rounded" style="z-index:10;">
            <i class="fas fa-calendar-day fa-sm text-white"></i>
            @php
            $mytime = Carbon\Carbon::now()->setTimeZone('Asia/Jakarta')->format('d-m-Y');
            echo $mytime;
            @endphp
        </p>
    </div>
    @include('form.alert')
    <div class="row">
        <div class="col-xxl-4 col-xl-12 mb-4">
            <div class="card h-100">
                <div class="card-body h-100 p-5">
                    <div class="row align-items-center">
                        <div class="col-xl-8 col-xxl-12">
                            <div class="text-center text-xl-start text-xxl-center mb-4 mb-xl-0 mb-xxl-4">
                                <h2 class="text-primary">Selamat Datang di e-Ning Tasiah!</h2>
                                <h1 class="text-secondary">{{Auth::user()->nama}}</h1>
                                <p class="text-gray-700 mb-0">
                                    @if($sekolah) 
                                    Kamu Terdaftar Sebagai Siswa di {{$sekolah->nama}} 
                                    @elseif($dataPengajuan)
                                    Kamu sudah mendaftar. Status sedang menunggu diverifikasi.
                                    @else
                                    Kamu Tidak Terdaftar Pada Sekolah Manapun, Segera Lakukan Pendaftaran Melalui Link Berikut:
                                    <br><button class="btn btn-primary mt-3" style="width:50%" data-toggle="modal" data-target="#daftar">Daftar</button>
                                    <div class="modal modal-danger fade" id="daftar" tabindex="-1" role="dialog" aria-labelledby="Delete" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Daftar Sekolah</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                <form action="{{ route('dashboard.pengajuan') }}" method="POST">
                                                    @csrf
                                                    <h5 class="text-center">Silahkan Pilih Sekolah Yang Ingin Didaftar</h5>
                                                    <div class="form-group mt-4">
                                                        <div id="sekolahParent" class="input-group">
                                                            <select id="sekolah" name="sekolah" class="form-control">
                                                                <option selected disabled>Pilih Sekolah</option>
                                                                @foreach($dataSekolah as $unit)
                                                                <option value="{{$unit->id}}">{{$unit->nama}}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                   
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tidak</button>
                                                    <button type="submit" class="btn btn-primary">Ya</button>
                                                </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                </p>
                            </div>
                        </div>
                        <div class="col-xl-4 col-xxl-12 text-center"><img class="img-fluid" src="{{asset('public/img/undraw_Welcome_re_h3d9.svg')}}"></div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
@section('script')
<script>
$(document).ready(function() {
    $('#sekolah').select2({
        width: '100%',
        dropdownParent: $("#sekolahParent")
    });
});
</script>
@endsection

@else
@section('content')
<div class="modal fade" id="ubah" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Pengumuman</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{route('pengumuman.store')}}" method="post">
        @csrf
        <div class="modal-body">
            <div class="form-group">
                <textarea class="form-control" placeholder="Masukkan Deskripsi Pertanyaan" name="deskripsi" style="height: 200px;">{{$pengumuman->value}}</textarea>
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

<div class="container-fluid">

<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
    <!-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
            class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> -->
</div>

<!-- Content Row -->
@include('form.alert')
<div class="row">
    <!-- Card Siswa Terdaftar -->
    <div class="col-xl-6 col-md-6 mb-4">
        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Siswa Terdaftar</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{number_format($statusList[1])}}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-users fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Card Siswa Tdk Terdaftar -->
            <div class="col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    Siswa Tidak Terdaftar</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{number_format($jumlahSiswa[0]-$jumlahSiswa[1])}}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-users fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Pengumuman -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <div class="row">
                    <div class="col">
                        <h6 class="m-0 font-weight-bold text-primary">Pengumuman</h6>
                    </div>
                    <div class="col text-right">
                        @if($role == 'Kota')
                            <button type="button" class="btn btn-sm btn-primary shadow-sm" data-toggle="modal" data-target="#ubah"><i class="fas fa-edit fa-sm text-white-50"></i>Ubah</button>
                        @endif
                    </div>
                </div>
            </div>
            <div class="card-body">
                <p>{{$pengumuman->value}}</p>
                Manual: <a href="https://drive.google.com/drive/folders/1CDnm8_gpiOMNKSvkqSWqEXEQQQJtKzNQ?usp=sharing">Link</a>
            </div>
        </div>    
    </div>
    
    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-6 col-md-6 mb-4">
        <div class="card shadow">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Status</h6>
            </div>
            <div class="card-body">
                @php
                function cekNol($statusList, $nomor, $jumlah){
                    if($statusList[$jumlah]>0){
                        return $statusList[$nomor]/$statusList[$jumlah]*100;
                    } 
                    else{
                        return 0;
                    }
                }
                @endphp
                <h4 class="small font-weight-bold">Belum Mengisi ({{$statusList[2]}}) <span    
                    class="float-right">@php echo number_format(cekNol($statusList,2,1),2) @endphp %</span></h4>
                <div class="progress mb-4">
                    <div class="progress-bar bg-danger" role="progressbar" style="width: @php echo cekNol($statusList,2,1); @endphp%"
                        aria-valuenow="{{$statusList[2]}}" aria-valuemin="0" aria-valuemax="{{$statusList[1]}}"></div>
                </div>
                <h4 class="small font-weight-bold">Belum Tervalidasi Sekolah ({{$statusList[3]}}) <span
                        class="float-right">@php echo number_format(cekNol($statusList,3,1),2) @endphp %</span></h4>
                <div class="progress mb-4">
                    <div class="progress-bar bg-warning" role="progressbar" style="width: @php echo cekNol($statusList,3,1); @endphp%"
                        aria-valuenow="{{$statusList[3]}}" aria-valuemin="0" aria-valuemax="{{$statusList[1]}}"></div>
                </div>
                <h4 class="small font-weight-bold">Tervalidasi Sekolah ({{$statusList[4]}}) <span
                        class="float-right">@php echo number_format(cekNol($statusList,4,1),2) @endphp %</span></h4>
                <div class="progress mb-4">
                    <div class="progress-bar" role="progressbar" style="width: @php echo cekNol($statusList,4,1); @endphp%"
                        aria-valuenow="{{$statusList[4]}}" aria-valuemin="0" aria-valuemax="{{$statusList[1]}}"></div>
                </div>
                <h4 class="small font-weight-bold">Tervalidasi Puskesmas ({{$statusList[5]}}) <span
                        class="float-right">@php echo number_format(cekNol($statusList,5,1),2) @endphp %</span></h4>
                <div class="progress mb-4">
                    <div class="progress-bar bg-info" role="progressbar" style="width: @php echo cekNol($statusList,5,1); @endphp%"
                        aria-valuenow="{{$statusList[5]}}" aria-valuemin="0" aria-valuemax="{{$statusList[1]}}"></div>
                </div>
                <h4 class="small font-weight-bold">Dirujuk ({{$statusList[6]}}) <span
                        class="float-right">@php echo number_format(cekNol($statusList,6,1),2) @endphp %</span></h4>
                <div class="progress mb-4">
                    <div class="progress-bar bg-warning" role="progressbar" style="width: @php echo cekNol($statusList,6,1); @endphp%"
                        aria-valuenow="{{$statusList[6]}}" aria-valuemin="0" aria-valuemax="{{$statusList[1]}}"></div>
                </div>
                <h4 class="small font-weight-bold">Sudah Dirujuk ({{$statusList[7]}}) <span
                        class="float-right">@php echo number_format(cekNol($statusList,7,1),2) @endphp %</span></h4>
                <div class="progress mb-4">
                    <div class="progress-bar bg-success" role="progressbar" style="width: @php echo cekNol($statusList,7,1); @endphp%"
                        aria-valuenow="{{$statusList[7]}}" aria-valuemin="0" aria-valuemax="{{$statusList[1]}}"></div>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection
@endif