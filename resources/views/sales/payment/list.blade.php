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


        <div class="modal fade" id="paymentEditModal" tabindex="-1" role="dialog" aria-labelledby="paymentEditModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="paymentEditModalLabel">
                            <span class="text-capitalize">Sales</span> Payment Edit
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div>
                            <h5><b>Payment Info:</b></h5>
                            <span><b>Receipt No :</b> <span id="payment_info_receipt_no"></span></span>
                            <p style="margin-bottom: 0 !important">
                                <span><b>Customer Name :</b> <span id="payment_info_customer_name">John Doe
                                        Supplies</span></span>
                            </p>
                            <span><b>Invoice Date :</b> <span id="payment_info_invoice_date">2025-01-01</span></span><br />
                            <span><b>Paid Amount :</b> <span id="payment_info_paid_amount">5000 tk</span></span><br />

                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label>Transaction Type</label>
                                <select class="form-select" id="payment_info_transactionTypes">
                                    @foreach ($transactionTypes as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label>Pay Amount</label>
                                <div class="d-flex">
                                    <input type="text" class="form-control w-full mr-1" id="payment_info_payAmount"
                                        placeholder="Enter amount" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" data-dismiss="modal" onclick="handlePaymentUpdateSubmit()">Update</button>
                    </div>
                </div>
            </div>
        </div>

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
                                    <a href="/payment/sales/pay-slip/${row.id}" type="button" class="text-white btn btn-success btn-sm">
                                     <i class="fa-regular fa-eye "></i> Pay Slip
                                    </a>
                                    <button type="button" class="btn btn-info btn-sm paymentEditBtn btn-fit" data-id="${row.id}">
                                            <i class="fa-solid fa-pen-to-square"></i> Edit
                                    </button>
                            </div>`;
                            return btns;
                        },
                        targets: 5
                    }
                ]
            });
        };

        var showModal = false;
        var payment_id = 0;

        $(document).on('click', '.paymentEditBtn', function() {
            payment_id = $(this).attr('data-id');
            console.clear();
            axios.get(`/payment/fetch/${payment_id}?type=sales`).then((response) => {
                const data = response.data.data;
                const modalElement = document.getElementById("paymentEditModal");
                showModal = new bootstrap.Modal(modalElement);
                showModal.show();
                $('#payment_info_receipt_no').text(data.receipt_no); // Set Receipt No
                $('#payment_info_customer_name').text(data.customer.name); // Set Supplier Name
                $('#payment_info_invoice_date').text(data.created_date); // Set Invoice Date
                $('#payment_info_paid_amount').text(`${data.amount} tk`); // Set Paid Amount
                $('#payment_info_transactionTypes').val(data.transaction_type_id);
                $('#payment_info_payAmount').val(data.amount);

            });
        });


        const handlePaymentUpdateSubmit = () => {

            const data = {
                payment_id: payment_id,
                transaction_type_id: $('#payment_info_transactionTypes').val(),
                amount: $('#payment_info_payAmount').val(),
                type: 'sales',
            };


            axios.put("/payment/update", data).then((response) => {
                const data = response.data.data;
                const message = response.data.message;
                Toastr.fire({
                    icon: message,
                    title: data,
                });

                if (message == "success") {
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                }
            });
        };
    </script>
@endpush
