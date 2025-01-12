@php
    $title = 'Sales Return';
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
                    ['name' => 'Sales Return List', 'url' => route('sales.return.index')],
                    ['name' => $title, 'url' => null],
                ],
            ]
        )


        <div>
            <section class="content">
                <div class="container-fluid">
                    <div class="row mx-2">
                        <div class="card card-navy p-0" style="width: 100%">
                            <div class="card-header w-100 bg-navy">
                                <h3 class="card-title">Sales Return</h3>
                            </div>
                            <div class="card-body row" style="width: 100%">
                                <div class="col-md-4 col-12">
                                    <div class="card card-outline card-info">
                                        <div class="card-header">
                                            <h3 class="card-title">
                                                Find Returnable Invoice
                                            </h3>
                                        </div>
                                        <div class="card-body">
                                            <div>
                                                <label class="required form-label">Select a Date:</label>
                                                <input type="date" id="selectedDate" class="form-control" />
                                            </div>
                                            <div>
                                                <label class="required form-label">Select a Customer:</label>
                                                <select class="custom-select" name="selectedCustomer" id="selectedCustomer">
                                                    <option disabled selected value="0">Select a Customer</option>
                                                </select>
                                            </div>
                                            <div class="mt-2">
                                                <label class="required form-label">Select an Invoice:</label>
                                                <select class="custom-select" name="selectedInvoice" id="selectedInvoice">
                                                    <option disabled selected value="0">Select an Invoice</option>
                                                </select>
                                            </div>

                                            <div class="mt-3 border p-2 sales_info d-none">
                                                <div>
                                                    <h5><b>Sales Info:</b></h5>
                                                    <p>
                                                        <b>Total Amount:</b>
                                                        <span class="sales_total_amount mx-1"></span> tk
                                                    </p>
                                                    <p>
                                                        <b>Paid Amount:</b>
                                                        <span class="sales_paid_amount mx-1"></span> tk
                                                    </p>
                                                    <p>
                                                        <b>Due Amount:</b>
                                                        <span class="sales_due_amount mx-1"></span> tk
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-8 col-12">
                                    <div class="card card-outline card-primary">
                                        <div class="card-header">
                                            <h3 class="card-title">Product Informations</h3>
                                        </div>
                                        <div class="card-body">
                                            <table class="table table-striped table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th scope="col" class="bg-success">#</th>
                                                        <th scope="col" class="bg-success">Particulars</th>
                                                        <th scope="col" class="bg-success">Qty</th>
                                                        <th scope="col" class="bg-success">Sales Rate</th>
                                                        <th scope="col" class="bg-success">Discount</th>
                                                        <th scope="col" class="w-25 bg-success">Resturn Qty</th>
                                                        <th scope="col" class="text-end bg-success">Total</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="salesDetailsBody"></tbody>
                                                <tfoot>
                                                    <tr>
                                                        <td class="text-end bg-success" colspan="6">Total Amount:</td>
                                                        <td class="text-end bg-success total_amount"></td>
                                                    </tr>
                                                </tfoot>
                                            </table>

                                            <div class="product_customization_note_amount mt-1">
                                                <div class="product_customization_note">
                                                    <label class="mt-2 mx-2 w-8rem">Note:</label>
                                                    <textarea class="form-control" id="note" placeholder="Note"></textarea>
                                                </div>
                                                <div class="flex-column product_customization_amount">
                                                    <div class="d-flex mt-1">
                                                        <div>
                                                            <label class="w-8rem">Transaction Type</label>
                                                            <select class="form-control w-fit" id="transactionType">
                                                                <option selected disabled value="">Transaction Type
                                                                </option>
                                                                @foreach ($transactionTypes as $item)
                                                                    <option value="{{ $item->id }}">
                                                                        {{ $item->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="mx-2">
                                                            <label class="mx-2 w-8rem">Return Amount</label>
                                                            <input type="number" class="form-control return_amount"
                                                                placeholder="Return amount" value="0" />
                                                        </div>
                                                    </div>
                                                    <div class="d-flex mt-1 justify-content-end">
                                                        <label>Due Amount: <span id="due_amount">0</span></label>
                                                    </div>
                                                    <div class="d-flex mt-1 justify-content-end">
                                                        <button type="button" class="btn btn-success btn-sm submitBtn"
                                                            onclick="submitBtn()">
                                                            Submit
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        var salesList = [];
        var salesDetailsData = [];
        var returnAmount = 0;
        $(() => {
            const today = new Date();
            const formattedDate = today.toISOString().split('T')[0]; // Extracts the date in YYYY-MM-DD format
            $("#selectedDate").val(formattedDate);
            fetchSipplier(formattedDate);
            handleChange();
            $('.submitBtn').prop('disabled', true);
        });

        const fetchSipplier = (date) => {
            axios.get(`/customer/fetch?type=sales-return&date=${date}`)
                .then((response) => {
                    const data = response.data.data;
                    var customerList = [];
                    salesList = data;
                    data.length > 0 &&
                        data.map((item) => {
                            customerList = [
                                ...customerList,
                                item.customer,
                            ];
                        });
                    customerList = customerList.filter(
                        (customer, index, self) =>
                        index ===
                        self.findIndex((s) => s.id === customer.id)
                    );

                    $("#selectedCustomer").empty();
                    $("#selectedCustomer").append('<option disabled selected value="0">Select a Customer</option>');
                    customerList.forEach(customer => {
                        $("#selectedCustomer").append(new Option(customer.name, customer.id));
                    });
                });
        };

        const handleChange = () => {

            $("#selectedDate").on('change', function(e) {
                fetchSipplier($(this).val())
            });

            $("#selectedCustomer").on('change', function(e) {
                const selectedCustomerId = $(this).val();
                const invoiceList = salesList.filter(
                    (item) => item.customer_id == selectedCustomerId
                );

                $("#selectedInvoice").empty();
                $("#selectedInvoice").append('<option disabled selected value="0">Select a Invoice</option>');

                invoiceList.forEach(item => {
                    $("#selectedInvoice").append(new Option(item.code, item.id));
                });
            });

            $("#selectedInvoice").on('change', function() {
                const selectedInvoice = $(this).val();
                axios
                    .get(
                        `/sales/fetch/${selectedInvoice}`
                    )
                    .then((response) => {
                        const {
                            sales,
                            salesDetails
                        } = response.data.data;
                        if (sales) {
                            $(".sales_info").removeClass('d-none');
                            $(".sales_total_amount").text(sales.total_amount);
                            $(".sales_paid_amount").text(sales.paid_amount);
                            $(".sales_due_amount").text(sales.due_amount);
                        }
                        salesDetailsInsert(salesDetails);
                        $('.submitBtn').prop('disabled', false);
                    });
            });


            $(".return_amount").on("keyup", function() {
                returnAmount = parseFloat($(this).val());
                const total_amount = parseFloat($('.total_amount').text());
                const dueAmount = total_amount - returnAmount;
                $('#due_amount').text(dueAmount);
            });



        };









        function salesDetailsInsert(data, hasSame = true) {
            salesDetailsData = data;
            console.log(data);
            const tbody = $('#salesDetailsBody');
            tbody.empty();

            var total_amount = 0;
            data.forEach((item) => {
                if (hasSame == true) {
                    item.return_qty = item.qty;
                }
                total_amount += parseFloat(item.total);
                const row = `
            <tr>
                <td class="d-flex-item-center">
                    <button type="button" class="btn btn-sm btn-danger mt-2" onclick="removeItem(${item.id})">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </td>
                <td>
                    ${item.product_attribute.code}<br />
                    ${item.product_attribute.color ? `<span>${item.product_attribute.color}</span><br />` : ''}
                    ${item.product_attribute.model ? `<span>${item.product_attribute.model}</span>` : ''}
                </td>
                <td>${item.qty}</td>
                <td>${item.sales_rate}</td>
                <td>${item.discount}</td>
                <td>
                    <input type="number" class="form-control handleReturnQty" data-item_id="${item.id}" value="${item.return_qty}"/>
                </td>
                <td class="text-end">${item.total}</td>
            </tr>
        `;
                tbody.append(row);
            });

            $(".total_amount").text(total_amount);

            $(".handleReturnQty").on('blur', function(e) {
                $(this).removeClass("form-control-red");
                $('.submitBtn').prop('disabled', false);

                const returnQty = parseInt($(this).val());
                const itemId = $(this).data('item_id');
                const item = data.find(d => d.id === itemId);
                item.total = parseInt($(this).val()) * item.sales_rate;
                item.return_qty = parseInt($(this).val());

                if (returnQty > item.qty) {
                    Toastr.fire({
                        icon: "error",
                        title: "Quantity is out of range",
                    });
                    $(this).addClass("form-control-red");
                    $('.submitBtn').prop('disabled', true);
                    return false;
                }

                salesDetailsInsert(data, false);
            });
        }



        const submitBtn = () => {

            const data = {
                sales_id: $("#selectedInvoice").val(),
                note: $("#note").val(),
                transaction_type_id: $("#transactionType").val(),
                total_amount: parseFloat($('.total_amount').text()),
                due_amount: parseFloat($('#due_amount').text()),
                return_amount: returnAmount,
                product_details: salesDetailsData,
            };



            $('.submitBtn').text('Processing');
            $('.submitBtn').prop('disabled', true);


            axios.post("/sales/return/create", data).then((response) => {
                const {
                    data,
                    status
                } = response.data;

                if (status == true) {
                    Toastr.fire({
                        icon: "success",
                        title: "Sales Return successful",
                    });

                    setTimeout(() => {
                        window.location.href = `/sales/return/invoice/${data.id}`;
                    }, 1600);
                } else {
                    $('.submitBtn').text('Submit');
                    $('.submitBtn').prop('disabled', false);
                }
            });

        };
    </script>
@endpush
