@extends('layouts.app', ['title' => 'Add New Sales'])

@section('content')
    <div class="content-wrapper">


        <breadcrumb-component :title="'Add New Sales'" :items="{{ json_encode(['home','add new sales']) }}">
        </breadcrumb-component>

        <sales-create-component></sales-create-component>

    </div>
@endsection
