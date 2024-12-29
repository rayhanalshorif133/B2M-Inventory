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
                                    <form class="mt-3">
                                        <div class="row">
                                            <h3 class="text-lg font-medium">Product's Basic Information</h3>
                                            <div class="col-12 col-md-4">
                                                <div class="form-group">
                                                    <label for="selectCategory" class="required">Select a Category</label>
                                                    <select class="custom-select" id="selectCategory">
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
                                                    <select class="custom-select" id="selectSubCategory">
                                                        <option value="" selected disabled>Choose a Subcategory
                                                        </option>
                                                        <!-- Options will be dynamically populated -->
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
                                                        <div class="col-md-6">
                                                            <input type="text" class="form-control"
                                                                placeholder="Detail Name">
                                                        </div>
                                                        <div class="col-md-6">
                                                            <input type="text" class="form-control"
                                                                placeholder="Detail Value">
                                                        </div>
                                                    </div>
                                                    <button type="button"
                                                        class="btn btn-danger btn-sm mt-2 remove-detail">Remove</button>
                                                </div>
                                                <button type="button" class="btn btn-primary btn-sm mt-3"
                                                    id="add-detail">Add Detail</button>
                                            </div>
                                        </div>

                                        <button type="button" class="btn btn-success btn-sm mt-3" id="submit-btn">
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
                                                    <label for="importFile" class="required">Select an uploaded file</label>
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
    <script>
        $(document).ready(function() {
            // Dynamically populate subcategories based on selected category
            $('#selectCategory').on('change', function() {
                var categoryId = $(this).val();

                axios.get(`/category/fetch?type=product-create&category_id=${categoryId}`).then((res) => {
                   var subCategorySelect = $('#selectSubCategory');
                    subCategorySelect.empty();
                    subCategorySelect.append('<option value="" selected disabled>Choose a Subcategory</option>');
                    res.data.data.forEach((subCategory) => {
                        subCategorySelect.append(`<option value="${subCategory.id}">${subCategory.name}</option>`);
                    });
                });

            });

            // Add new product detail row
            $('#add-detail').on('click', function() {
                var detailRow = `
                <div class="detail-row">
                    <div class="row">
                        <div class="col-md-6">
                            <input type="text" class="form-control" placeholder="Detail Name">
                        </div>
                        <div class="col-md-6">
                            <input type="text" class="form-control" placeholder="Detail Value">
                        </div>
                    </div>
                    <button type="button" class="btn btn-danger btn-sm mt-2 remove-detail">Remove</button>
                </div>
            `;
                $('#product-details-container').append(detailRow);
            });

            // Remove product detail row
            $(document).on('click', '.remove-detail', function() {
                $(this).closest('.detail-row').remove();
            });

            // Handle form submission
            $('#submit-btn').on('click', function() {
                alert('Form submitted!'); // Replace with your form submission logic
            });
        });
    </script>
@endpush
