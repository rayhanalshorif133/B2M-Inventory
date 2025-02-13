@extends('layouts.app', ['title' => 'Dashboard'])

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center py-2">
            <div class="col-md-3">
                <div class="card text-white bg-primary shadow-lg mb-3" style="width: 18rem;">
                    <div class="card-body text-center">
                        <i class="fa-solid fa-users fa-3x mb-2"></i>
                        <h5 class="card-title">User Count</h5>
                        <p class="card-text display-5 fw-bold">{{ $user_logs }}</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-success shadow-lg mb-3" style="width: 18rem;">
                    <div class="card-body text-center">
                        <i class="fa-solid fa-person-walking-arrow-loop-left fa-3x mb-2"></i>
                        <h5 class="card-title">Guest User Acivity Count</h5>
                        <p class="card-text display-5 fw-bold">{{ $user_acivity }}</p>
                    </div>
                </div>
            </div>
        </div>


    </div>
@endsection
