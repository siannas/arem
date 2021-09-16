@php
$role= Auth::user()->getRole->role;
@endphp

@if($role==='Siswa')
<!-- SISWA -->
@section('sidebar')
        
@endsection

@elseif($role==='Sekolah')
<!-- SEKOLAH -->
@section('sidebar')
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Aplikasi<sup>Remaja</sup></div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item @yield('dashboardStatus')">
        <a class="nav-link" href="/">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>
    <!-- Nav Item - Tables -->
    <li class="nav-item @yield('validasiStatus')">
        <a class="nav-link" href="/validasi">
            <i class="fas fa-fw fa-table"></i>
            <span>Validasi</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Data
    </div>

    <!-- Nav Item - Tables -->
    <li class="nav-item @yield('dataStatus')">
        <a class="nav-link" href="/data-siswa">
            <i class="fas fa-fw fa-users"></i>
            <span>Data Siswa</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
@endsection

@elseif($role==='Kelurahan')
<!-- KELURAHAN -->
@section('sidebar')
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Aplikasi<sup>Remaja</sup></div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item @yield('dashboardStatus')">
        <a class="nav-link" href="/">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>
    <!-- Nav Item - Tables -->
    <li class="nav-item @yield('validasiStatus')">
        <a class="nav-link" href="/validasi">
            <i class="fas fa-fw fa-users"></i>
            <span>Validasi</span></a>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Data
    </div>

    <!-- Nav Item - Tables -->
    <li class="nav-item @yield('siswaStatus')">
        <a class="nav-link" href="/data-siswa">
            <i class="fas fa-fw fa-users"></i>
            <span>Data Siswa</span></a>
    </li>
    <!-- Nav Item - Tables -->
    <li class="nav-item @yield('sekolahStatus')">
        <a class="nav-link" href="/data-sekolah">
            <i class="fas fa-fw fa-school"></i>
            <span>Data Sekolah</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
@endsection

@elseif($role==='Puskesmas')
<!-- PUSKESMAS -->
@section('sidebar')
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Aplikasi<sup>Remaja</sup></div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item @yield('dashboardStatus')">
        <a class="nav-link" href="/">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>
    <!-- Nav Item - Tables -->
    <li class="nav-item @yield('validasiStatus')">
        <a class="nav-link" href="/validasi">
            <i class="fas fa-fw fa-table"></i>
            <span>Validasi</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Data
    </div>

    <!-- Nav Item - Tables -->
    <li class="nav-item @yield('siswaStatus')">
        <a class="nav-link" href="/data-siswa">
            <i class="fas fa-fw fa-users"></i>
            <span>Data Siswa</span></a>
    </li>
    <!-- Nav Item - Tables -->
    <li class="nav-item @yield('sekolahStatus')">
        <a class="nav-link" href="/data-sekolah">
            <i class="fas fa-fw fa-school"></i>
            <span>Data Sekolah</span></a>
    </li>
    <!-- Nav Item - Tables -->
    <li class="nav-item @yield('kelurahanStatus')">
        <a class="nav-link" href="/data-kelurahan">
            <i class="fas fa-fw fa-table"></i>
            <span>Data Kelurahan</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
@endsection

@elseif($role==='Kecamatan')
<!-- KECAMATAN -->
@section('sidebar')
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Aplikasi<sup>Remaja</sup></div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item @yield('dashboardStatus')">
        <a class="nav-link" href="/">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>
    <!-- Nav Item - Tables -->
    <li class="nav-item @yield('validasiStatus')">
        <a class="nav-link" href="/validasi">
            <i class="fas fa-fw fa-table"></i>
            <span>Validasi</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Data
    </div>

    <!-- Nav Item - Tables -->
    <li class="nav-item @yield('siswaStatus')">
        <a class="nav-link" href="/data-siswa">
            <i class="fas fa-fw fa-users"></i>
            <span>Data Siswa</span></a>
    </li>
    <!-- Nav Item - Tables -->
    <li class="nav-item @yield('sekolahStatus')">
        <a class="nav-link" href="/data-sekolah">
            <i class="fas fa-fw fa-school"></i>
            <span>Data Sekolah</span></a>
    </li>
    <!-- Nav Item - Tables -->
    <li class="nav-item @yield('kelurahanStatus')">
        <a class="nav-link" href="/data-kelurahan">
            <i class="fas fa-fw fa-table"></i>
            <span>Data Kelurahan</span></a>
    </li>
    <!-- Nav Item - Tables -->
    <li class="nav-item @yield('puskesmasStatus')">
        <a class="nav-link" href="/data-puskesmas">
            <i class="fas fa-fw fa-table"></i>
            <span>Data Puskesmas</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
@endsection

@elseif($role==='Kota')
<!-- KOTA/DINAS -->
@section('sidebar')
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Aplikasi<sup>Remaja</sup></div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item @yield('dashboardStatus')">
        <a class="nav-link" href="/">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>
    <!-- Nav Item - Tables -->
    <li class="nav-item @yield('validasiStatus')">
        <a class="nav-link" href="/validasi">
            <i class="fas fa-fw fa-check-circle"></i>
            <span>Validasi</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Data
    </div>

    <!-- Nav Item - Tables -->
    <li class="nav-item @yield('siswaStatus')">
        <a class="nav-link" href="/data-siswa">
            <i class="fas fa-fw fa-users"></i>
            <span>Data Siswa</span></a>
    </li>
    <!-- Nav Item - Tables -->
    <li class="nav-item @yield('sekolahStatus')">
        <a class="nav-link" href="/data-sekolah">
            <i class="fas fa-fw fa-school"></i>
            <span>Data Sekolah</span></a>
    </li>
    <!-- Nav Item - Tables -->
    <li class="nav-item @yield('kelurahanStatus')">
        <a class="nav-link" href="/data-kelurahan">
            <i class="fas fa-fw fa-university"></i>
            <span>Data Kelurahan</span></a>
    </li>
    <!-- Nav Item - Tables -->
    <li class="nav-item @yield('puskesmasStatus')">
        <a class="nav-link" href="/data-puskesmas">
            <i class="fas fa-fw fa-hospital"></i>
            <span>Data Puskesmas</span></a>
    </li>
    <!-- Nav Item - Tables -->
    <li class="nav-item @yield('kecamatanStatus')">
        <a class="nav-link" href="/data-kecamatan">
            <i class="fas fa-fw fa-landmark"></i>
            <span>Data Kecamatan</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Form Skrining
    </div>

    <!-- Nav Item - Tables -->
    <li class="nav-item @yield('formStatus')">
        <a class="nav-link" href="/formulir">
            <i class="fab fa-fw fa-wpforms"></i>
            <span>Form Skrining</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
@endsection

@else
@section('sidebar')

@endsection
@endif