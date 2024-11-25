@extends('layouts.app', ['title' => 'Sales List'])

@section('content')
    <div class="content-wrapper">


        <breadcrumb-component :title="'Sales Due Collection'" :items="{{ json_encode(['home','Sales Due Collection']) }}">
        </breadcrumb-component>

        <sales-due-collection-component></sales-due-collection-component>

    </div>
@endsection
