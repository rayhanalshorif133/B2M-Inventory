@extends('layouts.app', ['title' => 'Purchase Return'])

@section('content')
    <div class="content-wrapper">


        <breadcrumb-component :title="'Purchase Return List'" :items="{{ json_encode(['home','Purchase Return List']) }}">
        </breadcrumb-component>

        <purchase-return-list-component></purchase-return-list-component>

    </div>
@endsection
