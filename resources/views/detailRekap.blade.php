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
                    <div class="col-sm-12 col-md-4 my-1 text-right">
                        <button type="submit" class="btn btn-sm btn-success my-1">
                            <i class="fas fa-download fa-sm text-white"></i>
                            &nbsp Download
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
        @if (isset($simpulans) and isset($csv_gabungan))
        <div class="col-lg-12">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link active" data-toggle="tab" href="#rekap-container" role="tab" aria-controls="rekap-container" aria-selected="true">Jawaban</a>
                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link" data-toggle="tab" href="#simpulan-container" role="tab" aria-controls="simpulan-container" aria-selected="false">Simpulan</a>
                </li>
            </ul>
            <div id="rekap-container" class="tab-pane fade show active" role="tabpanel" aria-labelledby="rekap-container"></div>
            <div id="simpulan-container" class="tab-pane fade" role="tabpanel" aria-labelledby="simpulan-container"></div>
        </div>
        @endif
    </div>
        <div class="card-footer text-right">
            <a href="{{url('/rekap')}}" class="btn btn-secondary"><i class="fas fa-fw fa-sign-out-alt"></i> Kembali</a>
        </div>
    </div>
</div>

@endsection

@section('script')
<script>
const myPieChart2 = function(id, labels, datas, $canvas=null, colors={backgroundColor:null,hoverBackgroundColor:null}) {
    var chartElem = $canvas || $('#'+id+'-canvas');
    // console.log('chartElem',chartElem);
    // return;
    new Chart( chartElem, {
        type: 'doughnut',
        data: {
        labels: labels,
        datasets: [{
            data: datas,
            backgroundColor: colors.backgroundColor || [],
            hoverBackgroundColor: colors.hoverBackgroundColor || [],
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

const colorGenerate = function(n=0){
    var colors= {
        backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc'],
        hoverBackgroundColor: ['#2e59d9', '#17a673', '#2c9faf'],
    }
    for (let i = 3; i <= n; i++) {
        const randomColor = "#" + Math.floor(Math.random()*16777215).toString(16);
        colors.backgroundColor.push(randomColor);
        colors.hoverBackgroundColor.push(randomColor);
    }
    return colors;
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
            <canvas></canvas>
        </div>
        <div class="mt-4 text-center small" id="-legend">
        </div>
    </div>
</div>`;
const simpulanTemplate=`<div class="card card-icon lift lift-sm mb-4">
    <div class="d-flex">
        <div class="col-auto bg-primary"></div>
        <div class="col">
            <div class="card-body py-4">
                <h5 class="card-title text-primary mb-2" id="-title">Gangguan Makan</h5>
                <span class="float-end fw-bold small" id="-total">220</span>
                <div class="d-flex">
                    <h4 class="small" style="width:20%;" id="-laki-container">
                        (L)
                        <span class="fw-bold" id="-laki">22</span>
                    </h4>
                    <h4 class="small" >
                        (P)
                        <span class="fw-bold" id="-perempuan">43</span>
                    </h4>
                </div>
                <div class="progress ">
                    <div class="progress-bar bg-primary" role="progressbar" aria-valuemin="0" aria-valuemax="100" id="-laki-val"></div>
                    <div class="progress-bar bg-success" role="progressbar" aria-valuemin="0" aria-valuemax="100" id="-perempuan-val"></div>
                </div>
            </div>
        </div>
    </div>
</div>`;
const legend='<span class="mr-2"><i class="fas fa-circle"></i>  </span>';
const myCSV=@json($csv_gabungan);
const mySimpulan=@json($simpulans);
const myPertanyaan=@json($pertanyaan);
const myHasil=@json($hasil_gabungan);console.log(myPertanyaan);
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
        });
    });
    return r;
}, {});
$(document).ready(function() {  
    const $rekapContainer=$('#rekap-container');
    const $simpulanContainer=$('#simpulan-container');
    var cnt=0;
    for (const key2 in myPertanyaan) {
        var judul = myPertanyaan[key2]['judul'];
        var pertanyaan = JSON.parse(myPertanyaan[key2]['json'])['pertanyaan'];
        $card=$(cardTemplate);
        $card.find('#title-pertanyaan').text(judul).removeAttr('id');
        var $body = $card.find('#body-pertanyaan').removeAttr('id');
        for (const x in pertanyaan) {
            const p = pertanyaan[x];
            //hanya pertanyaan pilihan ganda yg ditampilkan pada grafik
            if(p.tipe===3 || p.tipe===1){
                var opsis = myDataJSON[p.id];
                var $newchart = $(template);
                var $canvas=$newchart.find('canvas');
                $newchart.find("#-title").text(p['pertanyaan']).removeAttr('id');

                var values=[];
                var labels = Object.keys(opsis).reduce(function(r, data){
                    r.push(data+ " (L)")
                    r.push(data+ " (P)")
                    values = values.concat(opsis[data])
                    return r
                },[])

                //generate colors dulu
                var colors = colorGenerate(values.length);
                myPieChart2(null, labels, values, $canvas=$canvas, colors=colors);
                var $legendContainer=$newchart.find("#-legend").removeAttr('id');
                for(i in labels){
                    var label =labels[i];
                    var $legend=$(legend);
                    $legend.append(label)
                    $legend.css('color', colors.backgroundColor[i]);
                    $legendContainer.append($legend);
                };
                $body.append($newchart);
            }

        }
        $rekapContainer.append($card);

        //ini simpulannya
        $cardSimpulan=$(cardTemplate);
        $cardSimpulan.find('#title-pertanyaan').text(judul).removeAttr('id');
        var $bodySimpulan = $cardSimpulan.find('#body-pertanyaan').removeAttr('id');
        var simp=JSON.parse( mySimpulan[key2]['json_simpulan']);
        simp.forEach(s => {

            // penampil untuk simpulan tipe 1 dan tipe 2
            if(s.tipe===1 || s.tipe===2){
                var $ns = $(simpulanTemplate);
                var boy=myData[cnt*2];
                var girl=myData[cnt*2+1];
                var total=boy+girl;
                $ns.find("#-title").text(s.field).removeAttr("id");
                $ns.find("#-total").text(total).removeAttr("id");
                $ns.find("#-laki").text(boy).removeAttr("id");
                $ns.find("#-perempuan").text(girl).removeAttr("id");
                $ns.find("#-laki-val").css('width', 100*boy/total+"%").removeAttr("id");
                $ns.find("#-laki-container").css('width', Math.max(20, 100*boy/total)+"%").removeAttr("id");
                $ns.find("#-perempuan-val").css('width', 100*girl/total+"%").removeAttr("id");
                $bodySimpulan.append($ns)
                cnt++;

            }else{ // penampil untuk simpulan tipe 3
                s.range.forEach(elem => {
                    var $ns = $(simpulanTemplate);
                    var boy=myData[cnt*2];
                    var girl=myData[cnt*2+1];
                    var total=boy+girl;
                    $ns.find("#-title").text(elem[1]).removeAttr("id");
                    $ns.find("#-total").text(total).removeAttr("id");
                    $ns.find("#-laki").text(boy).removeAttr("id");
                    $ns.find("#-perempuan").text(girl).removeAttr("id");
                    $ns.find("#-laki-val").css('width', 100*boy/total+"%").removeAttr("id");
                    $ns.find("#-laki-container").css('width', Math.max(20, 100*boy/total)+"%").removeAttr("id");
                    $ns.find("#-perempuan-val").css('width', 100*girl/total+"%").removeAttr("id");
                    $bodySimpulan.append($ns)
                    cnt++;
                });
            }
            
        });
        if(simp.length >0){$simpulanContainer.append($cardSimpulan)}
    }
    // const $simpulanContainer=$('#simpulan-container');
    // var cnt=0;
    // for (const key in mySimpulan) {
    //     var e = JSON.parse(mySimpulan[key]['json_simpulan']);
    //     if(e.length>0){
    //         $card=$(cardTemplate);
    //         $card.find('#title-pertanyaan').text(myPertanyaan[key]['judul']).removeAttr('id');
    //         e.forEach(e2 => {
    //             var newchart = $(template);
    //             switch (e2.tipe) {
    //                 case 1:
                        
    //                     break;
    //                 case 2:
                        
    //                     break;
    //                 case 3:
                        
    //                     break;
    //             }
    //         });
    //         $simpulanContainer.append($card);
    //     }
    //     cnt++;
    // }
});

@endif

$(document).ready(function() {  
    $("#filter").select2({
        width: '100%'
    });
});
</script>
@endsection