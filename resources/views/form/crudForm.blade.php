@extends('layouts.layout')

@section('title')
Tambah Form Skrining
@endsection

@section('formStatus')
active
@endsection

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Tambah Form Skrining</h1>
    <form action="#" id="mainform" method="get" name="mainform">
    <div class="row">
        <div class="col-md">
            <!-- Basic Card Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Detail</h6>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label><b>Judul</b></label>
                        <input type="text" class="form-control" placeholder="Masukkan Judul Pertanyaan">
                    </div>
                    <div class="form-group">
                        <label><b>Deskripsi</b></label>
                        <textarea class="form-control" rows="2" placeholder="Masukkan Deskripsi Pertanyaan"></textarea>
                    </div>
                    <div class="form-group">
                        <label><b>Tipe Pertanyaan</b></label>
                        <div class="input-group">
                            <select id="terserah" class="form-control">
                                <option selected>Pilih Tipe</option>
                                <option value="1">Pilihan 2</option>
                                <option value="2">Pilihan 3</option>
                                <option value="3">Isian</option>
                                <option value="4">Gabungan</option>
                                <option value="5">Isian Dengan Foto</option>
                            </select>
                        
                            <a class="btn btn-success" onclick="nameFunction()"><i class="fas fa-plus"></i> Tambah</a>
                            <!-- <a class="btn btn-primary" onclick="resetElements()">Reset</a> -->
                        </div>
                    </div>
                    
                </div>
                <div class="card-footer">
                    <input type="submit" value="Submit" class="btn btn-primary">
                </div>
            </div>
        </div>

        <div class="col-md">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Pertanyaan</h6>
                </div>
                <div class="card-body">
                    <div id="myForm">
                        <template>
                        <div class="form-group text-right"><i class="fas fa-times-circle text-danger" id="close"></i>
                            <input type="text" class="form-control mb-2" placeholder="Pertanyaan">
                            <div class="row">
                                <div class="col"><input type="text" class="form-control mb-2" placeholder="Pilihan 1"></div>
                                <div class="col"><input type="text" class="form-control mb-2" placeholder="Pilihan 2"></div>
                            </div>
                        </div>
                        </template>
                        <template>
                        <hr class="sidebar-divider">
                        <div class="form-group text-right"><i class="fas fa-times-circle text-danger"></i>
                            <input type="text" class="form-control mb-2" placeholder="Pertanyaan">
                            <div class="row">
                                <div class="col"><input type="text" class="form-control mb-2" placeholder="Pilihan 1"></div>
                                <div class="col"><input type="text" class="form-control mb-2" placeholder="Pilihan 2"></div>
                                <div class="col"><input type="text" class="form-control mb-2" placeholder="Pilihan 3"></div>
                            </div>
                        </div>
                        </template>
                        <template>
                        <hr class="sidebar-divider">
                        <div class="form-group text-right"><i class="fas fa-times-circle text-danger" id="close"></i>
                        <div class="form-group">
                            <input type="text" class="form-control mb-2" placeholder="Pertanyaan">
                        </div>
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </form>

</div>
@endsection

@section('script')
<script src="js/form.js"></script>
@endsection