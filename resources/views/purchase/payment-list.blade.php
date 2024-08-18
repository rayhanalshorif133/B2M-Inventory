@extends('layouts.app', ['title' => 'Purchase Payment List'])

@section('content')
    <div class="content-wrapper">


        <breadcrumb-component :title="'Purchase Payment List'" :items="{{ json_encode(['home','Purchase Payment List']) }}">
        </breadcrumb-component>

        <purchase-payment-list-component></purchase-payment-list-component>

    </div>
@endsection
