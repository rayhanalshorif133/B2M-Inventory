@php
    $title = 'Add New Product';
@endphp
@extends('layouts.app', ['title' => $title])

@section('content')
    <div class="content-wrapper">
        @include(
            '_partials.breadcrumb',
            ['title' => $title],
            [
                'items' => [
                    ['name' => 'Home', 'url' => route('home')],
                    ['name' => 'Products', 'url' => route('product.list')],
                    ['name' => $title, 'url' => null],
                ],
            ]
        )

    </div>
@endsection
