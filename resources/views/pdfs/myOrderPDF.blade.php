<!DOCTYPE html>
<html>
<head>
    <title>{{ trans('messages.order') . ' ' . date('d-m-Y',  substr(strtotime($order[0]['fecha']), 0, 10)) }}</title>
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
                    {{ trans('messages.orderNumber') . ': ' . $order[0]['idPedido'] }}
                </li>
                <li>
                    {{ trans('messages.orderPlaced') }} {{ date('d-m-Y',  substr(strtotime($order[0]['fecha']), 0, 10)) }}
                </li>
                <li>
                    {{ trans('messages.client') . ': ' . $order[0]['nombre'] . ' ' . $order[0]['apellidos'] }}
                </li>
                <li>
                    {{ trans('messages.address') . ': ' . $order[0]['direccion'] }}
                </li>
            </ul>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12  mt-5">
            <h4>{{ trans('messages.yourOrder') }}</h4>
            <table class="table-bordered check-tbl">
                <thead class="text-left">
                <tr>
                    <th class="text-center">{{ trans('messages.article') }}</th>
                    <th class="text-center">{{ trans('messages.articleName') }}</th>
                    <th class="text-center">{{ trans('messages.unitPrice') }}</th>
                    <th class="text-center">{{ trans('messages.quantity') }}</th>
                    <th class="text-center">{{ trans('messages.total') }}</th>
                </tr>
                </thead>
                <tbody>
                @foreach($articles as $article)
                    <tr class="alert">
                        <td class="product-item-img text-center"><img
                                src="{{ assetFtp('images/articles/') }}{{ $article['imagen'] }}"
                                alt="">
                        </td>
                        <td class="product-item-name text-center">{{ $article['nombre'] }}</td>
                        <td class="product-item-price text-center">{{ $article['precio'] }} €</td>
                        <td class="product-item-quantity text-center">{{ $article['cantidad'] }}</td>
                        <td class="product-item-totle text-center">{{ $article['precio'] * $article['cantidad'] }}
                            €
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6 col-md-6 mt-2">
            <h4>{{ trans('messages.orderTotal') }}</h4>
            <table class="table-bordered check-tbl">
                <tbody>
                <tr>
                    <td>{{ trans('messages.orderSubtotal') }}</td>
                    <td id="total">{{ number_format($order[0]['precioTotal'] - ($order[0]['precioTotal'] * 0.21), 2)   .' €' }}</td>
                </tr>
                <tr>
                    <td>{{ trans('messages.iva') }}</td>
                    <td id="total">{{ number_format(($order[0]['precioTotal'] * 0.21), 2)  .' €' }}</td>
                </tr>
                <tr>
                    <td>{{ trans('messages.shipping') }}</td>
                    <td id="shipping">{{ trans('messages.freeShipping') }}</td>
                </tr>
                <tr>
                    <td>{{ trans('messages.total') }}</td>
                    <td id="total">{{ $order[0]['precioTotal'] }}€</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
