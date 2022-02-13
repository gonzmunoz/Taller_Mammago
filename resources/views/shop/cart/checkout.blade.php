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
            @if(\Cart::isEmpty())
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <h2>{{ trans('messages.emptyCart') }}</h2>
                        <a href="{{ route('shop', 'all') }}" class="site-button">{{ trans('messages.returnShop') }}</a>
                    </div>
                </div>
            @else
                @if(session('userLogged')['direccion'] == null)
                    <div class="col-lg-12 text-center">
                        <h2>{{ trans('messages.incompleteUser') }}</h2>
                        <a href="{{ route('myAccount') }}" class="site-button">{{ trans('messages.myAccount') }}</a>
                    </div>
                @else
                    <form class="shop-form" method="post" action="{{ route('payOrderWithPayPal') }}">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 col-lg-6 m-b30">
                                <h4>{{ trans('messages.shippingAddress') }}</h4>
                                <div class="row">
                                    <div class="form-group col-lg-6 col-md-6 col-sm-6">
                                        <input type="hidden" name="nombre_usuario"
                                               value="{{ session('userLogged')['nombre_usuario'] }}">
                                        <span class="font-weight-bold text-danger">{{ trans('messages.Name') }}</span>
                                        <input disabled type="text" class="form-control"
                                               placeholder="{{ trans('messages.Name') }}"
                                               value="{{ old('nombre') ? old('nombre') : ucfirst(session('userLogged')['nombre']) }}"
                                               name="nombre">
                                        @if($errors->has('nombre'))
                                            <span class="text-danger">{{ $errors->first('nombre') }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group col-lg-6 col-md-6 col-sm-6">
                                        <span
                                            class="font-weight-bold text-danger">{{ trans('messages.SurName') }}</span>
                                        <input disabled type="text" class="form-control"
                                               placeholder="{{ trans('messages.SurName') }}"
                                               value="{{ old('apellidos') ? old('apellidos') : ucfirst(session('userLogged')['apellidos']) }}"
                                               name="apellidos">
                                        @if($errors->has('apellidos'))
                                            <span class="text-danger">{{ $errors->first('apellidos') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group">
                                    <span class="font-weight-bold text-danger">{{ trans('messages.address') }}</span>
                                    <input disabled type="text" class="form-control"
                                           placeholder="{{ trans('messages.address') }}"
                                           value="{{ old('direccion') ? old('direccion') : ucfirst(session('userLogged')['direccion']) }}"
                                           name="direccion">
                                    @if($errors->has('direccion'))
                                        <span class="text-danger">{{ $errors->first('direccion') }}</span>
                                    @endif
                                </div>
                                <div class="row">
                                    <div class="form-group col-lg-6 col-md-6 col-sm-6">
                                        <span
                                            class="font-weight-bold text-danger">{{ trans('messages.country') }}</span>
                                        <input disabled type="text" class="form-control"
                                               placeholder="{{ trans('messages.country') }}"
                                               value="{{ old('pais') ? old('pais') : ucfirst(session('userLogged')['pais']) }}"
                                               name="pais">
                                        @if($errors->has('pais'))
                                            <span class="text-danger">{{ $errors->first('pais') }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group col-lg-6 col-md-6 col-sm-6">
                                        <span class="font-weight-bold text-danger">{{ trans('messages.state') }}</span>
                                        <input disabled type="text" class="form-control"
                                               placeholder="{{ trans('messages.state') }}"
                                               value="{{ old('provincia') ? old('provincia') : ucfirst(session('userLogged')['provincia']) }}"
                                               name="provincia">
                                        @if($errors->has('provincia'))
                                            <span class="text-danger">{{ $errors->first('provincia') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-lg-6 col-md-6 col-sm-6">
                                        <span class="font-weight-bold text-danger">{{ trans('messages.town') }}</span>
                                        <input disabled type="text" class="form-control"
                                               placeholder="{{ trans('messages.town') }}"
                                               value="{{ old('ciudad') ? old('ciudad') : ucfirst(session('userLogged')['ciudad']) }}"
                                               name="ciudad">
                                        @if($errors->has('ciudad'))
                                            <span class="text-danger">{{ $errors->first('ciudad') }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group col-lg-6 col-md-6 col-sm-6">
                                        <span class="font-weight-bold text-danger">{{ trans('messages.phone') }}</span>
                                        <input disabled type="text" class="form-control"
                                               placeholder="{{ trans('messages.phone') }}"
                                               value="{{ old('telefono') ? old('telefono') : ucfirst(session('userLogged')['telefono']) }}"
                                               name="telefono" id="telefono" maxlength="9">
                                        @if($errors->has('telefono'))
                                            <span class="text-danger">{{ $errors->first('telefono') }}</span>
                                        @elseif(session('error-phone'))
                                            <span class="text-danger">{{ session('error-phone') }}</span>
                                        @endif
                                        <input type="hidden" name="orderTotal" id="orderTotal"
                                               value="{{ \Cart::getTotal() }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-6 m-b30"
                                 style="background: center center no-repeat url('{{ assetFtp('images/checkout.jpg') }}'); background-size:
                                     contain"></div>
                        </div>
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
                                    @foreach(\Cart::getContent() as $article)
                                        <tr class="alert">
                                            <td class="product-item-img text-center"><img
                                                    src="{{ assetFtp('images/articles/') }}{{ $article['attributes']['imagen'] }}"
                                                    alt="">
                                            </td>
                                            <td class="product-item-name text-center">{{ $article['name'] }}</td>
                                            <td class="product-item-price text-center">{{ $article['price'] }} €</td>
                                            <td class="product-item-quantity text-center">{{ $article['quantity'] }}</td>
                                            <td class="product-item-totle text-center">{{ $article['price'] * $article['quantity'] }}
                                                €
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <form class="shop-form">
                                    <h4>{{ trans('messages.orderTotal') }}</h4>
                                    <table class="table-bordered check-tbl">
                                        <tbody>
                                        <tr>
                                            <td>{{ trans('messages.orderSubtotal') }}</td>
                                            <td id="subtotal">{{ \Cart::getSubTotal() }}€</td>
                                        </tr>
                                        <tr>
                                            <td>{{ trans('messages.shipping') }}</td>
                                            <td id="shipping">{{ trans('messages.freeShipping') }}</td>
                                        </tr>
                                        <tr>
                                            <td>{{ trans('messages.total') }}</td>
                                            <td id="total">{{ \Cart::getTotal() }}€</td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <h5><i class="fab fa-paypal"
                                           style="color: #0e91e3"></i> {{ trans('messages.payment') }}
                                    </h5>
                                    <div class="form-group">
                                        <button class="site-button button-lg btn-block"
                                                type="submit">{{ trans('messages.placeOrder') }}</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </form>
                @endif
            @endif
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
