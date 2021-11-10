@extends('layouts.layout')

@section('title')
Tambah Form Skrining
@endsection

@section('formStatus')
active
@endsection

@section('content')
<!-- Modal -->
<div class="modal fade" id="simpulanModal1" tabindex="-1" aria-labelledby="simpulanModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <form id="form-simpulanModal1">
        <div class="modal-header">
            <h5 class="modal-title" id="simpulanModal1Label">Simpulan Modal</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body" id="simpulanModal1Body">
            
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-success" >OK</button>
        </div>
        </form>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="simpulanModal2" tabindex="-1" aria-labelledby="simpulanModal" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <form id="form-simpulanModal2">
        <div class="modal-header">
            <h5 class="modal-title" id="simpulanModal2Label">Simpulan Modal</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body" id="simpulanModal2Body">
            <div class="form-group">
                <label>Nama Variabel</label>
                <input type="text" class="form-control" placeholder="Nama Variabel" name="variabel" required>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-success" >OK</button>
        </div>
        </form>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="previewModal" tabindex="-1" aria-labelledby="previewModal" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="previewModalLabel">Pratinjau Pertanyaan</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body" id="previewModalBody">
            ...
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </div>
        </div>
    </div>
</div>
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Tambah Form Skrining</h1>
    @include('form.alert')
    <div class="row">
        <div class="col-md-6">
            <!-- Basic Card Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Detail</h6>
                </div>
                <div class="card-body">
                    <form>
                    <div class="form-group">
                        <label><b>Judul</b></label>
                        <input type="text" class="form-control" placeholder="Masukkan Judul Pertanyaan" name="judul" value="{{ $judul }}">
                    </div>
                    <div class="form-group">
                        <label><b>Deskripsi</b></label>
                        <textarea class="form-control" rows="2" placeholder="Masukkan Deskripsi Pertanyaan" name="deskripsi" >{{ $deskripsi }}</textarea>
                    </div>
                    <div class="form-group">
                        <label><b>Tipe Pertanyaan</b></label>
                        <div class="input-group">
                            <select id="terserah" class="form-control">
                                <option disabled selected>Pilih Tipe</option>
                                <!-- <option value="1">Pilihan</option> -->
                                <option value="2">Isian</option>
                                <option value="3">Pilihan</option>
                                <option value="4">Upload</option>
                            </select>
                            <div class="input-group-append">
                                <button class="btn btn-success font-weight-bold" type="button" onclick="addPertanyaan()"><i class="fas fa-plus"></i>&nbsp Tambah</button>
                            </div>
                        </div>
                    </div>
                    </form>
                </div>
                <div class="card-footer">
                    <a href="{{url('/formulir/'.$id_form)}}" class="btn btn-secondary"><i class="fas fa-fw fa-sign-out-alt"></i> Kembali</a>
                    <button  class="btn btn-primary" onclick="$('#mainform').trigger('submit')"><i class="fas fa-fw fa-save"></i> Simpan</button>
                    <button  class="btn btn-info" id="previewButton" data-toggle="modal" data-target="#previewModal" ><i class="fas fa-fw fa-eye"></i> Pratinjau</button>
                </div>
            </div>
            
        </div>

        <div class="col-md-6">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#question" role="tab" aria-controls="question" aria-selected="true">Pertanyaan</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="conclusion-tab" data-toggle="tab" href="#conclusion" role="tab" aria-controls="conclusion" aria-selected="false">Simpulan</a>
                </li>
            </ul>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="question" role="tabpanel" aria-labelledby="question-tab">
                    <form action="" id="mainform" method="post">
                        <div class="accordion shadow" id="accordionPertanyaan"> 
                        
                        </div>
                    </form>
                </div>
                <div class="tab-pane fade" id="conclusion" role="tabpanel" aria-labelledby="conclusion-tab">
                    <div class="card shadow mb-4 br-t-0">
                        <form method="get" id="simpulan-form">
                        <div class="accordion" id="simpulan-content">
                            
                        </div>
                        </form>
                        <div class="card-body">
                            <div>
                                <button class="w-100 btn btn-success" id="tambah-simpulan"><i class="fas fa-plus"></i>&nbsp Tambah</button>
                            </div>
                        </div>                        
                    </div>
                </div>
            </div>
        </div>
        
    </div>
    <template>
        <div class="card">
            <div class="d-flex">
                <a class="card-header py-3 flex-grow-1 " href="#" data-toggle="collapse" id="collapse-toggle" aria-expanded="false">
                </a>
                <div class="input-group" style="width:unset!important;">
                    <div class="input-group-append">
                        <button class="btn btn-danger font-weight-bold" style="padding: 0 18px;border-radius:0;" type="button" id="delete"><i class="fas fa-trash"></i></button>
                    </div>
                </div>
            </div>
            <div id="collapse" class="collapse" data-parent="#accordionPertanyaan">
                <div class="card-body">
                    <div class="form-group">
                        <div class="mb-2" id="sub-pertanyaan">
                            <input type="text" class="form-control mb-3" placeholder="Pertanyaan" id="pertanyaan" onfocusout="myTextOnFocusOut(this, this.value)">
                        </div>  
                    </div>
                </div>
            </div>
        </div>
    </template>
    <template>
        <div class="card">
            <div class="d-flex">
                <a class="card-header py-3 flex-grow-1 " href="#" data-toggle="collapse" id="collapse-toggle" aria-expanded="false">
                </a>
                <div class="input-group" style="width:unset!important;">
                    <div class="input-group-append">
                        <button class="btn btn-danger font-weight-bold" style="padding: 0 18px;border-radius:0;" type="button" id="delete"><i class="fas fa-trash"></i></button>
                    </div>
                </div>
            </div>
            <div id="collapse" class="collapse" data-parent="#accordionPertanyaan">
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <div></div>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="TanpaSuffix" checked onclick="myToggleInput(this, '#suffix-container')">
                            <label class="custom-control-label" for="TanpaSuffix" >Tanpa Suffix</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control mb-3" placeholder="Pertanyaan" id="pertanyaan" onfocusout="myTextOnFocusOut(this, this.value)">  
                    </div>
                    <div class="form-group row collapse" id="suffixContainer">
                        <label class="col-sm-3 col-form-label">Suffix</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" placeholder="Suffix" id="suffix" disabled onfocusout="myTextOnFocusOut(this, this.value)">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </template>
    <template>
        <div class="card">
            <div class="d-flex">
                <a class="card-header py-3 flex-grow-1 " href="#" data-toggle="collapse" id="collapse-toggle" aria-expanded="false">
                </a>
                <div class="input-group" style="width:unset!important;">
                    <div class="input-group-append">
                        <button class="btn btn-danger font-weight-bold" style="padding: 0 18px;border-radius:0;" type="button" id="delete"><i class="fas fa-trash"></i></button>
                    </div>
                </div>
            </div>
            <div id="collapse" class="collapse" data-parent="#accordionPertanyaan">
                <div class="card-body">
                    <div class="form-group">
                        <input type="text" class="form-control mb-3" placeholder="Perintah" id="pertanyaan" onfocusout="myTextOnFocusOut(this, this.value)">  
                    </div>
                </div>
            </div>
        </div>
    </template>

    <template>
        <div class="form-group" style="margin-left:40px;" >
            <div class="d-flex justify-content-between">
                <label><b>Tambahan</b></label> 
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="TanpaSuffix" checked onclick="myToggleInput(this, '#suffix-container')">
                    <label class="custom-control-label" for="TanpaSuffix" >Tanpa Suffix</label>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-3 col-form-label">Pertanyaan</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" placeholder="Perintah Pertanyaan" id="tambahan-pertanyaan" onfocusout="myTextOnFocusOut(this, this.value)">
                </div>
            </div>
            <div class="form-group row collapse" id="suffixContainer">
                <label class="col-sm-3 col-form-label">Suffix</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" placeholder="Suffix" id="tambahan-suffix" disabled onfocusout="myTextOnFocusOut(this, this.value)">
                </div>
            </div>
        </div>
    </template>
