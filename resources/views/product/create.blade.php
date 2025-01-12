@php
    $title = 'Add New Product';
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
                    ['name' => 'Products', 'url' => route('product.list')],
                    ['name' => $title, 'url' => null],
                ],
            ]
        )

        <section class="content overflow-x-hidden">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">Create a new Product</h3>
                        </div>
                        <div class="card-body">
                            <nav>
                                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                    <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab"
                                        data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home"
                                        aria-selected="true" style="--setColor: #001f3f">
                                        <span style="color: #000000">Manual (Entry)</span>
                                    </button>
                                    <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab"
                                        data-bs-target="#nav-profile" type="button" role="tab"
                                        aria-controls="nav-profile" aria-selected="false" style="--setColor: #34a853">
                                        <span style="color: #000000">Auto (Via File)</span>
                                    </button>
                                </div>
                            </nav>
                            <div class="tab-content" id="nav-tabContent">
                                <div class="tab-pane fade show active" id="nav-home" role="tabpanel"
                                    aria-labelledby="nav-home-tab">
                                    <form class="mt-3" action="{{ route('product.create') }}" method="POST">
                                        @csrf
                                        @method('POST')
                                        <h3 class="text-lg font-medium">Product's Basic Information</h3>
                                        <div class="row">
                                            <div class="col-12 col-md-4">
                                                <div class="form-group">
                                                    <label for="selectCategory" class="required">Select a Category</label>
                                                    <select class="custom-select" id="selectCategory" name="category_id">
                                                        <option value="" selected disabled>Choose a Category</option>
                                                        @foreach ($categories as $category)
                                                            <option value="{{ $category->id }}">{{ $category->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-4">
                                                <div class="form-group">
                                                    <label for="selectSubCategory" class="required">Select a
                                                        Subcategory</label>
                                                    <select class="custom-select" name="sub_category_id"
                                                        id="selectSubCategory">
                                                        <option value="" selected disabled>Choose a Subcategory
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-4">
                                                <div class="form-group">
                                                    <label for="productName" class="required">Product Name</label>
                                                    <input class="form-control" id="productName" name="productName"
                                                        placeholder="Enter Product Name" />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="card card-navy">
                                            <div class="card-header">
                                                Product Details
                                            </div>
                                            <div class="card-body" id="product-details-container">
                                                <div class="detail-row">

                                                    <div class="row">
                                                        <div class="col-md-11">
                                                            <div class="row">
                                                                <!-- Product Code -->
                                                                <div class="col-md-3">
                                                                    <label for="product-code">Product Code</label>
                                                                    <input type="text" id="product-code"
                                                                        class="form-control"
                                                                        placeholder="Enter Product Code"
                                                                        name="product_details[0][product_code]">
                                                                </div>
                                                                <!-- Size -->
                                                                <div class="col-md-3">
                                                                    <label for="size">Size</label>
                                                                    <input type="text" id="size"
                                                                        class="form-control" placeholder="Enter Size"
                                                                        name="product_details[0][product_size]">
                                                                </div>
                                                                <!-- Model -->
                                                                <div class="col-md-3">
                                                                    <label for="model">Model</label>
                                                                    <input type="text" id="model"
                                                                        class="form-control" placeholder="Enter Model"
                                                                        name="product_details[0][product_model]">
                                                                </div>
                                                                <!-- Color -->
                                                                <div class="col-md-3">
                                                                    <label for="color">Color</label>
                                                                    <input type="text" id="color"
                                                                        class="form-control" placeholder="Enter Color"
                                                                        name="product_details[0][product_color]">
                                                                </div>
                                                                <!-- Current Stock -->
                                                                <div class="col-md-3 mt-3">
                                                                    <label for="current-stock">Current Stock</label>
                                                                    <input type="text" id="current-stock"
                                                                        class="form-control"
                                                                        placeholder="Enter Current Stock"
                                                                        name="product_details[0][current_stock]">
                                                                </div>
                                                                <!-- Unit Cost -->
                                                                <div class="col-md-3 mt-3">
                                                                    <label for="unit-cost">Unit Cost</label>
                                                                    <input type="text" id="unit-cost"
                                                                        class="form-control" placeholder="Enter Unit Cost"
                                                                        name="product_details[0][unit_cost]">
                                                                </div>
                                                                <!-- Sales Rate -->
                                                                <div class="col-md-3 mt-3">
                                                                    <label for="sales-rate">Sales Rate</label>
                                                                    <input type="text" id="sales-rate"
                                                                        class="form-control"
                                                                        placeholder="Enter Sales Rate"
                                                                        name="product_details[0][sales_rate]">
                                                                </div>
                                                                <!-- Last Purchase -->
                                                                <div class="col-md-3 mt-3">
                                                                    <label for="last-purchase">Last Purchase</label>
                                                                    <input type="text" id="last-purchase"
                                                                        class="form-control"
                                                                        placeholder="Enter Last Purchase"
                                                                        name="product_details[0][last_purchase]">
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-1">
                                                            <button type="button" class="btn btn-primary btn-sm mt-3"
                                                                id="add-detail">
                                                                <i class="fa-solid fa-plus"></i> Add
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <hr />

                                                </div>

                                            </div>
                                        </div>

                                        <button type="submit" class="btn btn-success btn-sm mt-3">
                                            Submit
                                        </button>
                                    </form>
                                </div>
                                <div class="tab-pane fade" id="nav-profile" role="tabpanel"
                                    aria-labelledby="nav-profile-tab">
                                    <form class="mt-3" enctype="multipart/form-data">
                                        <div class="row">
                                            <h3 class="text-lg font-medium">Product's Basic Information</h3>
                                            <div class="col-12 col-md-4">
                                                <div class="form-group">
                                                    <label for="importFile" class="required">Select an uploaded
                                                        file</label>
                                                    <input type="file" id="importFile" class="form-control"
                                                        accept=".xls, .xlsx" />
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-4 mt-5">
                                                <div class="d-flex mt-3">
                                                    <button type="button" class="btn btn-success btn-sm mx-3"
                                                        id="upload-btn">
                                                        Upload
                                                    </button>
                                                    <button type="button" class="btn btn-navy btn-sm mx-3"
                                                        id="sample-file">
                                                        Sample upload file
                                                        <i class="fa-solid fa-download mx-2"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>




    </div>
@endsection


@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/xlsx@0.18.5/dist/xlsx.full.min.js"></script>
    <script>
        $(document).ready(function() {

            // Dynamically populate subcategories based on selected category
            $('#selectCategory').on('change', function() {
                var categoryId = $(this).val();

                axios.get(`/category/fetch?type=product-create&category_id=${categoryId}`).then((res) => {
                    var subCategorySelect = $('#selectSubCategory');
                    subCategorySelect.empty();
                    subCategorySelect.append(
                        '<option value="" selected disabled>Choose a Subcategory</option>');
                    res.data.data.forEach((subCategory) => {
                        subCategorySelect.append(
                            `<option value="${subCategory.id}">${subCategory.name}</option>`
                        );
                    });
                });

            });

            // Add new product detail row
            var counter = 0;
            $('#add-detail').on('click', function() {
                counter = counter + 1;
                var detailRow = `
                <div class="detail-row">
                      <div class="row">
                           <div class="col-md-11">
                            <div class="col-md-11">
                        <div class="row">

                    <div class="col-md-3">
                        <label for="product-code">Product Code</label>
                        <input type="text" id="product-code" class="form-control" placeholder="Enter Product Code" name="product_details[${counter}][product_code]">
                    </div>
                    <!-- Size -->
                    <div class="col-md-3">
                        <label for="size">Size</label>
                        <input type="text" id="size" class="form-control" placeholder="Enter Size" name="product_details[${counter}][product_size]">
                    </div>
                    <!-- Model -->
                    <div class="col-md-3">
                        <label for="model">Model</label>
                        <input type="text" id="model" class="form-control" placeholder="Enter Model" name="product_details[${counter}][product_model]">
                    </div>
                    <!-- Color -->
                    <div class="col-md-3">
                        <label for="color">Color</label>
                        <input type="text" id="color" class="form-control" placeholder="Enter Color" name="product_details[${counter}][product_color]">
                    </div>
                    <!-- Current Stock -->
                    <div class="col-md-3 mt-3">
                        <label for="current-stock">Current Stock</label>
                        <input type="text" id="current-stock" class="form-control" placeholder="Enter Current Stock" name="product_details[${counter}][current_stock]">
                    </div>
                    <!-- Unit Cost -->
                    <div class="col-md-3 mt-3">
                        <label for="unit-cost">Unit Cost</label>
                        <input type="text" id="unit-cost" class="form-control" placeholder="Enter Unit Cost" name="product_details[${counter}][unit_cost]">
                    </div>
                    <!-- Sales Rate -->
                    <div class="col-md-3 mt-3">
                        <label for="sales-rate">Sales Rate</label>
                        <input type="text" id="sales-rate" class="form-control" placeholder="Enter Sales Rate" name="product_details[${counter}][sales_rate]">
                    </div>
                            <!-- Last Purchase -->
                            <div class="col-md-3 mt-3">
                                <label for="last-purchase">Last Purchase</label>
                                <input type="text" id="last-purchase" class="form-control" placeholder="Enter Last Purchase" name="product_details[${counter}][last_purchase]">
                            </div>
                                </div>
                            </div>

                             </div>
                            <div class="col-md-1">
                                <button type="button"
                                    class="btn btn-danger btn-sm mt-2 remove-detail">
                                    <i class="fa-solid fa-xmark"></i> Remove
                                </button>
                            </div>
                        </div>
                        <hr/>

                </div>
            `;
                $('#product-details-container').append(detailRow);
            });

            // Remove product detail row
            $(document).on('click', '.remove-detail', function() {
                $(this).closest('.detail-row').remove();
            });


            sampleUploadFile();



        });


        $(document).on('change', '#importFile', function(e) {
            handleFileUpload(e);
        });



        const handleFileUpload = (event) => {
            const file = event.target.files[0];
            console.log(file);

            if (file && file.type.includes("sheet")) {
                const reader = new FileReader();

                reader.onload = (e) => {
                    const data = new Uint8Array(e.target.result);
                    const workbook = XLSX.read(data, {
                        type: "array"
                    });

                    // Parse the first sheet
                    const sheetName = workbook.SheetNames[0];
                    const worksheet = workbook.Sheets[sheetName];

                    // Convert the sheet to JSON
                    var jsonData = XLSX.utils.sheet_to_json(worksheet);

                    jsonData = Array.from(jsonData.value);
                    console.log(jsonData);

                    Toastr.fire({
                        icon: "success",
                        title: "XLSX file read successfully",
                    });
                };

                // Read the file as binary
                reader.readAsArrayBuffer(file);
            } else {
                Toastr.fire({
                    icon: "error",
                    title: "Please upload a valid XLSX file.",
                });
            }
        };



        const sampleUploadFile = () => {


            $("#sample-file").click(function() {
                axios.get("/category/fetch").then((res) => {
                    const categories = res.data.data;
                    console.log(categories);
                    const data = [];
                    var listItem = 1;
                    categories.forEach((category) => {
                        console.log(category);
                        category.subCategories.map((item, index) => {
                            data.push({
                                List: listItem,
                                Category: category.name,
                                Subcategories: item.name,
                                "Product Name": "",
                                "Product Code (optional)": "",
                                "Product Size (optional)": "",
                                "Product Model (optional)": "",
                                "Product Color (optional)": "",
                                "Current Stock (optional)": "",
                                "Unit Cost (optional)": "",
                                "Sales Rate (optional)": "",
                                "Last Purchase (optional)": "",
                            });
                            listItem++;
                        });
                    });

                    // Create a worksheet from the data
                    const wsData = XLSX.utils.json_to_sheet(data);
                    wsData["!cols"] = [{
                            wch: 5
                        },
                        {
                            wch: 15
                        },
                        {
                            wch: 20
                        },
                        {
                            wch: 15
                        },
                        {
                            wch: 20
                        },
                        {
                            wch: 20
                        },
                        {
                            wch: 22
                        },
                        {
                            wch: 19.6
                        },
                        {
                            wch: 20
                        },
                        {
                            wch: 15.5
                        },
                        {
                            wch: 17
                        },
                        {
                            wch: 20
                        },
                    ];

                    XLSX.utils.sheet_add_aoa(
                        wsData,
                        [
                            [
                                "Product Upload Sample Template",
                                "Category",
                                "Subcategories",
                                "Product Name",
                                "Product Code (optional)",
                                "Product Size (optional)",
                                "Product Model (optional)",
                                "Product Color (optional)",
                                "Current Stock (optional)",
                                "Unit Cost (optional)",
                                "Sales Rate (optional)",
                                "Last Purchase (optional)",
                            ],
                        ], {
                            origin: "A1"
                        }
                    );
                    const wb = XLSX.utils.book_new();

                    if (!wsData["!merges"]) wsData["!merges"] = [];
                    wsData["!merges"].push({
                        s: {
                            r: 0,
                            c: 0
                        },
                        e: {
                            r: 0,
                            c: 11
                        }
                    });

                    XLSX.utils.sheet_add_json(wsData, data, {
                        origin: "A2"
                    });
                    XLSX.utils.book_append_sheet(wb, wsData, "Categories");

                    XLSX.writeFile(wb, "product_upload_template.xlsx");
                });
            });






        };
    </script>
@endpush
