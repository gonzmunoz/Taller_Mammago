@extends('layout.layout')

@section('additional-header')
    <link rel="stylesheet" type="text/css"
          href="{{ assetFtp('plugins/datatable/datatables.css') }}">

@endsection

@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-12 m-b30">
                @if(empty($cars))
                    <div class="col-lg-12 text-center">
                        <h2>{{ trans('messages.noAllCars') }}</h2>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table check-tbl text-center" id="cars-table">
                            <thead style="background-color: #EE3131" class="text-light">
                            <tr>
                                <th class="align-middle text-white">{{ trans('messages.ownerId') }}</th>
                                <th class="align-middle text-white">{{ trans('messages.owner') }}</th>
                                <th class="align-middle text-white">{{ trans('messages.brand')  }}</th>
                                <th class="align-middle text-white">{{ trans('messages.model')  }}</th>
                                <th class="align-middle text-white">{{ trans('messages.engine') }}</th>
                                <th class="align-middle text-white">{{ trans('messages.manufactureYear') }}</th>
                                <th class="align-middle text-white">{{ trans('messages.licensePlate') }}</th>
                                <th class="align-middle text-white">{{ trans('messages.chassisNumber') }}</th>
                                <th class="align-middle text-white">{{ trans('messages.editCar') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($cars as $car)
                                <tr>
                                    <th scope="row" class="align-middle"
                                        title="{{ ucfirst($car['id_cliente']) }}">{{ ucfirst($car['id_cliente']) }}</th>
                                    <td class="align-middle"
                                        title="{{ $car['dueno'] }}">{{ $car['dueno'] }}</td>
                                    <td class="align-middle"
                                        title="{{ ucfirst($car['marca']) }}">{{ ucfirst($car['marca']) }}</td>
                                    <td class="align-middle"
                                        title="{{ ucfirst($car['modelo']) }}">{{ ucfirst($car['modelo']) }}</td>
                                    <td class="align-middle" title="{{ $car['motor'] }}">{{ $car['motor'] }}</td>
                                    <td class="align-middle" title="{{ $car['anio'] }}">{{ $car['anio'] }}</td>
                                    <td class="align-middle"
                                        title="{{ $car['matricula'] }}">{{ $car['matricula'] }}</td>
                                    <td class="align-middle"
                                        title="{{ strtoupper($car['bastidor']) }}">{{ strtoupper($car['bastidor']) }}</td>
                                    <td class="align-middle">
                                        <a href="{{ route('viewCar', \Illuminate\Support\Facades\Crypt::encryptString($car['id'])) }}">
                                            <i class="fas fa-edit"></i>
                                        </a>
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
                $("#cars-table").dataTable(
                    {
                        pageLength: 6,
                        "language": {
                            "url": "{{ assetFtp(trans('messages.dataTable')) }}"
                        },
                        lengthChange: false,
                        "aoColumnDefs": [
                            {"bSortable": false, "aTargets": [8]},
                            {"bSearchable": false, "aTargets": [8]},
                        ]
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
