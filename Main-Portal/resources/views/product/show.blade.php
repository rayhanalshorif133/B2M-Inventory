@extends('layouts.app', ['title' => 'Product List'])

@section('content')
    <div class="content-wrapper">


        <breadcrumb-component :title="'Product Details'" :items="{{ json_encode(['home', 'product', 'product details']) }}"></breadcrumb-component>
        <product-show-component></product-show-component>

    </div>
@endsection
