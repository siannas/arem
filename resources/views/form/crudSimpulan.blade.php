@push('scripts')
<script>
var simpulan = `<div class="card">
    <div class="d-flex">
        <div class="input-group-prepend" style="padding:5px;background: #f8f9fc;">
            <select class="custom-select" style="height:unset;" id="types-selector">
                <option value="1">Tipe 1</option>
                <option value="2">Tipe 2</option>
                <option value="3">Tipe 3</option>
            </select>
        </div>
        <a class="card-header py-3 flex-grow-1 " data-toggle="collapse" id="collapse-toggle" aria-expanded="false">
            Simpulan
        </a>
        <div class="input-group" style="width:unset!important;">
            <div class="input-group-append">
                <button type="button" class="btn btn-danger font-weight-bold" style="padding: 0 18px;border-radius:0;" type="button" id="delete"><i class="fas fa-trash"></i></button>
            </div>
        </div>
    </div>
    <div id="simpulan" class="collapse" data-parent="#simpulan-content">
        <div class="card-body">
            
        </div>
    </div>
</div>`;

const tipe1 = `
<div class="form-group">
    <label>Nama Kolom</label>
    <input type="text" class="form-control" placeholder="Nama Kolom Simpulan" name="field">
</div>`;

const tipe2 = `<div class="form-group">
    <label>Nama Kolom</label>
    <input type="text" class="form-control" placeholder="Nama Kolom Simpulan" name="field">
</div>
<div class="form-group">
    <label class="col-form-label">Daftar Pertanyaan, Opsi</label>
    <button type="button" class="btn btn-sm btn-success float-right" id="pertanyaan-opsi-button"><i class="fas fa-fw fa-plus"></i></button>
    <table class="table mt-2" id="pertanyaan-opsi-tabel">
        <thead>
            <tr>
                <th scope="col">Pertanyaan</th>
                <th scope="col">opsi</th>
                <th width="20%"></th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>`;

const tipe3 = `<div class="form-group">
    <label class="col-form-label">Daftar Variabel</label>
    <button type="button" class="btn btn-sm btn-success float-right" id="variabel-button"><i class="fas fa-fw fa-plus"></i></button>
    <table class="table mt-2" id="variabel-tabel">
        <thead>
            <tr>
                <th scope="col">Variabel</th>
                <th scope="col">Pertanyaan</th>
                <th width="20%"></th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>
<div class="form-group">
    <label>Formula</label>
    <input type="text" class="form-control" placeholder="Formula Simpulan" name="formula">
</div>
<div class="form-group">
    <label class="col-form-label">Daftar Rentang</label>
    <button type="button" class="btn btn-sm btn-success float-right" id="rentang-button"><i class="fas fa-fw fa-plus"></i></button>                    
    <table class="table mt-2" id="rentang-tabel">
        <thead>
            <tr>
                <th scope="col">Rentang</th>
                <th scope="col">Kolom</th>
                <th width="1"></th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>`;

var mySimpulan;

const cekSimpulan= function(){
    mySimpulan=[];
    var obj = $('#simpulan-form');
    if(obj[0].checkValidity() === false){
        alert('Simpulan belum terisi sempurna, mohon dicek kembali');
        return false;
    }
    var all= {};
    $.each(obj, function(i, val) {
        Object.assign(all,getFormData($(val)));
    });
    all['id'].forEach(id=>{
        var simp = {}
        switch (all[id+'-tipe']) {
            case "1":
                var question_id = all[id+'-id']
                simp = {
                    tipe: 1,
                    id: question_id.substr(0, question_id.indexOf('_')),
                    field: all[id+'-field'],
                    opsi: all[id+'-opsi']
                }
                break;
            case "2":
                simp = {
                    tipe: 2,
                    field: all[id+'-field'],
                    on: all[id+"-on"].map((element, i) => [element, all[id+"-opsi"][i]])
                }
                break;
            case "3":
                simp = {
                    tipe: 3,
                    formula: all[id+'-formula'],
                    range: all[id+"-rentang"].map((element, i) => [element, all[id+"-field"][i]]),
                    vars: all[id+'-var'].reduce(function (arr, element, i) { arr[element]=all[id+'-on'][i]; return arr; }, {})
                }
                break;
        }
        mySimpulan.push(simp);
    })
    return true;
}

