@extends('layouts.app', ['title' => 'User Profile'])

@section('content')
    <div class="content-wrapper">


        <breadcrumb-component :title="'User'" :items="{{ json_encode(['home', 'user profile']) }}"></breadcrumb-component>
        <user-profile-component></user-profile-component>

    </div>
@endsection
