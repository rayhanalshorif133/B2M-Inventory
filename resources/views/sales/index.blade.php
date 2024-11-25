@extends('layouts.app', ['title' => 'Sales List'])

@section('content')
    <div class="content-wrapper">


        <breadcrumb-component :title="'Sales List'" :items="{{ json_encode(['home','Sales List']) }}">
        </breadcrumb-component>

        <sales-list-component></sales-list-component>

    </div>
@endsection
