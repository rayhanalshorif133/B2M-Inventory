@extends('layouts.app', ['title' => 'Expencse head'])

@section('content')
    <div class="content-wrapper">


        <breadcrumb-component :title="'Expencse Head'" :items="{{ json_encode(['home','Expencse Head']) }}">
        </breadcrumb-component>

        <expencse-head-list-component></Expencse-head-list-component>

    </div>
@endsection
