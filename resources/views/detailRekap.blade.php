@extends('layouts.layout')
@extends('layouts.sidebar')

@php
$role= Auth::user()->getRole->role;
@endphp

@section('title')
Detail Rekap
@endsection

@section('rekapStatus')
active
@endsection

@section('showSkrining')
show
@endsection

@section('header')
Form Skrining
@endsection

@section('description')
Dashboard
@endsection

@section('content')
<script>
    var myData= {};
</script>
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Rekap Skrining</h1>
    @include('form.alert')
    <div class="card shadow">
        <div class="card-header bg-primary mb-3">
            <div class="row p-4 justify-content-between align-items-center">
                <div class="col-12 col-lg-auto mb-5 mb-lg-0 text-center text-lg-left">
                    <i class="fas fa-laugh-wink text-light mb-3" style="font-size:50px;"></i>
                    <h5 class="text-light">e-Ning Tasiah</h5>
                </div>
                @if(isset($berdasar))
                <div class="col-12 col-lg-auto text-center text-lg-right text-light">
                    <h5 class="card-title text-light mb-3">
                        <b>{{ $berdasar->nama }}</b>
                    </h5>
                    <h6 class="card-subtitle text-gray-300 mb-2">Jenjang 
                        @if($formulir->kelas==='1,2,3,4,5,6')SD/MI 
                        @elseif($formulir->kelas==='7,8,9,10,11,12')SMP/MTS dan SMA/SMK/MA @endif
                    </h6>
                    <h6 class="card-subtitle text-gray-300 mb-2">Tahun Ajaran {{ $formulir->tahun_ajaran }}</h6>
                </div>
                @endif
            </div>
        </div>
        <div class="card-body row">
            <form action="#" class="mb-4 col" id="filter-form">
                <div class="row">
                    <div class="col-sm-6 col-md-5 my-1">
                        <select class="form-control" id="filter" name="for" required>
                            <option value="" disabled selected>Rekap Berdasar</option>
                            @foreach($filter as $f)
                            <option value="{{$f->id}}">{{$f->nama}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-4 col-md-3 my-1">
                        <button type="submit" class="btn btn-sm btn-success my-1">
                            Filter
                        </button>
                    </div>
                </div>
            </form>
        @if (isset($rekap))
        @foreach ($rekap as $key => $json)
        <div class="col-lg-12">

            <!-- Basic Card Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">{{ $json->judul }}</h6>
                </div>
                <div class="card-body">
                    @foreach ($json->pertanyaan as $p)
                        @if ($p->tipe === 1)
                            <div class="row" style="padding-top:20px">
                                <div class="col-12" style="margin-bottom:5px">
                                    <h5>{{ $p->pertanyaan }}</h5>
                                    <div class="chart-pie pt-4 pb-2">
                                        <canvas id="{{ $p->id.'-canvas' }}"></canvas>
                                    </div>
                                    <div class="mt-4 text-center small">
                                        @php
                                        $cnt = 0;
                                        @endphp
                                        <script>
                                            myData['{{ $p->id }}'] = {
                                                'label': [],
                                                'value': [],
                                            };
                                        </script>
                                        @foreach ($p->opsi as $index => $o)
                                        <span class="mr-2">
                                            <i class="fas fa-circle @if($cnt===0)text-primary @elseif($cnt===1)text-success @else text-info @endif"></i> {{ $index }}
                                        </span>
                                        @php
                                        $cnt += 1;
                                        @endphp
                                        <script>
                                            myData['{{ $p->id }}']['label'].push('{{$index}}');
                                            myData['{{ $p->id }}']['value'].push('{{$o}}');
                                        </script>
                                        @endforeach
                                    </div>
                                </div>
                                
                            </div>
                        @elseif ($p->tipe === 2)
                            <div class="row" style="padding-top:20px">
                                <div class="col-12 " style="margin-bottom:5px">
                                    <h5>{{ $p->pertanyaan }} @if($p->suffix) ( {{ $p->suffix }} ) @endif</h5>
                                    <div class="pt-4 nice-scrollbar" style="max-height:315px;">
                                        {!! $tulisan[$p->jawaban[0]] !!}
                                    </div>
                                </div>
                            </div>
                        @elseif ($p->tipe === 3)
                            <div class="row" style="padding-top:30px" >
                                <div class="col-12 @if(empty($p->tambahan) === false) col-md-6 @endif " style="margin-bottom:5px">
                                    <h5>{{ $p->pertanyaan }}</h5>
                                    <div class="chart-pie pt-4 pb-2">
                                        <canvas id="{{ $p->id.'-canvas' }}"></canvas>
                                    </div>
                                    <div class="mt-4 text-center small">
                                        @php
                                        $cnt = 0;
                                        @endphp
                                        <script>
                                            myData['{{ $p->id }}'] = {
                                                'label': [],
                                                'value': [],
                                            };
                                        </script>
                                        @foreach ($p->opsi as $index => $o)
                                        <span class="mr-2">
                                            <i class="fas fa-circle @if($cnt===0)text-primary @elseif($cnt===1)text-success @else text-info @endif"></i> {{ $index }}
                                        </span>
                                        @php
                                        $cnt += 1;
                                        @endphp
                                        <script>
                                            myData['{{ $p->id }}']['label'].push('{{$index}}');
                                            myData['{{ $p->id }}']['value'].push('{{$o}}');
                                        </script>
                                        @endforeach
                                    </div>
                                </div>
                                @if(empty($p->tambahan) === false)
                                <div class="col-12 col-md-6" >
                                    @foreach($p->tambahan as $tKey=> $t)
                                    @if($p->opsi->{$tKey} !== 0)
                                    <h5>{{ $tKey.': '.$t->pertanyaan }} @if($t->suffix) ( {{ $t->suffix }} ) @endif</h5>
                                    <div class="pt-4 nice-scrollbar" style="max-height:315px;">
                                        {!! $tulisan[$t->jawaban[0]] !!}
                                    </div>
                                    @endif
                                    @endforeach
                                </div>
                                @endif
                            </div>
                        @elseif ($p->tipe === 4)
                            <div class="row" style="padding-top:20px">
                                <div class="col-12" style="margin-bottom:5px">
                                    <h5>{{ $p->pertanyaan }}</h5>
                                    <div class="pt-4 nice-scrollbar" style="max-height:315px;">
                                        {!! $tulisan[$p->jawaban[0]] !!}
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
        @endforeach 
        @endif
        <div class="col-lg-12" id="simpulan-container"></div>
    </div>
        <div class="card-footer text-right">
            <a href="{{url('/rekap')}}" class="btn btn-secondary"><i class="fas fa-fw fa-sign-out-alt"></i> Kembali</a>
        </div>
    </div>
</div>

@endsection

@section('script')
<script>
const myPieChart2 = function(id, labels, datas) {
    var chartElem = $('#'+id+'-canvas');
    // console.log('chartElem',chartElem);
    // return;
    new Chart( chartElem, {
        type: 'doughnut',
        data: {
        labels: labels,
        datasets: [{
            data: datas,
            backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc'],
            hoverBackgroundColor: ['#2e59d9', '#17a673', '#2c9faf'],
            hoverBorderColor: "rgba(234, 236, 244, 1)",
        }],
        },
        options: {
        maintainAspectRatio: false,
        tooltips: {
            backgroundColor: "rgb(255,255,255)",
            bodyFontColor: "#858796",
            borderColor: '#dddfeb',
            borderWidth: 1,
            xPadding: 15,
            yPadding: 15,
            displayColors: false,
            caretPadding: 10,
        },
        legend: {
            display: false
        },
        cutoutPercentage: 60,
        },
    });
}

for(var key in myData){
    myPieChart2(key, myData[key]['label'], myData[key]['value']);
}

@if (isset($simpulans) and isset($csv_gabungan))
const cardTemplate=`<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary" id="title-pertanyaan"></h6>
    </div>
    <div class="card-body" id="body-pertanyaan">
    </div>
</div>`
const template=`<div class="row" style="padding-top:30px" >
    <div class="col-12" style="margin-bottom:5px">
        <h5 id="-title"></h5>
        <div class="chart-pie pt-4 pb-2">
            <canvas id="-canvas"></canvas>
        </div>
        <div class="mt-4 text-center small" id="-legend">
        </div>
    </div>
</div>`;
const myCSV=@json($csv_gabungan);
const mySimpulan=@json($simpulans);
const myPertanyaan=@json($pertanyaan);
const myHasil=@json($hasil_gabungan);
var myData= myCSV.reduce(function (r, a) {
        a.forEach(function (b, i) {
            r[i] = (r[i] || 0) + parseInt(b);
        });
        return r;
    }, []);
var myDataJSON= myHasil.reduce(function (r, data) {
        Object.keys(data).forEach(function (b, i) {
            r[b] = r[b] || {};
            Object.keys(data[b]).forEach(function (opsi, i) { // data[b] adalah tiap opsi
                r[b][opsi] = r[b][opsi] || [0,0];
                r[b][opsi][0]+=data[b][opsi][0];
                r[b][opsi][1]+=data[b][opsi][1];
                // ().forEach(function (c,x) {
                //     console.log(a[b]);
                //     r[b][x]=a[b][x]+c;
                //     // r[b] =  + a[b];
                // });
            });
            
        });
        return r;
    }, {});
$(document).ready(function() {  
    const $simpulanContainer=$('#simpulan-container');
    var cnt=0;
    for (const key in mySimpulan) {
        var e = JSON.parse(mySimpulan[key]['json_simpulan']);
        if(e.length>0){
            $card=$(cardTemplate);
            $card.find('#title-pertanyaan').text(myPertanyaan[key]['judul']).removeAttr('id');
            e.forEach(e2 => {
                var newchart = $(template);
                switch (e2.tipe) {
                    case 1:
                        
                        break;
                    case 2:
                        
                        break;
                    case 3:
                        
                        break;
                }
            });
            $simpulanContainer.append($card);
        }
        cnt++;
    }
});

@endif

$(document).ready(function() {  
    $("#filter").select2({
        width: '100%'
    });
});
</script>
@endsection