const generatePertanyaanList = function(type=null){
    var elem_str = '<div class="form-group"><label>Pertanyaan</label><select required name="pertanyaan"><option value="" disabled selected>Pilih Pertanyaan</option>';
    Object.values(myQuestions).forEach(e => {
        if(type){ //pertanyaan isian
            if(type===e['tipe']){
                elem_str+=`<option value="${e['id']+'_'+e['pertanyaan']}">${e['pertanyaan']}</option>`
            }
        }else{
            elem_str+=`<option value="${e['id']+'_'+e['pertanyaan']}">${e['pertanyaan']}</option>`
        }
    });
    elem_str +='</select></div>';
    return $(elem_str);
}

const generateOpsiList = function(id_pertanyaan){
    var elem_str = '<div class="form-group"><label>Pada Opsi</label><select required name="opsi"><option value="" disabled selected>Pilih Pertanyaan</option>';
    myQuestions[id_pertanyaan]['opsi'].forEach(e => {
        if(typeof e === 'object'){
            elem_str+=`<option value="${e[0]}">${e[0]}</option>`
        }else{
            elem_str+=`<option value="${e}">${e}</option>`;
        }
    });
    elem_str +='</select></div>';
    return $(elem_str);
}

const openModalSimpulan = function(id, type, id_row=null){
    var modalId;
    simpanAtauPreviewAtauRefresh(isRefresh=true);
    switch (type) {
        case 'pertanyaan-opsi-tabel':
            modalId = 'simpulanModal1';
            $pertanyaan = generatePertanyaanList(3)
            $('#simpulanModal1Body').empty().append($pertanyaan);
            $pertanyaanSelector = $pertanyaan.find('select');
            $pertanyaanSelector.select2({
                width: '100%'
            });
            $pertanyaanSelector[0].onchange= function(){
                $children = $('#simpulanModal1Body').children();
                if($children.length > 1){
                    $('#simpulanModal1Body').children(':last-child').remove();
                }
                var id_pertanyaan = this.value.substr(0, this.value.indexOf('_')); //ambil hanya id pertanyaan saja
                $opsi = generateOpsiList(id_pertanyaan);
                $('#simpulanModal1Body').append($opsi);
                $opsiSelector = $opsi.find('select');
                $opsiSelector.select2({
                    width: '100%'
                });
            };
            $("#form-simpulanModal1").removeAttr('onsubmit')
            $("#form-simpulanModal1")[0].onsubmit = function(e){
                e.preventDefault();
                var obj = $(this);
                var all= {};
                $.each(obj, function(i, val) {
                    Object.assign(all,getFormData($(val)));
                });
                if(id_row){
                    onTableEdit(id_row, type, all, id);
                }else{
                    onTableAdd(id, $("#"+id+"_pertanyaan-opsi-tabel"), type, all);
                }
                $('#'+modalId).modal('hide');
            }
            break;
        case 'variabel-tabel':
            modalId = 'simpulanModal2';
            $pertanyaan = generatePertanyaanList(2)
            $children = $('#simpulanModal2Body').children();
            if($children.length > 1){
                $('#simpulanModal2Body').children(':last-child').remove();
            }
            $('#simpulanModal2Body').append($pertanyaan);
            $pertanyaanSelector = $pertanyaan.find('select');
            $pertanyaanSelector.select2({
                width: '100%'
            });
            $("#form-simpulanModal2")[0].onsubmit = function(e){
                e.preventDefault();
                var obj = $(this);
                var all= {};
                $.each(obj, function(i, val) {
                    Object.assign(all,getFormData($(val)));
                });
                if(id_row){
                    onTableEdit(id_row, type, all, id);
                }else{
                    onTableAdd(id, $("#"+id+"_variabel-tabel"), type, all);
                }
                $('#'+modalId).modal('hide');
            }
            break;
    }
    $('#'+modalId).modal('show');
}

const onTableEdit = function(id_row, type, data, id){
    var elem = $('#'+id_row);
    switch (type) {
        case 'pertanyaan-opsi-tabel':
            var str = data['pertanyaan'].split('_');
            elem.children()[0].innerHTML = str[1]+`<input type="hidden" name="${id}-on[]" value="${str[0]}">`;
            elem.children()[1].innerHTML = data['opsi']+`<input type="hidden" name="${id}-opsi[]" value="${data['opsi']}">`;
            break;
        case 'variabel-tabel':
            var str = data['pertanyaan'].split('_');
            elem.children()[0].innerHTML = data['variabel']+`<input type="hidden" name="${id}-var[]" value="${data['variabel']}">`;
            elem.children()[1].innerHTML = str[1]+`<input type="hidden" name="${id}-on[]" value="${str[0]}">`;
            break;
    }
}

