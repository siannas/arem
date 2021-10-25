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
            <div class="card">
                <div class="card-body">    
                    <form action="" method="post">
                        <div class="form-group">
                            <label><b>Judul</b></label>
                            <input type="text" id="judul" name="judul" class="form-control" placeholder="Judul" required>
                        </div>
                        <label><b>Isi</b></label>
                        <textarea id="summernote" name="summernote" required></textarea>
                        
                        
                        <!-- <div class="bootstrap-tagsinput"><span class="tag label label-info">Amsterdam<span data-role="remove"></span></span> <span class="tag label label-info">Washington<span data-role="remove"></span></span> <span class="tag label label-info">Sydney<span data-role="remove"></span></span> <span class="tag label label-info">Beijing<span data-role="remove"></span></span> <span class="tag label label-info">Cairo<span data-role="remove"></span></span> <input type="text" placeholder=""></div><input type="text" value="Amsterdam,Washington,Sydney,Beijing,Cairo" data-role="tagsinput" style="display: none;"> -->
          
                    
                    </form>
                </div>
            </div>
        </div>
        <div class="col-xl-4">
            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <label><b>Jenjang</b></label>
                        <input type="text" id="jenjang" name="jenjang" class="form-control" placeholder="Pilih Jenjang" required>
                    </div>
                    <div class="form-group">
                        <label><b>Kategori</b></label>
                        <input type="text" id="kategori" name="kategori" class="form-control" placeholder="Pilih Kategori" required>
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
    height: 300,
    
    });
</script>
<script>
var cities = new Bloodhound({
  datumTokenizer: Bloodhound.tokenizers.obj.whitespace('text'),
  queryTokenizer: Bloodhound.tokenizers.whitespace,
  prefetch: 'assets/cities.json'
});
cities.initialize();

var elt = $('input');
elt.tagsinput(
  itemValue: 'value',
  itemText: 'text',
  typeaheadjs: {
    name: 'cities',
    displayKey: 'text',
    source: cities.ttAdapter()
  }
});
elt.tagsinput('add', { "value": 1 , "text": "Amsterdam"   , "continent": "Europe"    });
elt.tagsinput('add', { "value": 4 , "text": "Washington"  , "continent": "America"   });
elt.tagsinput('add', { "value": 7 , "text": "Sydney"      , "continent": "Australia" });
elt.tagsinput('add', { "value": 10, "text": "Beijing"     , "continent": "Asia"      });
elt.tagsinput('add', { "value": 13, "text": "Cairo"       , "continent": "Africa"    });
</script>
@endsection
