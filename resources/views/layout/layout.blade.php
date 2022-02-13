<!DOCTYPE html>
<html lang="es">
<head>
    <!-- META -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="format-detection" content="telephone=no">
    <meta name="_token" content="{{ csrf_token() }}">

    <!-- FAVICONS ICON -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ assetFtp('images/favicon.png') }}"/>

    <!-- PAGE TITLE HERE -->
    <title>{{ config('app.name') }}</title>

    <!-- MOBILE SPECIFIC -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!--[if lt IE 9]>
    <script src="{{ assetFtp('js/html5shiv.min.js') }}"></script>
    <script src="{{ assetFtp('js/respond.min.js') }}"></script>
    <![endif]-->

    <!-- STYLESHEETS -->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="/resources/demos/style.css">
    <link rel="stylesheet" type="text/css" href="{{ assetFtp('css/style.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ assetFtp('css/templete.min.css') }}">
    <link class="skin" rel="stylesheet" type="text/css" href="{{ assetFtp('css/skin/skin-1.css') }}">
    <!-- FLAGS -->
    <link href="{{ assetFtp('css/flag.min.css') }}" rel="stylesheet">
    <!-- Revolution Slider Css -->
    <link rel="stylesheet" type="text/css" href="{{ assetFtp('plugins/revolution/css/settings.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ assetFtp('plugins/revolution/css/navigation.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ assetFtp('css/pagination.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
          integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    <!-- SWEET ALERT -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <link rel="stylesheet" type="text/css" href="{{ assetFtp('plugins/sweet-alert/swal-forms.css') }}">
    <script src="{{ assetFtp('plugins/sweet-alert/swal-forms.js') }}"></script>

    @yield('additional-header')

</head>
<body id="bg">
<div id="loading-area"></div>
<div class="page-wraper d-flex flex-column min-vh-100">

@include('layout.navbar')
<!-- Content -->
    <div class="page-content">
        @yield('content')
    </div>
    <!-- Content END-->
    <!-- Footer -->
    <footer class="site-footer mt-auto">
        <!-- footer top part -->
        <div class="footer-top">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 col-md-6 col-sm-6 footer-col-4">
                        <div class="widget widget_about">
                            <div class="logo-footer">
                                <img src="{{ assetFtp('images/logo.png') }}" alt="">
                            </div>
                            <p>
                                <strong>Mammago</strong>
                                {{ trans('messages.footer') }}
                            </p>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-6 footer-col-4">
                        <div class="widget widget_services">
                            <h4 class="m-b15 text-uppercase">{{ trans('messages.ourBrands') }}</h4>
                            <div class="dlab-separator-outer m-b10">
                                <div class="dlab-separator bg-white style-skew"></div>
                            </div>
                            <ul>
                                <li>
                                    <i class="fas fa-arrow-right mr-2"></i>AUDI
                                </li>
                                <li>
                                    <i class="fas fa-arrow-right mr-2"></i>CITROËN
                                </li>
                                <li>
                                    <i class="fas fa-arrow-right mr-2"></i>FORD
                                </li>
                                <li>
                                    <i class="fas fa-arrow-right mr-2"></i>MERCEDES-BENZ
                                </li>
                                <li>
                                    <i class="fas fa-arrow-right mr-2"></i>PEUGEOT
                                </li>
                                <li>
                                    <i class="fas fa-arrow-right mr-2"></i>SEAT
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-6 footer-col-4">
                        <div class="widget widget_getintuch">
                            <h4 class="m-b15 text-uppercase">{{ trans('messages.contact us') }}</h4>
                            <div class="dlab-separator-outer m-b10">
                                <div class="dlab-separator bg-white style-skew"></div>
                            </div>
                            <ul>
                                <li><i class="fas fa-map-marker-alt"></i>
                                    <strong>{{ trans('messages.address') }}</strong>{{ ucfirst(trans('messages.arroyo del moro avenue')) }}
                                </li>
                                <li><i class="fas fa-phone"></i><strong>{{ trans('messages.phone') }}</strong>957 957
                                    957
                                </li>
                                <li><i class="fas fa-fax"></i><strong>{{ trans('messages.fax') }}</strong>957 957 759
                                </li>
                                <li><i class="fas fa-envelope"></i><strong>{{ trans('messages.email') }}</strong>tallermammago@gmail.com
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- footer bottom part -->
        <div class="footer-bottom footer-line">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 col-md-4 text-left">
                        <span>© Copyright 2020</span>
                    </div>
                    <div class="col-lg-4 col-md-4 text-center">
                        <span>Gonzalo Muñoz Romero </span>
                    </div>
                    <div class="col-lg-4 col-md-4 text-right">
                        <span>IES Trassierra</span>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- Footer END-->
    <!-- scroll top button -->
    <button class="scroltop fa fa-arrow-up"></button>
