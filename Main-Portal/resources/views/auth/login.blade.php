@extends('layouts.auth', ['title' => 'Login'])

@section('content')
    <div class="login-box" id="auth">
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <a href="#" class="h1 underline-none mr-4">
                    <img src="{{ asset('new_assets/img/logo.png') }}" alt="">
                </a>
            </div>
            <div class="card-body">
                <p class="login-box-msg">Sign in to start your session</p>
                <ul class="nav nav-tabs" id="loginTab" role="tablist">
                    <li class="nav-item w-50" id="switchToEmail" role="presentation">
                        <button class="nav-link active w-100" id="loginByEmail-tab" data-bs-toggle="tab"
                            data-bs-target="#loginByEmail" type="button" role="tab" aria-controls="loginByEmail"
                            aria-selected="true">
                            <span style="color: black">Login By Email</span>
                        </button>
                    </li>
                    <li class="nav-item w-50" id="switchToOtp" role="presentation">
                        <button class="nav-link w-100" id="loginByOtp-tab" data-bs-toggle="tab" data-bs-target="#loginByOtp"
                            type="button" role="tab" aria-controls="loginByOtp" aria-selected="false"><span
                                style="color: black">Login By OTP</span></button>

                    </li>
                </ul>
                <div class="tab-content" id="loginTabContent">
                    <div class="tab-pane fade show active" id="loginByEmail" role="tabpanel"
                        aria-labelledby="loginByEmail-tab">
                        <form action="#" class="mt-4" method="POST">
                            <div class="input-group mb-3">
                                <input type="email" class="form-control" id="email" placeholder="Email" />
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-envelope"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="input-group mb-3">
                                <input type="password" class="form-control" id="password" placeholder="Password" />
                                <div class="input-group-append password cursor-pointer icon-btn">
                                    <div class="input-group-text cursor-pointer icon-btn">
                                        <span class="fas fa-lock"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-8">
                                    <div class="icheck-primary">
                                        <input type="checkbox" id="remember" />
                                        <label for="remember"> Remember Me </label>
                                    </div>
                                </div>
                                <!-- /.col -->
                                <div class="col-4">
                                    <button type="button" class="btn btn-primary btn-block submitLogin"
                                        style="width: fit-content">
                                        Login
                                    </button>
                                </div>
                                <!-- /.col -->
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="loginByOtp" role="tabpanel" aria-labelledby="loginByOtp-tab">
                        <form action="#" class="mt-4" method="POST">
                            <div class="input-group mb-3">
                                <input type="number" class="form-control" id="phone" placeholder="Phone number" />
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-phone"></span>
                                    </div>
                                </div>
                            </div>
                            <div class="input-group mb-3">
                                <input type="password" class="form-control" id="password" placeholder="Password" />
                                <div class="input-group-append password cursor-pointer icon-btn">
                                    <div class="input-group-text cursor-pointer icon-btn">
                                        <span class="fas fa-lock"></span>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>




                <!-- /.social-auth-links -->

                <p class="mb-1">
                    <a href="/forgot-password">I forgot my password</a>
                </p>
                <p class="mb-0">
                    <a href="{{ route('auth.otp-send') }}" class="text-center">Register a new membership</a>
                </p>
            </div>
            <!-- /.card-body -->
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(() => {

            $("#loginByEmail-tab").click(function() {
                $(this).addClass('active');
                $("#loginByOtp-tab").removeClass('active');
                $("#loginByEmail").addClass('show active');
                $("#loginByOtp").removeClass('show active');
            });


            $("#loginByOtp-tab").click(function() {
                $(this).addClass('active');
                $("#loginByEmail-tab").removeClass('active');
                $("#loginByOtp").addClass('show active');
                $("#loginByEmail").removeClass('show active');
            });

            $(".submitLogin").click(function(e) {
                $(this).text('Processing...');
                $(this).attr('disabled', true);
                axios
                    .post("login", {
                        email: $("#email").val(),
                        password: $("#password").val(),
                    })
                    .then(function(response) {
                        const data = response.data.data;
                        const message = response.data.message;
                        sessionStorage.setItem('msg', message);
                        Toastr.fire({
                            icon: message,
                            title: data,
                        });
                        if (message == "success") {
                            window.location.href = "/home";
                        }
                    });

                setTimeout(() => {
                    const getMsg = sessionStorage.getItem('msg');
                    if (getMsg == 'error') {
                        $(".submitLogin").text('Login');
                        $(".submitLogin").attr('disabled', false);
                    }
                }, 1000);
            });





        });
    </script>
@endpush
