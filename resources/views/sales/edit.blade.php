@extends('layouts.app', ['title' => 'Add New Sales'])

@section('head')
    <style type="text/css">
        :host,
        :root {
            --fa-font-solid: normal 900 1em/1 "Font Awesome 6 Solid";
            --fa-font-regular: normal 400 1em/1 "Font Awesome 6 Regular";
            --fa-font-light: normal 300 1em/1 "Font Awesome 6 Light";
            --fa-font-thin: normal 100 1em/1 "Font Awesome 6 Thin";
            --fa-font-duotone: normal 900 1em/1 "Font Awesome 6 Duotone";
            --fa-font-sharp-solid: normal 900 1em/1 "Font Awesome 6 Sharp";
            --fa-font-sharp-regular: normal 400 1em/1 "Font Awesome 6 Sharp";
            --fa-font-sharp-light: normal 300 1em/1 "Font Awesome 6 Sharp";
            --fa-font-brands: normal 400 1em/1 "Font Awesome 6 Brands"
        }

        svg:not(:host).svg-inline--fa,
        svg:not(:root).svg-inline--fa {
            overflow: visible;
            box-sizing: content-box
        }

        .svg-inline--fa {
            display: var(--fa-display, inline-block);
            height: 1em;
            overflow: visible;
            vertical-align: -.125em
        }

        .svg-inline--fa.fa-2xs {
            vertical-align: .1em
        }

        .svg-inline--fa.fa-xs {
            vertical-align: 0
        }

        .dropdown-menu {
            display: none;
            position: absolute;
            background-color: white;
            border: 1px solid #ddd;
            padding: 0.5rem;
            z-index: 9999;
            left: -100%;
            transform: translate(22%, 0px);
        }

        .dropdown-menu.show {
            display: block;
        }

        .dropdown.action-btn {
            position: relative;
        }

        .card {
            box-shadow: none;
        }

        .table {
            width: 100%;
            max-width: 100%;
            margin: 0 auto;
        }

        .table-responsive {
            overflow-x: auto;
        }

        thead th,
        tbody td {
            white-space: nowrap;
        }

        .font-size-16px {
            font-size: 16px !important;
        }

        .font-size-14px {
            font-size: 14px !important;
        }
    </style>
@endsection


