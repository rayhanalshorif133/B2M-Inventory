@extends('layouts.app', ['title' => 'Sales List'])

@section('content')
    <div class="content-wrapper">


        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Sales List</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item">
                                <a href="{{ route('home') }}" class="text-capitalize">home</a>
                                <span class="text-gray"> / </span>
                                <span class="text-gray">Sales List</span>
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>


        <section class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-header justify-content-between d-flex">
                        <h3 class="card-title">Sales list</h3>
                        <div class="ml-auto">
                            {{-- click --}}
                            <button class="btn btn-sm btn-success mx-2" id="exportToExcel">
                                Export to Excel
                            </button>
                            <a class="btn btn-sm btn-success" href="/sales/create">
                                Create New Sales
                            </a>
                        </div>
                    </div>

                    <div class="card-body">
                        <table class="table table-bordered display table-hover" id="salesList">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Code</th>
                                    <th scope="col">Invoice Date</th>
                                    <th scope="col">Customer Name</th>
                                    <th scope="col">Total Amount</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>

        </section>



    </div>
@endsection


@push('scripts')
    <script>
        $(() => {
            url = '/sales/list?type=fetch';
            table = $('#salesList').DataTable({
                processing: true,
                serverSide: true,
                ajax: url,
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
                        render: function(data, type, row) {
                            return row.DT_RowIndex;
                        },
                        targets: 0,
                    },
                    {
                        render: function(data, type, row) {
                            return row.code;
                        },
                        targets: 0,
                    },

                    {
                        render: function(data, type, row) {
                            return row.invoice_date;
                        },
                        targets: 0,
                    },
                    {
                        render: function(data, type, row) {
                            var name = row.customer ? row.customer.name : "No Assign";
                            return name;
                        },
                        targets: 0,
                    },
                    {
                        render: function(data, type, row) {
                            return row.total_amount;
                        },
                        targets: 0,
                    }, {
                        render: function(data, type, row) {
                            const status = row.status == "0" ?
                                `<span class="badge badge-danger">Inactive</span>` :
                                `<span class="badge badge-success">Active</span>`;
                            return status;
                        },
                        targets: 0,
                    }, {
                        render: function(data, type, row) {
                            const btns = `
                    <div class="btn-group">
                        <button type="button" class="btn btn-success btn-sm showBtn btn-fit" data-id="${row.id}">
                         <i class="fa-regular fa-eye"></i> View
                        </button>
                        <a href="/sales/invoice/${row.id}" type="button" class="btn btn-primary btn-sm print btn-fit">
                         <i class="fa-solid fa-print"></i> Print
                        </a>
                        <button type="button" class="btn btn-danger btn-sm deleteBtn btn-fit" data-id="${row.id}">
                            <i class="fa-solid fa-trash"></i> Delete
                        </button>
                    </div>`;
                            return btns;
                        },
                        targets: 0,
                    },
                ]
            });
            $("#exportToExcel").click(() => $(".exportToExcel").click());
        });

    </script>
@endpush
