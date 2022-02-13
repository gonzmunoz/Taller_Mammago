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
    <!-- contact area -->
    <div class="section-full content-inner">
        <!-- Product -->
        <div class="container" id="cartBody">
            @if(\Cart::isEmpty())
                <div class="row">
                    <div class="col-lg-12 text-center">
                        <h2>{{ trans('messages.emptyCart') }}</h2>
                        <a href="{{ route('shop', 'all') }}" class="site-button">{{ trans('messages.returnShop') }}</a>
                    </div>
                </div>
            @else
                <div class="row">
                    <div class="col-lg-12 m-b30">
                        <div class="table-responsive">
                            <table class="table check-tbl">
                                <thead class="text-left">
                                <tr>
                                    <th>{{ trans('messages.article') }}</th>
                                    <th>{{ trans('messages.articleName') }}</th>
                                    <th>{{ trans('messages.unitPrice') }}</th>
                                    <th>{{ trans('messages.quantity') }}</th>
                                    <th>{{ trans('messages.total') }}</th>
                                    <th>{{ trans('messages.delete') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($cart as $article)
                                    <tr class="alert" id="celda{{$article['id']}}"
                                        idArticle="{{ \Illuminate\Support\Facades\Crypt::encryptString($article['id']) }}"
                                        price="{{ $article['price'] }}">
                                        <td class="product-item-img"><img
                                                src="{{ assetFtp('images/articles/') }}{{ $article['attributes']['imagen'] }}"
                                                alt="">
                                        </td>
                                        <td class="product-item-name">{{ $article['name'] }}</td>
                                        <td class="product-item-price">{{ $article['price'] }} €</td>
                                        <td class="product-item-quantity">
                                            <select class="article-quantity" style="width:50px;">
                                                @for($i = 1; $i< ($article['attributes']['stock'] + 1); $i++)
                                                    <option
                                                        id="{{ $i }}" {{ $i==$article['quantity'] ? 'selected' : '' }}>{{ $i }}</option>
                                                @endfor
                                            </select>
                                        </td>
                                        <td class="product-item-totle"
                                            id="articleTotalPrice">{{ $article['price'] * $article['quantity'] }}
                                            €
                                        </td>
                                        <td class="product-item-close">
                                            <a href="{{ route('cartRemoveItem') }}"
                                               class="fa fa-times"></a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-md-6"
                         style="background: center center no-repeat url('{{ assetFtp('images/cartIndex.jpg') }}'); background-size:
                             contain">
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <h5>{{ trans('messages.cartSubtotal') }}</h5>
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
                        <div class="form-group">
                            <a href="{{ route('cartClear') }}" class="site-button">{{ trans('messages.clearCart') }}</a>
                            <a href="{{ route('cartCheckout') }}"
                               class="site-button">{{ trans('messages.proceedCheckout') }}</a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
        <!-- Product END -->
    </div>
    <!-- contact area  END -->
@endsection

@section('additional-scripts')

    <script>

        $(document).ready(function () {

            // Eliminar producto
            $(".fa-times").on("click", function (e) {
                var row = $(this).closest("tr").attr("id");
                e.preventDefault();
                Swal.fire({
                    title: "{{ trans('messages.confirmRemoveProduct') }}",
                    text: "{{ trans('messages.confirmRemoveProductMessage') }}",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    cancelButtonText: "{{ trans('messages.notRemove') }}",
                    confirmButtonText: "{{ trans('messages.remove') }}"
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "GET",
                            url: '{{ route('cartRemoveItem') }}',
                            data: {
                                id: $(this).closest("tr").attr("idArticle"),
                            },
                            success: function (data) {
                                console.log(data);
                                Swal.fire({
                                    title: "{{ trans('messages.articleRemoved') }}",
                                    text: "{{ trans('messages.articleSuccessfullyRemoved') }}",
                                    icon: "success"
                                }).then(function () {
                                    if (data == 0) {
                                        $("#cartBody div").remove();
                                        $("#cartBody").append("<div class='row'><div class='col-lg-12 text-center'><h2>{{ trans('messages.emptyCart') }}</h2><a href='{{ route('shop', 'all') }}' class='site-button'>{{ trans('messages.returnShop') }}</a></div></div>");
                                        $("#lblCartCount").html(data);
                                    } else {
                                        $("#" + row).remove();
                                        $("#lblCartCount").html(data);
                                    }
                                });
                            }, error: function (xhr, ajaxOptions, thrownError) {
                                console.log(thrownError);
                            }
                        });
                    }
                })

            });

            $(".article-quantity").on("change", function () {
                var artId = $(this).find('option:selected').attr("id");
                var artPrice = $(this).closest('tr').attr("price");
                $.ajax({
                    type: "GET",
                    url: '{{ route('updateCartArticle') }}',
                    data: {
                        id: $(this).closest("tr").attr("idArticle"),
                        articleQuantity: $(this).find('option:selected').attr("id"),
                    },
                    success: function (data) {
                        Swal.fire({
                            title: "{{ trans('messages.cartUpdated') }}",
                            text: "{{ trans('messages.cartSuccessfullyUpdated') }}",
                            icon: "success"
                        }).then(function () {
                            $("#articleTotalPrice").html((parseFloat(artId) * parseFloat(artPrice)).toFixed(2) + " €");
                            $("#total").html(data[0].toFixed(2) + " €");
                            $("#subtotal").html(data[0].toFixed(2) + " €");
                            $("#lblCartCount").html(data[1]);
                        });
                    }, error: function (xhr, ajaxOptions, thrownError) {
                        console.log(thrownError);
                    }
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
