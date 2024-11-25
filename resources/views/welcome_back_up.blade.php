<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Invertory Management</title>
    <meta name="description" content="">
    <meta name="keywords" content="">

    <!-- Favicons -->
    <link href="{{ asset('assets/img/favicon.png') }}" rel="icon">
    <link href="{{ asset('assets/img/apple-touch-icon.png') }}" rel="apple-touch-icon">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/vendor/aos/aos.css') }}" rel="stylesheet">


    <!-- Main CSS File -->
    <link href="{{ asset('assets/css/main.css') }}" rel="stylesheet">

    <!-- <link rel="stylesheet" href="assets/css/docs.theme.min.css')}}"> -->

    <!-- Owl Stylesheets -->
    <link rel="stylesheet" href="{{ asset('assets/owlcarousel/assets/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/owlcarousel/assets/owl.theme.default.min.css') }}">

    <style>
        input[type='number']::-webkit-inner-spin-button,
        input[type='number']::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
    </style>


    <!-- =======================================================
  * Template Name: inventory
  * Template URL: http://b2m-tech.com//inventory/
  * Updated: October  2024 with Bootstrap
  ======================================================== -->

    <style>

    </style>
</head>

<body class="index-page">

    <header id="header" class="header sticky-top">

        <div class="topbar d-flex align-items-center accent-background">
            <div class="container d-flex justify-content-center justify-content-md-between">
                <div class="contact-info d-flex align-items-center">
                    <i class="bi bi-envelope d-flex align-items-center"><a
                            href="mailto:contact@inventory.com">contact@inventory.com</a></i>
                    <i class="bi bi-phone d-flex align-items-center ms-4"><span>+880181234567</span></i>
                </div>
                <div class="social-links d-none d-md-flex align-items-center">
                    <a href="#" class="twitter"><i class="bi bi-twitter-x"></i></a>
                    <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
                    <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
                    <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>
                </div>
            </div>
        </div><!-- End Top Bar -->

        <div class="branding d-flex align-items-cente">

            <div class="container position-relative d-flex align-items-center justify-content-between">
                <a href="index.html" class="logo d-flex align-items-center">
                    <!-- Uncomment the line below if you also wish to use an image logo -->
                    <!-- <img src="assets/img/logo.png" alt=""> -->
                    <h1 class="sitename">inventory</h1>
                </a>

                <nav id="navmenu" class="navmenu">
                    <ul>
                        <li><a href="#home" class="active">হোম</a></li>
                        <li><a href="#about">মেনু ১</a></li>
                        <li><a href="#easyBusiness">মেনু ২</a></li>
                        <li><a href="#everythingInBusiness">মেনু ৩</a></li>
                        <li><a href="#allTypeBusiness">মেনু ৪</a></li>
                        <li><a href="#clintSection">মেনু ৫</a></li>
                        <li><a href="#contact">যোগাযোগ</a></li>
                    </ul>
                    <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
                </nav>
                <div class="access-btn" id="accessBtn" value="{{ Auth::check() }}">
                    @if (Auth::check())
                        <a href="{{ route('auth.login') }}">{{ Auth::user()->name }}</a>
                    @else
                        <ul class="menu">
                            <li class="dropdown">
                                Access
                                <ul class="dropdown_menu dropdown_menu--animated dropdown_menu-6">
                                    <li class="dropdown_item-1"> <a href="{{ route('auth.login') }}" value="0" id="login"
                                            class="scrollto login-btn">Login </a>
                                    </li>
                                    <li class="dropdown_item-2"><a href="{{ route('auth.register') }}" id="signup"
                                            class="scrollto signup-btn"> Sign Up </a></li>
                                </ul>
                            </li>
                        </ul>
                    @endif

                </div>
            </div>
        </div>
    </header> <!-- End Header -->
    <main class="main">

        <!-- home banner Section -->
        <section id="home" class="home">
            <img src="assets/img/banner.png" alt="" class="img-fluid">
        </section><!-- /home banner Section -->
        <!-- About Section -->
        <section id="about" class="about section">
            <div class="container">
                <div class="row gy-4">
                    <div class="common_business_title mb-5" data-aos="flip-top" data-aos-delay="250">
                        <h2 class="text-center">আমাদের কথা</h2>
                    </div>
                    <div class="col-md-6 align-content-center" data-aos="fade-up" data-aos-delay="100">
                        <img src="assets/img/inventory-28582804.jpg" class="img-fluid text-center" alt="">
                    </div>
                    <div class="col-md-6 content" data-aos="fade-up" data-aos-delay="200">
                        <h3>Lorem ipsum dolor sit amet.</h3>
                        <p class="fst-italic">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut
                            labore et
                            dolore
                            magna aliqua.
                        </p>
                        <ul>
                            <li><i class="bi bi-check2-all"></i> <span>Ullamco laboris nisi ut aliquip ex ea commodo
                                    consequat.</span>
                            </li>
                            <li><i class="bi bi-check2-all"></i> <span>Duis aute irure dolor in reprehenderit in
                                    voluptate
                                    velit.</span></li>
                            <li><i class="bi bi-check2-all"></i> <span>Ullamco laboris nisi ut aliquip ex ea commodo
                                    consequat. Duis
                                    aute irure dolor in reprehenderit in voluptate trideta storacalaperda mastiro dolore
                                    eu fugiat nulla
                                    pariatur.</span></li>
                        </ul>
                        <p>
                            Ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in
                            reprehenderit in
                            voluptate
                            velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
                            proident
                        </p>
                    </div>
                </div>

            </div>

        </section>
        <!-- /About Section -->

        <!-- Easy business section one -->
        <section id="easyBusiness">
            <div class="container" data-aos="fade-up" data-aos-delay="200">
                <div class="row">
                    <div class="common_business_title mb-5" data-aos="flip-top" data-aos-delay="250">
                        <h2 class="text-center">ব্যবসা চালানো সহজ করে ইনভেন্টরি অ্যাপ</h2>
                    </div>

                    <div class="col-sm-4 col-md-4 mb-3" data-aos="fade-up" data-aos-delay="200">
                        <div class="card">
                            <img src="assets/img/demo1.png" class="card-img-top  " alt="..."
                                style="height: 45vh;">
                            <div class="card-body text-center">
                                <h5 class="card-title fw-bold pt-3 pb-3">ব্যবসার হিসাব</h5>
                                <p class="card-text lh-3">হাতের মুঠোয় ব্যবসার হিসাব কে না চায় আর সেটা যদি হয় আপনার
                                    হাতে থাকে মোবাইল।
                                    মোবাইল ব্যবহার করে খুব সহজেই ব্যবসার হিসাবগুলো রাখা যায়।</p>

                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4 col-md-4 mb-3" data-aos="fade-up" data-aos-delay="450">
                        <div class="card">
                            <img src="assets/img/demo1.png" class="card-img-top " alt="..."
                                style="height: 45vh;">
                            <div class="card-body text-center">
                                <h5 class="card-title fw-bold pt-3 pb-3">ডিজিটাল ওয়ালেট</h5>
                                <p class="card-text">একটি ডিজিটাল ওয়ালেট হচ্ছে এক ধরণের আর্থিক লেনদেনের অ্যাপ যা
                                    ইন্টারনেট সংযোগ আছে এমন
                                    যেকোনো ডিভাইসে ব্যবহার করা সম্ভব।</p>

                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4 col-md-4 mb-3" data-aos="fade-up" data-aos-delay="600">
                        <div class="card">
                            <img src="assets/img/demo1.png" class="card-img-top " alt="..."
                                style="height: 45vh;">
                            <div class="card-body text-center">
                                <h5 class="card-title fw-bold pt-3 pb-3">ডিজিটাল লোন</h5>
                                <p class="card-text">ডিজিটাল লোন একটি বিশেষ মোবাইল অ্যাপ যা দিয়ে লোনের আবেদন করা যায়
                                    এবং অ্যাপের
                                    মাধ্যমেই লোন প্রদান করা হয়।</p>

                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>
        <!-- /Easy business section one -->

        <!-- Every thing in business -->
        <section id="everythingInBusiness">
            <div class="container" data-aos="fade-up" data-aos-delay="200">
                <div class="row">
                    <div class="common_business_title mb-5" data-aos="flip-top" data-aos-delay="250">
                        <h2 class="text-center">ব্যবসার সব কিছু এক অ্যাপেই</h2>
                    </div>
                    <div class="col-sm-12 col-md-12 mb-4" data-aos="fade-up" data-aos-delay="300">
                        <div class="card mb-3 flex-row">
                            <div class="row g-0">
                                <div class="col-md-6" data-aos="fade-right" data-aos-delay="400">
                                    <img src="assets/img/demo1.png" class="img-fluid rounded-start" alt="...">
                                </div>
                                <div class="col-md-6" data-aos="fade-left" data-aos-delay="500">
                                    <div class="card-body">
                                        <h5 class="card-title fw-bold"> ব্যবসার হিসাব রাখা খুব সহজ</h5>
                                        <p class="card-text">বাকি, ক্যাশ, পেমেন্টের জন্য ভিন্ন ভিন্ন খাতা ব্যবহার না
                                            করে টালিখাতা অ্যাপে
                                            হিসাব রাখুন। ব্যবসার পাই-টু-পাই হিসাব থাকবে চোখের সামনে।

                                            কাস্টমার ও সাপ্লায়ারের লিস্ট দেনা-পাওনাসহ
                                            হিসাবের ব্যাকআপ থাকে
                                            অটো যোগ-বিয়োগে নির্ভুল হিসাব
                                            লেনদেন লিখে রাখা খুব সহজ</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-12 mb-4" data-aos="fade-up" data-aos-delay="200">
                        <div class="card">
                            <div class="row g-0 d-flex">

                                <div class="col-md-6 col-sm-12 d-flex order-2 order-md-1" data-aos="fade-right"
                                    data-aos-delay="400">
                                    <div class="card-body">
                                        <h5 class="card-title fw-bold pb-2">লেনদেনের মেসেজে হিসাব থাকে একদম ক্লিয়ার
                                        </h5>
                                        <p class="card-text">
                                            বাকি কাস্টমার ও সাপ্লায়ারকে প্রতিটি লেনদেনের রেকর্ড পাঠানো যায়। বাকির পরিমাণ
                                            ও পরিশোধ এর হিসাব
                                            নিয়ে আর ভুল বোঝাবুঝি হবে না। হিসাব থাকবে ক্লিয়ার, সম্পর্কও থাকবে ভাল।

                                            এসএমএস, ইমো, হোয়াটসঅ্যাপ বা মেসেঞ্জারে লেনদেনের বিস্তারিত শেয়ার
                                            তাগাদা মেসেজ পাঠিয়ে দ্রুত বাকি আদায়
                                            মেসেজে মালামালের বিস্তারিত
                                        </p>
                                    </div>
                                </div>


                                <div class="col-md-6 col-sm-12 order-1 order-md-2 d-flex text-end"
                                    data-aos="fade-left" data-aos-delay="500">
                                    <img src="assets/img/demo1.png" class="img-fluid rounded-end text-end"
                                        alt="Placeholder Image">
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="col-sm-12 col-md-12 mb-4" data-aos="fade-up" data-aos-delay="300">
                        <div class="card mb-3 flex-row">
                            <div class="row g-0">
                                <div class="col-md-6" data-aos="fade-right" data-aos-delay="400">
                                    <img src="assets/img/demo1.png" class="img-fluid rounded-start" alt="...">
                                </div>
                                <div class="col-md-6" data-aos="fade-left" data-aos-delay="500">
                                    <div class="card-body">
                                        <h5 class="card-title fw-bold">ব্যবসার সহজ লোন</h5>
                                        <p class="card-text">বাকি, ক্যাশ, পেমেন্টের জন্য ভিন্ন ভিন্ন খাতা ব্যবহার না
                                            করে টালিখাতা অ্যাপে
                                            হিসাব রাখুন। ব্যবসার পাই-টু-পাই হিসাব থাকবে চোখের সামনে।

                                            কাস্টমার ও সাপ্লায়ারের লিস্ট দেনা-পাওনাসহ
                                            হিসাবের ব্যাকআপ থাকে
                                            অটো যোগ-বিয়োগে নির্ভুল হিসাব
                                            লেনদেন লিখে রাখা খুব সহজ</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-12 col-md-12 mb-4" data-aos="fade-up" data-aos-delay="200">
                        <div class="card">
                            <div class="row g-0 d-flex">

                                <div class="col-md-6 col-sm-12 d-flex order-2 order-md-1" data-aos="fade-right"
                                    data-aos-delay="400">
                                    <div class="card-body">
                                        <h5 class="card-title fw-bold pb-2"> পেমেন্ট নিন ব্যাংক ও মোবাইল ব্যাংকিং অ্যাপ
                                            থেকে</h5>
                                        <p class="card-text">
                                            বাকি কাস্টমার ও সাপ্লায়ারকে প্রতিটি লেনদেনের রেকর্ড পাঠানো যায়। বাকির পরিমাণ
                                            ও পরিশোধ এর হিসাব
                                            নিয়ে আর ভুল বোঝাবুঝি হবে না। হিসাব থাকবে ক্লিয়ার, সম্পর্কও থাকবে ভাল।

                                            এসএমএস, ইমো, হোয়াটসঅ্যাপ বা মেসেঞ্জারে লেনদেনের বিস্তারিত শেয়ার
                                            তাগাদা মেসেজ পাঠিয়ে দ্রুত বাকি আদায়
                                            মেসেজে মালামালের বিস্তারিত
                                        </p>
                                    </div>
                                </div>


                                <div class="col-md-6 col-sm-12 order-1 order-md-2 d-flex text-end"
                                    data-aos="fade-left" data-aos-delay="500">
                                    <img src="assets/img/demo1.png" class="img-fluid rounded-end text-end"
                                        alt="Placeholder Image">
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- /Every thing in business -->
        <section id="#bannerImage" data-aos="fade-up" data-aos-delay="250">
            <figure>
                <img src="assets/img/banner-img.png" alt="banner-img" class="img-fluid" width="100%">
            </figure>
        </section>
        <!-- Easy business section one -->

        <section id="allTypeBusiness">
            <div class="container" data-aos="fade-up" data-aos-delay="100">
                <div class="row">
                    <div class="common_business_title mb-5" data-aos="flip-top" data-aos-delay="200">
                        <h2 class="text-center ">সব ধরণের ব্যবসা প্রয়োজন হচ্ছে এই ইনভেন্টরি অ্যাপে</h2>
                    </div>
                    <div class="col-sm-3 col-md-3 mb-4" data-aos="fade-up-left" data-aos-delay="150">
                        <div class="card">
                            <img src="assets/img/demo-icon.png" class="card-img-top " alt="...">
                            <div class="card-body text-center">
                                <h5 class="card-title ">অনলাইন ব্যবসা</h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3 col-md-3 mb-4" data-aos="fade-up-left" data-aos-delay="250">
                        <div class="card">
                            <img src="assets/img/demo-icon.png" class="card-img-top " alt="...">
                            <div class="card-body text-center">
                                <h5 class="card-title ">ফার্মেসি</h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3 col-md-3 mb-4" data-aos="fade-up-left" data-aos-delay="350">
                        <div class="card">
                            <img src="assets/img/demo-icon.png" class="card-img-top " alt="...">
                            <div class="card-body text-center">
                                <h5 class="card-title ">রেস্তোরাঁ</h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3 col-md-3 mb-4" data-aos="fade-up-left" data-aos-delay="450">
                        <div class="card">
                            <img src="assets/img/demo-icon.png" class="card-img-top " alt="...">
                            <div class="card-body text-center">
                                <h5 class="card-title ">ফ্যাশন</h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3 col-md-3 mb-4" data-aos="fade-up-right" data-aos-delay="100">
                        <div class="card">
                            <img src="assets/img/demo-icon.png" class="card-img-top " alt="...">
                            <div class="card-body text-center">
                                <h5 class="card-title ">জেনারেল স্টোর</h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3 col-md-3 mb-4" data-aos="fade-up-right" data-aos-delay="200">
                        <div class="card">
                            <img src="assets/img/demo-icon.png" class="card-img-top " alt="...">
                            <div class="card-body text-center">
                                <h5 class="card-title ">ক্যাফে</h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3 col-md-3 mb-4" data-aos="fade-up-right" data-aos-delay="300">
                        <div class="card">
                            <img src="assets/img/demo-icon.png" class="card-img-top " alt="...">
                            <div class="card-body text-center">
                                <h5 class="card-title ">সুপার শপ</h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3 col-md-3" data-aos="fade-up-right" data-aos-delay="400">
                        <div class="card">
                            <img src="assets/img/demo-icon.png" class="card-img-top " alt="...">
                            <div class="card-body text-center">
                                <h5 class="card-title">অন্যান্য</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- /Easy business section one -->

        <!--  Client section -->
        <section id="clintSection">
            <div class="container" data-aos="fade-down" data-aos-delay="200">
                <div class="row">
                    <div class="common_business_title mb-5" data-aos="flip-top" data-aos-delay="250">
                        <h2 class="text-center ">ব্যবহারকারীর আস্থাই আমাদের অর্জন</h2>
                    </div>
                    <div class="large-12 columns" data-aos="fade-up-left" data-aos-delay="250">
                        <div class="owl-carousel owl-theme" data-aos="flip-top" data-aos-delay="350">
                            <div class="item">
                                <img src="assets/img/clind1.png" class="img-fluid" alt="">
                            </div>
                            <div class="item">
                                <img src="assets/img/clind2.png" class="img-fluid" alt="">
                            </div>
                            <div class="item">
                                <img src="assets/img/clind3.png" class="img-fluid" alt="">
                            </div>
                            <div class="item">
                                <img src="assets/img/clind4.png" class="img-fluid" alt="">
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--  /Client section -->

        <!-- Contact Section -->
        <section id="contact" class="contact section">
            <div class="container" data-aos="fade-up" data-aos-delay="100">
                <div class="row gy-4">
                    <!-- Section Title -->
                    <div class="common_business_title mb-5" data-aos="flip-top" data-aos-delay="200">
                        <h2 class="text-center ">Contact</h2>
                    </div>
                    <!-- End Section Title -->

                    <div class="col-lg-5">
                        <div class="info-wrap">
                            <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="200">
                                <i class="bi bi-geo-alt flex-shrink-0"></i>
                                <div>
                                    <h3>Address</h3>
                                    <p>5A Dhanmondi, Dhaka</p>
                                </div>
                            </div><!-- End Info Item -->

                            <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="300">
                                <i class="bi bi-telephone flex-shrink-0"></i>
                                <div>
                                    <h3>Call Us</h3>
                                    <p>+88 01711 111111</p>
                                </div>
                            </div><!-- End Info Item -->

                            <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="400">
                                <i class="bi bi-envelope flex-shrink-0"></i>
                                <div>
                                    <h3>Email Us</h3>
                                    <p>info@inventory.com</p>
                                </div>
                            </div><!-- End Info Item -->
                            <iframe
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3652.164038835511!2d90.3709088759274!3d23.741529089115655!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3755bf4ae5ab86c3%3A0x766626a968510b9!2sB2M%20Technologies%20Ltd.!5e0!3m2!1sen!2sbd!4v1729416479815!5m2!1sen!2sbd"
                                width="100%" height="250" style="border:0;" allowfullscreen="" loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade"></iframe>
                            <iframe src="" frameborder="0" style="border:0; width: 100%; height: 270px;"
                                allowfullscreen="" loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>
                    </div>

                    <div class="col-lg-7">
                        <form action="forms/contact.php" method="post" class="php-email-form" data-aos="fade-up"
                            data-aos-delay="200">
                            <div class="row gy-4">

                                <div class="col-md-6">
                                    <label for="name-field" class="pb-2">Your Name</label>
                                    <input type="text" name="name" id="name-field" class="form-control"
                                        required="">
                                </div>

                                <div class="col-md-6">
                                    <label for="mobile-field" class="pb-2">Your Mobile</label>
                                    <input type="number" class="form-control" name="mobile" id="mobile-field"
                                        required="">
                                </div>

                                <div class="col-md-12">
                                    <label for="subject-field" class="pb-2">Subject</label>
                                    <input type="text" class="form-control" name="subject" id="subject-field"
                                        required="">
                                </div>

                                <div class="col-md-12">
                                    <label for="message-field" class="pb-2">Message</label>
                                    <textarea class="form-control" name="message" rows="10" id="message-field" required=""></textarea>
                                </div>

                                <div class="col-md-12 text-center">
                                    <button type="submit">Send Message</button>
                                </div>

                            </div>
                        </form>
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
                Designed by <a href="#">B2M-tech</a>
            </div>
        </div>

    </footer>

    <!-- Scroll Top -->
    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <!-- Preloader -->
    <div id="preloader"></div>

    <!-- Vendor JS Files -->
    <script src="{{ asset('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/aos/aos.js') }}"></script>
    <!-- <script src="{{ asset('assets/vendor/swiper/swiper-bundle.min.js') }}"></script> -->

    <!-- Main JS File -->
    <script src="{{ asset('assets/js/main.js') }}"></script>

    <!-- javascript -->
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/owlcarousel/owl.carousel.js') }}"></script>


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
        var logged = document.getElementById('get_name').value;
        var divValue = document.getElementById('accessBtn').getAttribute('value');
        if (divValue == '1') {
            document.querySelector(".access-btn").innerHTML = logged;
        }
    </script>



</body>

</html>
