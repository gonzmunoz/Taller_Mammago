@extends('layout.layout')

@section('additional-header')

@endsection

@section('content')
    <!-- contact area -->
    <div class="section-full content-inner">
        <!-- Product -->
        <div class="container">
            <form class="shop-form" method="post" enctype="multipart/form-data" action="{{ route('storeArticle') }}">
                @csrf
                <div class="row">
                    <div class="col-md-6 col-lg-6 m-b30"
                         style="background: center center no-repeat url('{{ assetFtp('images/newArticle.jpg') }}'); background-size:
                             contain">
                    </div>
                    <div class="col-md-6 col-lg-6 m-b30">
                        <h4>{{ trans('messages.articleData') }}</h4>
                        <div class="row">
                            <div class="form-group col-lg-6 col-md-6 col-sm-6">
                                <span class="font-weight-bold text-danger">{{ trans('messages.brand') }}</span>
                                <select class="form-control" id="marca" name="marca">
                                    <option value="selectBrand">{{ trans('messages.selectBrand') }}</option>
                                    @foreach($brands as $b)
                                        <option
                                            value="{{ $b['id'] }}" {{ old('marca') == $b['id'] ? 'selected' : '' }}>{{ $b['nombre'] }}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('marca'))
                                    <span class="text-danger">{{ $errors->first('marca') }}</span>
                                @endif
                            </div>
                            <div class="form-group col-lg-6 col-md-6 col-sm-6">
                                <span class="font-weight-bold text-danger">{{ trans('messages.model') }}</span>
                                <select class="form-control" id="modelo" name="modelo">
                                    <option value="selectModel">{{ trans('messages.selectModel') }}</option>
                                </select>
                                @if($errors->has('modelo'))
                                    <span class="text-danger">{{ $errors->first('modelo') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-lg-6 col-md-6 col-sm-6">
                                <span class="font-weight-bold text-danger">{{ trans('messages.engine') }}</span>
                                <select class="form-control" id="motor" name="motor">
                                    <option value="selectEngine">{{ trans('messages.selectEngine') }}</option>
                                </select>
                                @if($errors->has('motor'))
                                    <span class="text-danger">{{ $errors->first('motor') }}</span>
                                @endif
                            </div>
                            <div class="form-group col-lg-6 col-md-6 col-sm-6">
                                <span
                                    class="font-weight-bold text-danger">{{ trans('messages.articleCategory') }}</span>
                                <select class="form-control" id="id_categoria" name="id_categoria">
                                    @foreach($categories as $category)
                                        <option
                                            value="{{ $category['id'] }}" {{ old('id_categoria') == $category['id'] ? "selected":"" }}>{{ trans('messages.' . $category['nombre']) }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-lg-6 col-md-6 col-sm-6">
                                <span class="font-weight-bold text-danger">{{ trans('messages.articleName') }}</span>
                                <input type="text" class="form-control"
                                       placeholder="{{ trans('messages.articleName') }}"
                                       value="{{ old('nombre') }}" name="nombre">
                                @if($errors->has('nombre'))
                                    <span class="text-danger">{{ $errors->first('nombre') }}</span>
                                @endif
                            </div>
                            <div class="form-group col-lg-6 col-md-6 col-sm-6">
                                <span
                                    class="font-weight-bold text-danger">{{ trans('messages.articleDescription') }}</span>
                                <textarea class="form-control"
                                          placeholder="{{ trans('messages.articleDescription') }}" id="descripcion"
                                          name="descripcion">{{ old('descripcion') }}</textarea>
                                @if($errors->has('descripcion'))
                                    <span class="text-danger">{{ $errors->first('descripcion') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-lg-6 col-md-6 col-sm-6">
                                <span class="font-weight-bold text-danger">{{ trans('messages.articlePrice') }}</span>
                                <input type="text" maxlength="9" class="form-control"
                                       placeholder="{{ trans('messages.articlePrice') }}"
                                       value="{{ old('precio') }}" name="precio" id="precio">
                                @if($errors->has('precio'))
                                    <span class="text-danger">{{ $errors->first('precio') }}</span>
                                @elseif(session('error-precio'))
                                    <span class="text-danger">{{ session('error-precio') }}</span>
                                @endif
                            </div>
                            <div class="form-group col-lg-6 col-md-6 col-sm-6">
                                <span class="font-weight-bold text-danger">{{ trans('messages.articleStock') }}</span>
                                <input type="text" class="form-control"
                                       placeholder="{{ trans('messages.articleStock') }}"
                                       value="{{ old('stock') }}" name="stock">
                                @if($errors->has('stock'))
                                    <span class="text-danger">{{ $errors->first('stock') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-lg-6 col-md-6 col-sm-6">
                                <span class="font-weight-bold text-danger">{{ trans('messages.visible') }}</span>
                                <select class="form-control" id="visible" name="visible">
                                    <option value="1">{{ trans('messages.yes') }}</option>
                                    <option value="0">{{ trans('messages.no') }}</option>
                                </select>
                                @if($errors->has('visible'))
                                    <span class="text-danger">{{ $errors->first('visible') }}</span>
                                @endif
                            </div>
                            <div class="form-group col-lg-6 col-md-6 col-sm-6">
                                <div class="row ml-1">
                                    <label for="imagen"
                                           class="font-weight-bold text-danger">{{ trans('messages.articleImage') }}</label>
                                </div>
                                <div class="row">
                                    <input name="imagen" id="imagen" class="form-control-file" type="file"
                                           value="{{ old('imagen') }}"/>
                                    @if($errors->has('imagen'))
                                        <span class="text-danger">{{ $errors->first('imagen') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group">
                                <button class="site-button button-lg btn-block ml-4"
                                        type="submit">{{ trans('messages.saveArticle') }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <!-- Product END -->
    </div>
    <!-- contact area  END -->
@endsection

@section('additional-scripts')
    <script src="{{ assetFtp('js/commonFunctions.js') }}"></script>
    <script>

        onlyNumbers("#stock");

        $("#precio").on('input', function (e) {
            $("#precio").val($(this).val().replace(",", "."));
        });

        $(document).ready(function () {
            var selectedBrand = $("#marca option:selected").val();
            if (selectedBrand != "selectBrand") {
                var oldModel = "{{ old('modelo') }}";
                var oldEngine = "{{ old('motor') }}";

                $.ajax({
                    type: "GET",
                    url: '{{ route('getModels') }}',
                    data: {
                        id: $("#marca option:selected").val(),
                    },
                    success: function (data) {
                        $("#modelo option:gt(0)").remove();
                        $("#motor option:gt(0)").remove();
                        $(data).each((ind, ele) => {
                            if (ele.id == oldModel) {
                                $("#modelo").append("<option selected value='" + ele.id + "'>" + ele.nombre + "</option>");
                            } else {
                                $("#modelo").append("<option value='" + ele.id + "'>" + ele.nombre + "</option>");
                            }
                        });

                        $.ajax({
                            type: "GET",
                            url: '{{ route('getEngines') }}',
                            data: {
                                id: $("#modelo option:selected").val(),
                            },
                            success: function (data) {
                                $("#motor option:gt(0)").remove();
                                $(data).each((ind, ele) => {
                                    if (ele.id == oldEngine) {
                                        $("#motor").append("<option selected value='" + ele.id + "'>" + ele.nombre + "</option>");
                                    } else {
                                        $("#motor").append("<option value='" + ele.id + "'>" + ele.nombre + "</option>");
                                    }
                                });
                            }, error: function (xhr, ajaxOptions, thrownError) {
                                console.log(thrownError);
                            }
                        })
                    }, error: function (xhr, ajaxOptions, thrownError) {
                        console.log(thrownError);
                    }
                });


            }
        });

        $("#marca").change(function () {
            $.ajax({
                type: "GET",
                url: '{{ route('getModels') }}',
                data: {
                    id: $("#marca option:selected").val(),
                },
                success: function (data) {
                    $("#modelo option:gt(0)").remove();
                    $("#motor option:gt(0)").remove();
                    $(data).each((ind, ele) => {
                        $("#modelo").append("<option value='" + ele.id + "'>" + ele.nombre + "</option>");
                    });
                }, error: function (xhr, ajaxOptions, thrownError) {
                    console.log(thrownError);
                }
            })
        });

        $("#modelo").change(function () {
            $.ajax({
                type: "GET",
                url: '{{ route('getEngines') }}',
                data: {
                    id: $("#modelo option:selected").val(),
                },
                success: function (data) {
                    $("#motor option:gt(0)").remove();
                    $(data).each((ind, ele) => {
                        $("#motor").append("<option value='" + ele.id + "'>" + ele.nombre + "</option>");
                    });
                }, error: function (xhr, ajaxOptions, thrownError) {
                    console.log(thrownError);
                }
            })
        });


    </script>
    @if(session('response-form'))
        <script>
            Swal.fire({
                icon: "{{ session('response-form')['icon'] }}",
                title: "{{ session('response-form')['title'] }}",
                text: "{{ session('response-form')['text'] }}",
            });
            $(".swal2-select").remove();
        </script>
    @endif
@endsection
