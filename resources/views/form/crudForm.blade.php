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
                        <input type="text" class="form-control" placeholder="Masukkan Judul Pertanyaan" name="judul">
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
                                <option value="4">Isian Dengan Foto</option>
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
                        <button class="btn btn-danger font-weight-bold" style="padding: 0 18px;border-radius:0;" type="button"><i class="fas fa-trash"></i></button>
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
    </template>
    <template>
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
var myQuestionss = {};

function getFormData($form){
    var unindexed_array = $form.serializeArray();
    var indexed_array = {};

    $.map(unindexed_array, function(n, i){
        var key =n['name'];
        var is_arr=false;
        if(/(\[\d+\])$/.test(key)){
            key = key.replace( /(\[\d+\])$/, "");
            is_arr=true;
        }else if(/(\[\])$/.test(key)){
            key = key.replace( /(\[\])$/, "");
            is_arr=true;
        }

        if(is_arr && !(key in indexed_array)) indexed_array[key] = [];            
        if(typeof n['value'] === 'string') n['value']=n['value'].trim()

        if(is_arr){
            indexed_array[key].push( n['value']);
        }else{
            indexed_array[key] = n['value'];
        }
        
    });

    return indexed_array;
}

$('#mainform').submit(function(e){
    e.preventDefault();
    var obj = $("form");
    var all= {};
    $.each(obj, function(i, val) {
        Object.assign(all,getFormData($(val)));
    });
    console.log(all);
    var json = []
    for (var key in myQuestions) {
        var counter = 0;
        myQuestions[key]['pertanyaan'] = all[key+"_pertanyaan"];
        if(myQuestions[key]['tipe'] === 3){
            const types = all[key+"_opsi_tipe"]
            for (var index in types) {
                if(types[index] === 'none'){
                    myQuestions[key]['opsi'][index] = all[key+"_opsi"][index]
                }else if(types[index] === '2'){
                    var childKey = all[key+"_child"][counter];
                    myQuestions[key]['opsi'][index] = [
                        all[key+"_opsi"][index],
                        {
                            "id": childKey,
                            "tipe": 2,
                            "pertanyaan": all[counter+"_pertanyaan"],
                            "suffix": all[counter+"_suffix"],
                            "required": true
                        }
                    ];
                }
            }
        }
    }
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

const myPertanyaan = function(tipe, id){
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

        var toggle = elem.find('#collapse-toggle');
        toggle.prop('id', id+'_collapse-toggle');
        toggle.html('<h6 class="m-0 font-weight-bold text-primary" id="'+id+'_judul" >Pertanyaan</h6>')
        toggle.attr('data-target', '#'+id+'_collapse');
        toggle.attr('aria-controls', id+'_collapse');

        var collapse = elem.find('#collapse');
        collapse.prop('id', id+'_collapse');

        var subPertanyaan = elem.find('#sub-pertanyaan');

        html = '';
        for (let i = 1; i < 3; i++) {
            var id_ = id+'_Pilihan'+i+'_container';
            var idRandom = getRandomString(5);
            var html = html + `<div class="input-group mb-3" id="${id_}">
                <div class="input-group-prepend align-items-center" style="padding: 0 12px;">
                    <input type="radio" aria-label="Radio button" style="width: 1em;height: 1em;" disabled>
                </div>
                <input type="text" name="${id+'_opsi[]'}" class="form-control d-inline" placeholder="Pilihan ${i}">
                <input type="text" name="${id+'_child[]'}" value="${idRandom}" readonly hidden>
                <div class="input-group-append">
                    <select name="${id+'_opsi_tipe[]'}" class="custom-select" placeholder="" style="border-radius: 0 5.6px 5.6px 0;" onchange="myPertanyaanTambahan(this,'${id_}', '${idRandom}')">
                        <option disabled>Jika dipilih</option>
                        <option value="none" selected>None</option>
                        <option value="2">Isian</option>
                    </select>
                </div>
            </div>`;
        }
        // console.log(html)
        subPertanyaan.append(html);
        $("#accordionPertanyaan").append(container);
    }else if(tipe === '2'){

    }else if(tipe === '4'){

    }
}

const myPertanyaanTambahan = function(self, id_neighbor, id_baru){
    const val = self.value;
    const curElem = $('#'+id_neighbor+'_tambahan');
    
    if(curElem.length) curElem.remove();

    if(val === 'none'){
        console.log('none')
    }else if(val === '2'){
        var temp = document.getElementsByTagName("template")[3];
        var clone = temp.content.cloneNode(true);
        const elem = $(clone);
        elem.children(":first-child").prop('id', id_neighbor+'_tambahan');

        var TanpaSuffix = elem.find('#TanpaSuffix');
        TanpaSuffix.prop('id', id_neighbor+'_TanpaSuffix');
        TanpaSuffix.attr('onclick', "myToggleInput(this, '"+id_neighbor+"_suffixContainer')");
        TanpaSuffix.next().attr('for', id_neighbor+'_TanpaSuffix');

        var suffixContainer = elem.find('#suffixContainer');
        suffixContainer.prop('id', id_neighbor+'_suffixContainer');

        var tambahanPertanyaan = elem.find('#tambahan-pertanyaan');
        tambahanPertanyaan.removeProp('id');
        tambahanPertanyaan.attr('name', id_baru+'_pertanyaan');

        var tambahanSuffix = elem.find('#tambahan-suffix');
        tambahanSuffix.removeProp('id');
        tambahanSuffix.attr('name', id_baru+'_suffix');

        elem.insertAfter('#'+id_neighbor);
    }
}

const updatePertanyaan = function(val, id_judul){
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
function removeElement(parentDiv, childDiv){
    if (childDiv == parentDiv){
        alert("The parent div cannot be removed.");
    }
    else if (document.getElementById(childDiv)){
        var child = document.getElementById(childDiv);
        var parent = document.getElementById(parentDiv);
        parent.removeChild(child);
    }
    else{
        alert("Child div has already been removed or does not exist.");
    return false;
    }
}
/*
----------------------------------------------------------------------------
Functions that will be called upon, when user click on the Name text field.
----------------------------------------------------------------------------
*/
function addPertanyaan(){
    var value = document.getElementById('terserah').value
    console.log(value)
    if(value==='1'){
        var temp = document.getElementsByTagName("template")[0];
        var clon = temp.content.cloneNode(true);
        document.getElementById("myForm").appendChild(clon);
    }
    else if(value==='2'){
        var temp = document.getElementsByTagName("template")[1];
        var clon = temp.content.cloneNode(true);
        document.getElementById("myForm").appendChild(clon);
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
        myQuestionss[randomId]=questionObj;
        myPertanyaan('3',randomId);
    }
    else{
        // var r = document.createElement('span');
        // var y = document.createElement("INPUT");
        // y.setAttribute("type", "text");
        // y.setAttribute("class", "form-control");
        // y.setAttribute("placeholder", "Name");
        // var g = document.createElement("I");
        // g.setAttribute("class", "fas fa-times-circle");
        // increment();
        // y.setAttribute("Name", "textelement_" + i);
        // r.appendChild(y);
        // g.setAttribute("onclick", "removeElement('myForm','id_" + i + "')");
        // r.appendChild(g);
        // r.setAttribute("id", "id_" + i);
        // document.getElementById("myForm").appendChild(r);
    }
    
}
/*
-----------------------------------------------------------------------------
Functions that will be called upon, when user click on the Reset Button.
------------------------------------------------------------------------------
*/
function resetElements(){
document.getElementById('myForm').innerHTML = '';
}

</script>
@endsection