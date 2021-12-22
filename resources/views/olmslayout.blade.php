<!doctype html>
<html class="no-js" lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>{{ config('app.name') }} - @yield('titlename')</title>
        <meta name="description" content="">
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}" />

        <!-- favicon icon -->
        <link rel="shortcut icon" type="image/x-icon" href="{{ asset('public/images/favicon.ico') }}">
        <!-- google fonts -->
        <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600,700" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Dosis:300,400,500,600,700" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Poppins:400,600,700,800" rel="stylesheet">




        <!-- normalize css -->
        <link href="{{ asset('public/css/normalize.css') }}" rel="stylesheet">
        <!-- bootstrap css -->
        <link href="{{ asset('public/css/bootstrap.min.css') }}" rel="stylesheet">
        <!-- bootstrap css -->
        <link href="{{ asset('public/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
        <!-- et-line css -->
        <link href="{{ asset('public/css/et-line.css') }}" rel="stylesheet">
        <!-- font awesome css -->
        <link href="{{ asset('public/css/font-awesome.min.css') }}" rel="stylesheet">      
        <!-- meanmenu css -->
        <link href="{{ asset('public/css/meanmenu.css') }}" rel="stylesheet">
        <!-- owl.carousel css -->
        <link href="{{ asset('public/css/owl.carousel.min.css') }}" rel="stylesheet">
        <!-- magnific popup css -->
        <link href="{{ asset('public/css/magnific-popup.css') }}" rel="stylesheet">
        <!-- animate css -->
        <link href="{{ asset('public/css/animate.css') }}" rel="stylesheet">
        <!-- global css -->
        <link href="{{ asset('public/css/global.css') }}" rel="stylesheet">
        <!-- shortcode css -->
        <link href="{{ asset('public/css/shortcode/shortcodes.css') }}" rel="stylesheet">

         <link href="{{ asset('public/css/jquery-confirm.css') }}" rel="stylesheet"> 
        <!-- Toastr -->
         <link href="{{ asset('public/libs/toastr.min.css') }}" rel="stylesheet">
        <!-- style css -->
        <link href="{{ asset('public/css/style.css') }}" rel="stylesheet">
        <!-- responsive css -->
        <link href="{{ asset('public/css/responsive.css') }}" rel="stylesheet">
         <!-- Chosen -->
        <link href="{{ asset('public/libs/bootstrap-chosen.css') }}" rel="stylesheet"> 
        <!-- normalize js -->
        <script src="{{ asset('public/js/vendor/modernizr-3.6.0.min.js') }}" crossorigin="anonymous"></script>
       
    </head>
    <body>
        <!--[if lte IE 9]>
        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
        <![endif]-->
        
        <!-- Add your site or application content here -->
        <!-- Preloader -->
        <div class="page-loader">
            <div class="loader">Loading...</div>
        </div>
        <!-- /Preloader -->
         <!-- scrollToTop -->   
         <a href="#top" class="scroll-to-top">
            <i class="fa fa-arrow-up"></i>
        </a>
        <!-- /scrollToTop -->
        
        <!-- header -->
        @include('header')
        <!-- /header -->







 		<main>
            @yield('maincontent')
        </main>





<script src="//code.tidio.co/3bgmesp0fpo48bwsv2mjvedvzfbjjz9p.js" async></script>
        <!-- Footer Section -->        
        @include('footer')
        <!-- /Footer Section -->

         <!-- jquery js -->
        <script src="{{ asset('public/js/vendor/jquery-1.12.4.min.js') }}" crossorigin="anonymous"></script>
         <!--<script src="{{ asset('public/js/jquery-3.5.1.js') }}" crossorigin="anonymous"></script>-->

        <!-- bootstrap js -->
        <script src="{{ asset('public/js/popper.min.js') }}" crossorigin="anonymous"></script>
        <script src="{{ asset('public/js/bootstrap.min.js') }}" crossorigin="anonymous"></script>
        <!-- Toastr -->
        <script src="{{ asset('public/libs/toastr.min.js') }}" crossorigin="anonymous"></script>
        <!-- meanmenu js -->
        <script src="{{ asset('public/js/jquery.meanmenu.min.js') }}" crossorigin="anonymous"></script>
        <!-- owl.carousel js -->
        <script src="{{ asset('public/js/owl.carousel.min.js') }}" crossorigin="anonymous"></script>
        <!-- isotope js -->
        <script src="{{ asset('public/js/isotope.pkgd.min.js') }}" crossorigin="anonymous"></script>
        <!-- magnific-popup js -->
        <script src="{{ asset('public/js/jquery.magnific-popup.min.js') }}" crossorigin="anonymous"></script>
        <!-- counterup js -->
        <script src="{{ asset('public/js/jquery.counterup.min.js') }}" crossorigin="anonymous"></script>
        <script src="{{ asset('public/js/waypoints.min.js') }}" crossorigin="anonymous"></script>
        <!-- plugins js -->
        <script src="{{ asset('public/js/plugins.js') }}" crossorigin="anonymous"></script>
        
        <!-- main js -->
        <script src="{{ asset('public/js/main.js') }}" crossorigin="anonymous"></script>

        <script src="{{ asset('public/js/jquery.dataTables.min.js') }}" crossorigin="anonymous"></script>
        <script src="{{ asset('public/js/dataTables.bootstrap4.min.js') }}" crossorigin="anonymous"></script>

        <!-- confirm message -->
        <script src="{{ asset('public/js/jquery-confirm.js') }}" crossorigin="anonymous"></script>

        <!-- chosen -->
        <script src="{{ asset('public/libs/chosen.jquery.js') }}" crossorigin="anonymous"></script>

        <!--validation-->
        <script type="text/javascript" src="{{ asset('public/js/parsley.min.js') }}"></script>
        
        @yield('extralibincludefooter')
        
		@yield('customjs')

    </body>
</html>