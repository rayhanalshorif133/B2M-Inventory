@extends('layouts.app', ['title' => 'Add New Category'])

@section('content')
    <div class="content-wrapper">


        <breadcrumb-component :title="'Category'" :items="{{ json_encode(['home', 'category', 'add new category']) }}"></breadcrumb-component>
        <category-create-component></category-create-component>

    </div>
@endsection
