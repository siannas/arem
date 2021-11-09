@push('scripts')
<script>
var simpulan = `<div class="card">
    <div class="d-flex">
        <div class="input-group-prepend" style="padding:5px;background: #f8f9fc;">
            <select class="custom-select" style="height:unset;">
                <option value="1">Tipe 1</option>
                <option value="2">Tipe 2</option>
                <option value="3">Tipe 3</option>
            </select>
        </div>
        <a class="card-header py-3 flex-grow-1 " href="#simpulan" data-toggle="collapse" id="collapse-toggle" aria-expanded="false">
            Simpulan 1
        </a>
        <div class="input-group" style="width:unset!important;">
            <div class="input-group-append">
                <button class="btn btn-danger font-weight-bold" style="padding: 0 18px;border-radius:0;" type="button" id="delete"><i class="fas fa-trash"></i></button>
            </div>
        </div>
    </div>
    <div id="simpulan" class="collapse" data-parent="#simpulan-content">
        <div class="card-body">
            
        </div>
    </div>
</div>`

const tipe1 = `<div class="form-group">
    <label>Pertanyaan</label>
    <select name="id" id="pertanyaan">
        <option disabled selected>Pilih Pertanyaan</option>
        <option value="92438">Alergi?</option>
        <option value="92438">Alergi?</option>
        <option value="92438">Alergi?</option>
    </select>
</div>
<div class="form-group">
    <label>Nama Kolom</label>
    <input type="text" class="form-control" placeholder="Nama Kolom Simpulan" name="field">
</div>
<div class="form-group">
    <label>Pada Opsi</label>
    <select name="opsi[]" id="opsi"  multiple="multiple">
        <option value="92438">borderline</option>
        <option value="92438">Tidak</option>
    </select>
</div>`;

const tipe2 = `<div class="form-group">
    <label>Nama Kolom</label>
    <input type="text" class="form-control" placeholder="Nama Kolom Simpulan" name="field">
</div>
<div class="form-group">
    <label class="col-form-label">Daftar Pertanyaan, Opsi</label>
    <button class="btn btn-sm btn-success float-right"><i class="fas fa-fw fa-plus"></i></button>
    <table class="table mt-2">
        <thead>
            <tr>
                <th scope="col">Pertanyaan</th>
                <th scope="col">opsi</th>
                <th width="20%"></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Mark</td>
                <td>Otto</td>
                <td>
                    <button class="btn btn-sm btn-warning"><i class="fas fa-fw fa-pen"></i></button>
                    <button class="btn btn-sm btn-danger"><i class="fas fa-fw fa-times"></i></button>
                </td>
            </tr>
        </tbody>
    </table>
</div>`;

const tipe3 = `<div class="form-group">
    <label class="col-form-label">Daftar Variabel</label>
    <button class="btn btn-sm btn-success float-right"><i class="fas fa-fw fa-plus"></i></button>
    <table class="table mt-2">
        <thead>
            <tr>
                <th scope="col">Variabel</th>
                <th scope="col">Pertanyaan</th>
                <th width="20%"></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>BB</td>
                <td>Otto</td>
                <td>
                    <button class="btn btn-sm btn-warning"><i class="fas fa-fw fa-pen"></i></button>
                    <button class="btn btn-sm btn-danger"><i class="fas fa-fw fa-times"></i></button>
                </td>
            </tr>
        </tbody>
    </table>
</div>
<div class="form-group">
    <label>Formula</label>
    <input type="text" class="form-control" placeholder="Formula Simpulan" name="field">
</div>
<div class="form-group">
    <label class="col-form-label">Daftar Rentang</label>
    <button class="btn btn-sm btn-success float-right"><i class="fas fa-fw fa-plus"></i></button>                    
    <table class="table mt-2">
        <thead>
            <tr>
                <th scope="col">Rentang</th>
                <th scope="col">Kolom</th>
                <th width="1"></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><input type="text" class="form-control" /></td>
                <td><input type="text" class="form-control" /></td>
                <td>
                    <button class="btn btn-sm btn-danger"><i class="fas fa-fw fa-times"></i></button>
                </td>
            </tr>
            <tr>
                <td><input type="text" class="form-control" /></td>
                <td><input type="text" class="form-control" /></td>
                <td>
                    <button class="btn btn-sm btn-danger"><i class="fas fa-fw fa-times"></i></button>
                </td>
            </tr>
        </tbody>
    </table>
</div>`;

const onTambah = function(){
    var elem = $(simpulan);
    const id = getRandomString(3);

    var toggle = elem.find('#collapse-toggle');
    toggle.prop('id', id+'_collapse-toggle');
    toggle.attr('href', '#'+id+'_simpulan');
    
    var simp = elem.find('#simpulan');
    simp.prop('id', id+'_simpulan');

    var konten = simp.children(":first-child");
    konten.prop('id', id+'_content');

    konten.html(tipe1);

    $('#simpulan-content').append(elem);
}

$(document).ready(function(){
    $('#tambah-simpulan').on('click', onTambah);
})
</script>
@endpush