@section('content')
    <div class="content-wrapper">


        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Add New Sales</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item">
                                <a href="{{ route('home') }}" class="text-capitalize">home</a>
                                <span class="text-gray"> / </span>
                                <span class="text-gray">Add New Sales</span>
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>


        <section class="content overflow-x-hidden">
            <div class="col-12">
                <!-- Default box -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Seles Order</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="card mb-3 mt-2" data-controller="calculate-sales-order">
                            @if (count($transactionTypes) == 0)
                                <div class="alert alert-warning" role="alert">
                                    No transaction types found. Please
                                    <a href="{{ route('transaction-types.index') }}" class="alert-link">add one</a> !
                                </div>
                            @endif
                            <div class="alert alert-success d-none ttAddedsuccssAlart" role="alert">
                                Transaction types Added successfully.
                            </div>
                            @include('sales._partials.addNewCustomerModal', [
                                'customers' => $customers,
                            ])
                            <div class="card-body bg-white">
                                <form class="form-horizontal salesCreateForm" action="{{ route('sales.edit', $sales->id) }}"
                                    method="POST">
                                    @csrf
                                    @method('PUT')
                                    <label class="control-label align-middle">
                                        Sales Order #{{ $sales_code }}
                                        <input autocomplete="off" type="hidden" value="{{ $sales_code }}"
                                            name="sales_order[voucher_number]">
                                    </label>
                                    <!-- Customer Name-->
                                    <div class="row mb-3">
                                        <div class="col-md-6 col-12 mb-3">
                                            <div class="row">
                                                <div class="col-lg-6 col-12">
                                                    <div class="form-group">
                                                        <label class="text-capitalize" for="q_billing_status">
                                                            Customer Name
                                                        </label>
                                                        <select class="form-control select2" id="customer"
                                                            name="sales_order[customer_id]" style="width: 100%;"></select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-12">
                                                    <a class="btn btn-outline-success btn-sm ms-2 addNewModalBtn"
                                                        data-toggle="modal" data-target="#addNewCustomerModal">
                                                        <i class="fa fa-plus"></i>
                                                        New Customer
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12 mb-3">
                                            <div class="input-group has-validation">
                                                <label class="col-md-6 col-12 control-label-required text-end mt-2"
                                                    for="datepickerVal">Date Of
                                                    Issue : </label>
                                                <input type="date" name="sales_order[invoice_date]" id="invoice_date"
                                                    value="{{ date('Y-m-d') }}" class="form-control" required="required">
                                            </div>
                                        </div>
                                    </div>



                                    <div class="row mb-3">

                                        <div class="col-md-6 col-12 mb-3">
                                            <div class="row">
                                                <div class="col-lg-6 col-12">
                                                    <div class="form-group">
                                                        <label class="text-capitalize" for="q_billing_status">
                                                            Product Name
                                                        </label>
                                                        <select class="form-control select2" id="product"
                                                            style="width: 100%;">
                                                            <option value="">Select Product</option>
                                                        </select>

                                                    </div>
                                                </div>
                                                <div class="col-lg-6 col-12">
                                                    <a class="btn btn-outline-success btn-sm ms-2 addNewModalBtn"
                                                        href="{{ route('product.create') }}">
                                                        <i class="fa fa-plus"></i>
                                                        New Product
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-12 mb-3">
                                            <div class="input-group has-validation">
                                                <label class="col-md-6 col-12 control-label-required text-end mt-2"
                                                    for="datepickerVal">Barcode : </label>
                                                <input autocomplete="off" class="form-control" type="text" id="barcode"
                                                    placeholder="Enter or scan barcode">
                                            </div>
                                        </div>
                                    </div>


                                    <!-- Voucher Number-->

                                    <div class="mt-4 table-responsive" style="width: 100%;">
                                        <table class="table">
                                            <thead class="light">
                                                <tr class="bg-light dark__bg-1000">
                                                    <th scope="col" class="col-3 control-label-required">Item Name</th>
                                                    <th scope="col" class="col-1 control-label-required">Qty</th>
                                                    <th scope="col" class="col-2 control-label-required">Sales Rate
                                                    </th>
                                                    <th scope="col" class="col-2">Discount
                                                    </th>
                                                    <th scope="col" class="col-1 text-end">Amount
                                                    </th>
                                                    <th scope="col" class="col-1 text-end">Action
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody id="insertProductItemForSales">
                                                <tr class="slsord_line" id="no_record">
                                                    <td class="border-0 text-center" colspan="6">No Record</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>


                                    <div class="row m-2">
                                        <div class="col-md-7">
                                            <div class="mb-3">
                                                <label class="form-label font-size-14px">Customer Notes</label>
                                                <textarea rows="4" class="bg-focus form-control" name="sales_order[customer_note]"
                                                    id="sales_order_customer_notes"></textarea>
                                            </div>
                                        </div>

                                        <div class="col-md-5">
                                            <div class="row">
                                                <div class="col-12 col-md-6 mt-1">
                                                    <label class="form-label font-size-14px" style="float: right">Total
                                                        Discount</label>
                                                </div>
                                                <div class="col-12 col-md-6">
                                                    <input type="number" class="bg-focus form-control"
                                                        name="sales_order[total_discount]" id="total_discount"
                                                        value="0" />
                                                    <p class="d-flex mt-2 ">
                                                        <label class="form-label mx-2 font-size-14px">Grand Total
                                                            Amount:</label>
                                                        <label class="form-label text-success font-size-14px"
                                                            id="grand_total_amount">00</label>
                                                        <input type="hidden" class="bg-focus form-control"
                                                            name="sales_order[grand_total_amount]"
                                                            id="set_grand_total_amount" />
                                                    </p>
                                                </div>

                                            </div>
                                            <div class="row mt-2">
                                                <div class="col-12 col-md-6">

                                                    <div class="sales_create_tt_container">
                                                        <label class="form-label font-size-14px">Transaction
                                                            Type</label>
                                                        <button type="button" class="btn btn-sm btn-navy mx-2"
                                                            data-toggle="modal" data-target="#transactionTypeModal">
                                                            Add <i class="fa fa-plus"></i>
                                                        </button>
                                                    </div>
                                                    <select class="form-select bg-focus form-control"
                                                        name="sales_order[transaction_type]"
                                                        id="sales_order_transaction_type">
                                                        <option value="" selected>Select Transaction Type</option>
                                                        @foreach ($transactionTypes as $type)
                                                            <option value="{{ $type->id }}">{{ $type->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-12 col-md-6">
                                                    <label class="form-label font-size-14px">Paid Amount</label>
                                                    <input type="hidden" class="bg-focus form-control"
                                                        id="set_total_amount" name="sales_order[total_amount]">
                                                    <input type="text" class="bg-focus form-control"
                                                        name="sales_order[paid_amount]" id="paid_amount" />
                                                    <p class="d-flex mt-2 ">
                                                        <label class="form-label mx-2 font-size-14px">Due Amount:</label>
                                                        <label class="form-label text-danger font-size-14px"
                                                            id="due_amount">00</label>
                                                        <input type="hidden" class="bg-focus form-control"
                                                            name="sales_order[due_amount]" id="set_due_amount" />
                                                    </p>
                                                </div>
                                            </div>
                                        </div>


                                    </div>

                                    <!-- Form Buttons-->
                                    <div class="row mt-4 justify-content-end">
                                        <div class="d-flex justify-content-end">
                                            <a class="btn btn-outline-danger" style="margin-right: 10px;"
                                                href="{{ route('sales.edit', $sales->id) }}">Reset</a>
                                            <button type="button" class="btn btn-success me-2 salesCreateSubmitBtn"
                                                style="width: 20vw;">
                                                Submit
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card -->
            </div>

        </section>

        @include('transactionType.create')
    </div>
@endsection


@push('scripts')
    <script>
        var SALESDATA = [];
        var setCusomizationData = [];
        var setProductAttributeData = [];
        $(document).ready(function() {

            fetchSalesInformation();
            fetchProducts();
            handleCreateNewCustomer();
            handleProductChange();
            handlePaidAmount();
            handleBarcodeScan();

            $(".salesCreateSubmitBtn").click(function() {
                $(this).text('Processing ...').prop('disabled', true);
                $(".salesCreateForm").submit();
            });

        });


        const fetchSalesInformation = () => {
            const url = window.location.href;
            const idMatch = url.match(/\/sales\/(\d+)\/edit/);
            if (idMatch && idMatch[1]) {
                const id = idMatch[1];
                axios.get(`/sales/fetch/${id}/`)
                    .then(function(response) {
                        const {
                            sales,
                            salesDetails
                        } = response.data.data;
                        fetchCustomers(sales.company_id);
                        salesDetails.length > 0 && salesDetails.map(function(item) {
                            const {code, model, size, color} = item.product_attribute;
                            item.code = code;
                            item.model = model;
                            item.size = size;
                            item.color = color;
                            setProductDetails(item);
                        });
                        $("#sales_order_transaction_type").val(sales.payment.transaction_type_id);
                        $("#invoice_date").val(sales.invoice_date);
                        $("#salesTotalAmount").text();
                        $("#paid_amount").val(sales.paid_amount);
                        $("#note").val(sales.note);
                        $("#total_discount").val(sales.discount);
                        handleTotalGrandAmount();
                    });
            }

        };

        const handleBarcodeScan = () => {
            $("#barcode").keyup(function(e) {
                if (e.code == 'Enter') {
                    const barcode = $(this).val();
                    axios.get(`/product/fetch-by-code/?barcode=${barcode}`)
                        .then(function(response) {
                            const data = response.data.data;
                            setProductDetails(data);
                            setTimeout(() => {
                                $("#barcode").val('');
                                $("#barcode").click();
                            }, 500);
                        });
                }
            });
        };


        const handleTotalGrandAmount = () => {
            const total_discount = parseFloat($("#total_discount").val());
            const total_amount = parseFloat($("#set_total_amount").val());
            const paid_amount = parseFloat($("#paid_amount").val());
            const grand_total_amount = total_amount - total_discount;
            $("#grand_total_amount").text(grand_total_amount);
            $("#set_grand_total_amount").val(grand_total_amount);

            const dueAmount = grand_total_amount - paid_amount;
            $("#due_amount").text(dueAmount);
            $("#set_due_amount").val(dueAmount);

        };


        const handlePaidAmount = () => {
            $("#total_discount").keyup(function() {
                handleTotalGrandAmount();
            });


            $("#paid_amount").keyup(function() {
                const paidAmount = parseFloat($(this).val());
                const total_amount = $("#set_grand_total_amount").val();
                var dueAmount = 0;
                if (paidAmount > total_amount) {
                    Toastr.fire({
                        icon: "error",
                        title: "Payment amount is Error",
                    });
                    return false;
                }
                dueAmount = total_amount - parseFloat(paidAmount);

                $("#due_amount").text(dueAmount);
                $("#set_due_amount").val(dueAmount);
            });
        };



        const handleSubmit = () => {

            const transaction_type = $("#transaction_type").val();
            const selectedCustomer = $("#customer").val();
            const paid_amount = $("#paid_amount").val();

            $(".submitbtn").text('Processing ...');
            $(".submitbtn").attr('disabled', true);




            if (!transaction_type) {
                Toastr.fire({
                    icon: "error",
                    title: "Please Selected a transaction type",
                });

                $(".submitbtn").text('Submit');
                $(".submitbtn").attr('disabled', false);
                return false;
            }




            if (!selectedCustomer) {
                Toastr.fire({
                    icon: "error",
                    title: "Please Selected a Customer",
                });
                $(".submitbtn").text('Submit');
                $(".submitbtn").attr('disabled', false);
                return false;
            }

            if (setCusomizationData.length == 0) {
                Toastr.fire({
                    icon: "error",
                    title: "Please add product for customizations",
                });
                $(".submitbtn").text('Submit');
                $(".submitbtn").attr('disabled', false);
                return false;
            }


            if (!paid_amount) {
                Toastr.fire({
                    icon: "error",
                    title: "Please Enter a paid amount",
                });
                $(".submitbtn").text('Submit');
                $(".submitbtn").attr('disabled', false);
                return false;
            }


            const data = {
                customer_id: selectedCustomer,
                invoice_date: $("#invoice_date").val(),
                total_amount: parseFloat($("#salesTotalAmount").text()),
                sub_amount: 0,
                transaction_type_id: transaction_type,
                paid_amount: $("#paid_amount").val(),
                grand_total_amount: 0,
                productCustomizations: setCusomizationData,
                note: $("#note").val(),
            };



            axios
                .post(`/sales/create`, data)
                .then((response) => {
                    const data = response.data.data;
                    const status = response.data.status;
                    if (status == true) {
                        $(".submitbtn").text('Submit');
                        Toastr.fire({
                            icon: "success",
                            title: "Successfully created Sales",
                        });

                        setTimeout(() => {
                            window.location.href = `/sales/invoice/${data.id}`;
                        }, 1600);
                    } else {
                        Toastr.fire({
                            icon: "error",
                            title: "Something went wrong, Please try again.!",
                        });
                        $(".submitbtn").text('Submit');
                        $(".submitbtn").attr('disabled', false);
                    }
                });
        };



        const submitBtn = () => {
            const name = $('#createTransactionName').val();

            axios
                .post("/transaction-types/create", {
                    name: name
                })
                .then((response) => {
                    const data = response.data.data;
                    if (data) {
                        $("#sales_order_transaction_type").append(
                            `<option value="${data.transactionType.id}">${data.transactionType.name}</option>`
                        );

                        $(".ttAddedsuccssAlart").removeClass('d-none');

                        setTimeout(() => {
                            $(".ttAddedsuccssAlart").addClass('d-none');
                        }, 4000);
                    }
                });

        };






        // Function to populate product details
        const setProductDetails = (item) => {

            item.qty = item.qty? item.qty : 1;
            const tbody = $("#insertProductItemForSales");
            const tfoot = $("#insertProductItemForSales").next();
            const hasNoRecord = tbody.find("tr#no_record");
            const id = `row-${item.id}`;
            if (hasNoRecord) {
                hasNoRecord.addClass('hidden');
            }
            const rowWithId = tbody.find('#' + id) ? tbody.find('#' + id) :
                false;

            if (rowWithId.length == 0) {
                var rowHTML = `
            <tr id="${id}" class="slsord_line">
                <td class="col-3">
                    <input type="hidden" name="product_details[${item.id}][id]" value="${item.id}">
                    <input type="hidden" name="product_details[${item.id}][product_id]" value="${item.product_id}">
                    <input type="hidden" name="product_details[${item.id}][product_attribute_id]" value="${item.id}">
                    <small class="text-xs font-semibold">${item.product?.name ? item.product.name : ''}</small><br/>
                    <small class="text-xs font-semibold">${item.code ? item.code : ''} ${item.model ? ' / ' + item.model : ''} ${item.size ? ' / ' + item.size : ''} ${item.color ? ' / ' + item.color : ''}</small><br/>
                </td>
                <td>
                    <input type="number" name="product_details[${item.id}][qty]" value="${item.qty}" class="input_qty bg-focus form-control text-right" required="required">
                </td>
                <td>
                    <input type="number" name="product_details[${item.id}][sales_rate]" value="${item.sales_rate? item.sales_rate : 0}" class="bg-focus form-control text-right input_sales_rate" required="required">
                </td>
                <td>
                    <input type="number" name="product_details[${item.id}][discount]" value="0" class="input_discount bg-focus form-control text-right">
                    </td>
                    <td class="col-1 text-end total">
                        ${item.sales_rate? item.sales_rate * item.qty : 0}
                    </td>
                    <td class="remove-sales-order col-1">

                        <input type="hidden" name="product_details[${item.id}][total]" value="${item.sales_rate? item.sales_rate * item.qty : 0}" class="bg-focus form-control text-right input_total">
                    <span id="cancel" class="text-danger cursor-pointer d-block text-right" href="">
                        <i class="fa fa-trash fs-5 " aria-hidden="true"></i>
                    </span>
                </td>
            </tr>`;
                tbody.append(rowHTML);

                // Calculate total amount
                var total_amount = 0
                tbody.find('tr').each(function() {
                    // find td has total class
                    const total = parseFloat($(this).find('td.total').text().trim());
                    if (!isNaN(total)) {
                        total_amount += total;
                    }
                });



                const table_Foot = `
                <tr class="footer">
                        <td colspan="4" class="bg-success text-end">Total</td>
                        <td class="bg-success text-center" id="salesTotalAmount">${total_amount}</td>
                        <td class="bg-success text-center" id="salesTotalQty"></td>
                    </tr>
                `;

                $("#set_total_amount").val(total_amount);

                // if has already then delete
                tbody.find('tr.footer').remove();
                tbody.find('tr').last().after(table_Foot);


            } else {

                const qtyInput = rowWithId.find('td').eq(1).find('.input_qty');
                // input_total
                const input_total = rowWithId.find('.input_total');
                let salesRate = parseFloat(rowWithId.find('.input_sales_rate').val());
                let currentQty = parseInt(qtyInput.val()) + 1;
                qtyInput.val(currentQty);
                rowWithId.find('td').eq(4).html(currentQty * salesRate);
                input_total.val(currentQty * salesRate);

            }







            $(".remove-sales-order").click(function() {
                $(this).closest('tr').remove();
                if ($("#insertProductItemForSales").find('tr').length == 1) {
                    $("#insertProductItemForSales").find("tr#no_record").removeClass('hidden');
                }
            });

            $('.input_sales_rate, .input_qty, .input_discount').on('blur', updateTotalAmount);

            handleTotalGrandAmount();


        };

        function updateTotalAmount() {
            const rowWithId = $(this).closest('tr');
            const salesRate = parseFloat(rowWithId.find('.input_sales_rate').val());
            const currentQty = parseInt(rowWithId.find('.input_qty').val());
            const discount = parseFloat(rowWithId.find('.input_discount').val()) ||
                0; // Default to 0 if no discount
            const totalAmount = currentQty * (salesRate - discount); // Apply discount if any
            rowWithId.find('td').eq(4).html(totalAmount.toFixed(2));
            //  total amount calculation
            const tbody = $("#insertProductItemForSales");
            var total_amount = 0
            tbody.find('tr').each(function() {
                // find td has total class
                const total = parseFloat($(this).find('td.total').text().trim());
                if (!isNaN(total)) {
                    total_amount += total;
                }
            });
            tbody.find('tr.footer').find('td').eq(1).text(total_amount.toFixed(2));
            $("#set_total_amount").val(total_amount.toFixed(2));

            const input_total = rowWithId.find('.input_total');
            input_total.val(totalAmount);

            handleTotalGrandAmount();
        }


        const handleProductChange = () => {

            $("#product").on('change', function(e) {
                const p_id = $(this).val();
                axios
                    .get(
                        `/product/fetch-attribute?product_attribute_id=${p_id}`
                    )
                    .then((response) => {
                        const data = response.data.data;
                        setProductDetails(data);
                    });
            });
        };




        const handleCreateNewCustomer = () => {
            $("#addNewCustomerSubmitBtn").click(function() {
                let formData = {};
                $("#addNewCustomerModal [id]").each(function() {
                    const id = $(this).attr("id");
                    const value = $(this).val();
                    formData[id] = value;
                });
                axios.post("/customer/create", formData).then((response) => {
                    const data = response.data.data;
                    const message = response.data.message;
                    Toastr.fire({
                        icon: message,
                        title: data,
                    });
                    fetchCustomers();
                });
            });
        };

        const fetchCustomers = (customer_id = null) => {
            axios.get("/customer/fetch").then((response) => {
                const data = response.data.data;
                $("#customer").empty();
                data.forEach((item) => {
                    var option = '';
                    if (item.id == customer_id) {
                        option = `<option value="${item.id}" selected>${item.name}</option>`;
                    } else {
                        option = `<option value="${item.id}">${item.name}</option>`;
                    }
                    $("#customer").append(option);
                });


            });

        };

        const fetchProducts = () => {
            axios.get("/product/fetch?type=new-sales").then((response) => {
                const data = response.data.data;
                $("#product").empty();
                $("#product").append('<option value="">Select a product</option>');
                data.forEach((item) => {
                    const option =
                        `<option value="${item.id || ''}">
                            ${item.product?.name ? item.product.name : ''}
                            ${item.code ? ' / ' + item.code : ''}
                            ${item.model ? ' / ' + item.model : ''}
                            ${item.size ? ' / ' + item.size : ''}
                            ${item.color ? ' / ' + item.color : ''}
                            </option>`;
                    $("#product").append(option);
                });
            });
        };
    </script>
@endpush
