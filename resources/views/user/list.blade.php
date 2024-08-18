@extends('layouts.app', ['title' => 'User List'])

@section('content')
    <div class="content-wrapper">


        <breadcrumb-component :title="'User'" :items="{{ json_encode(['home', 'user list']) }}"></breadcrumb-component>
        <user-list-component></user-list-component>

    </div>
@endsection