</div>
@endsection

@section('script')
<script>
var myQuestions = {};
var myUrutan = [];
var jsonPertanyaan = @json($pertanyaan);

const simpanAtauPreviewAtauRefresh = async function(isPreview=false, isRefresh=false){    
    $('#loading').modal('show');
    var obj = $("form");
    var all= {};
    $.each(obj, function(i, val) {
        Object.assign(all,getFormData($(val)));
    });
    var json = []
    var deleted = []
    for (var i in myUrutan) {
        var key = myUrutan[i];
        if(all[key+"_pertanyaan"] === undefined){
            delete myQuestions[key]
            deleted.push(i)
            continue
        }
        myQuestions[key]['pertanyaan'] = all[key+"_pertanyaan"];

        if (myQuestions[key]['tipe'] === 2) {
            myQuestions[key]['suffix'] = all[key+"_suffix"] || null;
        }
        else if(myQuestions[key]['tipe'] === 3){
            const types = all[key+"_opsi_tipe"]
            for (var index in types) {
                if(types[index] === 'none'){
                    myQuestions[key]['opsi'][index] = all[key+"_opsi"][index]
                }else if(types[index] === '2'){
                    var childKey = all[key+"_child"][index];
                    myQuestions[key]['opsi'][index] = {
                        '0': all[key+"_opsi"][index],
                        'if-selected': {
                            "id": childKey,
                            "tipe": 2,
                            "pertanyaan": all[childKey+"_pertanyaan"],
                            "suffix": all[childKey+"_suffix"] || null,
                            "required": true
                        }
                    };
                }
            }
        }
        json.push(myQuestions[key]);
    }
    //delete key yang gak dipakai karena sudah didelete
    for (let i = deleted.length-1; i >= 0  ; i--) {
        myUrutan.splice(i,1);
    }
    
    jsonPertanyaan = {
        "judul": all['judul'].trim(),
        "deskripsi": all['deskripsi'].trim(),
        "gambar-petunjuk": null,
        "pertanyaan": json
    }

    if(isPreview){
        try {
            let data = {
                'judul': all['judul'],
                'json': JSON.stringify(jsonPertanyaan)
            };
            const res = await myRequest.post( '{{ route('pertanyaan.preview') }}' , data)
            $('#previewModalBody').html(res);
            // myAlert('Berhasil Preview');
        } catch(err) {
            myAlert('gagal, '+JSON.stringify(err['statusText']),'danger');
        }
    }else if(isRefresh){

    }else{
        try {
            let data = {
                'judul': all['judul'],
                'json': JSON.stringify(jsonPertanyaan)
            };
            const res = await myRequest.put( '{{ route('pertanyaan.update', ['pertanyaan'=> $id_pertanyaan]) }}' , data)
            myAlert('Berhasil menyimpan');
        } catch(err) {
            myAlert('gagal, '+JSON.stringify(err['statusText']),'danger');
        }
    }

    setTimeout(() => {
        $('#loading').modal('hide');
    }, 1000);
}

