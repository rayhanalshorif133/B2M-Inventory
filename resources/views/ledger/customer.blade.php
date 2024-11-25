@extends('layouts.app', ['title' => 'Customer Ledger '])

@section('content')
    <div class="content-wrapper">


        <breadcrumb-component :title="'Customer Ledger '" :items="{{ json_encode(['home','Customer Ledger ']) }}">
        </breadcrumb-component>

        <customer-ledger-component></customer-ledger-component>

    </div>
@endsection
