@php
$role= Auth::user()->getRole->role;
@endphp

@if($role==='Siswa')
<!-- SISWA -->
@section('sidebar')
        
@endsection

@elseif($role==='Kota'||$role==='Kecamatan'||$role==='Puskesmas'||$role==='Kelurahan'||$role==='Sekolah')

@section('sidebar')
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ url('/')}}">
        <div class="sidebar-brand-icon">
            <img src="{{ asset('public/img/surabaya_logo.png') }}" alt="" width="30px">
        </div>
        <div class="sidebar-brand-text ml-2">e-Ning Tasiah</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item @yield('dashboardStatus')">
        <a class="nav-link" href="{{ url('/')}}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    @if($role==='Sekolah')
    <!-- Nav Item - Tables -->
    <li class="nav-item @yield('verifikasiStatus')">
        <a class="nav-link" href="{{ url('/verifikasi')}}">
            <i class="fas fa-fw fa-user-plus"></i>
            <span>Verifikasi</span></a>
    </li>
    @endif

    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
            aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-table"></i>
            <span>Master Data</span>
        </a>
        <div id="collapseTwo" class="collapse @yield('showMaster')" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Master Data:</h6>
                <a class="collapse-item @yield('siswaStatus')" href="{{ url('/data-siswa')}}">
                    <i class="fas fa-fw fa-users"></i>
                    <span>Data Siswa</span></a>

                @if($role==='Kota'||$role==='Kecamatan'||$role==='Puskesmas'||$role==='Kelurahan')
                <a class="collapse-item @yield('sekolahStatus')" href="{{ url('/data-sekolah')}}">
                    <i class="fas fa-fw fa-school"></i>
                    <span>Data Sekolah</span></a>
                @endif

                @if($role==='Kota'||$role==='Kecamatan'||$role==='Puskesmas')
                <a class="collapse-item @yield('kelurahanStatus')" href="{{ url('/data-kelurahan')}}">
                    <i class="fas fa-fw fa-university"></i>
                    <span>Data Kelurahan</span></a>
                @endif

                @if($role==='Kota'||$role==='Kecamatan')
                <a class="collapse-item @yield('puskesmasStatus')" href="{{ url('/data-puskesmas')}}">
                    <i class="fas fa-fw fa-clinic-medical"></i>
                    <span>Data Puskesmas</span></a>
                @endif

                @if($role==='Kota')
                <a class="collapse-item @yield('kecamatanStatus')" href="{{ url('/data-kecamatan')}}">
                    <i class="fas fa-fw fa-landmark"></i>
                    <span>Data Kecamatan</span></a>
                @endif

            </div>
        </div>
    </li>
    
    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Data Imunisasi
    </div>
    <!-- Nav Item - Tables -->
    <li class="nav-item @yield('validasiImunStatus')">
        <a class="nav-link" href="{{ url('/imunisasi/validasi')}}">
            <i class="fas fa-fw fa-check-circle"></i>
            <span>Validasi</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Form Skrining
    </div>

    @if($role==='Kota')
    <!-- Nav Item - Tables -->
    <li class="nav-item @yield('formStatus')">
        <a class="nav-link" href="{{ url('/formulir')}}">
            <i class="fab fa-fw fa-wpforms"></i>
            <span>Form Skrining</span></a>
    </li>
    @endif

    <!-- Nav Item - Tables -->
    <li class="nav-item @yield('validasiStatus')">
        <a class="nav-link" href="{{ url('/validasi')}}">
            <i class="fas fa-fw fa-check-circle"></i>
            <span>Validasi</span></a>
    </li>

    <li class="nav-item @yield('rekapStatus')">
        <a class="nav-link" href="{{ url('/rekap')}}">
            <i class="fas fa-fw fa-file"></i>
            <span>Rekap Skrining</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        KIE
    </div>
    
    <!-- Nav Item - Tables -->
    <li class="nav-item @yield('kieStatus')">
        <a class="nav-link" href="{{ url('/kie')}}">
            <i class="fab fa-fw fa-wpforms"></i>
            <span>KIE</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
@endsection

@endif