const onTableAdd = function(id, $tabel, type, data=null){
    var str;
    const id2 = getRandomString(3);
    var elem;
    switch (type) {
        case 'pertanyaan-opsi-tabel':
            str = `<tr id="${id}-${id2}">
                <td>Mark</td>
                <td>Otto</td>
                <td>
                    <button type="button" class="btn btn-sm btn-warning" onclick="openModalSimpulan('${id}','pertanyaan-opsi-tabel', '${id}-${id2}')"><i class="fas fa-fw fa-pen"></i></button>
                    <button type="button" class="btn btn-sm btn-danger" onclick="onDeleteRow('${id}-${id2}')"><i class="fas fa-fw fa-times"></i></button>
                </td>
            </tr>`;
            elem = $(str);
            if(data){
                var str = data['pertanyaan'].split('_');
                elem.children()[0].innerHTML = str[1]+`<input type="hidden" name="${id}-on[]" value="${str[0]}">`;
                elem.children()[1].innerHTML = data['opsi']+`<input type="hidden" name="${id}-opsi[]" value="${data['opsi']}">`;
                break;
            }            
            break;
        case 'variabel-tabel':
            str=`<tr id="${id}-${id2}">
                <td>BB</td>
                <td>Otto</td>
                <td>
                    <button type="button" class="btn btn-sm btn-warning" onclick="openModalSimpulan('${id}','variabel-tabel', '${id}-${id2}')"><i class="fas fa-fw fa-pen"></i></button>
                    <button type="button" class="btn btn-sm btn-danger" onclick="onDeleteRow('${id}-${id2}')"><i class="fas fa-fw fa-times"></i></button>
                </td>
            </tr>`;
            elem = $(str);
            if(data){
                var str = data['pertanyaan'].split('_');
                elem.children()[0].innerHTML = data['variabel']+`<input type="hidden" name="${id}-var[]" value="${data['variabel']}">`;
                elem.children()[1].innerHTML = str[1]+`<input type="hidden" name="${id}-on[]" value="${str[0]}">`;
            }
            break;
        case 'rentang-tabel':
            str=`<tr id="${id}-${id2}">
                <td><input type="text" name="${id}-rentang[]" class="form-control" /></td>
                <td><input type="text" name="${id}-field[]"class="form-control" /></td>
                <td>
                    <button type="button" class="btn btn-sm btn-danger" onclick="onDeleteRow('${id}-${id2}')"><i class="fas fa-fw fa-times"></i></button>
                </td>
            </tr>`;
            elem = $(str);
            if(data){
                elem.children()[0].childNodes[0].value = (data[0]);
                elem.children()[1].childNodes[0].value = (data[1]);
            }
            break;
    }
    $tabel.find('tbody').append(elem);
}

const onDeleteRow = function(id){
    var elem = $('#'+id);
    elem.remove();
}

