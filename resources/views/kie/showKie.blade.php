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
<div class="container-fluid" style="max-width:60rem;">

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
                {{date_format(date_create($kie->created_at), "d-m-Y")}}
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