$('#mainform').submit(function(e){
    e.preventDefault();
    simpanAtauPreviewAtauRefresh();
});

$('#previewButton').on('click',function(e){
    simpanAtauPreviewAtauRefresh(true);
});

const myToggleInput = function(self, id_container){
    const elem = $('#'+id_container);
    const inputs = $('#'+id_container+' :input');

    if(self.checked){
        elem.collapse('hide');
        inputs.prop('disabled', true);
    }else{
        elem.collapse('show');
        inputs.prop('disabled', false);
    }
}

const myToggleCard = function(self, id_card){
    const elem = $('#'+id_card);
    elem.collapse('toggle');
    // console.log(elem.);
}

const myOptions = function(id, optionData="", withDeleteButton=false){
    var idRandom;
    var ifSelectedOpsi;
    var additionalHtml = '';
    var id_;
    var value;
    
    if(typeof optionData === 'string'){
        value = optionData;
        idRandom = getRandomString(5);
        id_ = id+'_'+idRandom+'_container';
        ifSelectedOpsi = '<option value="none" selected>None</option><option value="2">Isian</option>';
    }else{
        var data_ = optionData['if-selected'];
        value = optionData['0'];
        idRandom = data_['id'];
        id_ = id+'_'+data_['id']+'_container';
        ifSelectedOpsi = '<option value="none">None</option><option value="2" selected >Isian</option>';
        additionalHtml = myPertanyaanTambahan({'value': (data_.tipe).toString()}, id_, data_['id'], data_)
    }
    
    
    var html = `<div class="input-group mb-3" id="${id_}">
        <div class="input-group-prepend align-items-center" style="padding: 0 12px;">
            <input type="radio" aria-label="Radio button" style="width: 1em;height: 1em;" disabled>
        </div>
        <input type="text" name="${id+'_opsi[]'}" class="form-control d-inline" placeholder="Pilihan" value="${ value }" onfocusout="myTextOnFocusOut(this, this.value)">
        <input type="text" name="${id+'_child[]'}" value="${idRandom}" readonly hidden onfocusout="myTextOnFocusOut(this, this.value)">
        <div class="input-group-append">
            <select name="${id+'_opsi_tipe[]'}" class="custom-select" placeholder="" style="border-radius: ${withDeleteButton ? '0' : '0 5.6px 5.6px 0' } ;" onchange="myPertanyaanTambahan(this,'${id_}', '${idRandom}')">
                <option disabled>Jika dipilih</option>
                ${ ifSelectedOpsi }
            </select>
            ${withDeleteButton ? '<button class="btn btn-danger font-weight-bold" style="padding: 0 13px;" type="button" id="delete" onclick="$(\'#'+id_+'\').remove();$(\'#'+id_+'_tambahan\').remove()"><i class="fas fa-times"></i></button>' : ''}
        </div>
    </div>`;
    return html + additionalHtml;
}

