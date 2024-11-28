@extends('layouts.app', ['title' => 'Sales Update'])

@section('content')
    <div class="content-wrapper">

        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Sales Update</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item">
                                <a href="{{ route('home') }}" class="text-capitalize">home</a>
                                <span class="text-gray"> / </span>
                                <span class="text-gray">Sales Update</span>
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <section class="content overflow-x-hidden">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">Update Sales</h3>
                        </div>
                        <div class="card-body">
                            <form>
                                <div class="row">
                                    <div class="col-12 col-md-7 col-lg-7">
                                        <div class="form-group d-flex">
                                            <label for="customer" class="d-flex mx-1">Customer
                                                <span class="text-danger mx-1">*</span></label>
                                            <select class="form-control" id="customer">
                                                @foreach ($customers as $customer)
                                                    <option value="{{ $customer->id }}">
                                                        {{ $customer->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-5 col-lg-5">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <button data-toggle="modal" data-target="#addNewCustomer"
                                                    class="btn btn-navy btn-sm h-2" type="button">
                                                    <i class="fa fa-plus"></i> Add
                                                    New
                                                </button>
                                            </div>
                                            <div class="col-md-8 d-flex">
                                                <label for="invoice_date" class="d-flex mx-1 w-8rem">Invoice Time:
                                                    <span class="text-danger mx-1">*</span></label>
                                                <input type="date" id="invoice_date" class="form-control w-10rem" />
                                            </div>
                                        </div>
                                        @include('sales._partials.addNewSupplierModal', ['customers' => $customers])

                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>



    </div>
@endsection
