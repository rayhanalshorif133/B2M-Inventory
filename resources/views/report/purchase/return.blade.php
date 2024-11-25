@extends('layouts.app', ['title' => 'Purchase Report Return'])

@section('content')
    <div class="content-wrapper">


        <breadcrumb-component :title="'Purchase Report Return'"
            :items="{{ json_encode(['home', 'Purchase Report Return']) }}">
        </breadcrumb-component>

        <report-purchase-return-component :suppliers="{{ $suppliers }}"></report-purchase-return-component>


</div>
@endsection