const myButtonTambahOpsi = function(onclick_str){
    return `<div class="input-group mb-3" >
        <div class="input-group-prepend align-items-center" style="padding: 0 12px;">
            <input type="radio" aria-label="Radio button" style="width: 1em;height: 1em;" disabled>
        </div>
        <div class="input-group-append">
            <button class="btn btn-success font-weight-bold" type="button" onclick="${onclick_str}" ><i class="fas fa-plus"></i>&nbsp Tambah</button>
        </div>
    </div>
    `
}

const myPertanyaan = function(tipe, id, data={}){
    if (tipe === '1') {

    }else if(tipe === '3'){
        var temp = document.getElementsByTagName("template")[0];
        var clone = temp.content.cloneNode(true);
        const elem = $(clone);
        const container =  elem.children(":first-child");
        container.prop('id', id+'_pertanyaan');

        var pertanyaan = elem.find('#pertanyaan');
        pertanyaan.prop('id', id+'_pertanyaan');
        pertanyaan.attr('name', id+'_pertanyaan');
        pertanyaan.attr('onfocusout', 'updatePertanyaan(this,"'+id+'_judul" )');
        pertanyaan.val(data.pertanyaan || "");

        var deleteButton = elem.find('#delete');
        deleteButton.prop('id', id+'_delete');
        deleteButton.attr('onclick', 'removeElement("'+id+'_pertanyaan")');

        var toggle = elem.find('#collapse-toggle');
        toggle.prop('id', id+'_collapse-toggle');
        toggle.html('<h6 class="m-0 font-weight-bold text-primary" id="'+id+'_judul" >'+(data.pertanyaan || "Pertanyaan")+'</h6>');
        toggle.attr('onclick', 'myToggleCard(this, "'+id+'_collapse")');
        // toggle.attr('data-target', '#'+id+'_collapse');
        // toggle.attr('aria-controls', id+'_collapse');

        var collapse = elem.find('#collapse');
        collapse.prop('id', id+'_collapse');

        var subPertanyaan = elem.find('#sub-pertanyaan');

        html = '';
        if(data.opsi){
            for (let key in data.opsi) {
                html = html + myOptions(id, data.opsi[key], key>1);
            }
        }else{
            for (let i = 0; i < 3; i++) {
                html = html + myOptions(id, "", i>1);
            }
        }

        html = html + myButtonTambahOpsi('myTambahOpsi(this,\''+id+'\')');
        
        subPertanyaan.append(html);
        $("#accordionPertanyaan").append(container);
    }else if(tipe === '2'){
        var temp = document.getElementsByTagName("template")[1];
        var clone = temp.content.cloneNode(true);
        const elem = $(clone);
        const container =  elem.children(":first-child");
        container.prop('id', id+'_pertanyaan');

        var pertanyaan = elem.find('#pertanyaan');
        pertanyaan.prop('id', id+'_pertanyaan');
        pertanyaan.attr('name', id+'_pertanyaan');
        pertanyaan.attr('onfocusout', 'updatePertanyaan(this,"'+id+'_judul" )');
        pertanyaan.val(data.pertanyaan || "");

        var deleteButton = elem.find('#delete');
        deleteButton.prop('id', id+'_delete');
        deleteButton.attr('onclick', 'removeElement("'+id+'_pertanyaan")');

        var toggle = elem.find('#collapse-toggle');
        toggle.prop('id', id+'_collapse-toggle');
        toggle.html('<h6 class="m-0 font-weight-bold text-primary" id="'+id+'_judul" >'+(data.pertanyaan || "Pertanyaan")+'</h6>')
        toggle.attr('onclick', 'myToggleCard(this, "'+id+'_collapse")');
        // toggle.attr('data-target', '#'+id+'_collapse');
        // toggle.attr('aria-controls', id+'_collapse');

        var collapse = elem.find('#collapse');
        collapse.prop('id', id+'_collapse');

        var TanpaSuffix = elem.find('#TanpaSuffix');
        TanpaSuffix.prop('id', id+'_TanpaSuffix');
        TanpaSuffix.attr('onclick', "myToggleInput(this, '"+id+"_suffixContainer')");
        TanpaSuffix.next().attr('for', id+'_TanpaSuffix');
        
        var suffixContainer = elem.find('#suffixContainer');
        suffixContainer.prop('id', id+'_suffixContainer');

        var tambahanSuffix = elem.find('#suffix');
        tambahanSuffix.attr('name', id+'_suffix');
        tambahanSuffix.val(data.suffix || "");

        if(data.suffix){
            TanpaSuffix.attr('checked', false );
            suffixContainer.addClass('show');
            tambahanSuffix.prop('disabled', false);
        }

        $("#accordionPertanyaan").append(container);
    }else if(tipe === '4'){
        var temp = document.getElementsByTagName("template")[2];
        var clone = temp.content.cloneNode(true);
        const elem = $(clone);
        const container =  elem.children(":first-child");
        container.prop('id', id+'_pertanyaan');

        var pertanyaan = elem.find('#pertanyaan');
        pertanyaan.prop('id', id+'_pertanyaan');
        pertanyaan.attr('name', id+'_pertanyaan');
        pertanyaan.attr('onfocusout', 'updatePertanyaan(this,"'+id+'_judul" )');
        pertanyaan.val(data.pertanyaan || "");

        var deleteButton = elem.find('#delete');
        deleteButton.prop('id', id+'_delete');
        deleteButton.attr('onclick', 'removeElement("'+id+'_pertanyaan")');

        var toggle = elem.find('#collapse-toggle');
        toggle.prop('id', id+'_collapse-toggle');
        toggle.html('<h6 class="m-0 font-weight-bold text-primary" id="'+id+'_judul" >'+(data.pertanyaan || "Pertanyaan")+'</h6>')
        toggle.attr('onclick', 'myToggleCard(this, "'+id+'_collapse")');
        // toggle.attr('data-target', '#'+id+'_collapse');
        // toggle.attr('aria-controls', id+'_collapse');

        var collapse = elem.find('#collapse');
        collapse.prop('id', id+'_collapse');

        $("#accordionPertanyaan").append(container);
    }
}

