@extends('layouts.app', ['title' => 'Sales Return'])

@section('content')
    <div class="content-wrapper">


        <breadcrumb-component :title="'Sales Return List'" :items="{{ json_encode(['home','Sales Return List']) }}">
        </breadcrumb-component>

        <sales-return-list-component></sales-return-list-component>

    </div>
@endsection
