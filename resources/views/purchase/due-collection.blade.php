@extends('layouts.app', ['title' => 'Purchase Due Collection'])

@section('content')
    <div class="content-wrapper">


        <breadcrumb-component :title="'Purchase Due Collection'" :items="{{ json_encode(['home','Purchase Due Collection']) }}">
        </breadcrumb-component>

        <purchase-due-collection-component></purchase-due-collection-component>

    </div>
@endsection
