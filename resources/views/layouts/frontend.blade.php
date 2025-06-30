<!DOCTYPE html>
<html lang="en" dir="rtl">


<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link href="{{ asset('front/assets/css/bootstrap.rtl.min.css') }}" rel="stylesheet">
    <!-- Bootstrap Icon CSS -->
    <link href="{{ asset('front/assets/css/bootstrap-icons.css') }}" rel="stylesheet">
    <!-- Fontawesome all CSS -->
    <link href="{{ asset('front/assets/css/all.min.css') }}" rel="stylesheet">
    <link href="{{ asset('front/assets/css/nice-select.css') }}" rel="stylesheet">
    <link href="{{ asset('front/assets/css/animate.min.css') }}" rel="stylesheet">
    <!--  FancyBox CSS  -->
    <link rel="stylesheet" href="{{ asset('front/assets/css/jquery.fancybox.min.css') }}">

    <!-- Fontawesome CSS -->
    <link href="{{ asset('front/assets/css/fontawesome.min.css') }}" rel="stylesheet">
    <!-- box icon css -->
    <link rel="stylesheet" href="{{ asset('front/assets/css/boxicons.min.css') }}">
    <!-- slider CSS -->
    <link rel="stylesheet" href="{{ asset('front/assets/css/swiper-bundle.min.css') }}">
    <link rel="stylesheet" href="{{ asset('front/assets/css/slick-theme.css') }}">
    <link rel="stylesheet" href="{{ asset('front/assets/css/slick.css') }}">
    <!--  Style CSS  -->
    <link rel="stylesheet" href="{{ asset('front/assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('front/assets/css/style-rtl.css') }}">
    <title>{{ get_general_value('website_name_' . app()->getLocale()) }}</title>
    <link rel="apple-touch-icon" href="{{ asset('storage/' . get_general_value('website_icon')) }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('storage/' . get_general_value('website_icon')) }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('storage/' . get_general_value('website_icon')) }}">
</head>

<body>
    <!-- on page load modal -->

    @include('frontend.model_when_open')

    @include('frontend.top_bar')
    @include('frontend.login_register_model')



    @include('frontend.header')

    @include('frontend.sliders')

    @include('frontend.featchers')


    @include('frontend.categorires')

    @include('frontend.best_sellling')


    <!-- product view modal  -->
    @include('frontend.product_model')

    <!-- End Best Selling section section -->

    <!-- Start Just For section section -->
    @include('frontend.product_with_category')

    <!-- End Just For section section -->

    <!-- Start Offer Banner section section -->
    @include('frontend.banners')
    <!-- End Offer Banner section section -->

    <!-- Start Newest Product section section -->
    @include('frontend.new_products')
    <!-- End Newest Product section section -->

    <!-- Start Exclusive Product section section -->
    @include('frontend.exclosive')
    <!-- End Exclusive Product section section -->

    <!-- Start Special Offer section section -->
    @include('frontend.offers')
    <!-- End Special Offer section section -->

    <!-- Start Best Brand section section -->
    @include('frontend.best_brands')
    <!-- End Best Brand section section -->

    <!-- Start Makeup section section -->

    <!-- End Makeup section section -->

    <!-- Start Say About section section -->
    @include('frontend.say_about')
    <!-- End Say About section section -->

    <!-- Start Beauty Article section section -->
    @include('frontend.blogs')
    <!-- End Beauty Article section section -->

    <!-- Star Newsletter section section -->
    @include('frontend.newsletter')
    <!-- End Newsletter section section -->

    <!-- Start Instagram section section -->
    @include('frontend.instegram')
    <!-- End Instagram section section -->

    <!-- Star Gift section section -->

    <!-- End Gift section section -->

    <!-- Start Footer section section -->
    @include('frontend.footer')
    <!-- End Footer section section -->

    <!--  Main jQuery  -->
    <script data-cfasync="false" src="{{ asset('front/assets/js/cloudflare-static/email-decode.min.js') }}"></script>
    <script src="{{ asset('front/assets/js/jquery-3.6.0.min.js') }}"></script>
    <!-- Popper and Bootstrap JS -->
    <script src="{{ asset('front/assets/js/popper.min.js') }}"></script>
    <script src="{{ asset('front/assets/js/jquery.nice-select.min.js') }}"></script>
    <!-- Fancybox JS -->
    <script src="{{ asset('front/assets/js/jquery.fancybox.min.js') }}"></script>
    <script src="{{ asset('front/assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('front/assets/js/slick.js') }}"></script>
    <!-- Swiper slider JS -->
    <script src="{{ asset('front/assets/js/swiper-bundle.min.js') }}"></script>


    <script src="{{ asset('front/assets/js/waypoints.min.js') }}"></script>
    <!-- main js  -->
    <script src="{{ asset('front/assets/js/main.js') }}"></script>
</body>



</html>
