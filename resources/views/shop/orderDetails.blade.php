@extends('layout.layout')

@section('additional-header')
    <style>
        img {
            width: 50px;
            height: 50px;
        }
    </style>
@endsection

@section('content')
    <div class="section-full content-inner">
        <!-- Product -->
        <div class="container">
            <h4>{{ trans('messages.orderNumber') . ': ' . $order[0]['idPedido'] }}</h4>
            <h4>{{ trans('messages.orderPlaced') }} {{ date('d-m-Y',  substr(strtotime($order[0]['fecha']), 0, 10)) }}</h4>
            <div class="dlab-divider bg-gray-dark text-gray-dark icon-center"><i
                    class="fa fa-circle bg-white text-gray-dark"></i></div>
            <div class="row">
                <div class="col-lg-6 col-md-6">
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
                <div class="col-lg-6 col-md-6">
                    <h4>{{ trans('messages.orderTotal') }}</h4>
                    <table class="table-bordered check-tbl">
                        <tbody>
                        <tr>
                            <td>{{ trans('messages.orderSubtotal') }}</td>
                            <td id="subtotal">{{ $order[0]['precioTotal'] }}€</td>
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
                    <div class="form-group">
                        <a href="{{ route('printOrder', \Illuminate\Support\Facades\Crypt::encryptString($order[0]['idPedido']))  }}"
                           class="site-button button-lg btn-block text-white"><i
                                class="far fa-file-pdf"></i> {{ trans('messages.printPdf') }}</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Product END -->
    </div>
    <!-- contact area  END -->
@endsection

@section('additional-scripts')

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
