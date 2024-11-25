@extends('layouts.app', ['title' => 'Dashboard'])

@section('content')
    <div class="content-wrapper">


        <breadcrumb-component :title="'Supplier List'" :items="{{ json_encode(['home', 'Supplier List']) }}">
        </breadcrumb-component>
        <supplier-list-component></supplier-list-component>

    </div>
@endsection
