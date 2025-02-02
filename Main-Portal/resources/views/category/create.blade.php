@extends('layouts.app', ['title' => 'Add New Category'])

@section('content')
    <div class="content-wrapper">



        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Category List</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item">
                                <a href="{{ route('home') }}" class="text-capitalize">home</a>
                                <span class="text-gray"> / </span>
                                <a href="{{ route('category.list') }}" class="text-capitalize">Category List</a>
                                <span class="text-gray"> / </span>
                                <span class="text-gray">add new category</span>
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-primary">
                        <div class="card-header">
                            <h3 class="card-title">Create a new Category</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('category.create') }}" method="POST">
                                @csrf
                                <div class="row">
                                    <h3 class="text-lg font-medium">
                                        Category Information
                                    </h3>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="name" class="required">Name</label>
                                            <input type="text" id="name" name="category_name" class="form-control"
                                                placeholder="Enter category name" />
                                        </div>
                                    </div>
                                    <h3 class="text-lg font-medium">
                                        <span class="mr-5">Subcategory Information</span>
                                        <button type="button" class="btn btn-navy btn-sm add_new_subcategoryBtn">
                                            <i class="fa-solid fa-plus"></i> Add New
                                        </button>
                                    </h3>
                                </div>


                                <div class="row added_new_subcategory">
                                    <div class="col-md-11">
                                        <div class="form-group">
                                            <label for="name" class="required">Sub Category Name</label>
                                            <input type="text" class="form-control" name="subCategories[]"
                                                placeholder="Enter your name" />
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <div style="margin-top: 34px">
                                            <button class="btn btn-sm btn-danger remove_new_subcategory" type="button">
                                                <i class="fa-solid fa-minus"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <div></div>
                                <div>
                                    <button class="btn btn-primary btn-sm" type="submit">
                                        Submit
                                    </button>
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
        $(() => {
            // add_new_subcategoryBtn
            $('.add_new_subcategoryBtn').on('click', function() {
                const HTML = `<div class="row">
                                    <div class="col-md-11">
                                        <div class="form-group">
                                            <label for="name" class="required">Sub Category Name</label>
                                            <input type="text" class="form-control" name="subCategories[]"
                                                placeholder="Enter your name" />
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <div style="margin-top: 34px">
                                            <button class="btn btn-sm btn-danger remove_new_subcategory" type="button">
                                                <i class="fa-solid fa-minus"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>`;
                $('.added_new_subcategory').next().append(HTML);
            });


            $(document).on('click', '.remove_new_subcategory', function() {
                $(this).closest('.row').remove();
                $(this).remove();
            });
        });
    </script>
@endpush
