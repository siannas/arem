@extends('layouts.layout')
@extends('layouts.sidebar')

@php
$role= Auth::user()->getRole->role;
@endphp

@section('title')
KIE
@endsection

@section('kieStatus')
active
@endsection

@section('header')
KIE
@endsection

@section('description')
KIE
@endsection

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">KIE</h1>
    </div>

    @include('form.alert')    
    <div class="card mb-4">
        <div class="card-body">
            <h3>{{$kie->judul}}</h3>
            <small> 
                @if($kie->jenjang == '1,2,3,4,5,6') SD/MI 
                @else SMP/MTS dan SMA/SMK/MA 
                @endif
                    | 
                {{$kie->kategori}}
                    | 
                {{$kie->created_at}}
            </small>
            <div class="mt-4"></div>
            {!!$kie->isi!!}
        </div>
    </div>
        
</div>

@endsection


@section('style')
@endsection

@section('script')
@endsection
