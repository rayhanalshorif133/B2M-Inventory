<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Bais BD</title>
    <meta name="description" content="">
    <meta name="keywords" content="">

    <!-- Favicons -->
    <link href="{{ asset('new_assets/img/favicon.png') }}" rel="icon">
    <link href="{{ asset('new_assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('new_assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('new_assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('new_assets/vendor/aos/aos.css') }}" rel="stylesheet">

    <!-- google fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Noto+Sans+Bengali:wght@100..900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <!-- Main CSS File -->
    <link href="{{ asset('new_assets/css/main.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />

    <link rel="stylesheet" href="{{ asset('new_assets/owlcarousel/assets/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('new_assets/owlcarousel/assets/owl.theme.default.min.css') }}">

    <style>

    </style>
</head>

<body class="index-page">
    <header id="header" class="header sticky-top">
        <div class="branding d-flex align-items-cente">
            <div class="container position-relative d-flex align-items-center justify-content-between">
                <a href="/" class="logo d-flex align-items-center">
                    <!-- Uncomment the line below if you also wish to use an image logo -->
                    <img src="{{ asset('new_assets/img/logo.png') }}" alt="">
                    <!-- <h1 class="sitename">inventory</h1> -->
                </a>

                <nav id="navmenu" class="navmenu">
                    <ul>
                        <li><a href="#hero" class="active">Home</a></li>
                        <li><a href="#about">About</a></li>
                        <li><a href="#service">Our Services</a></li>
                        <li><a href="#contact">Contact Us</a></li>
                        <div class="loging-register-btn-mobile">
                            @if ($user)
                                <a href="{{ route('auth.login') }}" value="0" id="login"
                                    class="scrollto">{{ $user->name }}</a>
                            @else
                                <li class="dropdown_item-1"> <a href="{{ route('auth.login') }}" value="0"
                                        id="login" class="scrollto">Login </a>
                                </li>
                                <li class="dropdown_item-2"><a href="{{ route('auth.otp-send') }}" id="signup"
                                        class="scrollto"> Sign Up </a></li>
                            @endif


                        </div>
                    </ul>
                    <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
                </nav>

                <ul class="loging-register-btn">
                    @if ($user)
                        <a href="{{ route('auth.login') }}" value="0" id="login"
                            class="scrollto">{{ $user->name }} </a>
                    @else
                        <li class="dropdown_item-1"> <a href="{{ route('auth.login') }}" value="0" id="login"
                                class="scrollto">Login </a>
                        </li>
                        <li class="dropdown_item-2"><a href="{{ route('auth.otp-send') }}" id="signup"
                                class="scrollto">
                                Sign Up </a></li>
                    @endif

                </ul>
            </div>
        </div>
    </header> <!-- End Header -->
    <main class="main">

        <!-- Hero Section -->
        <section id="hero" class="hero section accent-background">
            <div id="hero-carousel" class="carousel slide carousel-fade">
                <div class="carousel-item active">
                    <img src="{{ asset('new_assets/img/banner.png') }}" alt="" class="img-fluid">
                    <div class="carousel-container">
                        <h2>বিজনেস একাউন্টস এবং ইনভেন্টরি সল্যুশন</h2>
                        <div class="start-more-btn">
                            <a href="#" class="btn-get-started">Get Started <i class="fas fa-arrow-right"></i>
                            </a>
                            <a href="#" class="btn-get-more">Learn More</a>
                        </div>

                    </div>
                </div><!-- End Carousel Item -->
            </div>
        </section><!-- /Hero Section -->


        <!-- About Section -->
        <section id="about" class="about-section section">
            <div class="container">
                <div class="row gy-4">
                    <div class="mb-5">
                        <h2 class="text-center">আপনার ব্যবসার জন্য সেরা পরিষেবার অভিজ্ঞতা নিন</h2>
                    </div>
                    <div class="col-md-6 align-content-center">
                        <img src="{{ asset('new_assets/img/left-img.png') }}" class="img-fluid text-center"
                            alt="">
                    </div>
                    <div class="col-md-6 content">
                        <img src="{{ asset('new_assets/img/right-img.png') }}" class="img-fluid text-center"
                            alt="">
                    </div>
                </div>

            </div>

        </section>
        <!-- /About Section -->

        <!-- Service Section -->
        <section id="service" class="service-section section">
            <div class="container">
                <div class="row gy-4">
                    <div class="mb-5">
                        <h2 class="text-center"></h2>
                    </div>
                    <div class="col-md-6 align-content-center">
                        <h2 class="text-white">আপনার ব্যবসা প্রসারিত করুন আরও সহজে</h2>
                    </div>
                    <div class="col-md-6 content">
                        <img src="{{ asset('new_assets/img/service-right.png') }}" class="img-fluid text-center"
                            alt="">
                    </div>
                </div>

            </div>

        </section>
        <!-- /Service Section -->



        <!-- Contact Section -->
        <section id="contact" class="contact section">
            <div class="container">
                <div class="row gy-4">
                    <!-- Section Title -->
                    <div class=" mb-5">
                        <h2 class="text-center ">Contact Us</h2>
                    </div>
                    <!-- End Section Title -->

                    <div class="col-lg-6 col-md-6">
                        <div class="company-img mb-3">
                            <img src="{{ asset('new_assets/img/logo.png') }}" alt="">
                        </div>
                        <div class="info">
                            <h5>
                                <i class="bi bi-geo-alt"></i>
                                Location:
                            </h5>
                            <p>House: 15, Road: 01, Block: A, Banasree, Dhaka-1212</p>
                        </div>
                        <div class="info">
                            <h5>
                                <i class="bi bi-envelope"></i>
                                Email:
                            </h5>
                            <p>info@b2m.com</p>
                        </div>
                        <div class="info">
                            <h5>
                                <i class="bi bi-phone"></i>
                                Call:
                            </h5>
                            <p>+880 0000 0000</p>
                        </div>



                    </div>

                    <div class="col-lg-6 col-md-6">
                        <h3>Quick Links</h3>
                        <a href="#">B2M Technologies Ltd.</a>
                    </div><!-- End Contact Form -->

                </div>

            </div>

        </section><!-- /Contact Section -->

    </main>

    <footer id="footer" class="footer dark-background">

        <div class="container footer-top">
            <div class="row gy-4">

            </div>
        </div>

        <div class="container copyright text-center mt-4">
            <p>© <span>Copyright</span> <strong class="px-1 sitename">b2m</strong> <span>All Rights Reserved</span></p>
            <div class="credits">
                <!-- All the links in the footer should remain intact. -->
                <!-- You can delete the links only if you've purchased the pro version. -->
                <!-- Licensing information: https://bootstrapmade.com/license/ -->
                <!-- Purchase the pro version with working PHP/AJAX contact form: [buy-url] -->
                Designed by <a href="#" class="text-white">B2M-tech</a>
            </div>
        </div>

    </footer>

    <!-- Scroll Top -->
    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <!-- Preloader -->
    <div id="preloader"></div>

    <!-- Vendor JS Files -->
    <script src="{{ asset('new_assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('new_assets/vendor/aos/aos.js') }}"></script>
    <!-- <script src="assets/vendor/swiper/swiper-bundle.min.js')}}"></script> -->

    <!-- Main JS File -->
    <script src="{{ asset('new_assets/js/main.js') }}"></script>

    <!-- javascript -->
    <script src="{{ asset('new_assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('new_assets/owlcarousel/owl.carousel.js') }}"></script>


    <script>
        $(document).ready(function() {
            var owl = $('.owl-carousel');
            owl.owlCarousel({
                items: 3,
                loop: true,
                margin: 10,
                autoplay: true,
                autoplayTimeout: 5000,
                autoplayHoverPause: true,
                responsiveClass: true,
                nav: true,
                navText: [
                    '<span class="custom-prev"><i class="bi bi-chevron-left"></i></span>', // Custom left arrow
                    '<span class="custom-next"><i class="bi bi-chevron-right"></i></span>' // Custom right arrow
                ],
                responsive: {
                    0: {
                        items: 1,
                        nav: true
                    },
                    600: {
                        items: 3,
                        nav: true
                    },
                    1000: {
                        items: 3,
                        nav: true,
                        loop: true
                    }
                }
            }).on('mouseenter', function() {
                $(this).trigger('stop.owl.autoplay');
            }).on('mouseleave', function() {
                $(this).trigger('play.owl.autoplay', [5000]); // optional duration
            });

        });
    </script>
    <script>
        var logged = "Your name";
        var divValue = document.getElementById('accessBtn').getAttribute('value');
        if (divValue == '0') {
            document.querySelector(".access-btn").innerHTML = logged;
        }
    </script>



</body>

</html>
