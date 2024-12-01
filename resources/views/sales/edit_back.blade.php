@extends('layouts.app', ['title' => 'Sales Update'])

@section('content')
    <div class="content-wrapper">


        <breadcrumb-component :title="'Sales Update'" :items="{{ json_encode(['home','update sales']) }}">
        </breadcrumb-component>

        <sales-edit-component></sales-edit-component>

    </div>
@endsection
