@push('scripts')
<script>
var simpulan1 = `<div class="card">
        <div class="d-flex">
            <div class="input-group-prepend" style="padding:5px;background: #f8f9fc;">
                <select class="custom-select" style="height:unset;">
                    <option value="1">Tipe 1</option>
                    <option value="2">Tipe 2</option>
                    <option value="3">Tipe 3</option>
                </select>
            </div>
            <a class="card-header py-3 flex-grow-1 " href="#simpulan-1" data-toggle="collapse" id="collapse-toggle" aria-expanded="false">
                Simpulan 1
            </a>
            <div class="input-group" style="width:unset!important;">
                <div class="input-group-append">
                    <button class="btn btn-danger font-weight-bold" style="padding: 0 18px;border-radius:0;" type="button" id="delete"><i class="fas fa-trash"></i></button>
                </div>
            </div>
        </div>
        <div id="simpulan-1" class="collapse" data-parent="#simpulan-content">
            <div class="card-body">
                aye
            </div>
        </div>
    </div>`
$(document).ready(function(){
    $('#simpulan-content').html(simpulan1);
})
</script>
@endpush