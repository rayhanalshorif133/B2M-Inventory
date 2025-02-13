@extends('layouts.app', ['title' => 'Dashboard'])

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center py-2">
            <div class="col-md-6 mx-auto">
                <div class="card shadow-lg">
                    <div class="card-body">
                        <h5 class="card-title text-center">Admin Profile</h5>
                        @if (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif

                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif
                        <form id="profileForm" action="{{ route('admin.profile') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ Auth::user()->name }}">
                            </div>
                            <div class="mb-3">
                                <label for="currentPassword" class="form-label">Current Password</label>

                                <div class="input-group">
                                    <input type="password" value="{{ old('current_password') }}" name="current_password"
                                        class="form-control" id="currentPassword" required>
                                    <button type="button" class="btn passIconBtn"><i class="fa-solid fa-eye"></i></button>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="newPassword" class="form-label">New Password</label>

                                <div class="input-group">
                                    <input type="password" value="{{ old('new_password') }}" name="new_password"
                                        class="form-control" id="newPassword" required>
                                    <button type="button" class="btn passIconBtn"><i class="fa-solid fa-eye"></i></button>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="confirmPassword" class="form-label">Confirm New Password</label>
                                <div class="input-group">
                                    <input type="password" value="{{ old('confrim_password') }}" name="confrim_password"
                                        class="form-control" id="confirmPassword" required>
                                    <button type="button" class="btn passIconBtn"><i class="fa-solid fa-eye"></i></button>
                                </div>
                            </div>
                            <div class="text-center w-100">
                                <button type="submit" id="editBtn" class="btn btn-primary w-100">Update</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


    </div>
@endsection


@push('scripts')
    <script>
        $(() => {
            $(".passIconBtn").click(function() {
                const INPUT = $(this).parent().find("input");
                const ICON = $(this).find("i");
                const TYPE = INPUT.attr('type') === 'password' ? 'text' : 'password';
                if (INPUT.attr('type') === 'password') {
                    INPUT.attr('type', 'text'); // পাসওয়ার্ড দেখানো
                    ICON.removeClass("fa-eye").addClass("fa-eye-slash"); // আইকন পরিবর্তন
                } else {
                    INPUT.attr('type', 'password'); // পাসওয়ার্ড লুকানো
                    ICON.removeClass("fa-eye-slash").addClass("fa-eye"); // আগের আইকন ফিরিয়ে আনা
                }
            });
        });
    </script>
@endpush