</div>

<!-- JavaScript  files ========================================= -->
<script src="{{ assetFtp('js/jquery.min.js') }}"></script><!-- JQUERY.MIN JS -->
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="{{ assetFtp('plugins/bootstrap/js/popper.min.js') }}"></script><!-- BOOTSTRAP.MIN JS -->
<script src="{{ assetFtp('plugins/bootstrap/js/bootstrap.min.js') }}"></script><!-- BOOTSTRAP.MIN JS -->
<script src="{{ assetFtp('plugins/bootstrap-select/bootstrap-select.min.js') }}"></script><!-- FORM JS -->
<script src="{{ assetFtp('plugins/bootstrap-touchspin/jquery.bootstrap-touchspin.js') }}"></script><!-- FORM JS -->
<script src="{{ assetFtp('plugins/magnific-popup/magnific-popup.js') }}"></script><!-- MAGNIFIC POPUP JS -->
<script src="{{ assetFtp('plugins/counter/waypoints-min.js') }}"></script><!-- WAYPOINTS JS -->
<script src="{{ assetFtp('plugins/counter/counterup.min.js') }}"></script><!-- COUNTERUP JS -->
<script src="{{ assetFtp('plugins/imagesloaded/imagesloaded.js') }}"></script><!-- IMAGESLOADED -->
<script src="{{ assetFtp('plugins/masonry/masonry-3.1.4.js') }}"></script><!-- MASONRY -->
<script src="{{ assetFtp('plugins/masonry/masonry.filter.js') }}"></script><!-- MASONRY -->
<script src="{{ assetFtp('plugins/owl-carousel/owl.carousel.js') }}"></script><!-- OWL SLIDER -->
<script src="{{ assetFtp('js/custom.min.js') }}"></script><!-- CUSTOM FUCTIONS  -->
<script src="{{ assetFtp('js/dz.carousel.min.js') }}"></script><!-- SORTCODE FUCTIONS  -->

<script src="{{ assetFtp('plugins/lightgallery/js/lightgallery-all.js') }}"></script><!-- LIGHT GALLERY -->
<script src="{{ assetFtp('js/dz.ajax.js') }}"></script><!-- CONTACT JS -->
<!-- REVOLUTION JS FILES -->
<script src="{{ assetFtp('plugins/revolution/js/jquery.themepunch.tools.min.js') }}"></script>
<script src="{{ assetFtp('plugins/revolution/js/jquery.themepunch.revolution.min.js') }}"></script>
<!-- Slider revolution 5.0 Extensions  (Load Extensions only on Local File Systems !  The following part can be removed on Server for On Demand Loading) -->
<script src="{{ assetFtp('plugins/revolution/js/extensions/revolution.extension.actions.min.js') }}"></script>
<script src="{{ assetFtp('plugins/revolution/js/extensions/revolution.extension.carousel.min.js') }}"></script>
<script src="{{ assetFtp('plugins/revolution/js/extensions/revolution.extension.kenburn.min.js') }}"></script>
<script src="{{ assetFtp('plugins/revolution/js/extensions/revolution.extension.layeranimation.min.js') }}"></script>
<script src="{{ assetFtp('plugins/revolution/js/extensions/revolution.extension.migration.min.js') }}"></script>
<script src="{{ assetFtp('plugins/revolution/js/extensions/revolution.extension.navigation.min.js') }}"></script>
<script src="{{ assetFtp('plugins/revolution/js/extensions/revolution.extension.parallax.min.js') }}"></script>
<script src="{{ assetFtp('plugins/revolution/js/extensions/revolution.extension.slideanims.min.js') }}"></script>
<script src="{{ assetFtp('plugins/revolution/js/extensions/revolution.extension.video.min.js') }}"></script>
<script src="{{ assetFtp('js/rev.slider.js') }}"></script>
<script>
    jQuery(document).ready(function () {
        'use strict';
        dz_rev_slider_1();
    });	/*ready*/
</script>
@yield('additional-scripts')
</body>
</html>