const onTypeChange = function(id, $konten, type, data=null){
    type = (typeof type === 'string') ? parseInt(type) : type;
    switch (type) {
        case 1:
            $konten.html(tipe1);
            $konten.prepend($(`<input type="hidden" name="${id}-tipe" value="1">`));
            var $field = $konten.find("[name='field']");
            $field.attr('name', id+'-field');
            $pertanyaan = generatePertanyaanList(3)
            $konten.append($pertanyaan);
            $pertanyaanSelector = $pertanyaan.find('select');
            $pertanyaanSelector.attr('name', id+'-id');
            $pertanyaanSelector.select2({
                width: '100%'
            });
            if(data){ //kalau load data dari db
                $field.val(data['field']);
                $pertanyaanSelector.val(data['id']+'_'+myQuestions[data['id']].pertanyaan).change();
                var id_pertanyaan = data['id']
                $opsi = generateOpsiList(id_pertanyaan);
                $konten.append($opsi);
                $opsiSelector = $opsi.find('select');
                $opsiSelector.attr('multiple','multiple');
                $opsiSelector.attr('name', id+'-opsi[]');
                $opsiSelector.select2({
                    width: '100%',
                });
                $opsiSelector.val(data['opsi']).change(); //reset semua value opsi
            }
            $pertanyaanSelector[0].onchange= function(){
                $children = $konten.children();
                if($children.length > 3){
                    $konten.children(':last-child').remove();
                }
                var id_pertanyaan = this.value.substr(0, this.value.indexOf('_')); //ambil hanya id pertanyaan saja
                $opsi = generateOpsiList(id_pertanyaan);
                $konten.append($opsi);
                $opsiSelector = $opsi.find('select');
                $opsiSelector.attr('multiple','multiple');
                $opsiSelector.attr('name', id+'-opsi[]');
                $opsiSelector.select2({
                    width: '100%',
                });
                $opsiSelector.val([]).change(); //reset semua value opsi
            };
            break;
        case 2:
            $konten.html(tipe2);
            $konten.prepend($(`<input type="hidden" name="${id}-tipe" value="2">`));
            var $field = $konten.find("[name='field']");
            $field.attr('name', id+'-field');
            var btn1=$konten.find('#pertanyaan-opsi-button');
            btn1.prop('id', id+'_pertanyaan-opsi-button');
            btn1.attr('onclick', `openModalSimpulan("${id}", "pertanyaan-opsi-tabel")`)
            // btn1.attr('onclick', `onTableAdd("${id}", $("#${id}_pertanyaan-opsi-tabel"), "pertanyaan-opsi-tabel")`)

            var tbl1=btn1.next();
            tbl1.prop('id', id+'_pertanyaan-opsi-tabel');

            if(data){ //kalau load data dari db
                $field.val(data['field']);
                var data_;
                data.on.forEach(d => {
                    data_ = {
                        pertanyaan: d[0]+'_'+myQuestions[d[0]].pertanyaan,
                        opsi: d[1]
                    }
                    onTableAdd(id, tbl1, "pertanyaan-opsi-tabel", data_) 
                });
            }
            break;
        case 3:
            $konten.html(tipe3);
            $konten.prepend($(`<input type="hidden" name="${id}-tipe" value="3">`));
            $formula = $konten.find("[name='formula']");
            $formula.attr('name', id+'-formula');
            var btn1=$konten.find('#variabel-button');
            btn1.prop('id', id+'_variabel-button');
            btn1.attr('onclick', `openModalSimpulan("${id}", "variabel-tabel")`)
            // btn1.attr('onclick', `onTableAdd("${id}", $("#${id}_variabel-tabel"), "variabel-tabel")`)

            var tbl1=btn1.next();
            tbl1.prop('id', id+'_variabel-tabel');
            
            var btn2=$konten.find('#rentang-button');
            btn2.prop('id', id+'_rentang-button');
            btn2.attr('onclick', `onTableAdd("${id}", $("#${id}_rentang-tabel"), "rentang-tabel")`)

            var tbl2=btn2.next();
            tbl2.prop('id', id+'_rentang-tabel');

            if(data){ //kalau load data dari db
                $formula.val(data['formula'])
                var data_, id_pertanyaan;
                Object.keys(data['vars']).foreach(key =>{
                    id_pertanyaan = data['vars'][key];
                    data_ = {
                        variabel: key,
                        pertanyaan: id_pertanyaan+"_"+myQuestions[id_pertanyaan].pertanyaan
                    }
                    onTableAdd(id, tbl1, "variabel-tabel", data_) 
                })
                data.range.forEach(d => {
                    onTableAdd(id, tbl2, "rentang-tabel", d) 
                });
            }
            break;
    }
}

const createSimpulanObj = function(data=null){
    var elem = $(simpulan);
    const id = getRandomString(3);

    var toggle = elem.find('#collapse-toggle');
    toggle.prop('id', id+'_collapse-toggle');
    toggle.attr('onclick', 'myToggleCard(this, "'+id+'_simpulan")');
    
    var simp = elem.find('#simpulan');
    simp.prop('id', id+'_simpulan');

    var konten = simp.children(":first-child");
    konten.prop('id', id+'_content');

    var typesSelector = elem.find('#types-selector');
    typesSelector.prop('id', id+'_types-selector');
    typesSelector.attr('onchange', `onTypeChange("${id}", $("#${id}_content"), this.value)`);

    var del = elem.find('#delete');
    del.prop('id', id+'_delete');
    del.attr('onclick', `$('#${id}').remove()`);

    elem.prop('id', id);
    elem.prepend($(`<input type="hidden" name="id[]" value="${id}">`));
    
    if(data){
        typesSelector.val(data['tipe']).change();
        onTypeChange(id, konten, data['tipe'], data);
    }else{
        onTypeChange(id, konten, 1);
    }

    return elem;
}

const onTambah = function(){
    simpanAtauPreviewAtauRefresh(isRefresh=true);

    var elem = createSimpulanObj();

    elem.find('#pertanyaan').select2({
        width: '100%'
    });

    $('#simpulan-content').append(elem);
}

$(document).ready(function(){
    $('#tambah-simpulan').on('click', onTambah);
    var elem;
    @foreach ( $simpulan as $s )
    elem = createSimpulanObj(@json($s));
    $('#simpulan-content').append(elem);
    @endforeach
})
</script>
@endpush