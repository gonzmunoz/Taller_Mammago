<!DOCTYPE html>
<html>
<head>
    <title>{{ trans('messages.order') . ' ' . date('d-m-Y',  substr(strtotime($repair['fecha_fin']), 0, 10)) }}</title>
    <link rel="stylesheet" type="text/css"
          href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<style>
    td img {
        width: 50px;
        height: 50px;
    }
</style>
<body>
<div class="container">
    <div class="row">
        <div class="col-6">
            <img src="{{ assetFtp('images/logo2.png') }}" width="193" height="89" alt="">
        </div>
        <div class="col-6 float-right text-right">
            <ul class="list-unstyled">
                <li>
                    {{ trans('messages.repairNumber') . ': ' . $repair['id'] }}
                </li>
                <li>
                    {{ trans('messages.repairCompletedAt') }} {{ date('d-m-Y',  substr(strtotime($repair['fecha_fin']), 0, 10)) }}
                </li>
                <li>
                    {{ trans('messages.client') . ': ' . $repair['nombre'] . ' ' . $repair['apellidos'] }}
                </li>
                <li>
                    {{ trans('messages.address') . ': ' . $repair['direccion'] }}
                </li>
            </ul>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12  mt-5">
            <h4>{{ trans('messages.replacements') }}</h4>
            <table class="table-bordered check-tbl">
                <thead class="text-left">
                <tr>
                    <th class="text-center">{{ trans('messages.replacement') }}</th>
                    <th class="text-center">{{ trans('messages.replacementName') }}</th>
                    <th class="text-center">{{ trans('messages.replacementPrice') }}</th>
                    <th class="text-center">{{ trans('messages.replacementQuantity') }}</th>
                    <th class="text-center">{{ trans('messages.total') }}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($replacements as $replacement)
                    <tr class="alert">
                        <td class="product-item-img text-center"><img
                                src="{{ assetFtp('images/articles/') }}{{ $replacement['imagen'] }}"
                                alt="">
                        </td>
                        <td class="product-item-name text-center">{{ $replacement['nombre'] }}</td>
                        <td class="product-item-price text-center">{{ $replacement['precio'] }} €</td>
                        <td class="product-item-quantity text-center">{{ $replacement['cantidad'] }}</td>
                        <td class="product-item-totle text-center">{{ $replacement['precio'] * $replacement['cantidad'] }}
                            €
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <h4>{{ trans('messages.repairWorks') }}</h4>
            <table class="table-bordered check-tbl">
                <thead class="text-left">
                <tr>
                    <th class="text-center">{{ trans('messages.replacement') }}</th>
                    <th class="text-center">{{ trans('messages.replacementName') }}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($works as $work)
                    <tr class="alert">
                        <td class="product-item-name text-center">{{ $work['descripcion'] }}</td>
                        <td class="product-item-price text-center">
                            {{ $work['tiempo_empleado'] . ' ' . trans('messages.hours') }}
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6 col-md-6 mt-2">
            <h4>{{ trans('messages.repairTotal') }}</h4>
            <table class="table-bordered check-tbl">
                <tbody>
                <tr>
                    <td>{{ trans('messages.workforceTotal') }}</td>
                    <td id="subtotal">{{ $repair['totalTrabajos'] .' €' }}</td>
                </tr>
                <tr>
                    <td>{{ trans('messages.replacementsTotal') }}</td>
                    <td id="subtotal">{{ $repair['totalRepuestos'] .' €' }}</td>
                </tr>
                <tr>
                    <td>{{ trans('messages.repairSubtotal') }}</td>
                    <td id="total">{{ number_format($repair['total'] - ($repair['total'] * 0.21), 2)   .' €' }}</td>
                </tr>
                <tr>
                    <td>{{ trans('messages.iva') }}</td>
                    <td id="total">{{ number_format(($repair['total'] * 0.21), 2)  .' €' }}</td>
                </tr>
                <tr>
                    <td>{{ trans('messages.total') }}</td>
                    <td id="total">{{ $repair['total'] .' €' }}</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
