@extends('layouts.auth', ['title' => 'Register a new account'])

@section('content')
    <div class="register-box" id="auth">
        <div class="card card-outline card-primary mt-5">
            <div class="card-header text-center">
                <a href="#" class="h1 underline-none"><b>INVENTORY</b></a>
            </div>
            <div class="card-body">
                <p class="register-msg-box">Register as a new member</p>
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                <form action="{{ route('auth.register') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <div class="card card-outline p-3 card-info">
                        <h2 class="text-sm font-semibold">Company Info</h2>
                        <div class="row">
                            <div class="col-md-6 col-12">
                                <!-- Company Name -->
                                <label for="company_name" class="form-label required">Name</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="company_name" id="company_name"
                                        placeholder="Name" value="{{ old('company_name') }}">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <span class="fa-solid fa-building"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 col-12">
                                <!-- Company Logo Upload -->
                                <label for="company_logo" class="form-label optional">Logo</label>
                                <div class="input-group">
                                    <label for="logo-upload" class="btn logo-upload-btn" style="width: 87%;">
                                        <span>Upload Your Company Logo</span>
                                    </label>
                                    <input type="file" class="d-none form-control" name="logo" id="logo-upload"
                                        accept="image/*">
                                    <div class="input-group-append cursor-pointer">
                                        <label class="input-group-text cursor-pointer" for="logo-upload"
                                            style="height: fit-content; padding: 10px;">
                                            <span class="fa fa-upload"></span>
                                        </label>
                                    </div>
                                </div>
                                <div id="logo-preview" style="margin-top: 10px;">
                                    <img src="" alt="Logo Preview" id="preview-image"
                                        style="max-width: 200px; max-height: 200px; display: none;">
                                </div>
                            </div>

                            <div class="col-md-6 col-12">
                                <!-- Email -->
                                <label for="company_email" class="form-label required">Email</label>
                                <div class="input-group">
                                    <input type="email" class="form-control" name="company_email" id="company_email"
                                        placeholder="Email" value="{{ old('company_email') }}">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <span class="fa-solid fa-envelope"></span>
                                        </div>
                                    </div>
                                </div>
                                <small class="company_email_check_status" style="font-weight: 700"></small>
                            </div>

                            <div class="col-md-6 col-12">
                                <!-- Company Address -->
                                <label for="address" class="form-label required">Company Address</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" name="company_address" id="address"
                                        placeholder="Address" value="{{ old('company_address') }}">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <span class="fa-solid fa-location-dot"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6 col-12">
                                <!-- Phone Number -->
                                <label for="phone" class="form-label required">Phone Number</label>
                                <div class="input-group">
                                    <input type="number" class="form-control" id="phone" name="company_phone"
                                        placeholder="Contact number" value="{{ old('company_phone') }}">
                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <span class="fa-solid fa-phone"></span>
                                        </div>
                                    </div>
                                </div>

                                <small class="phone_number_check_status" style="font-weight: 700"></small>

                            </div>


                        </div>
                        <label for="company_name" class="form-label optional">Other Information</label>
                        <div class="input-group mb-3">
                            <textarea type="text" class="form-control" name="other_info" placeholder="Others information">{{ old('other_info') }}</textarea>
                            <div class="input-group-append">
                                <div class="input-group-text"><span class="fa-solid fa-circle-info"></span></div>
                            </div>
                        </div>
                    </div>
                    <div class="card card-outline p-3 card-green mt-2">
                        <h2 class="text-sm font-semibold">User Info</h2>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="user_name" class="form-label required">User Name</label>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" placeholder="Enter your name"
                                        id="user_name" name="user_name" value="{{ old('user_name') }}">
                                    <div class="input-group-append">
                                        <div class="input-group-text"><span class="fas fa-user"></span></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="user_email" class="form-label required">User Email</label>
                                <div class="input-group mb-3"><input type="email" id="user_email" name="user_email"
                                        class="form-control" placeholder="Email" value="{{ old('user_email') }}">
                                    <div class="input-group-append">
                                        <div class="input-group-text"><span class="fas fa-envelope"></span></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="user_password" class="form-label required">Password</label>
                                <div class="input-group mb-3">
                                    <input type="password" class="form-control" id="user_password" name="user_password"
                                        placeholder="Password">
                                    <div class="input-group-append password">
                                        <div class="input-group-text cursor-pointer">
                                            <span class="fa-solid fa-unlock icon-btn"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="user_password" class="form-label required">Confirm Password</label>
                                <div class="input-group mb-3">
                                    <input type="password" class="form-control " placeholder="Confirm Password"
                                        name="user_confirm_password" required="">
                                    <div class="input-group-append password">
                                        <div class="input-group-text cursor-pointer"><span
                                                class="fa-solid fa-unlock icon-btn"></span></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-2"><!-- /.col -->
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-block">Register Now</button>
                        </div><!-- /.col -->
                    </div>
                </form>

                <p class="mb-0 mx-auto text-center mt-2">
                    Already signed in?
                    <a href="{{ route('auth.login') }}" class="text-center">Login Now</a>
                </p>
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
