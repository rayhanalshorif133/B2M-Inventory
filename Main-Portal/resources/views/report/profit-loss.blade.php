@extends('layouts.app', ['title' => 'Profit & Loss Report'])

@section('content')
    <div class="content-wrapper">


        <breadcrumb-component :title="'Profit & Loss Report'" :items="{{ json_encode(['home','Profit & Loss']) }}">
        </breadcrumb-component>

        <report-profit-loss-component></report-profit-loss-component>

    </div>
@endsection
