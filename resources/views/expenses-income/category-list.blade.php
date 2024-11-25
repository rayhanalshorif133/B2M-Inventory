@extends('layouts.app', ['title' => 'Expencse Category'])

@section('content')
    <div class="content-wrapper">


        <breadcrumb-component :title="'Expencse Category'" :items="{{ json_encode(['home','Expencse Category']) }}">
        </breadcrumb-component>

        <expencse-category-list-component></Expencse-category-list-component>

    </div>
@endsection
