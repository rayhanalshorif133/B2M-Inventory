@extends('layouts.app', ['title' => 'Dashboard'])

@section('content')
    <div class="content-wrapper">


        <breadcrumb-component :title="'Dashboard'" :items="{{ json_encode(['home', 'dashboard']) }}"></breadcrumb-component>
        <dashboard-component></dashboard-component>

    </div>
@endsection
