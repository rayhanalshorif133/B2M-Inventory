@extends('layouts.app', ['title' => 'Dashboard'])

@section('head')

@endsection

@section('content')
    <div class="content-wrapper">


        <breadcrumb-component :title="'Customer List'" :items="{{ json_encode(['home', 'Customer List']) }}">
        </breadcrumb-component>
        <customer-list-component></customer-list-component>
    </div>
@endsection
