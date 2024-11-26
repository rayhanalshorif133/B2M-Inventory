@extends('layouts.app', ['title' => 'User Profile'])

@section('content')
    <div class="content-wrapper">


        <breadcrumb-component :title="'User'"
            :items="{{ json_encode(['home', 'user profile']) }}"></breadcrumb-component>
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="mx-auto profile-container">
                        <div class="card">
                            <div class="card-header relative">
                                <h3 class="card-title mt-2">About Me</h3>
                                <div class="absolute" style="top: 5rem; right: 10px">
                                    <button class="btn editProfileBtn btn-success btn-sm float-right btn-tool" type="button">
                                        Edit Profile
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="card-body show_profile">
                                <div class="text-center">
                                    <img class="profile-user-img img-fluid img-circle" src="{{ $user->image }}"
                                        alt="User profile picture" />
                                </div>
                                <h3 class="profile-username text-center">
                                    {{ $user->name }}
                                </h3>
                                <p class="text-muted text-center text-capitalize">
                                    <span class="badge badge-success">{{ $user->role }}</span>
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
                                <div class="text-left">
                                    <label class="required">Update Profile Image</label>
                                    <input type="file" class="form-control" accept="image/*" />
                                    <p class="mt-2 text-muted">
                                        Preview:
                                    </p>
                                    <img :src="profileImagePreview" alt="Profile Image Preview" class="image-preview" />
                                </div>

                                <div class="text-left">
                                    <label class="required">User Name</label>
                                    <input type="text" class="form-control" />
                                </div>
                                <div class="text-left">
                                    <label class="required">User Role</label>
                                    <select class="form-control">
                                        @foreach ($roles as $role)
                                            <option value="{{ $role->id }}">
                                                {{ $role->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="text-left mt-3">
                                    <!-- Email -->
                                    <label class="required">Email</label>
                                    <input type="email" class="form-control" />
                                </div>
                                <hr />
                                <strong>
                                    <i class="fa-solid fa-circle-info mr-1"></i>
                                    Company Info</strong>
                                <div class="company-info">
                                    <div class="text-left mt-3">
                                        <label class="required">Name</label>
                                        <input type="text" class="form-control" />
                                    </div>

                                    <!-- Company Logo -->
                                    <div class="text-left">
                                        <!-- Company Logo -->
                                        <label class="optional">Logo</label>
                                        <input type="file" class="form-control" accept="image/*" />
                                        <p class="mt-2 text-muted">
                                            Preview:
                                        </p>
                                        <img src="logoPreview" alt="Company Logo Preview" class="image-preview" />
                                    </div>

                                    <!-- Company Email -->
                                    <div class="text-left mt-3">
                                        <label class="optional">Email</label>
                                        <input type="email" class="form-control" />
                                    </div>

                                    <!-- Company Address -->
                                    <div class="text-left mt-3">
                                        <label class="optional">Address</label>
                                        <input type="text" class="form-control" />
                                    </div>

                                    <!-- Company Phone -->
                                    <div class="text-left mt-3">
                                        <label class="optional">phone</label>
                                        <input type="text" class="form-control" />
                                    </div>
                                    <div class="text-left mt-3">
                                        <label class="optional">Other Information</label>
                                        <textarea class="form-control" rows="3"></textarea>
                                    </div>
                                    <div class="d-flex">
                                        <button class="btn btn-navy btn-sm mt-5 mx-1" type="button">
                                            Submit <i class="fa-solid fa-check"></i>
                                        </button>
                                        <button class="btn btn-danger btn-sm mt-5 mx-1" type="button">
                                            Cancel <i class="fa-solid fa-xmark"></i>
                                        </button>
                                    </div>
                                </div>
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
                $(".show_profile").toggleClass('d-none');
                $(".edit_profile").toggleClass('d-none');
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
