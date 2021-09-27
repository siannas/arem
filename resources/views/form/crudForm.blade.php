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
    @include('form.alert')
    <div class="row">
        <div class="col-md">
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
                        <textarea class="form-control" rows="2" placeholder="Masukkan Deskripsi Pertanyaan" name="deskripsi"></textarea>
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
                    <button  class="btn btn-primary" onclick="$('#mainform').trigger('submit')">Simpan</button>
                </div>
            </div>
        </div>

        <div class="col-md">
            <form action="" id="mainform" method="post">
                <div class="accordion shadow" id="accordionPertanyaan"> 
                
                </div>
            </form>
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
                            <input type="text" class="form-control mb-3" placeholder="Pertanyaan" id="pertanyaan" >
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
                        <input type="text" class="form-control mb-3" placeholder="Pertanyaan" id="pertanyaan" >  
                    </div>
                    <div class="form-group row collapse" id="suffixContainer">
                        <label class="col-sm-3 col-form-label">Suffix</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" placeholder="Suffix" id="suffix" disabled>
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
                        <input type="text" class="form-control mb-3" placeholder="Perintah" id="pertanyaan" >  
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
                    <input type="text" class="form-control" placeholder="Perintah Pertanyaan" id="tambahan-pertanyaan">
                </div>
            </div>
            <div class="form-group row collapse" id="suffixContainer">
                <label class="col-sm-3 col-form-label">Suffix</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" placeholder="Suffix" id="tambahan-suffix" disabled>
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

$('#mainform').submit(async function(e){
    e.preventDefault();
    $('#loading').modal('show');
    var obj = $("form");
    var all= {};
    $.each(obj, function(i, val) {
        Object.assign(all,getFormData($(val)));
    });
    console.log(all);
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
        "judul": all['judul'],
        "gambar-petunjuk": null,
        "pertanyaan": json
    }

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

    setTimeout(() => {
        $('#loading').modal('hide');
    }, 1000);
})

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

const myOptions = function(id, optionData=""){
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
        id_ = id+'_'+data_['id']+'_container';
        ifSelectedOpsi = '<option value="none">None</option><option value="2" selected >Isian</option>';
        additionalHtml = myPertanyaanTambahan({'value': (data_.tipe).toString()}, id_, data_['id'], data_)
    }
    
    
    var html = `<div class="input-group mb-3" id="${id_}">
        <div class="input-group-prepend align-items-center" style="padding: 0 12px;">
            <input type="radio" aria-label="Radio button" style="width: 1em;height: 1em;" disabled>
        </div>
        <input type="text" name="${id+'_opsi[]'}" class="form-control d-inline" placeholder="Pilihan" value="${ value }">
        <input type="text" name="${id+'_child[]'}" value="${idRandom}" readonly hidden>
        <div class="input-group-append">
            <select name="${id+'_opsi_tipe[]'}" class="custom-select" placeholder="" style="border-radius: 0 5.6px 5.6px 0;" onchange="myPertanyaanTambahan(this,'${id_}', '${idRandom}')">
                <option disabled>Jika dipilih</option>
                ${ ifSelectedOpsi }
            </select>
        </div>
    </div>`;
    return html + additionalHtml;
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
        pertanyaan.attr('onfocusout', 'updatePertanyaan(this.value,"'+id+'_judul" )');
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
            for (let opsi of data.opsi) {
                html = html + myOptions(id, opsi);
            }
        }else{
            for (let i = 1; i < 3; i++) {
                html = html + myOptions(id);
            }
        }
        
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
        pertanyaan.attr('onfocusout', 'updatePertanyaan(this.value,"'+id+'_judul" )');
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
        pertanyaan.attr('onfocusout', 'updatePertanyaan(this.value,"'+id+'_judul" )');
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

const updatePertanyaan = function(val, id_judul){
    if (val === "") val = "Pertanyaan";
    $('#'+id_judul).text(val);
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

$( document ).ready(function() {
@foreach ( $pertanyaan->pertanyaan as $key => $val )
myUrutan.push(@json($val->id));
myQuestions[@json($val->id)] = @json($val);
myPertanyaan((@json($val->tipe)).toString(), @json($val->id), @json($val));
@endforeach
});
</script>
@endsection