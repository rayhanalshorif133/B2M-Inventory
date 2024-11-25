@extends('layouts.app', ['title' => 'Sales Return'])

@section('content')
    <div class="content-wrapper">


        <breadcrumb-component :title="'Sales Return'" :items="{{ json_encode(['home','Sales Return']) }}">
        </breadcrumb-component>

        <sales-return-create-component></sales-return-create-component>

    </div>
@endsection
