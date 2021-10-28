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

    @if($role==='Kota')
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Daftar KIE</h1>
    @include('form.alert')

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="row">
                <div class="col align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">Daftar KIE</h6>
                </div>
                @if($role==='Kota')
                <div class="col text-right">
                    <a href="{{url('/kie/create')}}" type="button" class="btn btn-sm btn-primary">Tambah</a>
                </div>
                @endif
            </div>
            
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Judul</th>
                            <th>Jenjang</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>Judul</th>
                            <th>Jenjang</th>
                            <th>Aksi</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach($kie as $unit)
                        <tr>
                            <td>{{ $unit->judul }}</td>
                            @if($unit->jenjang==='1,2,3,4,5,6')
                            <td>SD/MI</td>
                            @elseif($unit->jenjang==='7,8,9,10,11,12')
                            <td>SMP/MTS dan SMA/SMK/MA</td>
                            @endif
                            <td>
                                <div class="row m-1">
                                    @if($role==='Kota')
                                    <a href="{{route('kie.show', [$unit->id])}}" class="btn btn-sm btn-primary mr-1"><i class="fas fa-fw fa-eye"></i></a>
                                    <a href="{{url('/kie/edit', [$unit->id])}}" class="btn btn-sm btn-warning mr-1"><i class="fas fa-fw fa-edit"></i></a>
                                    <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#delete{{ $unit->id }}"><i class="fas fa-fw fa-trash-alt"></i></button>
                                    <div class="modal modal-danger fade" id="delete{{ $unit->id }}" tabindex="-1" role="dialog" aria-labelledby="Delete" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Hapus</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                <form action="{{ route('kie.destroy', [$unit->id]) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <h5 class="text-center">Yakin Ingin Hapus?</h5>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tidak</button>
                                                    <button type="submit" class="btn btn-danger">Ya</button>
                                                </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    @elseif($role==='Siswa')
                                    <form action="{{url('/kie/'.$unit->id)}}" method="GET" class="mr-1"><button class="btn btn-sm btn-primary"><i class="fas fa-fw fa-eye"></i> Lihat</button></form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif

</div>

@endsection


@section('style')
<!-- include summernote css -->
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.css" integrity="sha512-xmGTNt20S0t62wHLmQec2DauG9T+owP9e6VU8GigI0anN7OXLip9i7IwEhelasml2osdxX71XcYm6BQunTQeQg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput-typeahead.css" integrity="sha512-wu4jn1tktzX0SHl5qNLDtx1uRPSj+pm9dDgqsrYUS16AqwzfdEmh1JR8IQL7h+phL/EAHpbBkISl5HXiZqxBlQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection

@section('script')
<!-- include summernote js -->
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.min.js" integrity="sha512-9UR1ynHntZdqHnwXKTaOm1s6V9fExqejKvg5XMawEMToW4sSw+3jtLrYfZPijvnwnnE8Uol1O9BcAskoxgec+g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
$('#isi').summernote({
    tabsize: 2,
    height: 300    
});
</script>
<script>
$('#kategori').select2({
    tags: true,
    width: '100%'
});
</script>
@endsection
