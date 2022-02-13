@extends('layout.layout')

@section('additional-header')

@endsection

@section('content')

    <!-- contact area -->
    <div class="section-full content-inner">
        <!-- Product -->
        <div class="container">
            <form class="shop-form" method="post" enctype="multipart/form-data" action="{{ route('storeCar') }}">
                @csrf
                <div class="row">
                    <div class="col-md-6 col-lg-6 m-b30"
                         style="background: center center no-repeat url('{{ assetFtp('images/addCar.jpg') }}'); background-size:
                             contain">
                    </div>
                    <div class="col-md-6 col-lg-6 m-b30">
                        <h4>{{ trans('messages.carData') }}</h4>
                        <div class="row">
                            <div class="form-group col-lg-6 col-md-6 col-sm-6">
                                <span class="font-weight-bold text-danger">{{ trans('messages.brand') }}</span>
                                <input type="hidden" name="id_cliente"
                                       value="{{ request()->route()->parameter('id') }}">
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
                                    class="font-weight-bold text-danger">{{ trans('messages.manufactureYear') }}</span>
                                <input type="text" class="form-control"
                                       placeholder="{{ trans('messages.manufactureYear') }}"
                                       value="{{ old('anio') }}" name="anio" id="anio">
                                @if($errors->has('anio'))
                                    <span class="text-danger">{{ $errors->first('anio') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-lg-6 col-md-6 col-sm-6">
                                <span class="font-weight-bold text-danger">{{ trans('messages.licensePlate') }}</span>
                                <input type="text" class="form-control"
                                       placeholder="{{ trans('messages.licensePlate') }}"
                                       value="{{ old('matricula') }}" name="matricula">
                                @if($errors->has('matricula'))
                                    <span class="text-danger">{{ $errors->first('matricula') }}</span>
                                @elseif(session('error-matricula'))
                                    <span class="text-danger">{{ session('error-matricula') }}</span>
                                @endif
                            </div>
                            <div class="form-group col-lg-6 col-md-6 col-sm-6">
                                <span class="font-weight-bold text-danger">{{ trans('messages.chassisNumber') }}</span>
                                <input type="text" maxlength="17" class="form-control"
                                       placeholder="{{ trans('messages.chassisNumber') }}"
                                       value="{{ old('bastidor') }}" name="bastidor" id="bastidor">
                                @if($errors->has('bastidor'))
                                    <span class="text-danger">{{ $errors->first('bastidor') }}</span>
                                @elseif(session('error-bastidor'))
                                    <span class="text-danger">{{ session('error-bastidor') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group">
                                <button class="site-button button-lg btn-block ml-4"
                                        type="submit">{{ trans('messages.saveCar') }}</button>
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

        onlyNumbers("#anio");
        validarBastidor();

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

        function validarBastidor() {
            $("#bastidor").keypress(function (e) {
                if ((e.which < 48) || (e.which > 57 && e.which < 65) || (e.which > 90 && e.which < 97) || (e.which > 122)) {
                    return false;
                }
            });
        }


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
