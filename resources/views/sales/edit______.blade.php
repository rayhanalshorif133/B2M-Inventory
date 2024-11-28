@extends('layouts.app', ['title' => 'Sales Update'])

@section('content')
    <div class="content-wrapper">

        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Sales Update</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item">
                                <a href="{{ route('home') }}" class="text-capitalize">home</a>
                                <span class="text-gray"> / </span>
                                <span class="text-gray">Sales Update</span>
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
                                                <input type="date" id="invoice_date" class="form-control w-10rem" />
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
                                                    <tbody>
                                                        <tr>
                                                            <td>
                                                                <button type="button" class="btn btn-sm btn-danger">
                                                                    <i class="fa fa-minus"></i>
                                                                </button>
                                                            </td>
                                                            <td>
                                                                <span>Product Code</span>
                                                                <span>-</span>
                                                                <span>Product Name</span>
                                                                <br />
                                                                <small>
                                                                    <span>Product Model</span>
                                                                    <span>-</span>
                                                                    <span>Color</span>
                                                                    <span>-</span>
                                                                    <span>Size</span>
                                                                </small>
                                                            </td>
                                                            <td>
                                                                <input type="number" class="form-control" />
                                                            </td>
                                                            <td>
                                                                <input type="number" class="form-control" />
                                                            </td>
                                                            <td>
                                                                <input type="number" class="form-control" />
                                                            </td>
                                                            <td>0.00</td>
                                                        </tr>
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <td colspan="2" class="bg-success text-end">Total</td>
                                                            <td class="bg-success text-center">0</td>
                                                            <td class="bg-success text-center"></td>
                                                            <td class="bg-success text-center"></td>
                                                            <td class="bg-success text-center">0.00</td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                                <div class="product_customization_note_amount mt-1">
                                                    <div class="product_customization_note">
                                                        <label class="mt-2 mx-2 w-8rem">Note:</label>
                                                        <textarea type="text" class="form-control" placeholder="Note"></textarea>
                                                    </div>
                                                    <div class="flex-column product_customization_amount">
                                                        <div class="d-flex mt-1">
                                                            <div>
                                                                <label class="w-8rem">Transaction Type</label>
                                                                <select class="form-control w-fit" id="transaction_type"
                                                                    name="transaction_type">
                                                                    @foreach ($transactionTypes as $trans)
                                                                        <option value="{{ $trans->id }}">
                                                                            {{ $trans->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="mx-2">
                                                                <label class="mx-2 w-8rem">Paid Amount</label>
                                                                <input type="text" class="form-control"
                                                                    placeholder="Paid amount" />
                                                            </div>
                                                        </div>
                                                        <div class="d-flex mt-1 justify-content-end">
                                                            <label>Due Amount: 0.00</label>
                                                        </div>
                                                        <div class="d-flex mt-1 justify-content-end">
                                                            <button class="btn btn-success btn-sm" type="button"
                                                                disabled>Submit</button>
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
        $(document).ready(function() {
            fetchCustomers();
            fetchProducts();
            fetchData();
            handleCreateNewCustomer();
            handleProductChange();
            getProductAttributesByBarcode();
        });


        // Example data to simulate fetched product details
        var productDetails = {
            product_name: "Sample Product",
            productAttributes: [{
                id: 1,
                code: "P001",
                color: "Red",
                model: "M1",
                size: "L",
                sales_rate: 150,
                current_stock: 10
            }, ],
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
                            ? `<button type="button" class="btn btn-sm btn-success" onclick="addToProductCustomization(${item.id})">
                                                                                                    Add <i class="fa fa-plus"></i>
                                                                                                  </button>`
                            : ""
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
        function addToProductCustomization(productId) {
            alert(`Product ID ${productId} added to customization!`);
        }

        // Populate the product details when the page loads


        const fetchData = () => {
            const id = window.getId();
            axios.get(`/sales/fetch/${id}`).then((response) => {
                const data = response.data.data;
                SALESDATA.push(data);
                $("#customer").val(data.sales.company_id);
                return false;
                getdata.value = data;
                paid_amount.value = data.sales.paid_amount;
                due_amount.value = data.sales.due_amount;
                note.value = data.sales.note;
                selected_transaction_type.value = 1;
                invoice_date.value = data.sales.invoice_date;
                if (data.salesDetails.length > 0) {
                    data.salesDetails.map((item) => {
                        const SET_VALUE = {
                            id: item.id,
                            p_code: item.product_attribute.code,
                            product_attribute_id: item.product_attribute.id,
                            p_name: item.product.name,
                            product_id: item.product.id,
                            p_color: item.product_attribute.color,
                            p_model: item.product_attribute.model,
                            p_size: item.product_attribute.size,
                            p_model: item.product_attribute.model,
                            purchase_rate: item.purchase_rate,
                            sales_rate: item.sales_rate,
                            qty: item.qty,
                            discount: item.discount,
                            total: item.total,
                        };
                        productCustomizations.value = [
                            ...productCustomizations.value,
                            SET_VALUE,
                        ];
                    });
                }

            });
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
                $("#customer").append('<option value="">Select a customer</option>');
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
