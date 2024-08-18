@extends('layouts.app', ['title' => 'Add new product'])

@section('content')
    <div class="content-wrapper">


        <breadcrumb-component :title="'Add new product'" :items="{{ json_encode(['home', 'list','add new product']) }}">
        </breadcrumb-component>

        <product-create-component></product-create-component>

    </div>
@endsection
