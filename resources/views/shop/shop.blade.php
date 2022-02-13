@extends('layout.layout')

@section('additional-header')
    <style>
        img {
            width: 200px;
            height: 200px;
        }

        .notVisible {
            opacity: 0.2;
        }
    </style>
@endsection

@section('content')
    <!-- contact area -->
    <div class="content-inner section-full bg-white">
        <!-- Product -->
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-3 col-sm-3">
                    <div class="widget bg-white">
                        <h5 class="widget-title">{{ trans('messages.search') }}</h5>
                        <div class="search-bx">
                            <form role="search" method="get" action="{{ route('searchShop') }}">
                                @csrf
                                <div class="input-group">
                                    <input name="searchProducts" id="searchProducts" class="form-control"
                                           placeholder="{{ trans('messages.typeSearch') }}" type="text"
                                           required>
                                    <input type="hidden" name="category" id="category" value="{{ $categoryName }}">
                                    <span class="input-group-btn">
										<button type="submit" class="site-button">
                                            <i class="fa fa-search"></i></button>
										</span>
                                </div>
                            </form>
                        </div>
                        @if($errors->has('searchProducts'))
                            <span class="text-danger">{{ $errors->first('searchProducts') }}</span>
                        @endif
                        <h5 class="widget-title mt-4">{{ trans('messages.searchEngine') }}</h5>
                        <div class="search-bx">
                            <form role="search" method="get" action="{{ route('searchShopEngine') }}">
                                @csrf
                                <div class="row">
                                    <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                        <span class="font-weight-bold text-danger">{{ trans('messages.brand') }}</span>
                                        <input type="hidden" name="category" id="category" value="{{ $categoryName }}">
                                        <select class="form-control" id="marca" name="marca">
                                            <option value="selectBrand">{{ trans('messages.selectBrand') }}</option>
                                            @foreach($brands as $b)
                                                <option
                                                    value="{{ $b['id'] }}" {{ old('marca') == $b['id'] ? 'selected' : '' }}>{{ $b['nombre'] }}</option>
                                            @endforeach
                                        </select>
                                        @if($errors->has('marca'))
                                            <span class="text-danger">{{ $errors->first('marca') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                        <span class="font-weight-bold text-danger">{{ trans('messages.model') }}</span>
                                        <select class="form-control" id="modelo" name="modelo">
                                            <option value="selectModel">{{ trans('messages.selectModel') }}</option>
                                        </select>
                                        @if($errors->has('modelo'))
                                            <span class="text-danger">{{ $errors->first('modelo') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-lg-12 col-md-12 col-sm-12">
                                        <span class="font-weight-bold text-danger">{{ trans('messages.engine') }}</span>
                                        <select class="form-control" id="motor" name="motor">
                                            <option value="selectEngine">{{ trans('messages.selectEngine') }}</option>
                                        </select>
                                        @if($errors->has('motor'))
                                            <span class="text-danger">{{ $errors->first('motor') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button class="site-button"
                                            type="submit">{{ trans('messages.search') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="widget bg-white widget_services">
                        <h4 class="widget-title">{{ trans('messages.categories') }}</h4>
                        <ul>
                            <li>
                                <a href="{{ route('shop', 'all') }}">{{ trans('messages.allCategories') }}</a>
                            </li>
                            @foreach($categories as $category)
                                <li>
                                    <a href="{{ route('shop', $category['nombre']) }}">{{ trans('messages.' . $category['nombre'] ) }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="col-lg-9 col-md-9">
                    <div class="text-center m-b50">
                        <h2 class="m-t0">{{ trans('messages.articles') }}</h2>
                        <div class="dlab-separator-outer ">
                            <div class="dlab-separator bg-primary style-skew"></div>
                        </div>
                        <h2 class="m-t0">{{  trans('messages.' . $categoryName ) }}</h2>
                    </div>
                    <div class="row" id="masonry">
                        @if(count($articles)<1)
                            <div class="alert alert-danger mx-auto" role="alert">
                                {{ trans('messages.noProductsCategory') }}
                            </div>
                        @else
                            @foreach($articles as $article)
                                <form method="post" action="{{ route('cartAdd') }}">
                                    @csrf
                                    <div
                                        class="col-lg-6 col-md-6 col-sm-6 m-b30 card-container {{ session('userLogged')['id_tipo_usuario']!=4 && $article['visible'] == 0 ? 'notVisible' : '' }}">
                                        <div class="dlab-box">
                                            <input type="hidden" name="idArticle"
                                                   value="{{ \Illuminate\Support\Facades\Crypt::encryptString($article['idArticulo']) }}">
                                            <img src="{{ assetFtp('images/articles/') }}{{ $article['imagen'] }}"
                                                 class="mx-auto d-block">
                                            <div class="dlab-info p-a20 text-center">
                                                <h4 class="dlab-title m-t0 text-uppercase"><a
                                                        href="{{ route('articleDetails', \Illuminate\Support\Facades\Crypt::encryptString($article['idArticulo'])) }}">{{ $article['nombre'] }}</a>
                                                </h4>
                                                <h6>{{ $article['marca'] . ' ' . $article['modelo'] . ' ' . $article['motor'] }}</h6>
                                                <h2 class="m-b0">{{ $article['precio'] }}€</h2>
                                                <div class="m-t20">
                                                    @if(session('userLogged')['id_tipo_usuario']==4)
                                                        @if($article['stock']<1)
                                                            <a class="site-button text-white" disabled
                                                               style="background-color: darkgrey">{{ trans('messages.outOfStock') }}</a>
                                                        @else
                                                            <button type="submit"
                                                                    class="site-button">{{ trans('messages.addToCart') }}</button>
                                                        @endif
                                                    @else
                                                        @if($article['stock']<1)
                                                            <a class="site-button text-white" disabled
                                                               style="background-color: darkgrey">{{ trans('messages.outOfStock') }}</a>
                                                        @else
                                                            <a class="site-button text-white"
                                                               disabled>{{ trans('messages.available') }}</a>
                                                        @endif
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            @endforeach
                        @endif
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="d-flex justify-content-center">
                                {{ $articles->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Product END -->
    </div>
    <!-- contact area  END -->
    </div>
@endsection

@section('additional-scripts')

    <script>
        $(document).ready(function () {
            var selectedBrand = $("#marca option:selected").val();
            if (selectedBrand != "selectBrand") {
                var oldModel = "{{ old('modelo') }}";
                var oldEngine = "{{ old('motor') }}";

                $.ajax({
                    type: "GET",
                    url: '{{ route('getModels') }}',
                    data: {
                        id: $("#marca option:selected").val(),
                    },
                    success: function (data) {
                        $("#modelo option:gt(0)").remove();
                        $("#motor option:gt(0)").remove();
                        $(data).each((ind, ele) => {
                            if (ele.id == oldModel) {
                                $("#modelo").append("<option selected value='" + ele.id + "'>" + ele.nombre + "</option>");
                            } else {
                                $("#modelo").append("<option value='" + ele.id + "'>" + ele.nombre + "</option>");
                            }
                        });

                        $.ajax({
                            type: "GET",
                            url: '{{ route('getEngines') }}',
                            data: {
                                id: $("#modelo option:selected").val(),
                            },
                            success: function (data) {
                                $("#motor option:gt(0)").remove();
                                $(data).each((ind, ele) => {
                                    if (ele.id == oldEngine) {
                                        $("#motor").append("<option selected value='" + ele.id + "'>" + ele.nombre + "</option>");
                                    } else {
                                        $("#motor").append("<option value='" + ele.id + "'>" + ele.nombre + "</option>");
                                    }
                                });
                            }, error: function (xhr, ajaxOptions, thrownError) {
                                console.log(thrownError);
                            }
                        })
                    }, error: function (xhr, ajaxOptions, thrownError) {
                        console.log(thrownError);
                    }
                });


            }
        });

        $("#marca").change(function () {
            $.ajax({
                type: "GET",
                url: '{{ route('getModels') }}',
                data: {
                    id: $("#marca option:selected").val(),
                },
                success: function (data) {
                    $("#modelo option:gt(0)").remove();
                    $("#motor option:gt(0)").remove();
                    $(data).each((ind, ele) => {
                        $("#modelo").append("<option value='" + ele.id + "'>" + ele.nombre + "</option>");
                    });
                }, error: function (xhr, ajaxOptions, thrownError) {
                    console.log(thrownError);
                }
            })
        });

        $("#modelo").change(function () {
            $.ajax({
                type: "GET",
                url: '{{ route('getEngines') }}',
                data: {
                    id: $("#modelo option:selected").val(),
                },
                success: function (data) {
                    $("#motor option:gt(0)").remove();
                    $(data).each((ind, ele) => {
                        $("#motor").append("<option value='" + ele.id + "'>" + ele.nombre + "</option>");
                    });
                }, error: function (xhr, ajaxOptions, thrownError) {
                    console.log(thrownError);
                }
            })
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
