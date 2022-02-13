@extends('layout.layout')

@section('additional-header')

@endsection

@section('content')

    <div class="section-full content-inner">
        <!-- Product -->
        <div class="container">
            @if($cars!=null)
                <form class="shop-form" method="post" enctype="multipart/form-data"
                      action="{{ route('storeAppointment') }}">
                    @csrf
                    <div class="row" style="height: 500px;">
                        <div class="col-md-6 col-lg-6 m-b30"
                             style="background: center center no-repeat url('{{ assetFtp('images/makeAppointment.jpg') }}'); background-size:
                                 contain">
                        </div>
                        <div class="col-md-6 col-lg-6 m-b30">
                            <h4>{{ trans('messages.appointmentData') }}</h4>
                            <div class="row">
                                <div class="form-group col-lg-6 col-md-6 col-sm-6">
                                    <span
                                        class="font-weight-bold text-danger">{{ trans('messages.appointmentDate') }}</span>
                                    <input type="text" class="form-control" name="fecha" id="fecha"
                                           @if(session('selectedDate'))
                                           value="{{ session('selectedDate') }}"
                                        @endif
                                    >
                                    @if($errors->has('fecha'))
                                        <span class="text-danger">{{ $errors->first('fecha') }}</span>
                                    @endif
                                </div>
                                <div class="form-group col-lg-6 col-md-6 col-sm-6" id="horas">
                                <span
                                    class="font-weight-bold text-danger">{{ trans('messages.appointmentHour') }}</span>
                                    <select class="form-control" name="hora" id="hora">
                                        <option value="">{{ trans('messages.selectDate') }}</option>
                                    </select>
                                    @if($errors->has('hora'))
                                        <span class="text-danger">{{ $errors->first('hora') }}</span>
                                    @elseif(session('error-hora'))
                                        <span class="text-danger">{{ session('error-hora') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-lg-6 col-md-6 col-sm-6">
                                <span
                                    class="font-weight-bold text-danger">{{ trans('messages.car') }}</span>
                                    <select class="form-control" name="coche" id="coche">
                                        <option value="">{{ trans('messages.selectCar') }}</option>
                                        @foreach($cars as $car)
                                            <option
                                                value="{{ $car['id'] }}" {{ old('coche') == $car['id'] ? "selected":"" }}>{{ $car['matricula'] }}</option>
                                        @endforeach
                                    </select>
                                    @if($errors->has('coche'))
                                        <span class="text-danger">{{ $errors->first('coche') }}</span>
                                    @endif
                                </div>
                                <div class="form-group col-lg-6 col-md-6 col-sm-6">
                                <span
                                    class="font-weight-bold text-danger">{{ trans('messages.appointmentReason') }}</span>
                                    <textarea class="form-control"
                                              placeholder="{{ trans('messages.appointmentReason') }}" id="motivo"
                                              name="motivo">{{ old('motivo') }}</textarea>
                                    @if($errors->has('motivo'))
                                        <span class="text-danger">{{ $errors->first('motivo') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group">
                                    <button class="site-button button-lg btn-block ml-4"
                                            type="submit">{{ trans('messages.saveAppointment') }}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            @else
                <div class="p-a30 bg-white m-b30">
                    <div class="col-lg-12 text-center">
                        <h2>{{ trans('messages.noCars') . '. ' . trans('messages.requiredCar') }}</h2>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection

@section('additional-scripts')
    <script src="{{ assetFtp('js/commonFunctions.js') }}"></script>
    @if(session('selectedDate'))
        <script>
            $.ajax({
                type: "GET",
                url: '{{ route('fillHours') }}',
                data: {
                    fecha: $("#fecha").val(),
                },
                success: function (data) {
                    $("#horas option:gt(0)").remove();
                    if (data.includes("{{ trans('messages.noAvailableAppointments') }}")) {
                        $("#hora").append("<option value='" + data[0] + "'>" + data[0] + "</option>");
                    } else {
                        $.each(data, function (key, value) {
                            $("#hora").append("<option value='" + value + "'>" + value.substr(0, 5) + "</option>");
                        })
                    }
                    $("option[value='{{ session('selectedHour') }}']").attr('selected', 'selected');
                }, error: function (xhr, ajaxOptions, thrownError) {
                    console.log(thrownError);
                }
            });
        </script>
    @endif
    <script>
        //$("#fecha").attr("min", new Date().toISOString().slice(0, 10));
        $.datepicker.regional['es'] = {
            closeText: 'Cerrar',
            prevText: '< Ant',
            nextText: 'Sig >',
            currentText: 'Hoy',
            monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
            monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
            dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
            dayNamesShort: ['Dom', 'Lun', 'Mar', 'Mié', 'Juv', 'Vie', 'Sáb'],
            dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sá'],
            weekHeader: 'Sm',
            dateFormat: 'dd/mm/yy',
            firstDay: 1,
            isRTL: false,
            showMonthAfterYear: false,
            yearSuffix: ''
        };
        $.datepicker.setDefaults($.datepicker.regional['es']);
        $(function () {
            $("#fecha").datepicker({
                beforeShowDay: $.datepicker.noWeekends,
                minDate: 1,
            });
        });

        $(".boottsrap-select").css("display", "none");
        $("#fecha").on("change", function () {
            $.ajax({
                type: "GET",
                url: '{{ route('fillHours') }}',
                data: {
                    fecha: $("#fecha").val(),
                },
                success: function (data) {
                    $("#horas option:gt(0)").remove();
                    if (data.includes("{{ trans('messages.noAvailableAppointments') }}")) {
                        $("#hora").append("<option value='" + data[0] + "'>" + data[0] + "</option>");
                    } else {
                        $.each(data, function (key, value) {
                            $("#hora").append("<option value='" + value + "'>" + value.substr(0, 5) + "</option>");
                        })
                    }
                }, error: function (xhr, ajaxOptions, thrownError) {
                    console.log(thrownError);
                }
            });
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
