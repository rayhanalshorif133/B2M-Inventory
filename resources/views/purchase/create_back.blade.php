@php
    $title = 'add new purchase';
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
                    ['name' => 'Purchases', 'url' => route('purchase.index')],
                    ['name' => $title, 'url' => null],
                ],
            ]
        )

        {{-- <purchase-create-component></purchase-create-component> --}}

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
                        <div class="card mb-3 mt-2" data-controller="calculate-purchase-order">
                            @include('purchase._partials.addNewSupplierModal', [
                                'suppliers' => $suppliers,
                            ])
                            <div class="card-body bg-white">
                                <form class="form-horizontal purchaseCreateForm" action="{{ route('purchase.create') }}"
                                    method="POST">
                                    @csrf
                                    @method('POST')
                                    <!-- supplier Name-->
                                    <div class="row mb-3">
                                        <label class="col-sm-2 col-md-2 text-capitalize" for="q_billing_status">Supplier
                                            Name</label><br>
                                        <div class="col-sm-3 col-md-2 mb-3">
                                            <div class="form-group">
                                                <select class="form-control select2" id="select_suppliers"
                                                    name="purchase_order[supplier_id]" style="width: 10rem;"></select>
                                            </div>
                                        </div>
                                        <div class="col-sm-2 col-md-2 mb-2">
                                            <a class="btn btn-outline-success btn-sm ms-2" data-toggle="modal"
                                                data-target="#addNewSupplierModal">
                                                <i class="fa fa-plus" style="color: #0a7822"></i>
                                                New Supplier
                                            </a>
                                        </div>
                                        <label class="col-sm-2 col-md-2 control-label-required text-end"
                                            for="datepickerVal">Date Of
                                            Issue : </label>
                                        <div class="col-sm-3 col-md-3 position-relative">
                                            <div class="input-group has-validation">
                                                <input type="date" name="purchase_order[invoice_date]" id="invoice_date"
                                                    value="{{ date('Y-m-d') }}" class="form-control" required="required">
                                            </div>
                                        </div>
                                    </div>



                                    <!-- Voucher Number-->
                                    <div class="row mb-3">
                                        <label class="col-sm-2 control-label-required text-end">Purchase Order #</label>
                                        <div class="col-sm-3">
                                            <label class="control-label align-middle">
                                                {{ $purchaseCode }}
                                                <input autocomplete="off" type="hidden" value="{{ $purchaseCode }}"
                                                    name="purchase_order[voucher_number]">
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
                                                    <th scope="col" class="col-2 control-label-required">Purchases Rate</th>
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
                                                <textarea rows="4" class="bg-focus form-control" name="purchase_order[supplier_note]"
                                                    id="purchase_order_supplier_notes"></textarea>
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
                                                        name="purchase_order[total_discount]" id="total_discount"
                                                        value="0" />
                                                    <p class="d-flex mt-2 ">
                                                        <label class="form-label mx-2 font-size-14px">Grand Total
                                                            Amount:</label>
                                                        <label class="form-label text-success font-size-14px"
                                                            id="grand_total_amount">00</label>
                                                        <input type="hidden" class="bg-focus form-control"
                                                            name="purchase_order[grand_total_amount]"
                                                            id="set_grand_total_amount" />
                                                    </p>
                                                </div>

                                            </div>
                                            <div class="row mt-2">
                                                <div class="col-12 col-md-6">
                                                    <label class="form-label font-size-14px">Transaction Type</label>
                                                    <select class="form-select bg-focus form-control"
                                                        name="purchase_order[transaction_type]"
                                                        id="purchase_order_transaction_type">
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
                                                        id="set_total_amount" name="purchase_order[total_amount]">
                                                    <input type="text" class="bg-focus form-control"
                                                        name="purchase_order[paid_amount]" id="paid_amount" />
                                                    <p class="d-flex mt-2 ">
                                                        <label class="form-label mx-2 font-size-14px">Due Amount:</label>
                                                        <label class="form-label text-danger font-size-14px"
                                                            id="due_amount">00</label>
                                                        <input type="hidden" class="bg-focus form-control"
                                                            name="purchase_order[due_amount]" id="set_due_amount" />
                                                    </p>
                                                </div>
                                            </div>
                                        </div>


                                    </div>

                                    <!-- Form Buttons-->
                                    <div class="row mt-4 justify-content-end">
                                        <div class="d-flex justify-content-end">
                                            <a class="btn btn-outline-danger" style="margin-right: 10px;"
                                                href="{{ route('product.create') }}">Reset</a>
                                            <button type="button" class="btn btn-success me-2 purchaseCreateSubmitBtn"
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

    </div>
