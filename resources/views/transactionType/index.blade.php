@extends('layouts.app', ['title' => 'Dashboard'])

@section('content')
    <div class="content-wrapper">


        <breadcrumb-component :title="'Transaction Type'" :items="{{ json_encode(['home', 'Transaction Type']) }}">
        </breadcrumb-component>
        <transaction-type-list-component></transaction-type-list-component>

    </div>
@endsection
