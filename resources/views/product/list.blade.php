@extends('layouts.app', ['title' => 'Product List'])

@section('content')
    <div class="content-wrapper">


        <breadcrumb-component :title="'Product List'" :items="{{ json_encode(['home', 'product']) }}"></breadcrumb-component>
        <product-list-component></product-list-component>

    </div>
@endsection
