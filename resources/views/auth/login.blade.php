@extends('layouts.auth')
@section('title', 'Login')

@section('content')
    <div class="login-box" id="auth">
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <a href="#" class="h1 underline-none"><b>INVENTORY</b></a>
            </div>
            <div class="card-body">
                <p class="login-box-msg">Sign in to start your session</p>

                <form action="#" method="POST">
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
                        <div class="input-group-append">
                            <div class="input-group-text">
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
                            <button type="button" class="btn btn-primary btn-block submitLogin" style="width: fit-content">
                                Login
                            </button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>
                <!-- /.social-auth-links -->

                <p class="mb-1">
                    <a href="/forgot-password">I forgot my password</a>
                </p>
                <p class="mb-0">
                    <a href="/register" class="text-center">Register a new membership</a>
                </p>
            </div>
            <!-- /.card-body -->
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(() => {

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
