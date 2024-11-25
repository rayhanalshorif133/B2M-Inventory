@extends('layouts.app', ['title' => 'Current Stocks'])

@section('content')
    <div class="content-wrapper">


        <breadcrumb-component :title="'Current Stocks'" :items="{{ json_encode(['home','Current Stocks']) }}">
        </breadcrumb-component>

        <report-current-stock-component></report-current-stock-component>

    </div>
@endsection