@endsection

@push('scripts')
    <script>
        var SALESDATA = [];
        var setCusomizationData = [];
        var setProductAttributeData = [];
        $(document).ready(function() {
            fetchSuppliers();
            fetchProducts();
            handleCreateNewSupplier();
            handleProductChange();
            handlePaidAmount();

            $(".purchaseCreateSubmitBtn").click(function() {
                $(this).text('Processing ...').prop('disabled', true);

                $(".purchaseCreateForm").submit();
            });

        });


        const handleTotalGrandAmount = () => {
            const total_discount = parseFloat($("#total_discount").val());
            const total_amount = parseFloat($("#set_total_amount").val());
            const grand_total_amount = total_amount - total_discount;
            $("#grand_total_amount").text(grand_total_amount);
            $("#set_grand_total_amount").val(grand_total_amount);
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






        // Function to populate product details
        const setProductDetails = (item) => {

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
                    <input type="hidden" name="product_details[${item.id}][product_id]" value="${item.product.id}">
                    <input type="hidden" name="product_details[${item.id}][product_attribute_id]" value="${item.id}">
                    <small class="text-xs font-semibold">${item.product?.name ? item.product.name : ''}</small><br/>
                    <small class="text-xs font-semibold">${item.code ? item.code : ''} ${item.model ? ' / ' + item.model : ''} ${item.size ? ' / ' + item.size : ''} ${item.color ? ' / ' + item.color : ''}</small><br/>
                </td>
                <td>
                    <input type="number" name="product_details[${item.id}][qty]" value="1" class="input_qty bg-focus form-control text-right" required="required">
                </td>
                <td>
                    <input type="number" name="product_details[${item.id}][last_purchase]" value="${item.last_purchase? item.last_purchase : 0}" class="bg-focus form-control text-right input_last_purchase" required="required">
                </td>
                <td>
                    <input type="number" name="product_details[${item.id}][discount]" value="0" class="input_discount bg-focus form-control text-right">
                    </td>
                    <td class="col-1 text-end total">
                        ${item.last_purchase? item.last_purchase : 0}
                    </td>
                    <td class="remove-sales-order col-1">
                        <input type="hidden" name="product_details[${item.id}][total]" value="${item.last_purchase? item.last_purchase : 0}" class="bg-focus form-control text-right input_total">
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
                let salesRate = parseFloat(rowWithId.find('.input_last_purchase').val());
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

            $('.input_last_purchase, .input_qty, .input_discount').on('blur', updateTotalAmount);

            handleTotalGrandAmount();


        };

        function updateTotalAmount() {
            const rowWithId = $(this).closest('tr');
            const salesRate = parseFloat(rowWithId.find('.input_last_purchase').val());
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


        // Function to handle adding to product customization
        function addToProductCustomization(productAttrID) {

            const hasCusomizationData = setCusomizationData.find(item => item.id === productAttrID);

            if (hasCusomizationData) {
                hasCusomizationData.qty += 1;
                hasCusomizationData.total = hasCusomizationData.qty * hasCusomizationData.last_purchase;
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
                    last_purchase: productAttr.last_purchase,
                    qty: 0,
                    discount: 0,
                    total: 0,
                };
                setCusomizationData.push(SET_VALUE);
            }

            handleCusomizeData(setCusomizationData);
        }







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




        const handleCreateNewSupplier = () => {
            $("#addNewSupplierSubmitBtn").click(function() {
                let formData = {};
                $("#addNewSupplierModal [id]").each(function() {
                    const id = $(this).attr("id");
                    const value = $(this).val();
                    formData[id] = value;
                });

                console.log(formData);

                axios.post("/supplier/create", formData).then((response) => {
                    const data = response.data.data;
                    const message = response.data.message;
                    Toastr.fire({
                        icon: message,
                        title: data,
                    });
                    fetchSuppliers();
                });
            });
        };

        const fetchSuppliers = () => {
            axios.get("/supplier/fetch").then((response) => {
                const data = response.data.data;
                $("#select_suppliers").empty();
                $("#select_suppliers").append('<option value="" disabled selected>Select a supplier</option>');
                data.forEach((item) => {
                    const option = `<option value="${item.id}">${item.name}</option>`;
                    $("#select_suppliers").append(option);
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
