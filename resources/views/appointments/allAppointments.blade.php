@extends('layout.layout')

@section('additional-header')
    <link rel="stylesheet" type="text/css"
          href="{{ assetFtp('plugins/datatable/datatables.css') }}">

@endsection

@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-12 m-b30">
                @if(empty($appointments))
                    <div class="col-lg-12 text-center">
                        <h2>{{ trans('messages.noAllAppointments') }}</h2>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table check-tbl text-center" id="users-table">
                            <thead style="background-color: #EE3131" class="text-light">
                            <tr>
                                <th class="align-middle text-white">{{ trans('messages.clientId') }}</th>
                                <th class="align-middle text-white">{{ trans('messages.client') }}</th>
                                <th class="align-middle text-white">{{ trans('messages.licensePlate') }}</th>
                                <th class="align-middle text-white">{{ trans('messages.appointmentDate') }}</th>
                                <th class="align-middle text-white">{{ trans('messages.appointmentHour')  }}</th>
                                <th class="align-middle text-white">{{ trans('messages.appointmentReason')  }}</th>
                                <th class="align-middle text-white">{{ trans('messages.cancelAppointment')  }}</th>
                                <th class="align-middle text-white">{{ trans('messages.confirmedAppointment')  }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($appointments as $appointment)
                                <tr fecha="{{ date('d-m-Y',  substr(strtotime($appointment['fecha']), 0, 10)) }}">
                                    <th scope="row" class="align-middle"
                                        title="{{ $appointment['idCliente'] }}">{{ $appointment['idCliente'] }}</th>
                                    <td class="align-middle"
                                        title="{{ $appointment['nombre'] }} {{ $appointment['apellidos'] }}">{{ $appointment['nombre'] }} {{ $appointment['apellidos'] }}</td>
                                    <td class="align-middle"
                                        title="{{ $appointment['matricula'] }}">{{ $appointment['matricula'] }}</td>
                                    <td class="align-middle"
                                        title="{{ date('d-m-Y',  substr(strtotime($appointment['fecha']), 0, 10)) }}">{{ date('d-m-Y',  substr(strtotime($appointment['fecha']), 0, 10)) }}</td>
                                    <td class="align-middle"
                                        title="{{ substr($appointment['fecha'], 11, 5) }}">{{ substr($appointment['fecha'], 11, 5) }}</td>
                                    <td class="align-middle"
                                        title="{{ $appointment['motivo'] }}">{{ $appointment['motivo'] }}</td>
                                    <td class="align-middle product-item-close">
                                        <a class="fa fa-times"
                                           idAppointment="{{ \Illuminate\Support\Facades\Crypt::encryptString($appointment['idCita']) }}"></a>
                                    </td>
                                    @if($appointment['confirmada']==true)
                                        <td class="align-middle product-item-close-green">
                                            <a class="fas fa-check"></a>
                                        </td>
                                    @else
                                        <td class="align-middle product-item-close">
                                            <a class="fas fa-check confirm"
                                               idAppointment="{{ \Illuminate\Support\Facades\Crypt::encryptString($appointment['idCita']) }}"></a>
                                        </td>
                                    @endif

                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('additional-scripts')
    <script src="{{ assetFtp('plugins/datatable/datatables.min.js') }}"
            type="text/javascript"></script>
    <script src="{{ assetFtp('plugins/datatable/spanish-datatable.json') }}"
            type="text/javascript"></script>
    <script>

        $(window).on("load", function () {
            $(function () {
                $("#users-table").dataTable(
                    {
                        pageLength: 6,
                        "order" :[
                            [3, "asc"]
                        ],
                        "language": {
                            "url": "{{ assetFtp(trans('messages.dataTable')) }}"
                        },
                        lengthChange: false,
                        "aoColumnDefs": [
                            {"bSortable": false, "aTargets": [6, 7]},
                            {"bSearchable": false, "aTargets": [6, 7]},
                        ]
                    });
            });
        });

        $(".fa-times").on("click", function (e) {
            e.preventDefault();
            Swal.fire({
                title: "{{ trans('messages.confirmMessage') }}",
                text: "{{ trans('messages.confirmCancelAppointment') }}",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                cancelButtonText: "{{ trans('messages.notCancel') }}",
                confirmButtonText: "{{ trans('messages.cancel') }}"
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "GET",
                        url: '{{ route('cancelAppointment') }}',
                        data: {
                            id: $(this).attr("idAppointment"),
                        },
                        success: function (data) {
                            Swal.fire({
                                title: "{{ trans('messages.appointmentCanceled') }}",
                                text: "{{ trans('messages.appointmentSuccessfullyCanceled') }}",
                                icon: "success"
                            }).then(function () {
                                window.location = "{{ route('listAppointments') }}";
                            });
                        }, error: function (xhr, ajaxOptions, thrownError) {
                            console.log(thrownError);
                        }
                    });
                }
            })

        });

        $(".confirm").on("click", function (e) {
            e.preventDefault();
            var currentDate = getDate();
            console.log(getDate());
            if ($(this).closest("tr").attr("fecha") != currentDate) {
                Swal.fire({
                    title: "{{ trans('messages.cantConfirmDate') }}",
                    text: "{{ trans('messages.incorrectDate') }}",
                    icon: "error"
                })
            } else {
                Swal.fire({
                    title: "{{ trans('messages.confirmMessage') }}",
                    text: "{{ trans('messages.confirmAppointmentMessage') }}",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    cancelButtonText: "{{ trans('messages.notConfirm') }}",
                    confirmButtonText: "{{ trans('messages.confirm') }}"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "GET",
                            url: '{{ route('confirmAppointment') }}',
                            data: {
                                id: $(this).attr("idAppointment"),
                            },
                            success: function (data) {
                                Swal.fire({
                                    title: "{{ trans('messages.appointmentConfirmed') }}",
                                    text: "{{ trans('messages.appointmentSuccessfullyConfirmed') }}",
                                    icon: "success"
                                }).then(function () {
                                    window.location = "{{ route('listAppointments') }}";
                                });
                            }, error: function (xhr, ajaxOptions, thrownError) {
                                console.log(thrownError);
                            }
                        });
                    }
                })
            }

        });

        function getDate() {

            var curDate = new Date();
            var day = curDate.getDate();
            var month = curDate.getMonth() + 1;
            var year = curDate.getFullYear();

            if (day < 10) {
                day = "0" + day;
            }

            if (month < 10) {
                month = "0" + month;
            }

            return day + "-" + month + "-" + year;
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
