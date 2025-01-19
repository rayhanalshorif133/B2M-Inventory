@php
    $title = 'Add New Product';
@endphp
@extends('layouts.app', ['title' => $title])

@section('content')
    <div class="content-wrapper">

        @include(
            '_partials.breadcrumb',
            ['title' => $title],
            [
                'items' => [
                    ['name' => 'Home', 'url' => route('home')],
                    ['name' => 'Products', 'url' => route('product.list')],
                    ['name' => $title, 'url' => null],
                ],
            ]
        )


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
            Toastr.fire({
                icon: "success",
                title: "Payment successful",
            });
            handleDataTable();
        });


        const handleDataTable = () => {
            $('#productList').DataTable().clear().destroy();
            url = '/product/list?type=fetch';
            $('#productList').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '/product/list?type=fetch', // Replace this with your API endpoint
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
                        data: 'name', // Display the product name
                        targets: 1
                    },
                    {
                        data: 'category.name', // Display the category name
                        targets: 2
                    },
                    {
                        data: 'sub_category.name', // Display the sub-category name
                        targets: 3
                    },
                    {
                        render: function(data, type, row) {
                            const status = `<span class="badge ${
                row.status == 1 ? "bg-success" : "bg-danger"
            }">
                ${row.status == 1 ? "Active" : "Inactive"}</span>`;
                            return status;
                        },
                        targets: 4
                    },
                    {
                        render: function(data, type, row) {
                            const btns = `
                <div class="btn-group">
                    <button type="button" class="btn btn-info btn-sm text-white showBtn"
                        data-id="${row.id}">
                        <i class="fa-regular fa-eye"></i> Show
                    </button>
                    <button type="button" class="btn statusBtn ${
                        row.status == 0 ? "btn-success" : "btn-danger"
                    } btn-sm text-white" data-id="${row.id}">
                        ${row.status == 0 ? "Activate" : "Deactivate"} <i class="fa-solid ${
                row.status == 0 ? "fa-check" : "fa-xmark"
            }"></i>
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
