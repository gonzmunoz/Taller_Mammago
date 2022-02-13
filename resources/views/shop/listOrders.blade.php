@extends('layout.layout')

@section('additional-header')
    <link rel="stylesheet" type="text/css"
          href="{{ assetFtp('plugins/datatable/datatables.css') }}">
@endsection

@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-12 m-b30">
                @if(empty($orders))
                    <div class="row">
                        <div class="col-lg-12 text-center">
                            <h2>{{ trans('messages.noOrders') }}</h2>
                        </div>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table check-tbl text-center" id="users-table">
                            <thead style="background-color: #EE3131" class="text-light">
                            <tr>
                                <th class="align-middle text-white">{{ trans('messages.orderNumber') }}</th>
                                <th class="align-middle text-white">{{ trans('messages.clientId') }}</th>
                                <th class="align-middle text-white">{{ trans('messages.clientName') }}</th>
                                <th class="align-middle text-white">{{ trans('messages.orderDate') }}</th>
                                <th class="align-middle text-white">{{ trans('messages.numArticles') }}</th>
                                <th class="align-middle text-white">{{ trans('messages.totalPrice')  }}</th>
                                <th class="align-middle text-white">{{ trans('messages.seeOrder')  }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($orders as $order)
                                <tr>
                                    <th scope="row" class="align-middle"
                                        title="{{ $order['idPedido'] }}">{{ $order['idPedido'] }}</th>
                                    <td class="align-middle"
                                        title="{{ $order['idCliente'] }}">{{ $order['idCliente'] }}</td>
                                    <td class="align-middle"
                                        title="{{ $order['nombre'] }} {{ $order['apellidos'] }}">{{ $order['nombre'] }} {{ $order['apellidos'] }}</td>
                                    <td class="align-middle"
                                        title="{{ date('d-m-Y',  substr(strtotime($order['fecha']), 0, 10)) }}">{{ date('d-m-Y',  substr(strtotime($order['fecha']), 0, 10)) }}</td>
                                    <td class="align-middle"
                                        title="{{ $order['articulos'] }}">{{ $order['articulos'] }}</td>
                                    <td class="align-middle"
                                        title="{{ $order['precioTotal'] }} €">{{ $order['precioTotal'] }} €
                                    </td>
                                    <td class="align-middle">
                                        <a
                                            href="{{ route('viewOrder', \Illuminate\Support\Facades\Crypt::encryptString($order['idPedido'])) }}">
                                            <i class="fas fa-box-open"></i>
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
                $("#users-table").dataTable(
                    {
                        pageLength: 6,
                        "language": {
                            "url": "{{ assetFtp(trans('messages.dataTable')) }}"
                        },
                        lengthChange: false,
                        "aoColumnDefs": [
                            {"bSortable": false, "aTargets": [6]},
                            {"bSearchable": false, "aTargets": [6]},
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
