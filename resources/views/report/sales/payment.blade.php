@extends('layouts.app', ['title' => 'Sales Report'])

@section('content')
    <div class="content-wrapper">


        <breadcrumb-component :title="'Sales Report'" :items="{{ json_encode(['home','Sales Report']) }}">
        </breadcrumb-component>

        <report-sales-payment-component :customers="{{ $customers }}"></report-sales-payment-component>
    </div>
@endsection
