<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@isset($title)
         {{ $title }} |
    @endisset {{ config('app.name', 'Inventory') }} </title>


    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

    <link rel="stylesheet" href="{{ asset('adminLTE/plugins/fontawesome-free/css/all.min.css') }}">

    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

    <link rel="stylesheet" href="{{ asset('adminLTE/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">

    <link rel="stylesheet" href="{{ asset('adminLTE/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">

    <link rel="stylesheet" href="{{ asset('adminLTE/plugins/jqvmap/jqvmap.min.css') }}">

    <link rel="stylesheet" href="{{ asset('adminLTE/dist/css/adminlte.min.css?v=3.2.0') }}">

    <link rel="stylesheet" href="{{ asset('adminLTE/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">

    <link rel="stylesheet" href="{{ asset('adminLTE/plugins/daterangepicker/daterangepicker.css') }}">

    <link rel="stylesheet" href="{{ asset('adminLTE/plugins/summernote/summernote-bs4.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper" id="app">

        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="{{ asset('adminLTE/dist/img/AdminLTELogo.png') }}" alt="AdminLTELogo" height="60"
                width="60">
        </div>

        <nav-bar-component></nav-bar-component>
        @php
            $users = \App\models\User::all();
        @endphp

        <side-bar-component :auth_user="{{ Auth::user() }}" :total_user={{ $users->count() }}></side-bar-component>
        @yield('content')
        <footer-component></footer-component>



        <aside class="control-sidebar control-sidebar-dark">

        </aside>

    </div>


    <script src="{{ asset('adminLTE/plugins/jquery/jquery.min.js') }}"></script>

    <script src="{{ asset('adminLTE/plugins/jquery-ui/jquery-ui.min.js') }}"></script>

    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>

    <script src="{{ asset('adminLTE/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <script src="{{ asset('adminLTE/plugins/chart.js/Chart.min.js') }}"></script>

    <script src="{{ asset('adminLTE/plugins/sparklines/sparkline.js') }}"></script>

    <script src="{{ asset('adminLTE/plugins/jqvmap/jquery.vmap.min.js') }}"></script>
    <script src="{{ asset('adminLTE/plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>

    <script src="{{ asset('adminLTE/plugins/jquery-knob/jquery.knob.min.js') }}"></script>

    <script src="{{ asset('adminLTE/plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('adminLTE/plugins/daterangepicker/daterangepicker.js') }}"></script>

    <script src="{{ asset('adminLTE/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>

    <script src="{{ asset('adminLTE/plugins/summernote/summernote-bs4.min.js') }}"></script>

    <script src="{{ asset('adminLTE/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>

    <script src="{{ asset('adminLTE/dist/js/adminlte.js?v=3.2.0') }}"></script>


    <script src="{{ asset('adminLTE/dist/js/pages/dashboard.js') }}"></script>
</body>

</html>
