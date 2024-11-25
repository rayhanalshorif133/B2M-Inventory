@extends('layouts.app', ['title' => 'Sales Payment List'])

@section('content')
    <div class="content-wrapper">


        <breadcrumb-component :title="'Sales Payment List'" :items="{{ json_encode(['home','Sales Payment List']) }}">
        </breadcrumb-component>

        <sales-payment-list-component></sales-payment-list-component>

    </div>
@endsection
