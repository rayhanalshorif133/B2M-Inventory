@extends('layouts.app', ['title' => 'User Profile'])

@section('content')
    <div class="content-wrapper">


        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">User Profile</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item">
                                <a href="{{ route('home') }}" class="text-capitalize">home</a>
                                <span class="text-gray"> / </span>
                                <span class="text-gray">User Profile</span>
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="mx-auto profile-container">
                        <div class="card">
                            <div class="card-header relative">

                                <div>
                                    <h3 class="card-title mt-2">About Me</h3>
                                    <button class="btn mt-1 updateProfileBtn d-none btn-success btn-sm float-right btn-tool"
                                        type="button">
                                        Update
                                        <i class="fa-solid fa-check"></i>
                                    </button>
                                </div>
                                <div class="absolute" style="top: 5rem; right: 10px">
                                    <button class="btn editProfileBtn btn-navy btn-sm float-right btn-tool" type="button">
                                        Edit Profile
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="card-body show_profile">
                                <div class="text-center">
                                    <img class="profile-user-img img-fluid img-circle" src="{{ asset($user->image) }}"
                                        alt="User profile picture" />
                                </div>
                                <h3 class="profile-username text-center">
                                    {{ $user->name }}
                                </h3>
                                <p class="text-muted text-center text-capitalize">
                                    <span class="badge badge-success">{{ $user->roles[0]->name }}</span>
                                </p>
                                <p class="text-muted text-center">
                                    <i class="fa-solid fa-envelope mr-1"> </i>{{ $user->email }}
                                </p>
                                <hr />
                                <strong>
                                    <i class="fa-solid fa-circle-info mr-1"></i>
                                    Company Info</strong>
                                <div class="company-info">
                                    <!-- Company Name -->
                                    <strong>
                                        <i class="fa-solid fa-building mr-1"></i>
                                        Name
                                    </strong>
                                    <p class="text-muted">
                                        {{ $user->company->name }}
                                    </p>

                                    <!-- Company Logo -->
                                    <strong>
                                        <i class="fa-solid fa-image mr-1"></i>
                                        Company Logo
                                    </strong>
                                    <p>
                                        <img src="{{ $user->company->logo }}" alt="Company Logo" class="company-logo" />
                                    </p>

                                    <!-- Company Email -->
                                    <strong>
                                        <i class="fa-solid fa-envelope mr-1"></i>
                                        Email
                                    </strong>
                                    <p class="text-muted">
                                        {{ $user->company->email }}
                                    </p>

                                    <!-- Company Address -->
                                    <strong>
                                        <i class="fa-solid fa-map-marker-alt mr-1"></i>
                                        Address
                                    </strong>
                                    <p class="text-muted">
                                        {{ $user->company->address }}

                                    </p>

                                    <!-- Company Phone -->
                                    <strong>
                                        <i class="fa-solid fa-phone mr-1"></i>
                                        Phone
                                    </strong>
                                    <p class="text-muted">
                                        {{ $user->company->phone }}

                                    </p>

                                    <!-- Other Info -->
                                    <strong>
                                        <i class="fa-solid fa-info-circle mr-1"></i>
                                        Other Info
                                    </strong>
                                    <p class="text-muted">
                                        {{ $user->company->other_info }}
                                    </p>
                                </div>
                            </div>
                            <div class="card-body edit_profile d-none">
                                <form action="{{ route('user.profile') }}" method="POST" enctype="multipart/form-data">
                                    @method('PUT')
                                    @csrf
                                    <input type="hidden" name="user_id" value="{{ $user->id }}" />
                                    <div class="text-left">
                                        <label class="required">Update Profile Image</label>
                                        <input type="file" class="form-control" name="profile_image" accept="image/*"
                                            id="imageProfileInput" />
                                        <p class="mt-2 text-muted d-none imagePreview_level">
                                            Preview:
                                        </p>
                                        <img id="imagePreview" alt="Company Logo Preview" class="image-preview d-none" />
                                    </div>

                                    <div class="text-left mt-2">
                                        <label class="required">User Name</label>
                                        <input type="text" name="user_name" class="form-control"
                                            value="{{ $user->name }}" />
                                    </div>
                                    <div class="text-left">
                                        <label class="required">User Role</label>
                                        <select class="form-control" name="user_role">
                                            @foreach ($roles as $role)
                                                <option value="{{ $role->name }}"
                                                    @if ($role->id == $user->roles[0]->id) selected @endif>
                                                    {{ $role->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="text-left mt-3">
                                        <!-- Email -->
                                        <label class="required">Email</label>
                                        <input type="email" class="form-control" name="user_email"
                                            value="{{ $user->email }}" />
                                    </div>
                                    <hr />
                                    <strong>
                                        <i class="fa-solid fa-circle-info mr-1"></i>
                                        Company Info</strong>
                                    <div class="company-info">
                                        <div class="text-left mt-3">
                                            <label class="required">Name</label>
                                            <input type="text" class="form-control" name="company_name"
                                                value="{{ $user->company->name }}" />
                                        </div>

                                        <!-- Company Logo -->
                                        <div class="text-left">
                                            <!-- Company Logo -->
                                            <label class="optional">Logo</label>
                                            <input type="file" class="form-control" accept="image/*"
                                                id="company_logoInput" name="company_logo" />
                                            <p class="mt-2 text-muted d-none company_logo_level">
                                                Preview:
                                            </p>
                                            <img id="company_logo" style="height: 150px; wight:auto"
                                                alt="Company Logo Preview" class="d-none" />
                                        </div>

                                        <!-- Company Email -->
                                        <div class="text-left mt-3">
                                            <label class="optional">Email</label>
                                            <input type="email" class="form-control" name="company_email"
                                                value="{{ $user->company->email }}" />
                                        </div>

                                        <!-- Company Address -->
                                        <div class="text-left mt-3">
                                            <label class="optional">Address</label>
                                            <input type="text" class="form-control"
                                                value="{{ $user->company->address }}" name="company_address" />
                                        </div>

                                        <!-- Company Phone -->
                                        <div class="text-left mt-3">
                                            <label class="optional">phone</label>
                                            <input type="text" class="form-control" name="company_phone"
                                                value="{{ $user->company->phone }}" />
                                        </div>
                                        <div class="text-left mt-3">
                                            <label class="optional">Other Information</label>
                                            <textarea class="form-control" rows="3" name="company_other_info">{{ $user->company->other_info }}</textarea>
                                        </div>
                                        <div class="d-flex">
                                            <button class="btn btn-navy btn-sm mt-5 mx-1" type="submit">
                                                Submit <i class="fa-solid fa-check"></i>
                                            </button>
                                            <button class="btn btn-danger btn-sm mt-5 mx-1" type="button">
                                                Cancel <i class="fa-solid fa-xmark"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </div>
@endsection


@push('scripts')
    <script>
        $(() => {
            fetchAuthData();

            $(".editProfileBtn").click(() => {
                $(".editProfileBtn").toggleClass('d-none');
                $(".show_profile").toggleClass('d-none');
                $(".updateProfileBtn").toggleClass('d-none');
                $(".edit_profile").toggleClass('d-none');
            });


            $('#imageProfileInput').change(function(e) {
                var file = e.target.files[0];
                var reader = new FileReader();

                reader.onload = function(event) {
                    $('#imagePreview').attr('src', event.target.result); // Show the image
                    $(".imagePreview_level").removeClass('d-none');
                    $("#imagePreview").removeClass('d-none');
                };

                if (file) {
                    reader.readAsDataURL(file);
                }
            });

            $('#company_logoInput').change(function(e) {
                var file = e.target.files[0];
                var reader = new FileReader();

                reader.onload = function(event) {
                    $('#company_logo').attr('src', event.target.result); // Show the image
                    $(".company_logo_level").removeClass('d-none');
                    $("#company_logo").removeClass('d-none');
                };

                if (file) {
                    reader.readAsDataURL(file);
                }
            });
        })
        const fetchAuthData = () => {
            axios.get("/user/fetch-auth").then((response) => {
                const data = response.data.data;
                console.log(data);
            });
        };
    </script>
@endpush
