@extends('layouts.app', ['title' => 'Sales Return'])

@section('content')
    <div class="content-wrapper">




        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Sales Return List</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item">
                                <a href="{{ route('home') }}" class="text-capitalize">home</a>
                                <span class="text-gray"> / </span>
                                <span class="text-gray">Sales Return List</span>
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        {{-- <sales-return-list-component></sales-return-list-component> --}}

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
                            <table class="table table-bordered display table-hover nowrap" id="salesReturnList"
                                style="width: 100%">
                                <thead>
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th>Code</th>
                                        <th>Invoice Date</th>
                                        <th>Customer Name</th>
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

        <div class="modal fade" id="showReturnSalesDetails" tabindex="-1" aria-labelledby="showReturnSalesDetailsLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header" style="height: 50px">
                        <h5 class="modal-title" id="showReturnSalesDetailsLabel">
                            Sales Return Details
                            <a class="btn btn-sm btn-outline-primary" href="#" id="editSalesReturn">
                                <i class="fa-solid fa-pen" aria-hidden="true"></i> Edit
                            </a>
                        </h5>
                        <button type="button" class="btn-close text-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div id="salesReturnData" class="row">
                            <h5><b>Purchase Info: </b></h5>
                            <p class="col-md-4 col-sm-2"><b>Code:</b> <span id="salesReturnCode"></span></p>
                            <p class="col-md-4 col-sm-2"><b>Invoice Date:</b> <span id="invoiceDate"></span></p>
                            <p class="col-md-4 col-sm-2"><b>Total Amount:</b> <span id="totalAmount"></span></p>
                            <p class="col-md-4 col-sm-2"><b>Return Amount:</b> <span id="returnAmount"></span></p>
                            <p class="col-md-4 col-sm-2"><b>Due Amount:</b> <span id="dueAmount"></span></p>
                            <p class="col-md-4 col-sm-2"><b>Note:</b> <span id="note"></span></p>
                            <hr />
                            <h5><b>Purchase Details:</b></h5>
                            <table class="table px-2">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Particulars</th>
                                        <th scope="col" style="width: 7rem">Qty</th>
                                        <th scope="col" style="width: 7rem">Sales Rate</th>
                                        <th scope="col" style="width: 7rem">Discount</th>
                                        <th scope="col">Total</th>
                                    </tr>
                                </thead>
                                <tbody id="purchaseDetailsBody"></tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="5" class="text-end"><b>Total :</b></td>
                                        <td colspan="2" class="text-start" id="totalAmountFooter"></td>
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
        var showReturnSalesDetails = false;
        $(() => {

            handleDataTable();
            $("#exportToExcel").click(() => $(".exportToExcel").click());
            $(document).on("click", ".showBtn", function() {
                const id = $(this).data("id");

                showReturnSalesDetails = new bootstrap.Modal(document.getElementById(
                    'showReturnSalesDetails')); // Create the modal instance
                showReturnSalesDetails.show();
                $("#editSalesReturn").attr("href", `/sales/return/${id}/edit/`);
                axios.get(`/sales/return/fetch/${id}`).then((response) => {
                    const {
                        salesReturn,
                        salesReturnDetails
                    } = response.data.data;
                    $('#salesReturnCode').text(salesReturn.code);
                    $('#invoiceDate').text(salesReturn.invoice_date);
                    $('#totalAmount').text(salesReturn.total_amount);
                    $('#returnAmount').text(salesReturn.return_amount);
                    $('#dueAmount').text(salesReturn.due_amount);
                    $('#note').text(salesReturn.note);

                    var tbodyContent = '';
                    salesReturnDetails.forEach(function(item, index) {
                        console.log(item);
                        tbodyContent += `<tr>
                            <td>${index + 1}</td>
                            <td>${item.product_attribute.code}<br>
                                    ${item.product_attribute.product.name}
                                    ${item.product_attribute.model != null ? '|' + item.product_attribute.model : ''}
                                    ${item.product_attribute.color != null ? '|' + item.product_attribute.color : ''}<br></td>
                            <td>${item.return_qty}</td>
                            <td>${item.sales_rate}</td>
                            <td>${item.discount}</td>
                            <td>${item.total}</td>
                        </tr>`;
                    });
                    $('#purchaseDetailsBody').html(tbodyContent);

                    // Set the total amount in the footer
                    $('#totalAmountFooter').text(salesReturn.total_amount + ' tk');
                });
            });

            $(document).on("click", ".deleteBtn", function() {
                const id = $(this).data("id");
                Swal.fire({
                    title: "Are you sure?",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, delete it!",
                }).then((result) => {
                    if (result.isConfirmed) {
                        axios.delete(`/sales/${id}/delete`).then((result) => {
                            Swal.fire({
                                title: "Deleted!",
                                text: "Your file has been deleted.",
                                icon: "success",
                            });
                            handleDataTable();
                        });

                    } else {
                        Swal.fire({
                            title: "Cancelled",
                            text: "Your imaginary file is safe :)",
                            icon: "error",
                        });
                    }
                });

            });

        });


        const hideShowSalesDetailsModal = () => {
            showReturnSalesDetails.hide()
        };




        const handleDataTable = () => {
            $('#salesReturnList').DataTable().clear().destroy();
            url = '/sales/return/list?type=fetch';
            table = $('#salesReturnList').DataTable({
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
                    }, {
                        render: function(data, type, row) {
                            const btns = `
                    <div class="btn-group">
                        <button type="button" class="btn btn-success btn-sm showBtn btn-fit" data-id="${row.id}">
                         <i class="fa-regular fa-eye"></i> View
                        </button>
                        <a href="/sales/return/invoice/${row.id}" type="button" class="btn btn-primary btn-sm print btn-fit">
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

        };
    </script>
@endpush
