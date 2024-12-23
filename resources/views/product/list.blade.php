@extends('layouts.app', ['title' => 'Product List'])

@section('content')
    <div class="content-wrapper">




        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Product List</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item">
                                <a href="{{ route('home') }}" class="text-capitalize">home</a>
                                <span class="text-gray"> / </span>
                                <span class="text-gray">Product List</span>
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <section class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h3 class="card-title">Product List</h3>
                        <div class="ml-auto">
                            <a href="{{ route('product.create') }}" class="btn btn-sm btn-success">Create New Product</a>
                            <button class="btn btn-sm btn-success mx-2" id="exportToExcel">
                                Export to Excel
                            </button>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive" style="width: 100%">
                            <table class="table table-bordered display table-hover nowrap" id="productList"
                                style="width: 100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Category</th>
                                        <th>Sub Category</th>
                                        <th>Status</th>
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


        {{-- show product details --}}
        <div class="modal fade" id="showProductDetails" tabindex="-1" aria-labelledby="showProductDetailsLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="showProductDetailsLabel">
                            Product Details
                        </h5>
                        <button type="button" class="btn-close" onclick="hideshowProductDetailsModal()"></button>
                    </div>
                    <div class="modal-body">
                        <div class="card card-info">
                            <h5 class="card-header">Basic Information</h5>
                            <div class="card-body">
                                <div class="row showProductBasicInfo">
                                    <input type="hidden" class="form-control" id="show_product_id" />
                                    <div class="card-text col-12 col-md-4"><b>Product Name:</b> <br> <span
                                            id="details_product_name"></span>
                                    </div>
                                    <div class="card-text col-12 col-md-4"><b>Product Category:</b> <br> <span
                                            id="details_product_category"></span></div>
                                    <div class="card-text col-12 col-md-4"><b>Product Sub Category:</b> <br> <span
                                            id="details_product_subcategory"></span></div>

                                </div>
                                <div class="row editProductBasicInfo hidden">
                                    <div class="col-12 col-md-4">
                                        <div class="form-group">
                                            <label for="productName" class="required">Product Name</label>
                                            <input type="text" class="form-control" id="productName" name="productName"
                                                placeholder="Enter Product Name" />
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <div class="form-group">
                                            <label for="productCategory" class="required">Product Category</label>
                                            <select class="custom-select" id="productCategory" name="productCategory">
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <div class="form-group">
                                            <label for="productSubCategory" class="required">Product Sub Category</label>
                                            <select class="custom-select" id="productSubCategory" name="productSubCategory">
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <button class="btn btn-primary btn-sm mt-2 editProductBasicInfoBtn">
                                    <span><i class="fa-solid fa-pen-to-square"></i> Edit</span>
                                </button>
                                <button class="btn btn-success btn-sm mt-2 checkProductBasicInfoBtn hidden">
                                    <span><i class="fa-solid fa-check"></i> Update</span>
                                </button>
                            </div>
                        </div>

                        <div class="card card-navy">
                            <h5 class="card-header">Product Details</h5>
                            <div class="mx-4">
                                <span id="setProductAttrDetails"></span>
                                <div class="row addNewProductAttr hidden">
                                    <div class="col-md-3 col-12 col-sm-2 mb-3">
                                        <label for="productCode" class="form-label optional">Code</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="productCode" value="">
                                            <span class="btn btn-primary btn-sm" type="button" id="generateCodeButton">
                                                <i class="fa-solid fa-rotate-right text-white"></i>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-md-3 col-12 col-sm-2 mb-3">
                                        <label for="size" class="form-label optional">Size</label>
                                        <input type="number" class="form-control" id="size" value="">
                                    </div>
                                    <div class="col-md-3 col-12 col-sm-2 mb-3">
                                        <label for="model" class="form-label optional">Model</label>
                                        <input type="text" class="form-control" id="model" value="">
                                    </div>
                                    <div class="col-md-3 col-12 col-sm-2 mb-3">
                                        <label for="color" class="form-label optional">Color</label>
                                        <input type="text" class="form-control" id="color" value="">
                                    </div>
                                    <div class="col-md-3 col-12 col-sm-2 mb-3">
                                        <label for="currentStock" class="form-label optional">Current Stock</label>
                                        <input type="number" class="form-control" id="currentStock" value="">
                                    </div>
                                    <div class="col-md-3 col-12 col-sm-2 mb-3">
                                        <label for="unitCost" class="form-label optional">Unit Cost</label>
                                        <input type="number" class="form-control" id="unitCost" value="">
                                    </div>
                                    <div class="col-md-3 col-12 col-sm-2 mb-3">
                                        <label for="salesRate" class="form-label optional">Sales Rate</label>
                                        <input type="number" class="form-control" id="salesRate" value="">
                                    </div>
                                    <div class="col-md-3 col-12 col-sm-2 mb-3">
                                        <label for="lastPurchase" class="form-label optional">Last Purchase</label>
                                        <input type="number" class="form-control" id="lastPurchase" value="">
                                    </div>
                                </div>
                                <div class="my-2">
                                    <button class="btn btn-sm btn-navy addNewProductAttrBtn">
                                        <i class="fa fa-plus"></i> Added New
                                    </button>
                                    <button class="btn btn-sm btn-danger addNewProductAttrBtnCancel hidden">
                                        <i class="fa fa-times"></i> Cancel
                                    </button>
                                    <button class="btn btn-sm btn-success addNewProductAttrBtnSubmit hidden">
                                        <i class="fa fa-check"></i> Submit
                                    </button>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary text-white"
                            onclick="hideshowProductDetailsModal()">
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>



    </div>
