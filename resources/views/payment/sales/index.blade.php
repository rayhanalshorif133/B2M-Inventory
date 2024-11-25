@extends('layouts.app', ['title' => 'Sales Payment'])

@section('content')
    <div class="content-wrapper">


        <breadcrumb-component :title="'Sales Payment'" :items="{{ json_encode(['home', 'Sales Payment']) }}"></breadcrumb-component>
        <sales-payment-create-component></sales-payment-create-component>

    </div>
@endsection
