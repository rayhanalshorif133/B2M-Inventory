@php
    $title = 'Purchase Payment';
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
                    ['name' => 'Purchase Payment List', 'url' => route('purchase.payment-list')],
                    ['name' => $title, 'url' => null],
                ],
            ]
        )



        <div class="row px-5">
            <div class="col-md-6 col-12">
                <div class="card card-outline card-primary relative">
                    <div class="purchase_payment_invoice_based_card"></div>
                    <div class="tooltip-content hidden">
                        <i class="fa-solid fa-caret-up"></i>
                        <div class="typing-text">
                            You can make payment based on purchase invoice
                        </div>
                    </div>
                    <div class="card-header">
                        <h3 class="card-title">Purchase Invoice Based</h3>
                    </div>

                    <div class="card-body">
                        <div>
                            <label class="required">Select a Date:</label>
                            <input type="date" id="selectedInvoiceDate" class="form-control" />
                        </div>
                        <div>
                            <label class="required">Select a Supplier:</label>
                            <select class="form-select" id="selectedSupplier">
                                <option value="0" disabled selected>Select a Supplier</option>
                            </select>
                        </div>
                        <div class="mt-2">
                            <label class="required">Select an Invoice:</label>
                            <select class="form-select" id="selectedInvoice">
                                <option value="0" disabled selected>Select an Invoice</option>
                            </select>
                        </div>
                        <div class="mt-3 border p-2" id="invoiceInfo">
                            <div>
                                <p>Total Amount: <span id="totalAmount">5000</span> tk</p>
                                <p>Paid Amount: <span id="paidAmount">2000</span> tk</p>
                                <p>
                                    Due Amount: <span id="dueAmount">3000</span> tk
                                    <button class="btn btn-sm btn-info" title="Full Payment">
                                        <i class="fa-solid fa-caret-down"></i>
                                    </button>
                                </p>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Transaction Type</label>
                                        <select class="form-select" id="selectedTransactionType">
                                            <option value="0" selected>Select a Transaction Type</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label>Pay Amount</label>
                                        <div class="d-flex">
                                            <input type="text" class="form-control w-full mr-1" id="paymentAmount" />
                                            <button class="btn btn-sm btn-success" style="width: 120px" id="payNowBtn">
                                                Pay Now
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-12">
                <div class="card card-outline card-info relative">
                    <div class="purchase_payment_supplier_based_card"></div>
                    <div class="tooltip-content hidden">
                        <i class="fa-solid fa-caret-up"></i>
                        <div class="typing-text">
                            You can make payment based on Supplier based
                        </div>
                    </div>
                    <div class="card-header">
                        <h3 class="card-title">Supplier Based</h3>
                    </div>

                    <div class="card-body">
                        <div>
                            <label class="required">Select a Date:</label>
                            <input type="date" id="selectedInvoiceDateSupplierBased" class="form-control" />
                        </div>
                        <div>
                            <label class="required">Select a Supplier:</label>
                            <select class="form-select" id="selectedSupplierBased">
                                <option value="0" disabled selected>Select a Supplier</option>
                            </select>
                        </div>

                        <div class="mt-3 border p-2 d-none" id="supplierBasedPaymentInfo">
                            <div>
                                <p>
                                    Due Amount: <span id="supplierBasedDueAmount">3000</span> tk
                                    <button class="btn btn-sm btn-info" title="Full Payment" id="fullPaymentBtn">
                                        <i class="fa-solid fa-caret-down"></i>
                                    </button>
                                </p>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Transaction Type</label>
                                        <select class="form-select" id="selectedTransactionTypeSupplierBased">
                                            <option value="0" selected>Select a Transaction Type</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label>Pay Amount</label>
                                        <div class="d-flex">
                                            <input type="text" class="form-control w-full mr-1"
                                                id="paymentAmountSupplierBased" />
                                            <button class="btn btn-sm btn-success" style="width: 120px"
                                                id="payNowBasedOnSupplierBtn">
                                                Pay Now
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="noDueAmount" class="mt-3" style="display: none;">
                            <div class="alert alert-danger" role="alert">
                                No due amount.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>




    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {


            $("#selectedInvoiceDateSupplierBased").change(function(e) {
                axios.get(`/purchase/fetch-invoice/?date=${$(this).val()}`)
                    .then(function(response) {

                        var supplierList = [];
                        const data = response.data.data;
                        if (data.length > 0) {
                            data.map((item) => {
                                supplierList.push(item.supplier);
                            });

                            supplierList = supplierList.filter(
                                (supplier, index, self) =>
                                index ===
                                self.findIndex((s) => s.name === supplier.name)
                            );

                            supplierList.forEach(function(supplier) {
                                $('#selectedSupplierBased').append(
                                    $('<option>', {
                                        value: supplier.id,
                                        text: supplier.name
                                    })
                                );
                            });
                            $('#selectedSupplierBased').addClass('form-select-green');
                        } else {
                            $('#selectedSupplierBased').addClass('form-select-red');
                        }
                    });
            });


            $("#selectedSupplierBased").change(function() {
                axios.get(`/purchase/fetch-invoice/?supplier_id=${$(this).val()}&type=supplier`)
                    .then(function(response) {
                        const data = response.data.data;
                        if (data) {
                            $("#supplierBasedPaymentInfo").removeClass('d-none');
                            $("#supplierBasedDueAmount").text(data);
                            fetchTransactionTypes('#selectedTransactionTypeSupplierBased');
                        }
                    });

            });

            $('#payNowBasedOnSupplierBtn').click(function() {
                $(this).prop('disabled', true);
                var paymentAmount = $('#paymentAmountSupplierBased').val();
                var supplier_id = $("#selectedSupplierBased").val();
                var dueAmount = parseFloat($("#supplierBasedDueAmount").text());
                var transaction_type_id = $('#selectedTransactionTypeSupplierBased').val();
                payNow(paymentAmount, dueAmount, supplier_id, transaction_type_id);
            });


            return false;




            // Populate suppliers


            // Populate invoices
            // invoices.forEach(function(invoice) {
            //     $('#selectedInvoice').append(
            //         $('<option>', {
            //             value: invoice.id,
            //             text: invoice.code
            //         })
            //     );
            // });

            // Populate transaction types
            transactionTypes.forEach(function(type) {
                $('#selectedTransactionType').append(
                    $('<option>', {
                        value: type.id,
                        text: type.name
                    })
                );
            });

            // Example logic to update total, paid, and due amounts when invoice is selected
            $('#selectedInvoice').change(function() {
                var selectedInvoiceId = $(this).val();
                if (selectedInvoiceId) {
                    // Assuming we fetch the invoice info based on the selected invoice
                    // Dummy data for selected invoice info
                    var invoiceInfo = {
                        total_amount: 5000,
                        paid_amount: 2000,
                        due_amount: 3000
                    };
                    $('#totalAmount').text(invoiceInfo.total_amount);
                    $('#paidAmount').text(invoiceInfo.paid_amount);
                    $('#dueAmount').text(invoiceInfo.due_amount);
                }
            });

            // Pay now button action

        });

        const fetchTransactionTypes = (PUT_ID) => {
            axios.get("/transaction-types/fetch").then((response) => {
                if (response.data.status == true) {
                    const data = response.data.data;
                    $(PUT_ID).empty();
                    data.forEach(function(item) {
                        $(PUT_ID).append(
                            $('<option>', {
                                value: item.id,
                                text: item.name
                            })
                        );
                    });
                }
            });
        };


        const payNow = (paymentAmount, dueAmount, supplier_id, transaction_type_id) => {


            if (!transaction_type_id) {
                Toastr.fire({
                    icon: "error",
                    title: "Please select a transaction type",
                });
                return false;
            }


            if (!paymentAmount) {
                Toastr.fire({
                    icon: "error",
                    title: "Please enter a payment amount",
                });
                return false;
            }

            if (paymentAmount > dueAmount) {
                Toastr.fire({
                    icon: "error",
                    title: "Please enter valid payment amount",
                });
                paymentAmount.value = "";
                return false;
            }

            const data = {
                payment_amount: paymentAmount,
                supplier_id: supplier_id,
                transaction_type_id: transaction_type_id,
            };
            axios.post("/payment/purchase/pay", data).then((response) => {
                if (response.data.status == true) {
                    Toastr.fire({
                        icon: "success",
                        title: "Payment successful",
                    });

                    setTimeout(() => {
                        window.location.assign(`/payment/purchase/pay-slip/${response.data.data}`);
                    }, 1000);
                }
            });
        };
    </script>
@endpush
