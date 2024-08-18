@extends('layouts.app', ['title' => 'Purchase Payment'])

@section('content')
    <div class="content-wrapper">


        <breadcrumb-component :title="'Purchase Payment'" :items="{{ json_encode(['home', 'Purchase Payment']) }}"></breadcrumb-component>
        <purchase-payment-create-component></purchase-payment-create-component>

    </div>
@endsection
