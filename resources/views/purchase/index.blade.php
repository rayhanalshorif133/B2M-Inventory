@extends('layouts.app', ['title' => 'Purchase List'])

@section('content')
    <div class="content-wrapper">


        <breadcrumb-component :title="'Purchase List'" :items="{{ json_encode(['home','Purchase List']) }}">
        </breadcrumb-component>

        <purchase-list-component></purchase-list-component>

    </div>
@endsection
