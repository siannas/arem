@foreach ($json->pertanyaan as $p)
    @if ($p->tipe === 1)
        <div class="row" style="padding-top:20px">
            <div class="col-12 col-md-5" style="margin-bottom:5px">
                {{ $p->pertanyaan }}
            </div>
            <div class="col-12 col-md-7" style="padding:0">
                <div class="row" style="margin:0px">
                    <input type="hidden" name="{{ 'preview-'.$p->id }}" value="" /> 
                    @foreach ($p->opsi as $index => $o)
                    <label class="radio-inline col-6 col-md-4">
                        <input type="radio" name="{{ 'preview-'.$p->id }}" id="{{ 'preview-'.$p->id.'__'.$index }}" value="{{ $o }}"> {{ $o }}
                    </label>
                    @endforeach
                </div>
            </div>
        </div>
    @elseif ($p->tipe === 2)
        <div class="row" style="padding-top:20px">
            <div class="col-12 col-md-5" style="margin-bottom:5px">
                {{ $p->pertanyaan }}
            </div>
            <div class="col-12 col-md-7">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="" name="{{ 'preview-'.$p->id }}" >
                    @if (isset($p->suffix))
                        <div class="input-group-append">
                            <div class="input-group-text" >{{ $p->suffix }}</div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @elseif ($p->tipe === 3)
        <div class="row" style="padding-top:30px" id="98s7dfy-container">
            <div class="col-12 col-md-5" style="margin-bottom:5px">
                {{ $p->pertanyaan }}
            </div>
            <div class="col-12 col-md-7" style="padding:0">
                <div class="row" style="margin:0px">
                    @foreach ($p->opsi as $index => $o)
                        <input type="hidden" name="{{ 'preview-'.$p->id }}" value="" /> 
                        @if (is_object($o))
                            <label class="radio-inline col-6 col-md-4">
                                <input type="radio" name="{{ 'preview-'.$p->id }}" id="{{ 'preview-'.$p->id.'__'.$index }}" value="{{ $o->{'0'} }}"> {{ $o->{'0'} }}
                            </label>
                        @else
                            <label class="radio-inline col-6 col-md-4">
                                <input type="radio" name="{{ 'preview-'.$p->id }}" id="{{ 'preview-'.$p->id.'__'.$index }}" value="{{ $o }}"> {{ $o }}
                            </label>
                        @endif
                    @endforeach
                    @foreach ($p->opsi as $index => $o)
                        @if (is_object($o) and $o->{'if-selected'}->tipe === 2 )
                            <div class="col-12 collapse" style="flex:1" id="{{ $o->{'if-selected'}->id }}-container">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="{{ $o->{'if-selected'}->id }}" id="{{ $o->{'if-selected'}->id }}" placeholder="{{ $o->{'if-selected'}->pertanyaan }}" disabled>
                                    @if (isset($o->{'if-selected'}->suffix))
                                        <div class="input-group-append">
                                            <div class="input-group-text" >{{ $o->{'if-selected'}->suffix }}</div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
        @foreach ($p->opsi as $index => $o)
            @if (is_object($o) and $o->{'if-selected'}->tipe === 1 )
                <div class="row collapse" style="padding-top:20px" id="{{ $o->{'if-selected'}->id }}-container">
                    <div class="col-12 col-md-5" style="margin-bottom:5px">
                        {{ $o->{'if-selected'}->pertanyaan }}
                    </div>
                    <div class="col-12 col-md-7" style="padding:0">
                        <div class="row" style="margin:0px">
                            @foreach ($o->{'if-selected'}->opsi as $index2 => $o2)
                            <label class="radio-inline col-6 col-md-4">
                                <input type="radio" name="{{ $o->{'if-selected'}->id }}" id="{{ $o->{'if-selected'}->id.'__'.$index2 }}" value="{{ $o2 }}" > {{ $o2 }}
                            </label>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    @elseif ($p->tipe === 4)
        <div class="row" style="padding-top:20px">
            <div class="col-12 col-md-5" style="margin-bottom:5px">
                {{ $p->pertanyaan }}
            </div>
            <div class="col-12 col-md-7">
                <div class="input-group">
                <input type="text" name="{{ 'preview-'.$p->id }}" id="{{ 'preview-'.$p->id }}" hidden readonly>
                <div class="custom-file">
                    <input type="file" class="custom-file-input" name="{{ 'preview-'.$p->id }}-file-dummy" id="{{ 'preview-'.$p->id }}-file-dummy" onchange="myToggleButtonUpload('{{ 'preview-'.$p->id }}','upload')">
                    <label class="custom-file-label" for="{{ 'preview-'.$p->id }}-file-dummy">Pilih file</label>
                </div>
                <div class="input-group-append" id="{{ 'preview-'.$p->id }}-btn-container">
                    <button id="{{ 'preview-'.$p->id }}-btn-upload" class="btn btn-outline-primary" type="button" onclick="myUpload('{{ 'preview-'.$p->id }}-file-dummy','{{ 'preview-'.$p->id }}')" hidden>Upload</button>
                    <button id="{{ 'preview-'.$p->id }}-btn-loading" class="btn btn-outline-primary" hidden>
                        <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    </button>
                    <a id="{{ 'preview-'.$p->id }}-btn-link" type="button" class="btn btn-outline-primary" onclick="" href="" target="_blank" hidden>
                        Link
                    </a>
                    <button id="{{ 'preview-'.$p->id }}-btn-danger" type="button" class="btn btn-outline-danger" onclick="" hidden>
                        Gagal
                    </button>
                </div>
                </div>
            </div>
        </div>
    @endif
@endforeach