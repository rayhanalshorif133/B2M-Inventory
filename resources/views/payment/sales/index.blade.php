@php
    $title = 'Sales Payment';
@endphp
@extends('layouts.app', ['title' => $title])

@section('head')
    <style>
        .fs-12px {
            font-size: 12px !important;
        }
    </style>
@endsection
@section('content')
    <div class="content-wrapper">


        @include(
            '_partials.breadcrumb',
            ['title' => $title],
            [
                'items' => [
                    ['name' => 'Home', 'url' => route('home')],
                    ['name' => 'Sales Payment List', 'url' => route('sales.payment-list')],
                    ['name' => $title, 'url' => null],
                ],
            ]
        )
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    @include('payment/sales/_partials/invoice-based')
                    @include('payment/sales/_partials/customer-based')
                </div>
            </div>
        </section>

    </div>
@endsection


@push('scripts')
    <script>
        $(() => {
            fetchInvoiceByDate();
            fetchCustomerByDate();
            handlePaymentAmount();
        });


        const handlePaymentAmount = () => {

            $("#salesInvoiceBasedPaymentAmount").keyup(function() {
                const amount = parseFloat($(this).val());
                const payAmount = parseFloat($("#salesInvoiceBasedDue_amount").text());

                if (amount > payAmount) {
                    $(".salesInvoiceBasedPaymentStatus").text('Amount is too high');
                    $(".salesInvoiceBasedPaymentBtn").prop('disabled', true);
                } else {
                    $(".salesInvoiceBasedPaymentStatus").text('');
                    $(".salesInvoiceBasedPaymentBtn").prop('disabled', false);
                }
            });

            $(".salesInvoiceBasedFullPaymentBtn").click(function() {
                const payAmount = parseFloat($("#salesInvoiceBasedDue_amount").text());
                $("#salesInvoiceBasedPaymentAmount").val(payAmount);
                $(".salesInvoiceBasedPaymentBtn").prop('disabled', false);
            });


            $(".salesInvoiceBasedPaymentBtn").click(function() {
                const data = {
                    sales_id: $("#salesInvoiceBasedSelect").val(),
                    customer_id: $("#salesInvoiceBasedSelectCustomer").val(),
                    payment_amount: $("#salesInvoiceBasedPaymentAmount").val(),
                    transaction_type_id: $("#salesInvoiceBasedTT_id").val(),
                };

                axios.post("/payment/sales/pay", data).then((response) => {
                    console.clear();
                    if (response.data.status == true) {
                        Toastr.fire({
                            icon: "success",
                            title: "Payment successful",
                        });

                        setTimeout(() => {
                            window.location.assign(
                                `/payment/sales/pay-slip/${response.data.data}`
                            );
                        }, 1000);
                    }
                });
            });

            payNowCustomerBased();
        };



        const fetchInvoiceByDate = () => {

            var selectedInvoiceDate = "";
            $("#salesInvoiceBasedDate").change(function() {
                selectedInvoiceDate = $(this).val();
                var customerList = [];
                axios
                    .get(`/sales/fetch-invoice/?date=${selectedInvoiceDate}`)
                    .then((response) => {
                        const data = response.data.data;
                        $("#salesInvoiceBasedSelect").val(0);
                        if (data.length > 0) {
                            data.map((item) => {
                                customerList.push(item.customer);
                            });

                            customerList = customerList.filter(
                                (item, index, self) =>
                                index ===
                                self.findIndex((s) => s.name === item.name)
                            );
                            var html = "";
                            html += ` <option value="0" disabled selected>Select a Customer</option>`;
                            customerList.map((item, index, self) => {
                                html += `<option value="${item.id}">${item.name}</option>`;
                            });

                            $("#salesInvoiceBasedSelectCustomer").html(html);



                            $(".selectedCustomerClass").addClass("form-select-green");
                        } else {
                            $(".selectedCustomerClass").addClass("form-select-red");
                            $("#salesInvoiceBasedSelect").html(
                                '<option value="0" disabled selected> Select an Invoice </option>');
                        }
                    });
                setTimeout(() => {
                    $(".selectedCustomerClass").removeClass("form-select-red").removeClass(
                        "form-select-green");
                }, 2000);
            });



            $("#salesInvoiceBasedSelectCustomer").change(function() {
                choiceCustomer(selectedInvoiceDate, $(this).val());
            });


            $("#salesInvoiceBasedSelect").change(function() {
                choiceInvoice($(this).val());
            });





        };


        const fetchCustomerByDate = () => {

            var selectedInvoiceDate = "";
            $("#salesCustomerBasedDate").change(function() {
                selectedInvoiceDate = $(this).val();
                var customerList = [];
                axios
                    .get(`/sales/fetch-invoice/?date=${selectedInvoiceDate}`)
                    .then((response) => {
                        const data = response.data.data;
                        if (data.length > 0) {
                            data.map((item) => {
                                customerList.push(item.customer);
                            });

                            customerList = customerList.filter(
                                (item, index, self) =>
                                index ===
                                self.findIndex((s) => s.name === item.name)
                            );
                            var html = "";
                            html += ` <option value="0" disabled selected>Select a Customer</option>`;
                            customerList.map((item, index, self) => {
                                html += `<option value="${item.id}">${item.name}</option>`;
                            });

                            $("#salesCustomerBasedSelectCustomer").html(html);
                            $(".selectedCustomerBasedClass").addClass("form-select-green");
                        } else {
                            $(".selectedCustomerBasedClass").addClass("form-select-red");
                        }
                    });
                setTimeout(() => {
                    $(".selectedCustomerBasedClass").removeClass("form-select-red").removeClass(
                        "form-select-green");
                }, 2000);
            });



            $("#salesCustomerBasedSelectCustomer").change(function() {
                axios
                    .get(
                        `/sales/fetch-invoice/?date=${selectedInvoiceDate}&customer_id=${$(this).val()}&type=customer`
                    )
                    .then((response) => {
                        const data = response.data.data;
                        $("#salesCustomerBasedDueAmount").text(data);

                        if (data == 0) {
                            $(".dueAmountAlertContainer").removeClass("hidden");
                        } else {
                            $(".dueAmountAlertContainer").addClass("hidden");
                        }
                    });
            });


            $("#salesInvoiceBasedSelectCustomer").change(function() {
                choiceCustomer(selectedInvoiceDate, $(this).val());
            });


            $("#salesInvoiceBasedSelect").change(function() {
                choiceInvoice($(this).val());
            });


            $(".salesCustomerBasedFullPay").click(function() {
                const amount = parseFloat($("#salesCustomerBasedDueAmount").text());
                $(".salesCustomerBasedPayInput").val(amount);
            });



        };


        const payNowCustomerBased = () => {

            $(".salesCustomerBasedPayBtn").click(function() {

                const payAmount = parseFloat($(".salesCustomerBasedPayInput").val());
                const customer_id = $("#salesCustomerBasedSelectCustomer").val();
                const transaction_type_id = $("#salesCustomerBasedTT_id").val();
                const dueAmount = parseFloat($("#salesCustomerBasedDueAmount").text());



                $(this).text("Processing ...");
                $(this).addClass("fs-12px");
                $(this).attr("disabled", true);




                if (customer_id == null) {
                    Toastr.fire({
                        icon: "error",
                        title: "Please select a customer",
                    });
                    $(this).text("Submit");
                    $(this).removeClass("fs-12px");
                    $(this).attr("disabled", false);
                    return false;
                }



                if (transaction_type_id == 0) {
                    Toastr.fire({
                        icon: "error",
                        title: "Please select a transaction type",
                    });
                    $(this).text("Submit");
                    $(this).removeClass("fs-12px");
                    $(this).attr("disabled", false);
                    return false;
                }

                if (payAmount == 0) {
                    Toastr.fire({
                        icon: "error",
                        title: "Please enter a payment amount",
                    });
                    $(this).text("Submit");
                    $(this).removeClass("fs-12px");
                    $(this).attr("disabled", false);
                    return false;
                }

                if (payAmount > dueAmount) {
                    Toastr.fire({
                        icon: "error",
                        title: "Please enter valid payment amount",
                    });
                    $(this).text("Submit");
                    $(this).removeClass("fs-12px");
                    $(this).attr("disabled", false);
                    return false;
                }





                const data = {
                    payment_amount: payAmount,
                    customer_id: customer_id,
                    transaction_type_id: transaction_type_id,
                };
                axios.post("/payment/sales/pay", data).then((response) => {
                    console.clear();
                    if (response.data.status == true) {
                        Toastr.fire({
                            icon: "success",
                            title: "Payment successful",
                        });

                        setTimeout(() => {
                            window.location.assign(
                                `/payment/sales/pay-slip/${response.data.data}`);
                        }, 1000);
                    }
                });
            });


        };


        const choiceCustomer = (date, customer_id) => {
            axios
                .get(
                    `/sales/fetch-invoice/?date=${date}&customer_id=${customer_id}`
                )
                .then((response) => {
                    const salesInvoiceList = response.data.data;

                    var html = "";
                    html += ` <option value="0" disabled selected>Select a Invoice</option>`;

                    if (salesInvoiceList.length > 0) {
                        salesInvoiceList.map((item) => {
                            html += `<option value="${item.id}">${item.code}</option>`;
                        });
                        $("#salesInvoiceBasedSelect").addClass("form-select-green");
                    } else {
                        $("#salesInvoiceBasedSelect").addClass("form-select-red");
                    }
                    $("#salesInvoiceBasedSelect").html(html);
                });
        };


        const choiceInvoice = (sales_id) => {
            axios
                .get(`/sales/fetch-invoice/?sales_id=${sales_id}`)
                .then((response) => {
                    const data = response.data.data;
                    console.log(data);
                    $(".hasSelectedInvoiceInfo").removeClass('hidden');
                    $("#salesInvoiceBasedTotal_amount").html(data.total_amount);
                    $("#salesInvoiceBasedPaid_amount").html(data.paid_amount);
                    $("#salesInvoiceBasedDue_amount").html(data.total_amount - data.paid_amount);
                });
        };
    </script>
@endpush
