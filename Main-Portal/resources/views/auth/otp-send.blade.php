@extends('layouts.auth', ['title' => 'Register a new account'])

@section('content')
    <div class="register-box" id="auth">
        <div class="card card-outline card-primary mt-5">
            <div class="card-header text-center">
                <a href="#" class="h1 underline-none">
                    <img src="{{ asset('new_assets/img/logo.png') }}" alt="">
                </a>
            </div>
            <div class="card-body">
                <p class="register-msg-box">Verify Your Inforamtion</p>
                <form action="{{ route('auth.otp-send') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <div class="col-md-12">
                        <label for="name" class="form-label required">User Name</label>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="Enter your name"
                                id="name" name="name" value="{{ old('name') }}">
                            <div class="input-group-append">
                                <div class="input-group-text"><span class="fa-solid fa-user"></span></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <label for="msisdn" class="form-label required">User Phone Number</label>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="Enter your phone number"
                                id="msisdn" name="msisdn" value="{{ old('msisdn') }}">
                            <div class="input-group-append">
                                <div class="input-group-text"><span class="fa-solid fa-phone"></span></div>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-navy btn-sm">Submit</button>
                </form>
            </div>
            <!-- /.card-body -->
        </div>
    </div>
@endsection


@push('scripts')
    <script>
        $(document).ready(function() {
            $('#logo-upload').on('change', function() {
                const file = this.files[0];
                const previewImage = $('#preview-image');
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        previewImage.attr('src', e.target.result).show();
                    };
                    reader.readAsDataURL(file);
                } else {
                    previewImage.attr('src', '').hide();
                }
            });

            $("#phone").on('keyup', function(e) {
                const GETNUMBER = e.target.value;
                const bdPhoneNumberPattern = /^(?:\+8801|8801|01)[3-9]\d{8}$/;
                const isValidNumber = bdPhoneNumberPattern.test(GETNUMBER);
                if (isValidNumber) {
                    $(".phone_number_check_status").addClass("text-success").removeClass("text-danger");
                    $(".phone_number_check_status").html(
                        'Valid phone number <i class="fa-solid fa-check"></i>');
                } else {
                    $(".phone_number_check_status").removeClass("text-success").addClass("text-danger");
                    $(".phone_number_check_status").html(
                        'Invalid phone number <i class="fa-solid fa-xmark"></i>');
                }
            });


            $("#company_email").on('keyup', function(e) {
                const GETEmail = e.target.value;
                const regex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
                const isValidEmail = regex.test(GETEmail);
                if (isValidEmail) {
                    $(".company_email_check_status").addClass("text-success").removeClass("text-danger");
                    $(".company_email_check_status").html(
                        'Valid Email <i class="fa-solid fa-check"></i>');
                } else {
                    $(".company_email_check_status").removeClass("text-success").addClass("text-danger");
                    $(".company_email_check_status").html(
                        'Invalid Email <i class="fa-solid fa-xmark"></i>');
                }
            });



        });
    </script>
@endpush
