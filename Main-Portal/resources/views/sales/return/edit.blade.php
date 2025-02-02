@extends('layouts.app', ['title' => 'Sales Update'])

@section('content')
    <div class="content-wrapper">


        <breadcrumb-component :title="'Sales Return Update'" :items="{{ json_encode(['home','Update sales return']) }}">
        </breadcrumb-component>

        <sales-return-edit-component></sales-return-edit-component>

    </div>
@endsection
