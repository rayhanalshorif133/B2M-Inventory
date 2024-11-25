@extends('layouts.app', ['title' => $title . ' Payment Update'])

@section('content')
    <div class="content-wrapper">
        <breadcrumb-component :title="'Update Payment'" :items="{{ json_encode(['home', $title . ' Payment Update']) }}"></breadcrumb-component>
        <payment-edit-component></payment-edit-component>
    </div>
@endsection
