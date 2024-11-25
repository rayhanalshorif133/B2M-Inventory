@extends('layouts.app', ['title' => 'Purchase Report'])

@section('content')
    <div class="content-wrapper">


        <breadcrumb-component :title="'Purchase Report'" :items="{{ json_encode(['home','Purchase Report']) }}">
        </breadcrumb-component>

        <report-purchase-component :suppliers="{{ $suppliers }}"></report-purchase-component>

    </div>
@endsection
