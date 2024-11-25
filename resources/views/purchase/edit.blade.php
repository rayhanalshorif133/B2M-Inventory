@extends('layouts.app', ['title' => 'Purchase Update'])

@section('content')
    <div class="content-wrapper">


        <breadcrumb-component :title="'Purchase Update'" :items="{{ json_encode(['home','update purchase']) }}">
        </breadcrumb-component>

        <purchase-edit-component></purchase-edit-component>

    </div>
@endsection
