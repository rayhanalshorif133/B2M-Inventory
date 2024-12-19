@extends('layouts.app', ['title' => 'Product List'])

@section('content')
    <div class="content-wrapper">


        {{-- <product-list-component></product-list-component> --}}


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
                        <button type="button" class="btn-close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="card card-info">
                            <h5 class="card-header">Basic Information</h5>
                            <div class="card-body">
                                <div class="row">
                                    <div class="card-text col-12 col-md-4"><b>Product Name:</b> <br> <span
                                            id="details_product_name"></span></div>
                                    <div class="card-text col-12 col-md-4"><b>Product Category:</b> <br> <span
                                            id="details_product_category"></span></div>
                                    <div class="card-text col-12 col-md-4"><b>Product Sub Category:</b> <br> <span
                                            id="details_product_subcategory"></span></div>

                                </div>
                                <button class="btn btn-primary btn-sm mt-2">
                                    <span><i class="fa-solid fa-pen-to-square"></i> Edit</span>
                                </button>
                            </div>
                        </div>

                        <div class="card card-navy">
                            <h5 class="card-header">Product Details</h5>
                            <div class="mx-4">
                                <span id="setProductAttrDetails"></span>
                                <div class="my-2">
                                    <button class="btn btn-sm btn-navy">
                                        <i class="fa fa-plus"></i> Added New
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary text-white">
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







            $(document).on("click", ".showBtn", function() {

                const id = $(this).data("id");

                showProductDetails = new bootstrap.Modal(document.getElementById(
                    'showProductDetails')); // Create the modal instance
                showProductDetails.show();


                axios.get(`/product/show-product-details/${id}`).then((response) => {
                    const {
                        product,
                        productAttributes
                    } = response.data.data;


                    // set Product Details
                    $('#details_product_name').text(product.name);
                    $('#details_product_category').text(product.category.name);
                    $('#details_product_subcategory').text(product.sub_category
                        .name);



                    // set Product's Attributes
                    var productDetailsHTML = productAttributes.map(function(product) {
                        console.log(product);
                        return `
                                   <div class="mt-2">
                                <div>
                                    <div class="d-flex justify-content-between px-2">
                                        <p><b>Code:</b> ${product.code ? product.code : 'Not Set'}</p>
                                        <p><b>Size:</b> ${product.size ? product.size : 'Not Set'}</p>
                                        <p><b>Model:</b> ${product.model ? product.model : 'Not Set'}</p>
                                        <p><b>Color:</b> ${product.color ? product.color : 'Not Set'}</p>
                                    </div>
                                    <div class="d-flex justify-content-between px-2">
                                        <p><b>Current Stock:</b> ${product.current_stock ? product.current_stock : 'Not Set'}</p>
                                        <p><b>Unit Cost:</b> ${product.unit_cost ? product.unit_cost : 'Not Set'}</p>
                                        <p><b>Sales Rate:</b> ${product.sales_rate ? product.sales_rate : 'Not Set'}</p>
                                        <p><b>Last Purchase:</b> ${product.last_purchase ? product.last_purchase : 'Not Set'}</p>
                                    </div>
                                </div>
                                <button class="btn btn-primary btn-sm mt-2">
                                    <span><i class="fa-solid fa-pen-to-square"></i> Edit</span>
                                </button>
                                        <hr>
                                    </div>
                            `;
                    }).join('');

                    $('#setProductAttrDetails').html(productDetailsHTML);
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