@endsection


@push('scripts')
    <script>
        var showProductDetails = false;
        var table = "";


        $(() => {

            handleDataTable();

            // $("#exportToExcel").click(() => $(".exportToExcel").click());

            handleProductDetailsEdit();
            addNewAddNewProductAttrBtn();

            $(document).on("click", ".showBtn", function() {

                const id = $(this).data("id");
                $("#show_product_id").val(id);

                showProductDetails = new bootstrap.Modal(document.getElementById(
                    'showProductDetails'));
                showProductDetails.show();


                axios.get(`/product/show-product-details/${id}`).then((response) => {
                    const {
                        product,
                        productAttributes
                    } = response.data.data;


                    // set Product Details
                    $('#details_product_name').text(product.name);
                    $('#details_product_category').text(product.category.name);
                    $('#details_product_subcategory').text(product.sub_category.name);



                    // set Product's Attributes
                    var productDetailsHTML = productAttributes.map(function(product) {
                        return `<div class="mt-2">
                                        <div class="productAttrContainer">
                                            <div class="d-flex justify-content-between px-2 showProductAttrDetails">
                                                <p><b>Code:</b> <span id="showProductAttrCode-${product.id}">${product.code ? product.code : 'Not Set'}</span></p>
                                                <p><b>Size:</b> <span id="showProductAttrSize-${product.id}">${product.size ? product.size : 'Not Set'}</span></p>
                                                <p><b>Model:</b> <span id="showProductAttrModel-${product.id}">${product.model ? product.model : 'Not Set'}</span></p>
                                                <p><b>Color:</b> <span id="showProductAttrColor-${product.id}">${product.color ? product.color : 'Not Set'}</span></p>
                                            </div>


                                            <div class="d-flex justify-content-between px-2 showProductAttrDetails">
                                                <p><b>Current Stock:</b> ${product.current_stock ? product.current_stock : 'Not Set'}</p>
                                                <p><b>Unit Cost:</b> ${product.unit_cost ? product.unit_cost : 'Not Set'}</p>
                                                <p><b>Sales Rate:</b>
                                                <span id="showProductAttrSalesRate-${product.id}">${product.sales_rate ? product.sales_rate : 'Not Set'}</span>
                                                    </p>

                                                <p><b>Last Purchase:</b> ${product.last_purchase ? product.last_purchase : 'Not Set'}</p>
                                            </div>
                                            <div class="row px-2 hidden">
                                                <input type="hidden" id="productAttrId" value="${product.id}">
                                                <div class="mb-3 col-4">
                                                    <label for="productCode" class="form-label"><b>Code:</b></label>
                                                    <input type="text" id="productCode_${product.id}" name="productCode" class="form-control" value="${product.code ? product.code : ''}" placeholder="Not Set">
                                                </div>
                                                <div class="mb-3 col-4">
                                                    <label for="productSize" class="form-label"><b>Size:</b></label> <br/>
                                                    <input type="text" id="productSize_${product.id}" class="form-control" value="${product.size ? product.size : ''}" placeholder="Not Set">
                                                </div>
                                                <div class="mb-3 col-4">
                                                    <label for="productModel" class="form-label"><b>Model:</b></label> <br/>
                                                    <input type="text" id="productModel_${product.id}" class="form-control" value="${product.model ? product.model : ''}" placeholder="Not Set">
                                                </div>
                                                <div class="mb-3 col-4">
                                                    <label for="productColor" class="form-label"><b>Color:</b></label> <br/>
                                                    <input type="text" id="productColor_${product.id}" class="form-control" value="${product.color ? product.color : ''}" placeholder="Not Set">
                                                </div>
                                                <div class="mb-3 col-4">
                                                    <label for="productSalesRate" class="form-label"><b>Sales Rate:</b></label> <br/>
                                                    <input type="text" id="productSalesRate_${product.id}" class="form-control" value="${product.sales_rate ? product.sales_rate : ''}" placeholder="Not Set">
                                                </div>
                                            </div>
                                        </div>
                                        <button class="btn btn-primary btn-sm mt-2 editProductAttribute">
                                            <span><i class="fa-solid fa-pen-to-square"></i> Edit</span>
                                        </button>
                                        <button class="btn btn-success btn-sm mt-2 checkProductAttribute hidden">
                                            <span><i class="fa-solid fa-check"></i> Done</span>
                                        </button>
                                        <hr>
                             </div>
                            `;
                    }).join('');

                    $('#setProductAttrDetails').html(productDetailsHTML);
                });


            });


            $(document).on('click', '.editProductAttribute', function() {
                $(this).parent().find('.productAttrContainer').find('.hidden').toggleClass('hidden')
                    .toggleClass('d-flex')
                $(this).parent().find('.showProductAttrDetails').toggleClass('hidden').toggleClass(
                    'd-flex');
                $(this).addClass('hidden');
                $(this).parent().find('.checkProductAttribute').removeClass('hidden');
            });

            $(document).on('click', '.checkProductAttribute', function() {
                $(this).parent().find('.productAttrContainer').find('.d-flex').toggleClass('hidden')
                    .toggleClass('d-flex')
                $(this).parent().find('.showProductAttrDetails').toggleClass('hidden').toggleClass(
                    'd-flex');
                $(this).addClass('hidden');
                $(this).parent().find('.editProductAttribute').removeClass('hidden');

                const productAttrId = $("#productAttrId").val();
                const productAttrData = {
                    code: $(`#productCode_${productAttrId}`).val(),
                    size: $(`#productSize_${productAttrId}`).val(),
                    model: $(`#productModel_${productAttrId}`).val(),
                    color: $(`#productColor_${productAttrId}`).val(),
                    sales_rate: $(`#productSalesRate_${productAttrId}`).val(),
                };
                axios.put(`/product/update/${productAttrId}?type=attr-info`, productAttrData)
                    .then(function(res) {
                        const data = res.data.data;
                        $(`#showProductAttrCode-${data.id}`).text(data.code ? data.code : 'Not Set');
                        $(`#showProductAttrSize-${data.id}`).text(data.size ? data.size : 'Not Set');
                        $(`#showProductAttrModel-${data.id}`).text(data.model ? data.model : 'Not Set');
                        $(`#showProductAttrColor-${data.id}`).text(data.color ? data.color : 'Not Set');
                        $(`#showProductAttrSalesRate-${data.id}`).text(data.sales_rate ? data
                            .sales_rate : 'Not Set');

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

        const addNewAddNewProductAttrBtn = () => {
            $(document).on('click', '.addNewProductAttrBtn', function() {
                $(".addNewProductAttr").toggleClass('hidden');
                $(".addNewProductAttrBtnCancel").toggleClass('hidden');
                $(".addNewProductAttrBtnSubmit").toggleClass('hidden');
                $(this).toggleClass('hidden');
            });

            $(document).on('click', '.addNewProductAttrBtnCancel', function() {
                $(".addNewProductAttr").toggleClass('hidden');
                $(".addNewProductAttrBtnCancel").toggleClass('hidden');
                $(".addNewProductAttrBtnSubmit").toggleClass('hidden');
                $(".addNewProductAttrBtn").toggleClass('hidden');
            });


            // add new product attribute
            $(document).on('click', '.addNewProductAttrBtnSubmit', function() {
                const product_id = $("#show_product_id").val();

                console.log(product_id);
                return false;
                const productAttrData = {
                    code: $("#productCode").val(),
                    size: $("#size").val(),
                    model: $("#model").val(),
                    color: $("#color").val(),
                    current_stock: $("#currentStock").val(),
                    unit_cost: $("#unitCost").val(),
                    sales_rate: $("#salesRate").val(),
                    last_purchase: $("#lastPurchase").val(),
                };
                axios.post(`/product/${product_id}/add-new-attr`, productAttrData)
                    .then(function(res) {
                        const data = res.data.data;
                    });
            });
        }


        const handleProductDetailsEdit = () => {
            $(document).on('click', '.editProductBasicInfoBtn', function() {
                var cateogryData = [];
                const product_id = $("#show_product_id").val();
                $(".showProductBasicInfo").toggleClass('hidden');
                $(".editProductBasicInfo").toggleClass('hidden');
                $(".checkProductBasicInfoBtn").toggleClass('hidden');
                $(this).toggleClass('hidden');
                axios.get(`/category/fetch`).then((response) => {
                    const data = response.data.data;

                    var html = '';
                    data.map((item) => {
                        html += `<option value="${item.id}">${item.name}</option>`;
                    });
                    $("#productCategory").html(html);
                    cateogryData = data;
                });

                axios.get(`/product/show-product-details/${product_id}`).then((response) => {
                    const {
                        product
                    } = response.data.data;
                    $("#productName").val(product.name);
                    $("#productCategory").val(product.company_id);
                    const {
                        subCategories
                    } = cateogryData.find((item) => item.id == product.company_id);
                    html = '';
                    subCategories.map((item) => {
                        html += `<option value="${item.id}">${item.name}</option>`;
                    });
                    $("#productSubCategory").html(html);
                });

                $("#productCategory").on('change', function() {
                    const {
                        subCategories
                    } = cateogryData.find((item) => item.id == $(this).val());
                    html = '';
                    subCategories.map((item) => {
                        html += `<option value="${item.id}">${item.name}</option>`;
                    });
                    $("#productSubCategory").html(html);
                });
            });
            $(document).on('click', '.checkProductBasicInfoBtn', function() {
                const product_id = $("#show_product_id").val();
                $(".showProductBasicInfo").toggleClass('hidden');
                $(".editProductBasicInfo").toggleClass('hidden');
                $(".editProductBasicInfoBtn").toggleClass('hidden');
                $(this).toggleClass('hidden');
                const data = {
                    'category_id': $("#productCategory").val(),
                    'sub_category_id': $("#productSubCategory").val(),
                    'name': $("#productName").val(),
                };



                axios.put(`/product/update/${product_id}?type=basic-info`, data)
                    .then(function(res) {
                        const data = res.data.data;
                        $('#details_product_name').text(data.name);
                        $('#details_product_category').text(data.category.name);
                        $('#details_product_subcategory').text(data.sub_category.name);
                    });
            });
        }


        const hideshowProductDetailsModal = () => {
            showProductDetails.hide()
        };






        const handleDataTable = () => {
            $('#productList').DataTable().clear().destroy();
            url = '/product/list?type=fetch';
            $('#productList').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '/product/list?type=fetch', // Replace this with your API endpoint
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
                        data: 'name', // Display the product name
                        targets: 1
                    },
                    {
                        data: 'category.name', // Display the category name
                        targets: 2
                    },
                    {
                        data: 'sub_category.name', // Display the sub-category name
                        targets: 3
                    },
                    {
                        render: function(data, type, row) {
                            const status = `<span class="badge ${
                    row.status == 1 ? "bg-success" : "bg-danger"
                }">
                    ${row.status == 1 ? "Active" : "Inactive"}</span>`;
                            return status;
                        },
                        targets: 4
                    },
                    {
                        render: function(data, type, row) {
                            const btns = `
                    <div class="btn-group">
                        <button type="button" class="btn btn-info btn-sm text-white showBtn"
                            data-id="${row.id}">
                            <i class="fa-regular fa-eye"></i> Show
                        </button>
                        <button type="button" class="btn statusBtn ${
                            row.status == 0 ? "btn-success" : "btn-danger"
                        } btn-sm text-white" data-id="${row.id}">
                            ${row.status == 0 ? "Activate" : "Deactivate"} <i class="fa-solid ${
                    row.status == 0 ? "fa-check" : "fa-xmark"
                }"></i>
                        </button>
                    </div>`;
                            return btns;
                        },
                        targets: 5
                    }
                ]
            });


        };
    </script>
@endpush

