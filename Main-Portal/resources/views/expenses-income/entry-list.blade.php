@extends('layouts.app', ['title' => 'Expencse Income'])

@section('content')
    <div class="content-wrapper">


        <breadcrumb-component :title="'Expencse & Income'" :items="{{ json_encode(['home','Expencse & Income']) }}">
        </breadcrumb-component>

        <expencse-income-list-component></Expencse-income-list-component>

    </div>
@endsection
