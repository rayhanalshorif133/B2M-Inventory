@php
    $title = 'Purchase List';
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

        <purchase-list-component></purchase-list-component>

        <section class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-header justify-content-between d-flex">
                        <h3 class="card-title">Sales list</h3>
                        <div class="ml-auto">
                            <button class="btn btn-sm btn-success mx-2" id="exportToExcel">
                                Export to Excel
                            </button>
                            <a class="btn btn-sm btn-success" href="/purchase/create">
                                Create New Purchase
                            </a>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive" style="width: 100%">
                            <table class="table table-bordered display table-hover nowrap" id="purchasesList"
                                style="width: 100%">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Code</th>
                                        <th scope="col">Invoice Date</th>
                                        <th scope="col">Supplier Name</th>
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
            </div>
        </section>

    </div>
@endsection

@push('scripts')
    <script>
        $(() => {
            // Toastr.fire({
            //     icon: "success",
            //     title: "Payment successful",
            // });
            handleDataTable();
        });




        const handleDataTable = () => {
            $('#purchasesList').DataTable().clear().destroy();
            url = '/purchase/list?type=fetch';
            $('#purchasesList').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: url, // Replace this with your API endpoint
                    type: 'GET',
                    dataSrc: function(json) {
                        return json.data;
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
                            return row.code; // Display the row index (1-based)
                        },
                        targets: 0
                    },
                    {
                        render: function(data, type, row, meta) {
                            return row.invoice_date; // Display the row index (1-based)
                        },
                        targets: 0
                    },
                    {
                        render: function(data, type, row, meta) {
                            var name = row.supplier ? row.supplier.name : "No Assign";
                            return name; // Display the row index (1-based)
                        },
                        targets: 0
                    },
                    {
                        render: function(data, type, row, meta) {
                            return row.total_amount; // Display the row index (1-based)
                        },
                        targets: 0
                    },
                    {
                        render: function(data, type, row) {
                            const status =
                                row.status == "0" ?
                                `<span class="badge badge-danger">Inactive</span>` :
                                `<span class="badge badge-success">Active</span>`;
                            return status;
                        },
                        targets: 4
                    },
                    {
                        render: function(data, type, row) {
                            const btns = `
                    <div class="btn-group">
                        <button type="button" class="btn btn-success btn-sm showBtn btn-fit" data-id="${row.id}">
                         <i class="fa-regular fa-eye"></i> View
                        </button>
                        <a href="/purchase/invoice/${row.id}" type="button" class="btn btn-primary btn-sm print btn-fit">
                         <i class="fa-solid fa-print"></i> Print
                        </a>
                        <button type="button" class="btn btn-danger btn-sm deleteBtn btn-fit" data-id="${row.id}">
                            <i class="fa-solid fa-trash"></i> Delete
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
