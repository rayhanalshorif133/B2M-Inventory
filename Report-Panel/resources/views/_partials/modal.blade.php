{{-- For Home Page --}}
<div class="modal modalAnimate fade" id="gameDetailsCampaignModal" tabindex="-1" role="dialog"
    aria-labelledby="gameDetailsCampaignModal" aria-hidden="true" data-animation-in="fadeInLeft"
    data-animation-out="bounceOut">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <div class="game-image">
                    <img src="assets/images/game1.jpg" alt="Game Image" class="img-fluid gameDetailsCampaignModalImage">
                </div>
            </div>

            <!-- Modal Body -->
            <div class="modal-body modal-custom-body">
                <div class="game-info gameDetailsCampaignModalInfo">
                    <h2>Game Name</h2>
                    <p>Game Description</p>
                </div>
                <div class="game-buttons game-buttons-container"></div>
                <div class="leaderboard-container hidden relative">
                    <div class="absolute" style="top: -40px;right: 0;">
                        <button class="btn cancelLeaderBoardBtn"><i class="fa-solid fa-xmark"></i></button>
                    </div>
                    <ul class="nav nav-tabs" id="leaderboardTab" role="tablist">
                        <li class="nav-item w-50" role="presentation">
                            <button class="nav-link active w-100" id="daily-tab" data-bs-toggle="tab"
                                data-bs-target="#daily" type="button" role="tab" aria-controls="daily"
                                aria-selected="true">daily</button>
                        </li>
                        <li class="nav-item w-50" role="presentation">
                            <button class="nav-link w-100" id="weekly-tab" data-bs-toggle="tab" data-bs-target="#weekly"
                                type="button" role="tab" aria-controls="weekly"
                                aria-selected="false">weekly</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="leaderboardTabContent">
                        
                        <div class="tab-pane fade show active" id="daily" role="tabpanel"
                            aria-labelledby="daily-tab">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Rank</th>
                                        <th>Msisdn</th>
                                        <th>Score</th>
                                    </tr>
                                </thead>
                                <tbody class="dailyLeaderBoard"></tbody>
                            </table>
                        </div>
                        <div class="tab-pane fade" id="weekly" role="tabpanel" aria-labelledby="weekly-tab">

                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Rank</th>
                                        <th>Name</th>
                                        <th>Score</th>
                                    </tr>
                                </thead>
                                <tbody class="weeklyLeaderBoard"></tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>



{{-- For All Game Page --}}
<div class="modal modalAnimate fade" id="gameDetailsModal" tabindex="-1" role="dialog"
    aria-labelledby="gameDetailsModal" aria-hidden="true" data-animation-in="fadeInLeft" data-animation-out="bounceOut">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <div class="game-image">
                    <img src="assets/images/game1.jpg" alt="Game Image" class="img-fluid gameDetailsModalImage">
                </div>
            </div>

            <!-- Modal Body -->
            <div class="modal-body modal-custom-body">
                <div class="game-info gameDetailsModalInfo">
                    <h2>Game Name</h2>
                    <p>Game Description</p>
                </div>
                <div class="game-buttons">
                    {{-- <div class="play-button"></div> --}}
                    <div class="trial-play-btn"></div>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


<div class="modal modalAnimate fade" id="loginModel" tabindex="-1" role="dialog" aria-labelledby="loginModel"
    aria-hidden="true" data-animation-in="fadeInLeft" data-animation-out="bounceOut">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header bg-red">
                <div class="game-image">
                    <img src="{{ asset('assets/images/user.png') }}" alt="Game Image" class="img-fluid">
                </div>
            </div>

            <!-- Modal Body -->
            <div class="modal-body modal-custom-body">
                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        <button class="nav-link active" id="nav-login-tab" data-bs-toggle="tab"
                            data-bs-target="#nav-login" type="button" role="tab" aria-controls="nav-login"
                            aria-selected="true" style="width: 50%">Login</button>
                        <button class="nav-link" id="nav-register-tab" data-bs-toggle="tab"
                            data-bs-target="#nav-register" type="button" role="tab"
                            aria-controls="nav-register" aria-selected="false" style="width: 50%">Register</button>
                    </div>
                </nav>
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-login" role="tabpanel"
                        aria-labelledby="nav-login-tab">
                        <h5 class="text-center mt-3" id="loginModalTitle">Login Your Account</h5>

                        <form method="POST" action="{{ route('player.login') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="login_phone" class="form-label">{{ __('Phone Number') }}</label>
                                <input id="login_phone" type="number"
                                    class="form-control @error('phone') is-invalid @enderror" name="phone"
                                    value="{{ old('phone') }}" required autocomplete="phone" autofocus>
                                @error('phone')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="login_password" class="form-label">{{ __('Password') }}</label>
                                <input id="login_password" type="password"
                                    class="form-control @error('password') is-invalid @enderror" name="password"
                                    required autocomplete="current-password">
                                @error('password')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary btn-block">
                                    {{ __('Login') }}
                                </button>
                            </div>

                            <div class="text-center mt-3">
                                @if (Route::has('password.request'))
                                    <a class="text-decoration-none" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </form>

                    </div>
                    <div class="tab-pane fade" id="nav-register" role="tabpanel" aria-labelledby="nav-register-tab">
                        <h5 class="text-center mt-3" id="loginModalTitle">Create a New Account</h5>

                        <form method="POST" action="{{ route('player.register') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="phone" class="form-label">{{ __('Name') }}</label>
                                <input id="name" type="text"
                                    class="form-control @error('name') is-invalid @enderror" name="name"
                                    value="{{ old('name') }}" required autocomplete="name" autofocus>
                                @error('name')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="phone" class="form-label">{{ __('Phone Number') }}</label>
                                <input id="phone" type="number"
                                    class="form-control @error('phone') is-invalid @enderror" name="phone"
                                    value="{{ old('phone') }}" required autocomplete="phone" autofocus>
                                @error('phone')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">{{ __('Password') }}</label>
                                <input id="password" type="password"
                                    class="form-control @error('password') is-invalid @enderror" name="password"
                                    required autocomplete="current-password">
                                @error('password')
                                    <div class="invalid-feedback">
                                        <strong>{{ $message }}</strong>
                                    </div>
                                @enderror
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary btn-block">
                                    {{ __('Register') }}
                                </button>
                            </div>

                            <div class="text-center mt-3">
                                @if (Route::has('password.request'))
                                    <a class="text-decoration-none" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>


            </div>
        </div>
    </div>
</div>




<div class="modal modalAnimate fade" id="paymentDetailsModal" tabindex="-1" role="dialog"
    aria-labelledby="paymentDetailsModal" aria-hidden="true" data-animation-in="fadeInLeft"
    data-animation-out="bounceOut">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <div class="game-image">
                    <div class="icon-container">
                        <i class="fa-solid fa-check" style="color: #ffffff;"></i>
                    </div>
                </div>
            </div>

            <!-- Modal Body -->
            <div class="modal-body modal-custom-body">
                <div class="game-info paymentDetailsModalInfo">
                    <h2 class="payment_status font-bold"></h2>
                    <h3>Game Name</h3>
                    <p>Game Description</p>
                </div>
                <div class="game-buttons">
                    <div class="play-button paymentPlayButton">
                        <button class="btn btn-primary mb-2" id="bKash_button">
                            <i class="fas fa-play"></i> Try Again <span id="payment_gameDetailsTk">50TK</span>
                        </button>
                    </div>
                    <div class="gust-button paymentGuestButton">
                        <a href="" class="btn btn-outline-info" id="paymentGameDetailsSetURL"><i
                                class="fas fa-play"></i> Guest</a>
                    </div>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
