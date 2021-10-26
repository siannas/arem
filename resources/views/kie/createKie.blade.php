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
        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
    </div>

    @include('form.alert')
    <div class="row">
        <div class="col-xl-8">
            <div class="card mb-4">
                <div class="card-body">
                    <form action="" method="post">
                        <div class="form-group">
                            <label><b>Judul</b></label>
                            <input type="text" id="judul" name="judul" class="form-control" placeholder="Judul" required>
                        </div>
                        <label><b>Isi</b></label>
                        <textarea id="summernote" name="summernote" required></textarea>
                    </form>
                </div>
                
            </div>
        </div>
        <div class="col-xl-4">
            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <label><b>Jenjang</b></label>
                        <div class="input-group">
                            <select id="jenjang" name="jenjang" class="form-control">
                                <option selected disabled>Pilih Jenjang</option>
                                <option value="1,2,3,4,5,6">SD/MI</option>
                                <option value="7,8,9,10,11,12">SMP/MTS dan SMA/SMK/MA</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label><b>Kategori</b></label><br>
                        <select id="kategori" name="kategori" class="form-control" multiple="multiple" required>
                            <option selected="selected">orange</option>
                            <option>white</option>
                            <option selected="selected">purple</option>
                        </select>
                    </div>
                </div>
                <div class="card-footer">
                    <button class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </div>
    </div>

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
$('#summernote').summernote({
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
