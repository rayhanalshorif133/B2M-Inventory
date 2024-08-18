@extends('layouts.app', ['title' => 'Add New Purchase'])

@section('content')
    <div class="content-wrapper">


        <breadcrumb-component :title="'Add New Purchase'" :items="{{ json_encode(['home','add new purchase']) }}">
        </breadcrumb-component>

        <purchase-create-component></purchase-create-component>

    </div>
@endsection
