@extends('layouts.app', ['title' => 'Add New User'])

@section('content')
    <div class="content-wrapper">


        <breadcrumb-component :title="'User'"
            :items="{{ json_encode(['home', 'user', 'add new user']) }}"></breadcrumb-component>

        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Create a new User</h3>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('user.create') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name" class="required">User Name</label>
                                            <input type="text" id="name" class="form-control" name="name"
                                                placeholder="Enter your name" value="{{ old('name') }}" />
                                            @error('name')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="profile_image" class="optional">Profile Image</label>
                                            <input type="file" id="profile_image" class="form-control"
                                                name="profile_image" accept="image/*" />
                                            @error('profile_image')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="email" class="required">User Email</label>
                                            <input type="email" id="email" class="form-control" name="email"
                                                placeholder="Enter your email" value="{{ old('email') }}" />
                                            @error('email')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="password" class="required">Password</label>
                                            <input type="password" id="password" class="form-control" name="password"
                                                placeholder="Enter your password" />
                                            @error('password')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="confirm_password" class="required">Confirm password</label>
                                            <input type="password" id="confirm_password" class="form-control"
                                                name="confirm_password" placeholder="Enter your confirm password" />
                                            @error('confirm_password')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="role">Role</label>
                                            <select id="role" class="form-control custom-select" name="role"
                                                required>
                                                <option selected disabled>Select role</option>
                                                @foreach ($roles as $role)
                                                    <option value="{{ $role->name }}"
                                                        {{ old('role') == $role->id ? 'selected' : '' }}>
                                                        {{ $role->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('role')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <button class="btn btn-primary btn-sm" type="submit">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>


    </div>
@endsection
