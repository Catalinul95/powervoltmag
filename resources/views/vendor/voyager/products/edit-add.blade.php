@php
    $edit = !is_null($dataTypeContent->getKey());
    $add  = is_null($dataTypeContent->getKey());
@endphp

@extends('voyager::master')

@section('css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@stop

@section('page_title', __('voyager::generic.'.($edit ? 'edit' : 'add')).' '.$dataType->getTranslatedAttribute('display_name_singular'))

@section('page_header')
    <h1 class="page-title">
        <i class="{{ $dataType->icon }}"></i>
        {{ __('voyager::generic.'.($edit ? 'edit' : 'add')).' '.$dataType->getTranslatedAttribute('display_name_singular') }}
    </h1>
    @include('voyager::multilingual.language-selector')
@stop

@section('content')
    <div class="page-content edit-add container-fluid">
        <div class="row">
            <div class="col-md-12">

                <div class="panel panel-bordered">
                    <!-- form start -->
                    <form role="form"
                            class="form-edit-add"
                            action="{{ $edit ? route('voyager.'.$dataType->slug.'.update', $dataTypeContent->getKey()) : route('voyager.'.$dataType->slug.'.store') }}"
                            method="POST" enctype="multipart/form-data">
                        <!-- PUT Method if we are editing -->
                        @if($edit)
                            {{ method_field("PUT") }}
                        @endif

                        <!-- CSRF TOKEN -->
                        {{ csrf_field() }}

                        <div class="panel-body">

                            @if (count($errors) > 0)
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <!-- Adding / Editing -->
                            @php
                                $dataTypeRows = $dataType->{($edit ? 'editRows' : 'addRows' )};
                            @endphp

                            @foreach($dataTypeRows as $row)
                                <!-- GET THE DISPLAY OPTIONS -->
                                @php
                                    $display_options = $row->details->display ?? NULL;
                                    if ($dataTypeContent->{$row->field.'_'.($edit ? 'edit' : 'add')}) {
                                        $dataTypeContent->{$row->field} = $dataTypeContent->{$row->field.'_'.($edit ? 'edit' : 'add')};
                                    }
                                @endphp
                                @if (isset($row->details->legend) && isset($row->details->legend->text))
                                    <legend class="text-{{ $row->details->legend->align ?? 'center' }}" style="background-color: {{ $row->details->legend->bgcolor ?? '#f0f0f0' }};padding: 5px;">{{ $row->details->legend->text }}</legend>
                                @endif

                                <div class="form-group @if($row->type == 'hidden') hidden @endif col-md-{{ $display_options->width ?? 12 }} {{ $errors->has($row->field) ? 'has-error' : '' }}" @if(isset($display_options->id)){{ "id=$display_options->id" }}@endif>
                                    {{ $row->slugify }}
                                    <label class="control-label" for="name">{{ $row->getTranslatedAttribute('display_name') }}</label>
                                    @include('voyager::multilingual.input-hidden-bread-edit-add')
                                    @if (isset($row->details->view))
                                        @include($row->details->view, ['row' => $row, 'dataType' => $dataType, 'dataTypeContent' => $dataTypeContent, 'content' => $dataTypeContent->{$row->field}, 'action' => ($edit ? 'edit' : 'add'), 'view' => ($edit ? 'edit' : 'add'), 'options' => $row->details])
                                    @elseif ($row->type == 'relationship')
                                        @include('voyager::formfields.relationship', ['options' => $row->details])
                                    @else
                                        {!! app('voyager')->formField($row, $dataType, $dataTypeContent) !!}
                                    @endif

                                    @foreach (app('voyager')->afterFormFields($row, $dataType, $dataTypeContent) as $after)
                                        {!! $after->handle($row, $dataType, $dataTypeContent) !!}
                                    @endforeach
                                    @if ($errors->has($row->field))
                                        @foreach ($errors->get($row->field) as $error)
                                            <span class="help-block">{{ $error }}</span>
                                        @endforeach
                                    @endif
                                </div>
                            @endforeach

                            <div class="form-group">
                                <label for="control-label">Rezolutie</label>
                                <select name="rezolutie" id="" class="form-control">
                                    <option selected>NA</option>
                                    <option @if (isset($filters->rezolutie) && $filters->rezolutie == 'hd-720p-(1-mp)') selected @endif value="hd-720p-(1-mp)">HD 720p (1-Mp)</option>
                                    <option @if (isset($filters->rezolutie) && $filters->rezolutie == 'full-hd-1080p-(2---2.4-mp)') selected @endif value="full-hd-1080p-(2---2.4-mp)">FULL HD 1080p (2 - 2.4 Mp)</option>
                                    <option @if (isset($filters->rezolutie) && $filters->rezolutie == '4-megapixeli-(2k)') selected @endif value="4-megapixeli-(2k)">4 Megapixeli (2K)</option>
                                    <option @if (isset($filters->rezolutie) && $filters->rezolutie == '5-megapixeli-(2k)') selected @endif value="5-megapixeli-(2k)">5 Megapixeli (2K) </option>
                                    <option @if (isset($filters->rezolutie) && $filters->rezolutie == '8-megapixeli-(4k)') selected @endif value="8-megapixeli-(4k)">8 Megapixeli (4K) </option>
                                    
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="control-label">Infrarosu</label>
                                <select name="infrarosu" id="" class="form-control">
                                    <option selected>NA</option>
                                    <option @if (isset($filters->infrarosu) && $filters->infrarosu == '10-metri') selected @endif value="10-metri">10 Metri</option>
                                    <option @if (isset($filters->infrarosu) && $filters->infrarosu == '20-metri') selected @endif value="20-metri">20 Metri</option>
                                    <option @if (isset($filters->infrarosu) && $filters->infrarosu == '30-metri') selected @endif value="30-metri">30 Metri</option>
                                    <option @if (isset($filters->infrarosu) && $filters->infrarosu == '40-metri') selected @endif value="40-metri">40 Metri</option>
                                    <option @if (isset($filters->infrarosu) && $filters->infrarosu == '50-metri') selected @endif value="50-metri">50 Metri</option>
                                    <option @if (isset($filters->infrarosu) && $filters->infrarosu == '60-metri') selected @endif value="60-metri">60 Metri</option>
                                    <option @if (isset($filters->infrarosu) && $filters->infrarosu == '80-metri') selected @endif value="80-metri">80 Metri</option>    
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="control-label">Tip Camera</label>
                                <select name="tip-camera" id="" class="form-control">
                                    <option selected>NA</option>
                                    <option @if (isset($filters->{"tip-camera"}) && $filters->{"tip-camera"} == 'dome') selected @endif  value="dome">Dome</option>
                                    <option @if (isset($filters->{"tip-camera"}) && $filters->{"tip-camera"} == 'bullet') selected @endif  value="bullet">Bullet</option>
                                    <option @if (isset($filters->{"tip-camera"}) && $filters->{"tip-camera"} == 'speed-demo') selected @endif  value="speed-dome">Speed dome</option>
                                    <option @if (isset($filters->{"tip-camera"}) && $filters->{"tip-camera"} == 'zoom-motorizat') selected @endif  value="zoom-motorizat">Zoom motorizat</option>  
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="control-label">Tehnologie</label>
                                <select name="tehnologie" id="" class="form-control">
                                <option selected>NA</option>
                                    <option @if (isset($filters->tehnologie) && $filters->tehnologie == 'hdcvi') selected @endif value="hdcvi">HDCVI</option>
                                    <option @if (isset($filters->tehnologie) && $filters->tehnologie == 'turbo-hd') selected @endif value="turbo-hd">Turbo HD</option>
                                    <option @if (isset($filters->tehnologie) &&  $filters->tehnologie == 'ip') selected @endif value="ip">IP</option>
                                    <option @if (isset($filters->tehnologie) && $filters->tehnologie == 'cvi-/-ahd-/-turbo-hd-/-analog') selected @endif value="cvi-/-ahd-/-turbo-hd-/-analog">CVI / AHD / TURBO HD / ANALOG</option>
                                    <option @if (isset($filters->tehnologie) && $filters->tehnologie == 'turbo-hd-/-ahd-/-analog') selected @endif value="turbo-hd-/-ahd-/-analog">TURBO HD / AHD / ANALOG</option>
                                    
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="control-label">Lentila Varifocala</label>
                                <select name="lentila-varifocala" id="" class="form-control">
                                    <option selected>NA</option>
                                    <option @if (isset($filters->{"lentila-varifocala"}) && $filters->{"lentila-varifocala"} == '2,8---12-mm') selected @endif  value="2,8---12-mm">2,8 - 12 mm</option>
                                    <option @if (isset($filters->{"lentila-varifocala"}) && $filters->{"lentila-varifocala"} == '2,8---10-mm') selected @endif  value="2,8---10-mm">2,8 - 10 mm</option>
                                    <option @if (isset($filters->{"lentila-varifocala"}) && $filters->{"lentila-varifocala"} == '2,7---13,5-mm') selected @endif  value="2,7---13,5-mm">2,7 - 13,5 mm</option>
                                    <option @if (isset($filters->{"lentila-varifocala"}) && $filters->{"lentila-varifocala"} == '2,7---12-mm') selected @endif  value="2,7---12-mm">2,7 - 12 mm</option>
                                    <option @if (isset($filters->{"lentila-varifocala"}) && $filters->{"lentila-varifocala"} == '4,3---129-mm') selected @endif  value="4,3---129-mm">4,3 - 129 mm</option>                                 
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="control-label">Lentila fixa</label>
                                <select name="lentila-fixa" id="" class="form-control">
                                    <option selected>NA</option>
                                    <option @if (isset($filters->{"lentila-fixa"}) && $filters->{"lentila-fixa"} == '2.8-mm') selected @endif value="2.8-mm">2.8 mm</option>
                                    <option @if (isset($filters->{"lentila-fixa"}) && $filters->{"lentila-fixa"} == '3.6-mm') selected @endif value="3.6-mm">3.6 mm</option>
                                    <option @if (isset($filters->{"lentila-fixa"}) && $filters->{"lentila-fixa"} == 'fisheye') selected @endif value="fisheye">FISHEYE</option>                             
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="control-label">Nr canale</label>
                                <select name="nr-canale" id="" class="form-control">
                                    <option selected>NA</option>
                                    <option @if (isset($filters->{"nr-canale"}) && $filters->{"nr-canale"} == '4') selected @endif value="4">4</option>
                                    <option @if (isset($filters->{"nr-canale"}) && $filters->{"nr-canale"} == '8') selected @endif value="8">8</option>
                                    <option @if (isset($filters->{"nr-canale"}) && $filters->{"nr-canale"} == '16') selected @endif value="16">16</option>
                                    <option @if (isset($filters->{"nr-canale"}) && $filters->{"nr-canale"} == '32') selected @endif value="32">32</option>
                                    
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="control-label">Internet</label>
                                <select name="internet" id="" class="form-control">
                                    <option selected>NA</option>
                                    <option @if (isset($filters->internet) && $filters->internet == 'ip-dinamic') selected @endif value="ip-dinamic">IP Dinamic (DDNS)</option>
                                    <option @if (isset($filters->internet) && $filters->internet == 'cloud') selected @endif value="cloud">CLOUD</option>
                                    
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="control-label">Nr HDD</label>
                                <select name="nr-hdd" id="" class="form-control">
                                    <option selected>NA</option>
                                    <option @if (isset($filters->{"nr-hdd"}) && $filters->{"nr-hdd"} == '1-hdd') selected @endif value="1-hdd">1 HDD</option>
                                    <option @if (isset($filters->{"nr-hdd"}) && $filters->{"nr-hdd"} == '2-hdd') selected @endif value="2-hdd">2 HDD</option>
                                    <option @if (isset($filters->{"nr-hdd"}) && $filters->{"nr-hdd"} == '4-hdd') selected @endif value="4-hdd">4 HDD</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="control-label">Poc</label>
                                <select name="poc" id="" class="form-control">
                                    <option selected>NA</option>
                                    <option @if (isset($filters->poc) && $filters->poc == 'da') selected @endif value="da">Da</option>
                                    <option @if (isset($filters->poc) && $filters->poc == 'nu') selected @endif value="nu">Nu</option>
                                    
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="control-label">Starlight/Starvis</label>
                                <select name="starlight-starvis" id="" class="form-control">
                                    <option selected>NA</option>
                                    <option  @if (isset($filters->{"starlight-starvis"}) && $filters->{"starlight-starvis"} == 'da') selected @endif value="da">Da</option>
                                    <option  @if (isset($filters->{"starlight-starvis"}) && $filters->{"starlight-starvis"} == 'nu') selected @endif value="nu">Nu</option>
                                    
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="control-label">Intrari Audio</label>
                                <select name="intrari-audio" id="" class="form-control">
                                    <option selected>NA</option>
                                    <option  @if (isset($filters->{"intrari-audio"}) && $filters->{"intrari-audio"} == '1-intrare') selected @endif value="1-intrare">1 intrare</option>
                                    <option @if (isset($filters->{"intrari-audio"}) && $filters->{"intrari-audio"} == '4-intrari') selected @endif  value="4-intrari">4 intrari</option>
                                    <option @if (isset($filters->{"intrari-audio"}) && $filters->{"intrari-audio"} == '8-intrari') selected @endif  value="8-intrari">8 intrari</option>
                                    <option @if (isset($filters->{"intrari-audio"}) && $filters->{"intrari-audio"} == '16-intrari') selected @endif  value="16-intrari">16 intrari</option>
                                    
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="control-label">Audio prin Coaxial</label>
                                <select name="audio-prin-coaxial" id="" class="form-control">
                                    <option selected>NA</option>
                                    <option @if (isset($filters->{"audio-prin-coaxial"}) && $filters->{"audio-prin-coaxial"} == 'audio-prin-hdcvi') selected @endif value="audio-prin-hdcvi">Audio prin HDCVI</option>
                                    <option @if (isset($filters->{"audio-prin-coaxial"}) && $filters->{"audio-prin-coaxial"} == 'audio-prin-hdtvi') selected @endif value="audio-prin-hdtvi">Audio prin HDTVI</option>
                                    
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="control-label">Conexiune</label>
                                <select name="conexiune" id="" class="form-control">
                                    <option selected>NA</option>
                                    <option @if (isset($filters->conexiune) && $filters->conexiune == 'wireless') selected @endif value="wirless">Wireless</option>
                                    <option @if (isset($filters->conexiune) && $filters->conexiune == 'cablu') selected @endif value="cablu">Cablu</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="control-label">Material</label>
                                <select name="material" id="" class="form-control">
                                    <option selected>NA</option>
                                    <option @if (isset($filters->material) && $filters->material == 'plastic') selected @endif value="plastic">Plastic</option>
                                    <option @if (isset($filters->material) && $filters->material == 'metal') selected @endif value="metal">Metal</option>                                  
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="control-label">Utilizare</label>
                                <select name="utilizare" id="" class="form-control">
                                    <option selected>NA</option>
                                    <option @if (isset($filters->utilizare) && $filters->utilizare == 'interior') selected @endif value="interior">Interior</option>
                                    <option @if (isset($filters->utilizare) && $filters->utilizare == 'exterior') selected @endif value="exterior">Exterior</option>
                                    <option @if (isset($filters->utilizare) && $filters->utilizare == 'mixt') selected @endif value="mixt">Mixt</option>
                                    
                                </select>
                            </div>

                        </div><!-- panel-body -->

                        <div class="panel-footer">
                            @section('submit-buttons')
                                <button type="submit" class="btn btn-primary save">{{ __('voyager::generic.save') }}</button>
                            @stop
                            @yield('submit-buttons')
                        </div>
                    </form>

                    <iframe id="form_target" name="form_target" style="display:none"></iframe>
                    <form id="my_form" action="{{ route('voyager.upload') }}" target="form_target" method="post"
                            enctype="multipart/form-data" style="width:0;height:0;overflow:hidden">
                        <input name="image" id="upload_file" type="file"
                                 onchange="$('#my_form').submit();this.value='';">
                        <input type="hidden" name="type_slug" id="type_slug" value="{{ $dataType->slug }}">
                        {{ csrf_field() }}
                    </form>

                </div>
            </div>
        </div>
    </div>

    <div class="modal fade modal-danger" id="confirm_delete_modal">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"
                            aria-hidden="true">&times;</button>
                    <h4 class="modal-title"><i class="voyager-warning"></i> {{ __('voyager::generic.are_you_sure') }}</h4>
                </div>

                <div class="modal-body">
                    <h4>{{ __('voyager::generic.are_you_sure_delete') }} '<span class="confirm_delete_name"></span>'</h4>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('voyager::generic.cancel') }}</button>
                    <button type="button" class="btn btn-danger" id="confirm_delete">{{ __('voyager::generic.delete_confirm') }}</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End Delete File Modal -->
