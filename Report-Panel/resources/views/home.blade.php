<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="favicon.ico">

    <title>Bkash Game</title>
    <!-- Bootstrap core CSS -->

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    <link
        href="https://fonts.googleapis.com/css2?family=Noto+Sans+Bengali:wght@200;300;400;500;600;700&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap"
        rel="stylesheet">
    <!-- icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

    <!-- Custom styles for this template -->
    <link href="{{ asset('assets/dist/animate/animate.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/dist/owlcarousel/assets/owl.carousel.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/lucide@latest/dist/css/lucide.css">
    <script src="https://cdn.jsdelivr.net/npm/lucide@latest"></script>
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/home.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/modal.css') }}" rel="stylesheet">


    {{-- Payment LINK --}}
    <script src="https://scripts.pay.bka.sh/versions/1.2.0-beta/checkout/bKash-checkout.js"></script>

    <style>
        .movie-card {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 20px;
            /* Space between inline-block elements */
            margin-top: 1.1vh;
            background-color: #efefef;
            padding: 1.5% 1.2%;
        }



        .card-text,
        .view-gmae {
            display: inline-block;
            /* Ensures elements are inline-block */
            margin: 0;
            text-align: center;
            padding: 5px;
        }

        /* remove increment and decrement btn from input number */
        input[type='number']::-webkit-inner-spin-button,
        input[type='number']::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
    </style>

</head>

