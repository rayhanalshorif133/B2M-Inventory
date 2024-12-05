@extends('layouts.app', ['title' => 'Add New Sales'])

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
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">Update Sales</h3>
                        </div>
                        <div class="card-body">
                            <form>
                                <div class="row">
                                    <div class="col-12 col-md-7 col-lg-7">
                                        <div class="form-group d-flex">
                                            <label for="customer" class="d-flex mx-1">Customer
                                                <span class="text-danger mx-1">*</span></label>
                                            <select class="form-control" id="customer">
                                                <option value="">Select a customer</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-5 col-lg-5">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <button data-toggle="modal" data-target="#addNewCustomerModal"
                                                    class="btn btn-navy btn-sm h-2" type="button">
                                                    <i class="fa fa-plus"></i> Add
                                                    New
                                                </button>
                                            </div>
                                            <div class="col-md-8 d-flex">
                                                <label for="invoice_date" class="d-flex mx-1 w-8rem">Invoice Time:
                                                    <span class="text-danger mx-1">*</span></label>
                                                <input type="date" id="invoice_date" class="form-control w-10rem"
                                                    value="{{ date('Y-m-d') }}" />
                                            </div>
                                        </div>
                                        @include('sales._partials.addNewCustomerModal', [
                                            'customers' => $customers,
                                        ])
                                    </div>
                                    <div class="col-12 col-md-7 col-lg-7">
                                        <div class="form-group d-flex">
                                            <label for="Product" class="d-flex mx-1">Product
                                                <span class="text-danger mx-1">*</span></label>
                                            <select class="form-control" id="product" name="product">
                                                <option value="" selected disabled>
                                                    Select a product
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-5 col-lg-5 row">
                                        <input type="text" id="barcode" class="form-control" placeholder="Barcode" />
                                    </div>
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
        const setProductDetails = (productAttributes) => {
            if (productAttributes.length > 0) {
                $("#product_name").text(productAttributes[0].product.name);
            }
            const tbody = $("#productAttributes");
            tbody.empty();
            if (productAttributes.length > 0) {
                productAttributes.forEach((item) => {
                    const row = $("<tr>");
                    row.html(`
                <td>
                    <small class="text-xs font-semibold">${item.code || ""}</small><br/>
                    <small class="text-xs font-semibold">${item.color || ""}</small><br/>
                    <small class="text-xs font-semibold">${item.model || ""}</small><br/>
                    <small class="text-xs font-semibold">${item.size || ""}</small>
                </td>
                <td>${item.sales_rate}</td>
                <td>${item.current_stock}</td>
                <td>
                    ${
                        parseInt(item.current_stock) > 0
                            ? `<button type="button" class="btn btn-sm btn-success"
                                                onclick="addToProductCustomization(${item.id})"> Add <i class="fa fa-plus"></i> </button>`
                            : "No Stock Available"
                    }
                </td>
            `);

                    tbody.append(row);
                });
            } else {
                const notFoundRow = $("<tr>").html(`
            <td colspan="4" class="text-center text-danger font-semibold">
                Not Found
            </td>
        `);
                tbody.append(notFoundRow);
            }
        };


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
                        `/product/fetch-attribute?product_id=${p_id}`
                    )
                    .then((response) => {
                        const data = response.data.data;
                        setProductAttributeData = [];
                        setProductAttributeData = data;
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
            axios.get("/product/fetch").then((response) => {
                const data = response.data.data;
                $("#product").empty();
                $("#product").append('<option value="">Select a product</option>');
                data.forEach((item) => {
                    const option =
                        `<option value="${item.id}">${item.name}</option>`;
                    $("#product").append(option);
                });
            });
        };
    </script>
@endpush
