@extends('layouts.layout')
@extends('layouts.sidebar')

@php
$role= Auth::user()->getRole->role;
@endphp

@section('title')
Edit KIE
@endsection

@section('kieStatus')
active
@endsection

@section('header')
Edit KIE
@endsection

@section('description')
Edit KIE
@endsection

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit KIE</h1>
    </div>

    <form action="{{url('/kie/edit',[$kie->id])}}" method="post" id="kie-form">
    @csrf
    @method('PUT')
    <div class="row">
        
        <div class="col-xl-8">
            <div class="card mb-4">
                <div class="card-body">
                    <form action="" method="post">
                        <div class="form-group">
                            <label><b>Judul</b></label>
                            <input type="text" id="judul" name="judul" class="form-control" placeholder="Judul" value="{{$kie->judul}}" required>
                        </div>
                        <label><b>Isi</b></label>
                        <div id="isi" name="isi" required>{!! $kie->isi !!}</div>
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
                                <option disabled>Pilih Jenjang</option>
                                <option value="1,2,3,4,5,6" @if($kie->jenjang=="1,2,3,4,5,6") selected @endif>SD/MI</option>
                                <option value="7,8,9,10,11,12" @if($kie->jenjang=="7,8,9,10,11,12") selected @endif>SMP/MTS dan SMA/SMK/MA</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label><b>Kategori</b></label><br>
                        <select id="kategori" name="kategori[]" class="form-control" multiple="multiple" value="{{$kie->isi}}" required>
                            @php
                            $list = explode(',', $kie->kategori);
                            $flag = 0;
                            
                            foreach($kategori as $unit){
                                $flag = 0;
                                foreach($list as $unit2){
                                    if($unit->nama_kategori == $unit2){
                                        echo "<option selected='selected'>{$unit2}</option>";
                                        $flag = 1;
                                    }
                                }
                                if($flag == 0){
                                    echo "<option>{$unit->nama_kategori}</option>";
                                }
                            }
                                
                            @endphp        
                        </select>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </div>
        
    </div>
    </form>

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
// A $( document ).ready() block.
$( document ).ready(function() {
    $('#isi').summernote({
        tabsize: 2,
        height: 300    
    });

    $('#kie-form').submit(function(e){
        var konten = $('.note-editable').clone();
        var foto = konten.find('img')[0];
        if(foto!== undefined){
            var foto_str = $(foto).attr('src');
            foto.remove();
            $("<input />").attr("type", "hidden")
                .attr("name", "foto")
                .attr("value", foto_str)
                .appendTo("#kie-form");
        }
        let strippedString = konten.prop('outerHTML').replace(/(<([^>]+)>)/gi, "");
        strippedString = strippedString.substr(0,254);
        $("<input />").attr("type", "hidden")
            .attr("name", "ringkasan")
            .attr("value", strippedString)
            .appendTo("#kie-form");
        return true;
    })
});
</script>
<script>
$('#kategori').select2({
    tags: true,
    width: '100%'
});
</script>
@endsection
