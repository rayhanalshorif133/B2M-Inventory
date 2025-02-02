<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="favicon.ico">

    <title>Category</title>
    <!-- Bootstrap core CSS -->

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    <link
        href="https://fonts.googleapis.com/css2?family=Noto+Sans+Bengali:wght@200;300;400;500;600;700&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap"
        rel="stylesheet">
    <!-- icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons"> -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <!-- <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" /> -->

    <!-- Custom styles for this template -->
    <link href="assets/dist/animate/animate.min.css" rel="stylesheet">

    <link href="assets/dist/ionicons/css/ionicons.css" rel="stylesheet">
    <link href="assets/dist/owlcarousel/assets/owl.carousel.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/lucide@latest/dist/css/lucide.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/lucide@latest"></script>
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/category.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/modal.css') }}" rel="stylesheet">

</head>

<body>

    <div class="container mt-3" id="search">
        <div class="row">
            <div class="col-12 d-flex justify-content-center">
                <input type="text" id="game_search" class="form-control" placeholder="Search Game ...">
            </div>
        </div>
    </div>


    <main role="main">
        <section id="category-part">
            <div class="container">
                <div class="row">
                    <div class="col-12 popular-games">
                        <h1 class="section-title">Popular Games</h1>
                        @include('_partials.flashMessage')
                        <div class="custom-nav">
                            <button class="custom-prev"><i class="fas fa-chevron-left"></i></button>
                            <button class="custom-next"><i class="fas fa-chevron-right"></i></button>
                        </div>
                        <div class="owl-carousel owl-theme one-by-one">
                            @foreach ($games as $item)
                                <div class="item gameDetailsModal" data-toggle="modal"
                                data-target="#gameDetailsModal" data-gameid="{{ $item->id }}">
                                    <img src="{{ asset($item->banner) }}" alt="" class="img img-fluid" />
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!--/ All Game   /-->
        <section id="section_two" class="mb-4">
            <div class="container">
                <div class="row" style="margin-bottom: 3rem;">
                    <div class="col-12">
                        <h1 class="section-title">All Games</h1>

                        @if (Auth::check())
                            <input type="hidden" id="auth_phone_number" value="{{ Auth::user()->phone }}" />
                        @endif

                    </div>
                    @foreach ($games as $key => $game)
                        <div class="col-6 col-sm-6 col-md-4 col-lg-3 my-3 game-box gameDetailsModal" data-toggle="modal"
                            data-target="#gameDetailsModal" data-gameid="{{ $game->id }}">
                            <div class="card-box-a card-shadow">
                                <div class="card-body">
                                    <div class="img-box">
                                        <img class="card-img-top cover img-responsive" src="{{ asset($game->banner) }}"
                                            alt="Card image cap" style="height: 150px; width:100%;">
                                        <div class="img-box-counter">
                                            <p><i class="fa fa-user" aria-hidden="true"></i> {{ $game->attempt }}</p>
                                        </div>
                                    </div>
                                </div>
                                @if (Auth::check())
                                    <div class="play-gmae-name" style="margin-top:0px">
                                        <a href="#" class="btn-custom card-text text-left"> <i
                                                class="fas fa-play"></i>
                                            {{ $game->title }}</a>
                                        </a>
                                    </div>
                                @else
                                    <div class="play-gmae-name" style="margin-top:0px" data-toggle="modal"
                                        data-target="#loginModel">
                                        <a href="#" class="btn-custom card-text text-left"> <i
                                                class="fas fa-play"></i>
                                            {{ $game->title }}</a>
                                        </a>
                                    </div>
                                @endif

                            </div>
                        </div>
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


    <!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script> -->

    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script src="{{ asset('assets/dist/owlcarousel/owl.carousel.js') }}"></script>
    <script src="{{ asset('assets/dist/scrollreveal/scrollreveal.min.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>

    <script type="text/javascript">
        $(() => {

            $("#game_search").keyup(function() {
                const search = $(this).val();
                $(".game-box").each(function() {
                    const title = $(this).find(".card-text").text();
                    if (title.toLowerCase().includes(search.toLowerCase())) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });

                if (search === '') {
                    // $(".game-box").show();
                    $(".popular-games").show();
                } else {
                    $(".popular-games").hide();
                }
            });

            $(".gameDetailsModal").click(function() {
                const id = $(this).attr("data-gameid");
                const msisdn = $("#auth_phone_number").val();

                axios.get(`/game/${id}/fetch?msisdn=${msisdn}`)
                    .then(function(response) {
                        const data = response.data.data;
                        $(".gameDetailsModalImage").attr("src", data.banner);
                        $(".gameDetailsModalInfo h2").text(data.title);
                        $(".gameDetailsModalInfo p").text(data.description);
                        const GAME_URL =
                            `${data.url}?token=${msisdn}&keyword=${data.keyword}&campaign_id=free`;
                        $(".trial-play-btn").html(
                            `<button data-url="${GAME_URL}" data-gameid="${data.id}" class="btn btn-outline-info"><i class="fas fa-play"></i>Trial Play</button>`
                        );
                    })
            });
        });

        $(document).ready(function() {
            const owl = $('.one-by-one');
            owl.owlCarousel({
                rtl: true,
                loop: true,
                margin: 10,
                nav: false,
                responsive: {
                    0: {
                        items: 1
                    },
                    600: {
                        items: 2
                    },
                    700: {
                        items: 3
                    },
                    1000: {
                        items: 4
                    }
                }
            });

            // Custom Navigation
            $('.custom-prev').click(function() {
                owl.trigger('prev.owl.carousel');
            });

            $('.custom-next').click(function() {
                owl.trigger('next.owl.carousel');
            });
        });


        $(document).on('click', '.trial-play-btn button', function(e) {
            const id = $(this).data('gameid');
            const url = $(this).data('url');
            axios.get(`/game/${id}/fetch?type=attend`)
                .then(function(response) {
                    window.location.href = url;
                });
        });
    </script>


</body>

</html>
