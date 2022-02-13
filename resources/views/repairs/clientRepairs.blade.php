@extends('layout.layout')

@section('additional-header')
    <link rel="stylesheet" type="text/css"
          href="{{ assetFtp('plugins/datatable/datatables.css') }}">
@endsection

@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-12 m-b30">
                @if(empty($repairs))
                    <div class="col-lg-12 text-center">
                        <h2> {{ trans('messages.noClientRepairs') }}</h2>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table check-tbl text-center" id="users-table">
                            <thead style="background-color: #EE3131" class="text-light">
                            <tr>
                                <th class="align-middle text-white">{{ trans('messages.carLicensePlate') }}</th>
                                <th class="align-middle text-white">{{ trans('messages.repairReason') }}</th>
                                <th class="align-middle text-white">{{ trans('messages.spentTime') }}</th>
                                <th class="align-middle text-white">{{ trans('messages.repairState') }}</th>
                                <th class="align-middle text-white">{{ trans('messages.repairPaid') }}</th>
                                <th class="align-middle text-white">{{ trans('messages.cancelRepair') }}</th>
                                <th class="align-middle text-white">{{ trans('messages.viewRepair') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($repairs as $repair)
                                <tr>
                                    <th scope="row" class="align-middle"
                                        title="{{ $repair['matricula'] }}">{{ $repair['matricula'] }}</th>
                                    <td class="align-middle"
                                        title="{{ $repair['motivo'] }}">{{ $repair['motivo'] }}</td>
                                    <td class="align-middle"
                                        title="{{ $repair['tiempo_empleado'] }} {{ trans('messages.hours') }}">{{ $repair['tiempo_empleado'] }} {{ trans('messages.hours') }}</td>
                                    <td class="align-middle"
                                        title="{{ $repair['estado'] }}">{{ $repair['estado'] }}</td>
                                    @if($repair['pagada']==1)
                                        <td class="align-middle product-item-close-green">
                                            <a class="far fa-money-bill-alt" title="{{ trans('messages.paid') }}"></a>
                                        </td>
                                    @else
                                        <td class="align-middle product-item-close">
                                            <a class="far fa-money-bill-alt" title="{{ trans('messages.unPaid') }}"></a>
                                        </td>
                                    @endif
                                    <td class="align-middle product-item-close">
                                        <a class="fa fa-times"
                                           idRepair="{{ \Illuminate\Support\Facades\Crypt::encryptString($repair['idReparacion']) }}"></a>
                                    </td>
                                    <td class="align-middle product-item-close">
                                        <a class="fas fa-tools"
                                           href="{{ route('viewClientRepair', \Illuminate\Support\Facades\Crypt::encryptString($repair['idReparacion'])) }}"></a>
                                    </td>
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
                        "language": {
                            "url": "{{ assetFtp(trans('messages.dataTable')) }}"
                        },
                        lengthChange: false,
                        "aoColumnDefs": [
                            {"bSortable": false, "aTargets": [3, 4, 5, 6]},
                            {"bSearchable": false, "aTargets": [3, 4, 5, 6]},
                        ]
                    });


                $(".fa-times").on("click", function (e) {
                    e.preventDefault();
                    var idRepair = $(this).attr("idRepair");
                    $.ajax({
                        type: "GET",
                        url: '{{ route('checkDeleteRepair') }}',
                        data: {
                            id: idRepair,
                        },
                        success: function (data) {
                            if (data === "false") {
                                Swal.fire({
                                    title: "{{ trans('messages.cantCancelRepair') }}",
                                    text: "{{ trans('messages.cantCancelRepairMessage') }}",
                                    icon: "error"
                                })
                            } else {
                                Swal.fire({
                                    title: "{{ trans('messages.confirmMessage') }}",
                                    text: "{{ trans('messages.confirmCancelRepair') }}",
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
                                            url: '{{ route('cancelRepair') }}',
                                            data: {
                                                id: idRepair,
                                            },
                                            success: function (data) {
                                                Swal.fire({
                                                    title: "{{ trans('messages.repairPaidAdmin') }}",
                                                    text: "{{ trans('messages.repairSuccessfullyPaid') }}",
                                                    icon: "success"
                                                }).then(function () {
                                                    window.location = "{{ route('listRepairs') }}";
                                                });
                                            }, error: function (xhr, ajaxOptions, thrownError) {
                                                console.log(thrownError);
                                            }
                                        });
                                    }
                                })
                            }
                        }, error: function (xhr, ajaxOptions, thrownError) {
                            console.log(thrownError);
                        }
                    });


                });
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
