<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.30.1/moment.min.js"></script>

    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">

    <title>BaisBD Report Panel</title>
</head>

<body>

    <nav class="navbar navbar-light" style="background-color: #FFFFFF;">
        <div class="container-fluid">
            <div class="w-100 d-flex justify-content-between py-1">
                <ul class="nav justify-content-center">
                    <a class="navbar-brand" href="#">
                        <img src="{{ asset('images/logo.png') }}" alt="" width="auto" height="32"
                            class="d-inline-block align-text-top">
                    </a>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.dashboard') }}"><i class="fa-solid fa-house"></i>
                            Home</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button"
                            aria-expanded="false"><i class="fa-solid fa-address-book"></i> Users</a>
                        <ul class="dropdown-menu subItem">
                            <li>
                                <a class="dropdown-item sub-item" href="{{ route('admin.user.logs') }}">
                                    <i class="fa-solid fa-angle-right"></i> User Logs
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item sub-item" href="{{ route('admin.user.guest-activites') }}"><i class="fa-solid fa-angle-right"></i>
                                    Guest User Activites</a>
                            </li>
                        </ul>
                    </li>
                </ul>
                <div class="d-flex align-items-center cursor-pointer">
                    <i class="fa-solid fa-user" style="font-size: 20px"></i>
                    <p style="margin: auto 5px">{{ Auth::user()->name }}</p>
                    <a class="dropdown-item" href="{{ route('logout') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="bx bx-power-off me-2"></i>
                        <span class="align-middle">Log Out</span>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </nav>


    <div class="container">
        @yield('content')
    </div>


    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>


    <script>
        $(document).ready(function() {
            // Toggle dropdown on click
            $('.nav-item.dropdown').on('click', function(e) {
                e.preventDefault();
                $(this).find('.dropdown-menu').toggleClass('show');
            });

            // Close dropdown when clicking outside
            $(document).on('click', function(e) {
                if (!$(e.target).closest('.nav-item.dropdown').length) {
                    $('.dropdown-menu').removeClass('show');
                }
            });

        });

        $(document).on('click', '.sub-item', function(e) {
            window.location.href = $(this).attr('href');
        });

        
        function formatDuration(timeString) {
            const duration = moment.duration(moment.utc(timeString, "HH:mm:ss").diff(moment.utc().startOf('day')));

            const hours = duration.hours();
            const minutes = duration.minutes();
            const seconds = duration.seconds();

            if (hours > 0) {
                return `${hours} hr ${minutes} min ${seconds} sec`;
            } else if (minutes > 0) {
                return `${minutes} min ${seconds} sec`;
            } else {
                return `${seconds} sec`;
            }
        }
    </script>

    

    @stack('scripts')
</body>

</html>