const myTambahOpsi = function(self, id){
    var btn_parent = $(self).parent().parent();
    html = myOptions(id, "", true);
    btn_parent.before(html);
}

const myPertanyaanTambahan = function(self, id_neighbor, id_baru, dataTambahan={}){
    const val = self.value;
    const curElem = $('#'+id_neighbor+'_tambahan');
    
    if(curElem.length) curElem.remove();

    if(val === 'none'){
        console.log('none')
    }else if(val === '2'){
        var temp = document.getElementsByTagName("template")[3];
        var clone = temp.content.cloneNode(true);
        const elem = $(clone);
        const elemChild = elem.children(":first-child")
        elemChild.prop('id', id_neighbor+'_tambahan');

        var TanpaSuffix = elem.find('#TanpaSuffix');
        TanpaSuffix.prop('id', id_neighbor+'_TanpaSuffix');
        TanpaSuffix.attr('onclick', "myToggleInput(this, '"+id_neighbor+"_suffixContainer')");
        TanpaSuffix.next().attr('for', id_neighbor+'_TanpaSuffix');

        var suffixContainer = elem.find('#suffixContainer');
        suffixContainer.prop('id', id_neighbor+'_suffixContainer');

        var tambahanPertanyaan = elem.find('#tambahan-pertanyaan');
        tambahanPertanyaan.removeAttr('id');
        tambahanPertanyaan.attr('name', id_baru+'_pertanyaan');
        tambahanPertanyaan.attr('value', dataTambahan.pertanyaan || "");

        var tambahanSuffix = elem.find('#tambahan-suffix');
        tambahanSuffix.removeAttr('id');
        tambahanSuffix.attr('name', id_baru+'_suffix');
        tambahanSuffix.val(dataTambahan.suffix || "");

        if(dataTambahan.suffix){
            TanpaSuffix.attr('checked', false );
            suffixContainer.addClass('show');
            tambahanSuffix.prop('disabled', false);
        }

        if(Object.keys(dataTambahan).length === 0){
            elem.insertAfter('#'+id_neighbor);
        }else{
            return elemChild.prop('outerHTML');
        }
    }
    return '';
}

