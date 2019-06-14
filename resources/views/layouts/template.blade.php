<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Portal SSOMA</title>
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <link rel="apple-touch-icon" sizes="57x57" href="{{ asset('img/favicon/apple-icon-57x57.png') }}">
        <link rel="apple-touch-icon" sizes="57x57" href="{{ asset('img/favicon/apple-icon-57x57.png') }}">
        <link rel="apple-touch-icon" sizes="60x60" href="{{ asset('img/favicon/apple-icon-60x60.png') }}">
        <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('img/favicon/apple-icon-72x72.png') }}">
        <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('img/favicon/apple-icon-76x76.png') }}">
        <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('img/favicon/apple-icon-114x114.png') }}">
        <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('img/favicon/apple-icon-120x120.png') }}">
        <link rel="apple-touch-icon" sizes="144x144" href="{{ asset('img/favicon/apple-icon-144x144.png') }}">
        <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('img/favicon/apple-icon-152x152.png') }}">
        <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('img/faviconapple-icon-180x180.png') }}">
        <link rel="icon" type="image/png" sizes="192x192"  href="{{ asset('img/favicon/android-icon-192x192.png') }}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('img/favicon/favicon-32x32.png') }}">
        <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('img/favicon/favicon-96x96.png') }}">
        <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('img/favicon/favicon-16x16.png') }}">
        <link rel="manifest" href="{{ asset('/manifest.json') }}">
        <meta name="msapplication-TileColor" content="#ffffff">
        <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
        <meta name="theme-color" content="#ffffff"> 

        <link rel="stylesheet" href="{{ asset('bootstrap/dist/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('font-awesome/css/font-awesome.min.css') }}">
        <link rel="stylesheet" href="{{ asset('Ionicons/css/ionicons.min.css') }}">
        <link rel="stylesheet" href="{{ asset('datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/AdminLTE.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/indicadores.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('skins/_all-skins.min.css') }}">
        <link rel="stylesheet" href="{{ asset('morris.js/morris.css') }}">
        <link rel="stylesheet" href="{{ asset('jvectormap/jquery-jvectormap.css') }}">
        <link rel="stylesheet" href="{{ asset('bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
        <link rel="stylesheet" href="{{ asset('bootstrap-daterangepicker/daterangepicker.css') }}">
        <!--<link href="{{ asset('datatables/dataTables.bootstrap4.css') }}" rel="stylesheet">-->
        
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">

    </head>

    <body class="hold-transition skin-red sidebar-mini">
        <div class="wrapper">
           @include('layouts.nav')
           @yield('sidebar')
           @yield('content')
           @include('layouts.footer')
        </div>

        <script src="{{ asset('jquery/dist/jquery.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('bootstrap/dist/js/bootstrap.min.js') }}" type="text/javascript"></script>

        @yield('scripts')
        <script src="{{ asset('jquery-slimscroll/jquery.slimscroll.min.js') }}" type="text/javascript"></script>
        <script src="{{ asset('fastclick/lib/fastclick.js') }}" type="text/javascript"></script>
        <script src="{{ asset('js/adminlte.min.js') }}" ></script>
        @include('sweet::alert')
    </body>
</html>