<body>


    <main role="main">

        <section id="section_one">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="min-h-screen">
                            @if (count($campaigns) > 0)
                                <h1 class="section-title tiro-bangla-regular">খেলে জিতে নিন</h1>
                            @endif
                            @include('_partials.flashMessage')
                            @if (Auth::check())
                                <input type="hidden" id="auth_phone_number" value="{{ Auth::user()->phone }}" />
                            @endif
                            <div class="owl-carousel owl-theme home-page-carousel">
                                @foreach ($campaigns as $campaign)
                                    @if ($campaign->time_status != 'Expired')
                                        <div class="game-card gameDetailsCampaignModal" data-toggle="modal"
                                            data-target="#gameDetailsCampaignModal" data-campid="{{ $campaign->id }}">
                                            <div class="image-container">
                                                <img src="{{ asset($campaign->banner) }}" alt="{{ $campaign->name }}">
                                                @if (Auth::check())
                                                    <div class="selected-game-name-wrap">
                                                        <a href="#"
                                                            class="btn-custom card-text text-left selected-game-name">
                                                            <i class="fas fa-play"></i> &nbsp;
                                                            {{ $campaign->name }}
                                                        </a>
                                                    </div>
                                                @else
                                                    <div class="selected-game-name-wrap" data-toggle="modal"
                                                        data-target="#loginModel">
                                                        <a href="#"
                                                            class="btn-custom card-text text-left selected-game-name">
                                                            <i class="fas fa-play"></i> &nbsp;
                                                            {{ $campaign->name }}
                                                        </a>
                                                    </div>
                                                @endif

                                            </div>
                                            <div class="card-content">
                                                <div class="card-footer">
                                                    <div class="players">
                                                        <i class="fas fa-user"></i>
                                                        <span>{{ $campaign->participation }}</span>
                                                    </div>
                                                    @if ($campaign->time_status == 'Expired')
                                                        <div class="countdown expired">
                                                            <span>{{ $campaign->time_status }}</span>
                                                            <i class="far fa-clock"></i>
                                                        </div>
                                                    @else
                                                        <div class="countdown" data-expires="Dec 12, 2025 01:04:59">
                                                            <span>{{ $campaign->time_status }}</span>
                                                            <i class="far fa-clock"></i>
                                                            <div class="timer">
                                                                <span class="days">{{ $campaign->day_left }}</span>D
                                                                <span
                                                                    class="hours">{{ $campaign->time_h_left }}</span>:
                                                                <span
                                                                    class="minutes">{{ $campaign->time_m_left }}</span>
                                                            </div>
                                                        </div>
                                                    @endif

                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--/ Popular Game   /-->
        <section id="section_two">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <h1 class="section-title">Play | Complete | Win</h1>

                        @if (count($campaigns) == 0)
                            <div class="alert alert-danger" role="alert">
                                No campaigns found. Please check back later
                            </div>
                        @endif
                    </div>
                    @foreach ($campaigns as $key => $campaign)
                        @if ($campaign->time_status != 'Expired')
                            <div class="col-6 col-sm-6 col-md-6 col-lg-4 mb-10 gameDetailsCampaignModal"
                                data-toggle="modal" data-target="#gameDetailsCampaignModal"
                                data-campid="{{ $campaign->id }}">
                                <div class="card-box-a card-shadow">
                                    <div class="card-body">
                                        <a href="#">
                                            <img class="card-img-top cover img-responsive campaign_image"
                                                src="{{ asset($campaign->banner) }}" alt="Card image cap ">
                                        </a>
                                    </div>
                                    @if (Auth::check())
                                        <div class="play-gmae-name" style="margin-top:0px">
                                            <a href="#" class="btn-custom card-text text-left"> <i
                                                    class="fas fa-play"></i>
                                                {{ $campaign->name }}</a>
                                            </a>
                                        </div>
                                    @else
                                        <div class="play-gmae-name" style="margin-top:0px" data-toggle="modal"
                                            data-target="#loginModel">
                                            <a href="#" class="btn-custom card-text text-left"> <i
                                                    class="fas fa-play"></i>
                                                {{ $campaign->name }}</a>
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>

        </section>
    </main>


    @include('_partials.web_footer')
    @include('_partials.modal')







    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script> -->

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('assets/dist/owlcarousel/owl.carousel.js') }}"></script>
    <script src="{{ asset('assets/dist/scrollreveal/scrollreveal.min.js') }}"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>

    <script src="{{ asset('assets/js/payment.js') }}"></script>
    <script>
        $(() => {

            $(".gameDetailsCampaignModal").click(function() {
                const id = $(this).attr("data-campid");
                const msisdn = $("#auth_phone_number").val();
                axios.get(`/campaign/${id}/fetch?msisdn=${msisdn}`)
                    .then(function(response) {
                        const data = response.data.data;


                        $(".gameDetailsCampaignModalImage").attr("src", data.banner);
                        $(".gameDetailsCampaignModalInfo h2").text(data.name);
                        $(".gameDetailsCampaignModalInfo p").text(data.game.title);
                        const GAME_URL =
                            `${data.game.url}?token=${msisdn}&keyword=${data.game.keyword}&campaign_id=${data.id}`;

                        if (data.hasSubs) {
                            $(".trial-play-btn").html('');
                            $(".game-buttons").html(`
                                <div class="play-button">
                                    <a href="${GAME_URL}" class="btn btn-outline-navy">
                                        <i class="fas fa-play"></i> Play Now
                                    </a>
                                </div>
                                <div class="leaderboard-button">
                                    <button data-campid="${id}" class="btn btn-outline-leaderboard leaderboardBtn">
                                        <i class="fa-solid fa-person-chalkboard"></i> Leaderboard
                                    </button>
                                </div>
                            `);
                        } else {
                            $("#gameDetailsTk").text(``);

                            if (data.time_status == 'Expired') {
                                $(".game-buttons").html(`
                                <div class="play-button">
                                    <span class="text-danger font-bold">⚠️ This campaign has expired.</span>
                                    <div>
                                        <button data-url="${GAME_URL}" data-gameid="${data.game.id}" class="btn btn-outline-info"><i class="fas fa-play"></i>Trial Play</button>
                                    </div>
                                </div>
                            `);
                            } else {
                                $(".game-buttons").html(`
                                <div class="play-button">
                                    <button id="bKash_button" data-campid=${id} class="btn btn-outline-navy">
                                        <i class="fas fa-play"></i> Play Now
                                    </button>
                                </div>
                                 <div class="trial-play-btn">
                                        <button data-url="${GAME_URL}" data-gameid="${data.game.id}" class="btn btn-outline-info"><i class="fas fa-play"></i>Trial Play</button>
                                </div>
                                <div class="leaderboard-button">
                                    <button data-campid="${id}" class="btn btn-outline-leaderboard leaderboardBtn">
                                        <i class="fa-solid fa-person-chalkboard"></i> Leaderboard
                                    </button>
                                </div>
                            `);
                            }
                        }



                    })
            });






            $(document).on('click', '.leaderboardBtn', function(e) {
                const campid = $(this).data('campid');
                axios.get(`/leaderboard/${campid}/fetch`)
                    .then(function(response) {
                        $(".game-buttons-container").addClass('hidden');
                        $(".leaderboard-container").removeClass('hidden');
                        const {
                            daily,
                            user,
                            weekly
                        } = response.data.data;
                        $(".dailyLeaderBoard").html('');
                        console.log(weekly, user);
                        daily.length > 0 && daily.map(function(item, index) {
                            $(".dailyLeaderBoard").append(`
                                <tr>
                                    <td>${index + 1}</td>
                                    <td>${item.msisdn}</td>
                                    <td>${item.total_score}</td>
                                </tr>
                            `);
                        });

                        weekly.length > 0 && weekly.map(function(item, index) {
                            $(".weeklyLeaderBoard").append(`
                                <tr>
                                    <td>${index + 1}</td>
                                    <td>${item.msisdn}</td>
                                    <td>${item.total_score}</td>
                                </tr>
                            `);
                        });
                    });
            });

            $(document).on('click', '.cancelLeaderBoardBtn', function(e) {
                $(".game-buttons-container").removeClass('hidden');
                $(".leaderboard-container").addClass('hidden');
            });

            $(document).on('click', '.trial-play-btn button', function(e) {
                const id = $(this).data('gameid');
                const url = $(this).data('url');
                axios.get(`/game/${id}/fetch?type=attend`)
                    .then(function(response) {
                        window.location.href = url;
                    });
            });

            $(document).on('click', '#leaderboardTab button', function(e) {
                e.preventDefault();
                $(this).tab('show'); // Bootstrap's method to show a tab
            });


        });

        var countClick = 0;

        $(document).on('click', "#bKash_button", function() {
            countClick++;
            console.log(countClick);
            if (countClick == 1) {
                $(this).click();
            }
            $(this).text('Lodding...');
            const msisdn = $("#auth_phone_number").val();
            const campaign = $(this).attr("data-campid");
            var inv_no = Math.floor((Math.random() * 100000) + 1);
            console.log('inv_no', inv_no);
            var paymentID = '';
            bKash.init({
                paymentMode: 'checkout',
                paymentRequest: {
                    amount: '01',
                    intent: 'sale'
                },
                createRequest: function(
                    request
                ) { //request object is basically the paymentRequest object, automatically pushed by the script in createRequest method
                    $.ajax({
                        url: `http://bkash-sandbox.bdgamers.club/payment/create/${msisdn}?campaign_id=${campaign}`,
                        type: 'GET',
                        contentType: 'application/json',
                        success: function(data) {
                            $(this).text('Play Now');
                            if (data == 'Completed') {
                                window.location.href =
                                    "https://www.google.com/?number";
                                return 0;
                            }
                            if (data && data.paymentID != null) {
                                paymentID = data.paymentID;
                                window.sessionStorage.setItem('paymentID', paymentID);
                                bKash.create().onSuccess(data);
                            } else {
                                bKash.create().onError();
                            }
                        },
                        error: function() {
                            bKash.create().onError();
                        }
                    });
                },
                executeRequestOnAuthorization: function() {

                    const paymentID = window.sessionStorage.getItem('paymentID');
                    const url =
                        `http://bkash-sandbox.bdgamers.club/payment/execute/${msisdn}/${paymentID}`;
                    setTimeout(() => {
                        window.location.href = url;
                    }, 1000);
                },
                onClose: function() {
                    const paymentID = window.sessionStorage.getItem('paymentID');
                    const url =
                        `http://bkash-sandbox.bdgamers.club/payment/execute/${msisdn}/${paymentID}`;

                    setTimeout(() => {
                        window.location.href = url;
                    }, 200);
                }
            });
        });
    </script>


    <script>
        $(document).ready(function() {
            // Switch tabs on button click
            $('#nav-login-tab').on('click', function() {
                $('#nav-login-tab').addClass('active');
                $('#nav-register-tab').removeClass('active');
                $('#nav-login').addClass('show active');
                $('#nav-register').removeClass('show active');
            });

            $('#nav-register-tab').on('click', function() {
                $('#nav-register-tab').addClass('active');
                $('#nav-login-tab').removeClass('active');
                $('#nav-register').addClass('show active');
                $('#nav-login').removeClass('show active');
            });


        });
    </script>


    <script type="text/javascript">
        // Initialize Owl Carousel
        $(document).ready(function() {
            $(".home-page-carousel").owlCarousel({
                center: true,
                items: 1.5,
                loop: true,
                margin: 30,
                nav: false,
                dots: false,
                autoplay: false,
                autoplayTimeout: 5000,
                autoplayHoverPause: true,
                responsive: {
                    0: {
                        items: 1.5
                    },
                    768: {
                        items: 3
                    }
                }
            });


        });

        // Initialize Lucide icons

        // Update all countdown timers



        function modalAnimation(animation) {
            $('.modal .modal-dialog').attr('class', 'modal-dialog  ' + animation + ' animated');
        };
        $('.modal').on('show.bs.modal', function(e) {
            $('.modal .modal-dialog').attr('class', 'modal-dialog  fadeIn  animated');
        })
        $('.modalAnimate').on('hide.bs.modal', function(e) {
            var anim = $(this).attr('data-animation-out');
            modalAnimation(anim);
        });
    </script>

</body>

</html>