const updatePertanyaan = function(self, id_judul){
    var $jwb = $(self);
    var filteredval = $jwb.val().trim();
    $jwb.val(filteredval);

    if (filteredval === "") filteredval = "Pertanyaan";
    $('#'+id_judul).text(filteredval);
}

var i = 0; /* Set Global Variable i */
function increment(){
    i += 1; /* Function for automatic increment of field's "Name" attribute. */
}
/*
---------------------------------------------
Function to Remove Form Elements Dynamically
---------------------------------------------
*/
function removeElement(id){
    $('#'+id).remove();
}
/*
----------------------------------------------------------------------------
Functions that will be called upon, when user click on the Name text field.
----------------------------------------------------------------------------
*/
function addPertanyaan(){
    var value = document.getElementById('terserah').value
    if(value==='2'){
        var randomId = getRandomString(5);
        var questionObj = {
            "id": randomId,
            "tipe": 2,
            "pertanyaan": "",
            "suffix": "",
            "required": true
        };
        myUrutan.push(randomId)
        myQuestions[randomId]=questionObj;
        myPertanyaan('2',randomId);
    }
    else if(value==='3'){
        var randomId = getRandomString(5);
        var questionObj = {
            "id": randomId,
            "tipe": 3,
            "pertanyaan": "",
            "opsi": ["", ""],
            "required": true
        };
        myUrutan.push(randomId)
        myQuestions[randomId]=questionObj;
        myPertanyaan('3',randomId);
    }
    else if(value==='4'){
        var randomId = getRandomString(5);
        var questionObj = {
            "id": randomId,
            "tipe": 4,
            "pertanyaan": "",
            "required": true
        };
        myUrutan.push(randomId)
        myQuestions[randomId]=questionObj;
        myPertanyaan('4',randomId);
    }
}

var myTextOnFocusOut = function(self, value){
    var $jwb = $(self);
    var filteredval = $jwb.val().trim();
    $jwb.val(filteredval);
    // if(filteredval === ''){
    //     $jwb.addClass('invalid');
    // }else{
    //     $jwb.removeClass('invalid');
    // }
}

$( document ).ready(function() {
@foreach ( $pertanyaan->pertanyaan as $key => $val )
myUrutan.push(@json($val->id));
myQuestions[@json($val->id)] = @json($val);
myPertanyaan((@json($val->tipe)).toString(), @json($val->id), @json($val));
@endforeach
});
</script>
@endsection

@include('form.crudSimpulan')