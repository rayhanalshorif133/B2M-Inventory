<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Forgot Password | Inventory</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('adminLTE/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="{{ asset('adminLTE/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('adminLTE/dist/css/adminlte.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.24.0/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
</head>

<body class="hold-transition login-page">

    <div class="login-box" id="auth">



        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <h1 class="h1">Forgot Password</h1>
            </div>
            <div class="card-body">
                <p class="login-box-msg">Enter your email address</p>

                <form id="forgotPasswordForm">
                    <div class="input-group mb-3">
                        <input type="email" class="form-control" placeholder="Email" id="email" name="email" />
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <button type="button" id="submitEmail" class="btn btn-primary btn-block">
                                Continue
                            </button>
                        </div>
                    </div>
                </form>

                <p class="my-2">
                    <a href="/login">Back to Login</a>
                </p>
            </div>
        </div>

    </div>

    <script src="{{ asset('adminLTE/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('adminLTE/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('adminLTE/dist/js/adminlte.min.js') }}"></script>

    <script>
        const Toastr = Swal.mixin({
            toast: true,
            position: "top",
            iconColor: "white",
            customClass: {
                popup: "colored-toast",
            },
            showConfirmButton: false,
            timer: 3500,
            timerProgressBar: true,
        });

        window.Toastr = Toastr;

        $(document).ready(function() {
            $('#submitEmail').on('click', function() {
                const email = $('#email').val();

                if (!email) {


                    Toastr.error('Please enter your email address');
                    return false;
                }

                axios.post('/forgot-password', {
                        email: email
                    })
                    .then(function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: response.data.message,
                        });
                    })
                    .catch(function(error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: error.response.data.message || 'Something went wrong',
                        });
                    });
            });
        });
    </script>



</body>

</html>
