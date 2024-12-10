@extends('layouts.app', ['title' => 'Category List'])

@section('content')
    <div class="content-wrapper overflow-x-hidden">
        <breadcrumb-component :title="'Category List'" :items="{{ json_encode(['home', 'category', 'Category List']) }}"></breadcrumb-component>
        <category-list-component></category-list-component>
    </div>
@endsection
