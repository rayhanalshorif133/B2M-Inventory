<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        @isset($title)
            {{ $title }} |
        @endisset {{ config('app.name', 'Inventory') }}
    </title>


    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

    <link rel="stylesheet" href="{{ asset('adminLTE/plugins/fontawesome-free/css/all.min.css') }}">

    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

    <link rel="stylesheet"
        href="{{ asset('adminLTE/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">

    <link rel="stylesheet" href="{{ asset('adminLTE/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">

    <link rel="stylesheet" href="{{ asset('adminLTE/plugins/jqvmap/jqvmap.min.css') }}">

    <link rel="stylesheet" href="{{ asset('adminLTE/dist/css/adminlte.min.css?v=3.2.0') }}">

    <link rel="stylesheet" href="{{ asset('adminLTE/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">

    <link rel="stylesheet" href="{{ asset('adminLTE/plugins/daterangepicker/daterangepicker.css') }}">

    <link rel="stylesheet" href="{{ asset('adminLTE/plugins/summernote/summernote-bs4.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper" id="app">

        {{-- <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="{{ asset('adminLTE/dist/img/AdminLTELogo.png') }}" alt="AdminLTELogo"
                height="60" width="60">
        </div> --}}

        @include('_partials.navbar')
        @include('_partials.sidebar')


        {{-- <side-bar-component></side-bar-component> --}}


        <div id="flash-messages" data-success="{{ session('success') }}" data-error="{{ session('error') }}">
        </div>
        @yield('content')

        <tips-skip-component></tips-skip-component>
        <footer-component></footer-component>


        <div class="tour-tips hidden" style="--top:21.2rem;--left:10rem;">
            <img class="hand light_pointer" src="{{ asset('./images/cursor_point.png') }}" />
            <img class="hand dark_pointer hidden" src="{{ asset('./images/cursor_point_black.png') }}" />
            <div class="tour-tips-box">
                <div class="content">
                    <p class="title">Click here</p>
                    <div class="btn-container">
                        <button class="btn-skip" type="button">
                            Skip
                        </button>
                        <button class="btn-next" type="button" id="btn-next-for-inventory">
                            Next
                        </button>
                    </div>
                </div>
            </div>
        </div>



    </div>


    <script src="{{ asset('adminLTE/plugins/jquery/jquery.min.js') }}"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.js"></script>


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
    <script src="{{ asset('/js/guideline-tour.js') }}"></script>


    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            iconColor: 'white',
            customClass: {
                popup: 'colored-toast',
            },
            showConfirmButton: false,
            timer: 2500,
            timerProgressBar: true,
        });


        const getId = () => {
            const currentURL = window.location.pathname;
            const id = parseInt(currentURL.match(/\d+/)[0]);
            if (id === undefined) {
                return 0;
            }
            return id;
        }



        $(document).ready(function() {
            var successMessage = $('#flash-messages').data('success');
            var errorMessage = $('#flash-messages').data('error');



            if (successMessage) {
                Toast.fire({
                    icon: 'success',
                    title: successMessage,
                })
            }

            if (errorMessage) {
                Toast.fire({
                    icon: 'error',
                    title: errorMessage,
                })

            }
        });
    </script>

    @stack('scripts')

</body>

</html>
