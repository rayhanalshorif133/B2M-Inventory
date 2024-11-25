@extends('layouts.app', ['title' => 'Sales Report Return'])

@section('content')
    <div class="content-wrapper">


        <breadcrumb-component :title="'Sales Report Return'" :items="{{ json_encode(['home', 'Sales Report Return']) }}">
        </breadcrumb-component>

        <report-sales-return-component :customers="{{ $customers }}"></report-sales-return-component>



    </div>
@endsection
