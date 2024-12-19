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
    </style>

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
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
                            <div class="card-body bg-white">
                                <form class="form-horizontal" action="" method="">

                                    <!-- Customer Name-->
                                    <div class="row mb-3">
                                        <label class="col-sm-2 col-md-2 text-capitalize" for="q_billing_status">Customer
                                            Name</label><br>
                                        <div class="col-sm-3 col-md-2 mb-3">
                                            <div class="form-group">
                                                <select class="form-control select2" id="customer"
                                                    style="width: 100%;"></select>
                                            </div>
                                        </div>
                                        <div class="col-sm-2 col-md-2 mb-2">
                                            <a class="btn btn-outline-success btn-sm ms-2" data-toggle="modal"
                                                data-target="#addNewCustomerModal">
                                                <svg class="svg-inline--fa fa-user-plus" aria-hidden="true"
                                                    focusable="false" data-prefix="fas" data-icon="user-plus" role="img"
                                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"
                                                    data-fa-i2svg="">
                                                    <path fill="currentColor"
                                                        d="M96 128a128 128 0 1 1 256 0A128 128 0 1 1 96 128zM0 482.3C0 383.8 79.8 304 178.3 304h91.4C368.2 304 448 383.8 448 482.3c0 16.4-13.3 29.7-29.7 29.7H29.7C13.3 512 0 498.7 0 482.3zM504 312V248H440c-13.3 0-24-10.7-24-24s10.7-24 24-24h64V136c0-13.3 10.7-24 24-24s24 10.7 24 24v64h64c13.3 0 24 10.7 24 24s-10.7 24-24 24H552v64c0 13.3-10.7 24-24 24s-24-10.7-24-24z">
                                                    </path>
                                                </svg>
                                                New Customer
                                            </a>
                                        </div>
                                        <label class="col-sm-2 col-md-2 control-label-required text-end"
                                            for="datepickerVal">Date Of
                                            Issue : </label>
                                        <div class="col-sm-3 col-md-3 position-relative">
                                            <div class="input-group has-validation">
                                                <input type="date" name="invoice_date" id="invoice_date"
                                                    value="{{ date('Y-m-d') }}" class="form-control" required="required">
                                            </div>
                                        </div>
                                    </div>

                                    @include('sales._partials.addNewCustomerModal', [
                                        'customers' => $customers,
                                    ])

                                    <!-- Voucher Number-->
                                    <div class="row mb-3">
                                        <label class="col-sm-2 control-label-required text-end">Sales Order #</label>
                                        <div class="col-sm-3">
                                            <label class="control-label align-middle">
                                                SLSODR/001
                                                <input autocomplete="off" type="hidden" value="SLSODR/005"
                                                    name="sales_order[voucher_number]" id="sales_order_voucher_number">
                                            </label>
                                        </div>
                                    </div>



                                    <div class="row mt-3">
                                        <label class="col-sm-2 control-label-required text-end text-capitalize"
                                            for="customer-name">Product
                                            Name</label>
                                        <div class="col-sm-10 mb-3">
                                            <div class="form-group">
                                                <select class="form-control select2" id="product" style="width: 100%;">
                                                    <option value="">Select Product</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mt-4" style="width: 100%;">
                                        <table class="table table-bordered">
                                            <thead class="light">
                                                <tr class="bg-light dark__bg-1000">
                                                    <th scope="col" class="col-3 control-label-required">Item Name</th>
                                                    <th scope="col" class="col-1 control-label-required">Qty</th>
                                                    <th scope="col" class="col-2 control-label-required">Sales Rate</th>
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
                                                <!-- Uncomment for future rows
                                                                              <tr id="subtotal-tr">
                                                                                <td class="border-0" colspan="4"></td>
                                                                                <td>Subtotal</td>
                                                                                <td class="text-end"> <span id="inv-total">0.00</span></td>
                                                                              </tr>
                                                                              <tr>
                                                                                <td class="border-0" colspan="4"></td>
                                                                                <td>Discount</td>
                                                                                <td class="text-end"><span id="est-discount">0.00</span></td>
                                                                              </tr>
                                                                              <tr>
                                                                                <td class="border-0" colspan="4"></td>
                                                                                <td>Tax</td>
                                                                                <td class="text-end"><span id="tax-amount">0.00</span></td>
                                                                              </tr>
                                                                              <tr>
                                                                                <td class="border-0" colspan="4"></td>
                                                                                <td>Due</td>
                                                                                <td class="text-end"><span id="due-amount">0.00</span></td>
                                                                              </tr>
                                                                              <tr class="bg-light border-top">
                                                                                <td colspan="4"></td>
                                                                                <td class="fw-bold">Total</td>
                                                                                <td class="fw-bold text-end" id="est-grand-total">0.00</td>
                                                                              </tr>
                                                                              -->
                                            </tbody>
                                        </table>

                                    </div>


                                    <div class="row mb-2">
                                        <div class="col-md-7">
                                            <div class="mb-3">
                                                <label class="form-label">Customer Notes</label>
                                                <textarea rows="4" class="bg-focus form-control" name="sales_order[customer_notes]"
                                                    id="sales_order_customer_notes"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <label class="form-label">Transaction Type</label>
                                            <select class="form-select bg-focus form-control"
                                                name="sales_order[transaction_type]" id="sales_order_transaction_type">
                                                <option value="cash">Cash</option>
                                                <option value="bkash">Bkash</option>

                                            </select>
                                        </div>
                                        <div class="col-md-3"><label class="form-label">Paid Amount</label>
                                            <input type="text" class="bg-focus form-control" name="paid_amount">
                                        </div>
                                    </div>

                                    <!-- Form Buttons-->
                                    <div class="row mt-4 justify-content-end">
                                        <div class="d-flex justify-content-end">
                                            <a class="btn btn-outline-danger" style="margin-right: 10px;"
                                                href="">Cancel</a>
                                            <button name="button" type="submit" class="btn btn-success me-2"
                                                style="width: 20vw;">
                                                Save
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">

                    </div>
                    <!-- /.card-footer-->
                </div>
                <!-- /.card -->
            </div>
            <div class="row d-none">
                <div class="col-md-12">
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">Update Sales</h3>
                        </div>
                        <div class="card-body">
                            <form>
                                <div class="row">

                                    <div class="col-md-12 col-lg-4">
                                        <div class="card card-navy">
                                            <div class="card-header">
                                                Product Details
                                            </div>
                                            <div class="card-body">
                                                <table class="table table-striped table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th colspan="4" class="text-center text-capitalize"
                                                                id="product_name">
                                                            </th>
                                                        </tr>
                                                        <tr>
                                                            <th>Attribute</th>
                                                            <th>Sales Rate</th>
                                                            <th>Stock</th>
                                                            <th>Actions</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="productAttributes">
                                                        <td colspan="4" class="text-center text-danger font-semibold">
                                                            Not Found
                                                        </td>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-lg-8 col-md-12">
                                        <div class="card card-success">
                                            <div class="card-header">Product Customization</div>
                                            <div class="card-body">
                                                <table class="table table-striped table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Particulars</th>
                                                            <th>Qty</th>
                                                            <th class="text-center">
                                                                Rate <br />
                                                                <small>Sales</small>
                                                            </th>
                                                            <th>Discount</th>
                                                            <th>Total</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="productCustomization"></tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <td colspan="2" class="bg-success text-end">Total</td>
                                                            <td class="bg-success text-center" id="salesTotalQty">0</td>
                                                            <td class="bg-success text-center"></td>
                                                            <td class="bg-success text-center"></td>
                                                            <td class="bg-success text-center" id="salesTotalAmount">0.00
                                                            </td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                                <div class="product_customization_note_amount mt-1">
                                                    <div class="product_customization_note">
                                                        <label class="mt-2 mx-2 w-8rem">Note:</label>
                                                        <textarea type="text" class="form-control" id="note" placeholder="Note"></textarea>
                                                    </div>
                                                    <div class="flex-column product_customization_amount">
                                                        <div class="d-flex mt-1">
                                                            <div>
                                                                <label class="w-8rem">Transaction Type</label>
                                                                <select class="form-control w-fit" id="transaction_type">
                                                                    @foreach ($transactionTypes as $trans)
                                                                        <option value="{{ $trans->id }}">
                                                                            {{ $trans->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="mx-2">
                                                                <label class="mx-2 w-8rem">Paid Amount</label>
                                                                <input type="text" class="form-control"
                                                                    placeholder="Paid amount" id="paid_amount" />
                                                            </div>
                                                        </div>
                                                        <div class="d-flex mt-1 justify-content-end">
                                                            <label>Due Amount: <span id="due_amount">00</span></label>
                                                        </div>
                                                        <div class="d-flex mt-1 justify-content-end">
                                                            <button class="btn btn-success btn-sm submitbtn"
                                                                type="button" onclick="handleSubmit()">Submit</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </section>

    </div>
@endsection


@push('scripts')
    <script>
        var SALESDATA = [];
        var setCusomizationData = [];
        var setProductAttributeData = [];
        $(document).ready(function() {
            fetchCustomers();
            fetchProducts();
            // fetchData();
            handleCreateNewCustomer();
            handleProductChange();
            // getProductAttributesByBarcode();
            // handlePaidAmount();
        });


        const handlePaidAmount = () => {
            $("#paid_amount").keyup(function() {
                const paidAmount = $(this).val();
                const salesTotalAmount = parseFloat($("#salesTotalAmount").text());
                var dueAmount = 0;
                dueAmount = salesTotalAmount - parseFloat(paidAmount);
                if (paidAmount > salesTotalAmount) {
                    Toastr.fire({
                        icon: "error",
                        title: "Payment amount is Error",
                    });
                    return false;
                }
                setTimeout(() => {
                    $(this).val(salesTotalAmount);
                    $("#due_amount").text(0);
                }, 4000);
                $("#due_amount").text(dueAmount);
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




        const getProductAttributesByBarcode = () => {

            $("#barcode").on('keyup', function(event) {
                if (event.code == "Enter" || event.code == "NumpadEnter") {
                    axios
                        .get(
                            `/product/fetch-attribute?barcode=${event.target.value}`
                        )
                        .then((response) => {
                            const data = response.data.data;
                            setProductDetails(data);
                        });
                }
            });

        };

        // Function to populate product details
        const setProductDetails = (item) => {

            const tbody = $("#insertProductItemForSales");
            const hasNoRecord = tbody.find("tr#no_record");
            const id = `row-${item.id}`;
            if (hasNoRecord) {
                hasNoRecord.addClass('hidden');
            }
            console.clear();
            const rowWithId = tbody.find('#' + id) ? tbody.find('#' + id) :
                false;



            if (rowWithId.length == 0) {


                var rowHTML = `
            <tr id="${id}" class="slsord_line">
                <td class="col-3">
                    <small class="text-xs font-semibold">${item.product?.name ? item.product.name : ''}</small><br/>
                    <small class="text-xs font-semibold">${item.code ? item.code : ''} ${item.model ? ' / ' + item.model : ''} ${item.size ? ' / ' + item.size : ''} ${item.color ? ' / ' + item.color : ''}</small><br/>
                </td>
                <td>
                    <input type="number" name="qty" value="1" class="bg-focus form-control text-right" required="required">
                </td>
                <td>
                    <input type="number" name="sales_rate" value="${item.sales_rate? item.sales_rate : 0}" class="bg-focus form-control text-right" required="required">
                </td>
                <td>
                    <input type="number" name="discount" value="0" class="bg-focus form-control text-right">
                </td>
                <td class="col-1 text-end total">${item.sales_rate? item.sales_rate : 0}</td>
                <td class="remove-sales-order col-1">
                    <span id="cancel" class="text-danger cursor-pointer d-block text-right" href="">
                        <i class="fa fa-trash fs-5 " aria-hidden="true"></i>
                    </span>
                </td>
            </tr>`;
                tbody.append(rowHTML);
            } else {
                const qtyInput = rowWithId.find('td').eq(1).find('input[name="qty"]');
                let salesRate = parseFloat(rowWithId.find('input[name="sales_rate"]').val());
                let currentQty = parseInt(qtyInput.val()) + 1;
                qtyInput.val(currentQty);
                rowWithId.find('td').eq(4).html(currentQty * salesRate);
            }


            $(".remove-sales-order").click(function() {
                $(this).closest('tr').remove();
                if ($("#insertProductItemForSales").find('tr').length == 1) {
                    $("#insertProductItemForSales").find("tr#no_record").removeClass('hidden');
                }
            });

            $('input[name="sales_rate"], input[name="qty"], input[name="discount"]').on('blur', updateTotalAmount);



        };

        function updateTotalAmount() {
            const rowWithId = $(this).closest('tr');
            const salesRate = parseFloat(rowWithId.find('input[name="sales_rate"]').val());
            const currentQty = parseInt(rowWithId.find('input[name="qty"]').val());
            const discount = parseFloat(rowWithId.find('input[name="discount"]').val()) || 0; // Default to 0 if no discount
            const totalAmount = currentQty * (salesRate - discount); // Apply discount if any
            rowWithId.find('td').eq(4).html(totalAmount.toFixed(2));
        }


        // Function to handle adding to product customization
        function addToProductCustomization(productAttrID) {

            const hasCusomizationData = setCusomizationData.find(item => item.id === productAttrID);

            if (hasCusomizationData) {
                hasCusomizationData.qty += 1;
                hasCusomizationData.total = hasCusomizationData.qty * hasCusomizationData.sales_rate;
            } else {
                const productAttr = setProductAttributeData.find(item => item.id === productAttrID);

                const SET_VALUE = {
                    id: productAttr.id,
                    p_code: productAttr.code,
                    product_attribute_id: productAttr.id,
                    p_name: productAttr.product.name,
                    product_id: productAttr.product.id,
                    p_color: productAttr.color,
                    p_model: productAttr.model,
                    p_size: productAttr.size,
                    p_model: productAttr.model,
                    purchase_rate: productAttr.purchase_rate,
                    sales_rate: productAttr.sales_rate,
                    qty: 0,
                    discount: 0,
                    total: 0,
                };
                setCusomizationData.push(SET_VALUE);
            }

            handleCusomizeData(setCusomizationData);
        }

        // Populate the product details when the page loads





        const handleCusomizeData = (setCusomizationData) => {
            const tbody = $("#productCustomization");
            var salesTotalQty = 0;
            var salesTotalAmount = 0;
            tbody.empty();
            if (setCusomizationData.length > 0) {
                setCusomizationData.forEach((item) => {
                    salesTotalQty += parseInt(item.qty);
                    salesTotalAmount += parseInt(item.total);
                    const row = $(`<tr data-product_id='${item.product_id}'>`);
                    row.html(`
                    <td><button type="button" class="btn btn-sm btn-danger" onclick="removeToProductCustomization(${item.id})"><i class="fa fa-minus"></i></button></td>
                <td>
                    <small class="text-xs font-semibold">${item.p_code || ""} -</small>
                    <small class="text-xs font-semibold">${item.p_name || ""}</small><br/>
                    <small class="text-xs font-semibold">${item.p_color || ""} -</small>
                    <small class="text-xs font-semibold">${item.p_model || ""} -</small>
                    <small class="text-xs font-semibold">${item.p_size || ""}</small>
                </td>
                <td><input type="number" value="${item.qty}" class="form-control changeSalesQty" /></td>
                <td><input type="number" value="${item.sales_rate}" class="form-control changeSalesRate" /></td>
                <td><input type="number" value="${item.discount}" class="form-control changeSalesDiscount" /></td>
                <td>
                    ${item.total}
                </td>
            `);

                    tbody.append(row);
                });
            } else {
                const notFoundRow = $("<tr>").html(`
            <td colspan="6" class="text-center text-danger font-semibold">
                Not Found
            </td>
        `);
                tbody.append(notFoundRow);
            }

            $("#salesTotalQty").text(salesTotalQty);
            $("#salesTotalAmount").text(salesTotalAmount);


            $(".changeSalesQty").on('blur', function(e) {
                const product_id = parseInt($(this).closest('tr').attr('data-product_id'));
                const qty = $(this).val();

                if (qty == '') {
                    return false;
                }
                setCusomizationData.forEach(item => {
                    if (item.product_id === product_id) {
                        item.qty = qty;
                        item.total = item.qty * (item.sales_rate - item.discount);
                    }
                });
                handleCusomizeData(setCusomizationData);
            });
            $(".changeSalesRate").on('blur', function(e) {
                const product_id = parseInt($(this).closest('tr').attr('data-product_id'));
                const sales_rate = $(this).val();

                if (sales_rate == '') {
                    return false;
                }
                setCusomizationData.forEach(item => {
                    if (item.product_id === product_id) {
                        item.sales_rate = sales_rate;
                        item.total = item.qty * (item.sales_rate - item.discount);
                    }
                });
                handleCusomizeData(setCusomizationData);
            });

            $(".changeSalesDiscount").on('blur', function(e) {
                const product_id = parseInt($(this).closest('tr').attr('data-product_id'));
                const discount = $(this).val();

                if (discount == '') {
                    return false;
                }
                setCusomizationData.forEach(item => {
                    if (item.product_id === product_id) {
                        item.discount = discount;
                        item.total = item.qty * (item.sales_rate - item.discount);
                    }
                });
                handleCusomizeData(setCusomizationData);
            });




        };

        const removeToProductCustomization = (targetId) => {
            const indexToDelete = setCusomizationData.findIndex(item => item.id === targetId);

            // If the item exists, remove it
            if (indexToDelete !== -1) {
                setCusomizationData.splice(indexToDelete, 1);
            }
            handleCusomizeData(setCusomizationData);
        };


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

        const fetchCustomers = () => {
            axios.get("/customer/fetch").then((response) => {
                const data = response.data.data;
                $("#customer").empty();
                $("#customer").append('<option value="" disabled selected>Select a customer</option>');
                data.forEach((item) => {
                    const option = `<option value="${item.id}">${item.name}</option>`;
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

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script type="text/javascript">
        $(function() {
            //Initialize Select2 Elements
            $('.select2').select2()
        })
    </script>
@endpush
