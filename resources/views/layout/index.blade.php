@extends('layout.layout')

@section('additional-header')

@endsection

@section('content')
    <!-- About Company -->
    <div class="section-full bg-white content-inner-1"
         style="background-image: url({{ assetFtp('images/bg-img.png') }}); background-repeat: repeat-x; background-position: left bottom -37px;">
        <div class="container">
            <div class="row">
                <div class="col-lg-7 about-contant">
                    <div class="m-b20">
                        <h2 class="text-uppercase m-t0 m-b10">
                            {{ trans('messages.garage') }} <span class="text-primary">Mammago</span></h2>
                        <span class="text-secondry font-16">{{ ucfirst(trans('messages.slogan')) }}</span>
                        <div class="clear"></div>
                    </div>
                    <p class="m-b30">
                        Mammago {{ trans('messages.index1') }}
                    </p>
                    <div class="row">
                        <div class="col-md-4 col-lg-4 col-sm-4 m-b15">
                            <div class="icon-bx-wraper bx-style-1 p-tb15 p-lr10 center">
                                <div class="icon-bx-sm radius bg-primary m-b5"><i
                                        class="fas fa-users"></i></div>
                                <div class="icon-content">
                                    <h2 class="text-primary m-t20 m-b10"><span class="counter">{{ $clients }}</span>+
                                    </h2>
                                    <p>{{ ucfirst(trans('messages.clients')) }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-lg-4 col-sm-4 m-b15">
                            <div class="icon-bx-wraper bx-style-1 p-tb15 p-lr10 center">
                                <div class="icon-bx-sm radius bg-primary m-b5"><i
                                        class="fas fa-tools"></i></div>
                                <div class="icon-content">
                                    <h2 class="text-primary m-t20 m-b10"><span class="counter">{{ $repairs }}</span>+
                                    </h2>
                                    <p>{{ ucfirst(trans('messages.repairs')) }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-lg-4 col-sm-4 m-b15">
                            <div class="icon-bx-wraper bx-style-1 p-tb15 p-lr10 center">
                                <div class="icon-bx-sm radius bg-primary m-b5"><i
                                        class="fas fa-shopping-cart"></i></div>
                                <div class="icon-content">
                                    <h2 class="text-primary m-t20 m-b10"><span class="counter">{{ $sales }}</span>+</h2>
                                    <p>{{ ucfirst(trans('messages.sales')) }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <p class="m-b30">
                        Mammago {{ trans('messages.index2') }}
                    </p>
                </div>
                <div class="col-lg-5 about-img">
                    <img src="{{ assetFtp('images/layout1.jpg') }}" alt=""/>
                </div>
            </div>
        </div>
    </div>
    <!-- About Company END -->
    <!-- Our Projects  -->
    <div class="section-full bg-img-fix content-inner overlay-black-middle"
         style="background-image:url({{ assetFtp('images/background/bg1.jpg') }});">
        <div class="container">
            <div class="section-head  text-center text-white">
                <h2 class="text-uppercase">{{ trans('messages.our services') }}</h2>
                <div class="dlab-separator-outer ">
                    <div class="dlab-separator bg-white style-skew"></div>
                </div>
            </div>
            <div class="site-filters clearfix center  m-b40">
                <ul class="filters" data-toggle="buttons">
                    <li data-filter="" class="btn active">
                        <input type="radio">
                        <a href="#" class="site-button-secondry"><span>{{ trans('messages.show all') }}</span></a>
                    </li>
                    <li data-filter="home" class="btn">
                        <input type="radio">
                        <a href="#" class="site-button-secondry"><span>{{ trans('messages.brakes') }}</span></a>
                    </li>
                    <li data-filter="office" class="btn">
                        <input type="radio">
                        <a href="#" class="site-button-secondry"><span>{{ trans('messages.suspension') }}</span></a>
                    </li>
                    <li data-filter="commercial" class="btn">
                        <input type="radio">
                        <a href="#" class="site-button-secondry"><span>{{ trans('messages.wheels') }}</span></a>
                    </li>
                    <li data-filter="window" class="btn">
                        <input type="radio">
                        <a href="#" class="site-button-secondry"><span>{{ trans('messages.steering') }}</span></a>
                    </li>
                </ul>
            </div>
            <ul id="masonry" class="row dlab-gallery-listing gallery-grid-4 lightgallery gallery s m-b0">
                <li class="home card-container col-lg-4 col-md-4 col-sm-6 col-6">
                    <div class="dlab-box dlab-gallery-box">
                        <div class="dlab-media dlab-img-overlay1 dlab-img-effect zoom-slow">
                            <img src="{{ assetFtp('images/our-work/pic1.jpg') }}" alt="pic1">
                        </div>
                    </div>
                </li>
                <li class="office card-container col-lg-4 col-md-4 col-sm-6 col-6">
                    <div class="dlab-box dlab-gallery-box">
                        <div class="dlab-media dlab-img-overlay1 dlab-img-effect zoom-slow">
                            <img src="{{ assetFtp('images/our-work/pic2.jpg') }}" alt="pic2">
                        </div>
                    </div>
                </li>
                <li class="card-container col-lg-4 col-md-4 col-sm-6 col-6 commercial">
                    <div class="dlab-box dlab-gallery-box">
                        <div class="dlab-media dlab-img-overlay1 dlab-img-effect zoom-slow">
                            <img src="{{ assetFtp('images/our-work/pic3.jpg') }}" alt="pic3">
                        </div>
                    </div>
                </li>
                <li class="commercial card-container col-lg-4 col-md-4 col-sm-6 col-6">
                    <div class="dlab-box dlab-gallery-box">
                        <div class="dlab-media dlab-img-overlay1 dlab-img-effect zoom-slow">
                            <img src="{{ assetFtp('images/our-work/pic4.jpg') }}" alt="pic4">
                        </div>
                    </div>
                </li>
                <li class="window card-container col-lg-4 col-md-4 col-sm-6 col-6">
                    <div class="dlab-box dlab-gallery-box">
                        <div class="dlab-media dlab-img-overlay1 dlab-img-effect zoom-slow">
                            <img src="{{ assetFtp('images/our-work/pic5.jpg') }}" alt="pic5">
                        </div>
                    </div>
                </li>
                <li class="window card-container col-lg-4 col-md-4 col-sm-6 col-6">
                    <div class="dlab-box dlab-gallery-box">
                        <div class="dlab-media dlab-img-overlay1 dlab-img-effect zoom-slow">
                            <img src="{{ assetFtp('images/our-work/pic6.jpg') }}" alt="pic6">
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
    <!-- Our Projects END -->
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
