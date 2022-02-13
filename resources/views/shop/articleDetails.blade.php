@extends('layout.layout')

@section('additional-header')
    <style>
        img {
            width: 400px;
            height: 400px;
        }
    </style>
@endsection

@section('content')
    <!-- contact area -->
    <div class="section-full content-inner bg-white">
        <!-- Product details -->
        <div class="container woo-entry">
            <div class="row m-b30">
                <div class="col-lg-5 col-md-5">
                    <img src="{{ assetFtp('images/articles/') }}{{ $article['imagen'] }}" alt=""
                         class="mx-auto d-block">
                </div>
                <div class="col-lg-7 col-md-7">
                    <div class="sticky-top">
                        <form method="post" class="cart" action="{{ route('cartAddAmount') }}">
                            @csrf
                            <input type="hidden" name="idArticle" id="idArticle"
                                   value="{{ \Illuminate\Support\Facades\Crypt::encryptString($article['idArticulo']) }}">
                            <div class="dlab-post-title ">
                                <h2 class="post-title">{{ $article['nombre'] }}</h2>
                                <p class="m-b10">{{ $article['descripcion'] }}</p>
                                <div class="dlab-divider bg-gray tb15"><i class="icon-dot c-square"></i></div>
                            </div>
                            <div class="relative">
                                <h3 class="m-tb10">{{ $article['precio'] }}€</h3>
                            </div>
                            <div class="shop-item-tage">
                                <span>{{ trans('messages.vehicle') .' :' }}</span>
                                <span>{{ $article['marca'] . ' ' . $article['modelo'] . ' ' . $article['motor'] }}</span>
                            </div>
                            <div class="shop-item-tage">
                                <span>{{ trans('messages.category') .' :' }}</span>
                                <a href="{{ route('shop', $article['categoria']) }}">{{ trans('messages.' . $article['categoria'] ) }}</a>
                            </div>
                            @if(session('userLogged')['id_tipo_usuario']==1 || session('userLogged')['id_tipo_usuario']==2)
                                <div class="shop-item-tage">
                                    <span>{{ trans('messages.articleStock') }} :</span>
                                    <span>{{ $article['stock'] }}</span>
                                </div>
                            @endif
                            <div class="dlab-divider bg-gray tb15"><i class="icon-dot c-square"></i></div>
                            @if(session('userLogged')['id_tipo_usuario']==4)
                                @if($article['stock']<1)
                                    <button class="site-button radius-no" disabled style="background-color: darkgrey"><i
                                            class="ti-shopping-cart"></i> {{ trans('messages.outOfStock') }}</button>
                                @else
                                    <div class="row">
                                        <div class="m-b30 col-lg-6 col-md-6 col-sm-6">
                                            <h6>{{ trans('messages.selectQuantity') }}</h6>
                                            <div class="quantity btn-quantity style-1">
                                                <select class="article-quantity" name="quantity" id="quantity"
                                                        style="width:50px;">
                                                    @for($i = 1; $i< ($article['stock'] + 1); $i++)
                                                        <option
                                                            id="{{ $i }}">{{ $i }}</option>
                                                    @endfor
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <button class="site-button radius-no"><i
                                            class="ti-shopping-cart"></i> {{ trans('messages.addToCart') }}</button>
                                @endif
                            @else
                                <a href="{{ route('editArticle', \Illuminate\Support\Facades\Crypt::encryptString($article['idArticulo'])) }}"
                                   class="site-button text-white">{{ trans('messages.editArticle') }}</a>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Product details -->
    </div>
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
