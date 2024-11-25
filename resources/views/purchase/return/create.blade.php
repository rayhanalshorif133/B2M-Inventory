@extends('layouts.app', ['title' => 'Purchase Return'])

@section('content')
    <div class="content-wrapper">


        <breadcrumb-component :title="'Purchase Return'" :items="{{ json_encode(['home','Purchase Return']) }}">
        </breadcrumb-component>

        <purchase-return-create-component></purchase-return-create-component>

    </div>
@endsection
