@extends('layouts.app', ['title' => 'Add New User'])

@section('content')
    <div class="content-wrapper">


        <breadcrumb-component :title="'User'" :items="{{ json_encode(['home', 'user', 'add new user']) }}"></breadcrumb-component>
        <user-create-component></user-create-component>

    </div>
@endsection
