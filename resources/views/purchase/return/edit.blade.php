@extends('layouts.app', ['title' => 'Purchase Update'])

@section('content')
    <div class="content-wrapper">


        <breadcrumb-component :title="'Purchase Return Update'" :items="{{ json_encode(['home','Update purchase return']) }}">
        </breadcrumb-component>

        <purchase-return-edit-component></purchase-return-edit-component>

    </div>
@endsection
