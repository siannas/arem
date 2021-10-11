<div id="alert">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check"></i> Success:<small> {{ session('success') }}</small>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @elseif (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-times"></i> Error:<small> {{ session('error') }}</small>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
</div>
@push('scripts')
<script>
var str = `<div class="alert alert-dismissible fade show" role="alert"> 
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>`;
var $alert_, $alertContainer;
$( document ).ready(function() {            
$alert_ = $.parseHTML(str);
$alertContainer = $('#alert');
});

const myAlert = function(msg, tipe=''){
    $alert = $($alert_).clone();
    if(tipe==='danger') $alert.addClass('alert-danger');
    else $alert.addClass('alert-success');
    $alert.prepend(msg);
    $alertContainer.empty();
    $alertContainer.append($alert);
}  
</script>
@endpush