@stop

@section('javascript')
    <script>
        var params = {};
        var $file;

        function deleteHandler(tag, isMulti) {
          return function() {
            $file = $(this).siblings(tag);

            params = {
                slug:   '{{ $dataType->slug }}',
                filename:  $file.data('file-name'),
                id:     $file.data('id'),
                field:  $file.parent().data('field-name'),
                multi: isMulti,
                _token: '{{ csrf_token() }}'
            }

            $('.confirm_delete_name').text(params.filename);
            $('#confirm_delete_modal').modal('show');
          };
        }

        $('document').ready(function () {
            $('.toggleswitch').bootstrapToggle();

            //Init datepicker for date fields if data-datepicker attribute defined
            //or if browser does not handle date inputs
            $('.form-group input[type=date]').each(function (idx, elt) {
                if (elt.hasAttribute('data-datepicker')) {
                    elt.type = 'text';
                    $(elt).datetimepicker($(elt).data('datepicker'));
                } else if (elt.type != 'date') {
                    elt.type = 'text';
                    $(elt).datetimepicker({
                        format: 'L',
                        extraFormats: [ 'YYYY-MM-DD' ]
                    }).datetimepicker($(elt).data('datepicker'));
                }
            });

            @if ($isModelTranslatable)
                $('.side-body').multilingual({"editing": true});
            @endif

            $('.side-body input[data-slug-origin]').each(function(i, el) {
                $(el).slugify();
            });

            $('.form-group').on('click', '.remove-multi-image', deleteHandler('img', true));
            $('.form-group').on('click', '.remove-single-image', deleteHandler('img', false));
            $('.form-group').on('click', '.remove-multi-file', deleteHandler('a', true));
            $('.form-group').on('click', '.remove-single-file', deleteHandler('a', false));

            $('#confirm_delete').on('click', function(){
                $.post('{{ route('voyager.'.$dataType->slug.'.media.remove') }}', params, function (response) {
                    if ( response
                        && response.data
                        && response.data.status
                        && response.data.status == 200 ) {

                        toastr.success(response.data.message);
                        $file.parent().fadeOut(300, function() { $(this).remove(); })
                    } else {
                        toastr.error("Error removing file.");
                    }
                });

                $('#confirm_delete_modal').modal('hide');
            });
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
@stop
