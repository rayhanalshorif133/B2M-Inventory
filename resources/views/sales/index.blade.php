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
                        <div class="table-responsive">
                            <table class="table table-bordered display table-hover nowrap" id="salesList"
                                style="width: 100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Code</th>
                                        <th>Invoice Date</th>
                                        <th>Customer Name</th>
                                        <th>Total Amount</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <div class="modal fade" id="showSalesDetails" tabindex="-1" aria-labelledby="showSalesDetailsLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header" style="height: 50px">
                        <h5 class="modal-title" id="showSalesDetailsLabel">
                            Sales Details
                            <a class="btn btn-sm btn-outline-primary salesEditLink" href="#">
                                <i class="fa-solid fa-pen" aria-hidden="true"></i>
                                Edit
                            </a>
                        </h5>
                        <button type="button" class="btn-close text-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <h5><b>Sales Info:</b></h5>
                            <p class="col-md-4 col-sm-2"><b>Code:</b> <span id="salesCode"></span></p>
                            <p class="col-md-4 col-sm-2"><b>Invoice Date:</b> <span id="invoiceDate"></span></p>
                            <p class="col-md-4 col-sm-2"><b>Total Amount:</b> <span id="totalAmount"></span></p>
                            <p class="col-md-4 col-sm-2"><b>Paid Amount:</b> <span id="paidAmount"></span></p>
                            <p class="col-md-4 col-sm-2"><b>Due Amount:</b> <span id="dueAmount"></span></p>
                            <p class="col-md-4 col-sm-2"><b>Note:</b> <span id="salesNote"></span></p>
                            <hr />
                            <h5><b>Sales Details:</b></h5>
                            <table class="table px-2">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Particulars</th>
                                        <th scope="col" style="width: 7rem">Qty</th>
                                        <th scope="col">Sales</th>
                                        <th scope="col" style="width: 7rem">Discount</th>
                                        <th scope="col">Total</th>
                                    </tr>
                                </thead>
                                <tbody id="salesDetailsBody"></tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="5" class="text-end"><b>Total :</b></td>
                                        <td colspan="2" class="text-start"><span id="finalTotal"></span> tk</td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary text-white" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

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
                                    <button type="button" class="btn btn-success btn-sm showBtn btn-fit" data-id="${row.id}" data-bs-toggle="modal" data-bs-target="#showSalesDetails">
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

            $(document).on("click", ".showBtn", function() {
                const id = $(this).data("id");

                axios.get(`/sales/fetch/${id}`).then((response) => {
                    $(".salesEditLink").attr("href", `/sales/${id}/edit`);
                    const {
                        sales,
                        salesDetails
                    } = response.data.data;

                    $("#salesCode").text(sales.code);
                    $("#invoiceDate").text(sales.invoice_date);
                    $("#totalAmount").text("৳ " + sales.total_amount);
                    $("#paidAmount").text("৳ " + sales.paid_amount);
                    $("#dueAmount").text("৳ " + sales.due_amount);
                    $("#salesNote").text(sales.note);

                    // salesDetailsBody
                    $('#salesDetailsBody').empty();
                    var finalTotal = 0;

                    // Insert rows into the table body
                    $.each(salesDetails, function(index, item) {
                        console.log(item)
                        const row = `
                            <tr>
                                <td>${index + 1}</td>
                                <td>
                                    ${item.product_attribute.code}<br>
                                    ${item.product.name}
                                    ${item.product_attribute.model != null ? '|' + item.product_attribute.model : ''}
                                    ${item.product_attribute.color != null ? '|' + item.product_attribute.color : ''}<br>
                                </td>
                                <td>${item.qty}</td>
                                <td>${item.sales_rate} tk</td>
                                <td>${item.discount} tk</td>
                                <td>${item.total} tk</td>
                            </tr>
                        `;
                        $('#salesDetailsBody').append(row);
                        finalTotal += item.total;
                    });
                    $("#finalTotal").text(finalTotal);
                });
            });

        });
    </script>
@endpush
