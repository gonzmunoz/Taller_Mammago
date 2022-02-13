<!DOCTYPE html>
<html lang="es">
<head>
    <!-- META -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="keywords" content=""/>
    <meta name="author" content=""/>
    <meta name="robots" content=""/>
    <meta name="format-detection" content="telephone=no">

    <!-- FAVICONS ICON -->
    <link rel="icon" href="{{ assetFtp('images/favicon.ico') }}" type="image/x-icon"/>
    <link rel="shortcut icon" type="image/x-icon" href="{{ assetFtp('images/favicon.png') }}"/>

    <!-- PAGE TITLE HERE -->
    <title>{{ config('app.name') }}</title>

    <!-- MOBILE SPECIFIC -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!--[if lt IE 9]>
    <script src="js/html5shiv.min.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->

    <!-- STYLESHEETS -->
    <link rel="stylesheet" type="text/css" href="{{ assetFtp('css/style.min.css') }}">
    <link class="skin" rel="stylesheet" type="text/css" href="{{ assetFtp('css/skin/skin-1.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ assetFtp('css/templete.min.css') }}">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="{{ assetFtp('js/jquery.min.js') }}"></script><!-- JQUERY.MIN JS -->

</head>
<body id="bg" class="full-boxed">
<div id="loading-area"></div>
<div class="page-wrapers">
    @yield('content')
</div>
<!-- JavaScript  files ========================================= -->

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
<script src="{{ assetFtp('js/dz.ajax.js') }}"></script><!-- CONTACT JS  -->

</body>
</html>
