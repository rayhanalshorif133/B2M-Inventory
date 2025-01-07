@php
    $title = 'Sales Payment List';
@endphp
@extends('layouts.app', ['title' => $title])

@section('content')
    <div class="content-wrapper">
        @include(
            '_partials.breadcrumb',
            ['title' => $title],
            [
                'items' => [['name' => 'Home', 'url' => route('home')], ['name' => $title, 'url' => null]],
            ]
        )

        <sales-payment-list-component></sales-payment-list-component>
        <section class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-header justify-content-between d-flex">
                        <h3 class="card-title">Sales list</h3>
                        <div class="ml-auto">
                            <button class="btn btn-sm btn-success mx-2" id="exportToExcel">
                                Export to Excel
                            </button>
                            <a class="btn btn-sm btn-success" href="/sales/create">
                                Create New Sales
                            </a>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive" style="width: 100%">
                            <table class="table table-bordered display table-hover nowrap" id="salesPaymentList"
                                style="width: 100%">
                                <thead>
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th style="width: 10px">Invoice Date</th>
                                        <th style="width: 10px">Customer Name</th>
                                        <th style="width: 10px">Payment Amount</th>
                                        <th style="width: 10px">Actions</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script>
        $(() => {

            handleDataTable();
        });


        const handleDataTable = () => {


            $('#salesPaymentList').DataTable().clear().destroy();
            url = '/sales/payment-list?fetch=1';
            $('#salesPaymentList').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '/sales/payment-list?fetch=1', // Replace this with your API endpoint
                    type: 'GET',
                    dataSrc: function(json) {
                        // Transform or filter data if necessary before passing to DataTable
                        return json.data; // Assuming the response has a 'data' field containing the array
                    }
                },
                dom: 'Bfrltip', // Add this line to include the buttons in the UI
                buttons: [{
                    extend: 'excel',
                    text: '<i class="fa-solid fa-file-excel"></i> Export to Excel',
                    className: 'exportToExcel d-none',
                    exportOptions: {
                        columns: ':not(:last-child)' // Excludes the last column
                    }
                }],
                columns: [{
                        render: function(data, type, row, meta) {
                            return meta.row + 1; // Display the row index (1-based)
                        },
                        targets: 0
                    },
                    {
                        render: function(data, type, row, meta) {
                            const date =
                                `<span>${row.created_date}</span> <span class="d-none">${row.receipt_no}</span>`;

                            return date; // Display the row index (1-based)
                        },
                        targets: 0
                    },
                    {
                        render: function(data, type, row, meta) {
                            return row.customer.name; // Display the row index (1-based)
                        },
                        targets: 0
                    },
                    {
                        render: function(data, type, row, meta) {
                            return row.amount; // Display the row index (1-based)
                        },
                        targets: 0
                    },
                    {
                        render: function(data, type, row) {
                            const btns = `<div class="btn-group">
                                    <a href="/payment/sales/pay-slip/${row.id}" type="button" class="btn btn-success btn-sm">
                                     <i class="fa-regular fa-eye"></i> Pay Slip
                                    </a>
                                    <button type="button" class="btn btn-info btn-sm paymentEditBtn btn-fit" data-id="${row.id}">
                                            <i class="fa-solid fa-pen-to-square"></i> Edit
                                    </button>
                                    <button type="button" class="btn btn-danger btn-sm">
                                    Delete <i class="fa-solid fa-trash"></i>
                                    </button>
                            </div>`;
                            return btns;
                        },
                        targets: 5
                    }
                ]
            });


        };
    </script>
@endpush
