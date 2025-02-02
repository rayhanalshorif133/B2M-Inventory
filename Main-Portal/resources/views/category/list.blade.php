@extends('layouts.app', ['title' => 'Category List'])

@section('content')
    <div class="content-wrapper overflow-x-hidden">

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
                                <span class="text-gray">Category List</span>
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <div class="row px-5">
            {{-- make forease --}}
            @foreach ($categories as $item)
                <div class="col-md-12">
                    <div class="timeline">
                        <div class="time-label">
                            <span class="bg-navy w-100 d-flex justify-content-between">
                                <div class="pl-3 d-flex-centerd h-30px category_info" data-id="{{ $item->id }}">
                                    <span id="category_info-{{ $item->id }}">
                                        {{ $item->name }}
                                        @if ($item->status == 1)
                                            <span class="badge bg-success mx-1 h-fit">Active</span>
                                        @else
                                            <span class="badge bg-danger mx-1 h-fit">Inactive</span>
                                        @endif
                                    </span>
                                    <span class="hidden my-1">
                                        <input type="text" class="form-control mx-1" value="{{ $item->name }}"
                                            style="height:33px" />
                                        <select class="form-select mx-1" style="height:33px">
                                            <option value="1" @if ($item->status == 1) selected @endif>Active
                                            </option>
                                            <option value="0" @if ($item->status == 0) selected @endif>
                                                Inactive</option>
                                        </select>
                                    </span>
                                </div>
                                <div class="btn-group mx-2">
                                    <span>
                                        <span class="btn btn-sm btn-info h-30px editCategoryBtn">
                                            <i class="fa-regular fa-pen-to-square"></i>
                                            Edit
                                        </span>
                                        <span class="btn btn-sm btn-purple h-30px hidden updateCategoryBtn">
                                            <i class="fa-solid fa-check"></i>
                                            Update
                                        </span>
                                    </span>
                                    <span class="btn btn-danger btn-sm d-none">
                                        Delete <i class="fa-solid fa-trash"></i>
                                    </span>
                                </div>
                            </span>
                        </div>



                        @foreach ($item->subCategories as $subItem)
                            <div>
                                <i class="fas fa-tag bg-navy"></i>
                                <div class="timeline-item d-flex justify-content-between">
                                    <div class="timeline-header text-nav" data-id="{{ $subItem->id }}">
                                        <span id="category_info-{{ $subItem->id }}">
                                            {{ $subItem->name }}
                                            @if ($subItem->status == 1)
                                                <span class="badge bg-success mx-1 h-fit">Active</span>
                                            @else
                                                <span class="badge bg-danger mx-1 h-fit">Inactive</span>
                                            @endif
                                        </span>
                                        <span class="hidden my-1">
                                            <input type="text" class="form-control mx-1" value="{{ $subItem->name }}"
                                                style="height:33px" />
                                            <select class="form-select mx-1" style="height:33px">
                                                <option value="1" @if ($subItem->status == 1) selected @endif>
                                                    Active
                                                </option>
                                                <option value="0" @if ($subItem->status == 0) selected @endif>
                                                    Inactive</option>
                                            </select>
                                        </span>
                                    </div>
                                    <div class="btn-group mx-2 d-flex-centerd">
                                        <span>
                                            <span class="btn btn-sm btn-info h-30px editCategoryBtn">
                                                <i class="fa-regular fa-pen-to-square"></i>
                                                Edit
                                            </span>
                                            <span class="btn btn-sm btn-purple h-30px hidden updateCategoryBtn">
                                                <i class="fa-solid fa-check"></i>
                                                Update
                                            </span>
                                        </span>
                                        <span class="btn btn-brown btn-sm h-30px d-none">
                                            Delete <i class="fa-solid fa-trash"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @endforeach


                        <div class="cursor-pointer">
                            <i class="fas fa-plus add-new-sub-btn-bg-success mt-2"></i>
                            <div class="timeline-item-add-new d-flex">
                                <div class="col-12 col-sm-12 col-md-5 col-lg-4 d-flex">
                                    <input type="text" class="form-control" id="newSubCat-{{ $item->id }}" placeholder="Enter new Sub Category Name" />
                                    <button type="button" class="btn btn-sm btn-success ml-2 addNewSubCategoryBtn"
                                        data-category_id="{{ $item->id }}">
                                        Submit
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            {{-- end of foreach --}}

            <div class="col-md-12 mx-auto hidden">
                <p class="alert alert-danger text-center" style="font-size: 20px;" role="alert">
                    <b>Notice:</b> Empty Category List
                </p>
            </div>

        </div>
    </div>
@endsection


@push('scripts')
    <script>
        $(document).ready(function() {
            handleEditCategory();
            handleNewCategory();
            console.clear();
        });

        const handleNewCategory = () => {


            $(".addNewSubCategoryBtn").click(function() {
                const category_id = $(this).data("category_id");
                const newSubCategoryName = $(`#newSubCat-${category_id}`).val();
                axios
                    .put(`/category/add-new-sub/${category_id}`, {
                        name: newSubCategoryName,
                    })
                    .then(function(response) {
                        const status = response.data.status;
                        const message = response.data.message;
                        if (status == true) {
                            Toastr.fire({
                                icon: "success",
                                title: "New Subcategory added successfully",
                            });
                            setTimeout(() => {
                                location.reload();
                            }, 1000);
                        }else{
                            Toastr.fire({
                                icon: "error",
                                title: message,
                            });
                        }
                    });
            });


        }

        const handleEditCategory = () => {
            $(".editCategoryBtn").click(function() {
                $(this).addClass("hidden");
                $(this).next().removeClass("hidden");
                const category_info = $(this).closest("div").prev().find("span").first();
                const category_edit = $(this).closest("div").prev().find("span").last();
                category_info.addClass("hidden");
                category_edit.removeClass("hidden").addClass("d-flex");
            });

            $(".updateCategoryBtn").click(function() {
                $(this).addClass("hidden");
                $(this).prev().removeClass("hidden");
                const category_info = $(this).closest("div").prev().find("span").first();
                const category_edit = $(this).closest("div").prev().find("span").last();
                category_info.removeClass("hidden");
                category_edit.addClass("hidden").removeClass("d-flex");

                // get values
                const category_id = $(this).closest("div").prev().data("id");
                const category_name = $(this).closest("div").prev().find("span").last().find("input").val();
                const category_status = $(this).closest("div").prev().find("span").last().find("select").val();

                axios
                    .put(`/category/update/${category_id}`, {
                        name: category_name,
                        status: category_status,
                    })
                    .then((response) => {
                        var {
                            name,
                            status,
                            id
                        } = response.data.data;
                        status = status == "1" ? 'active' : 'inactive';
                        const bg_color = status == 'active' ? 'bg-success' : 'bg-danger';
                        var categoryInfo = $("#category_info-" + id);

                        categoryInfo.html(
                            `${name} <span class="badge ${bg_color} mx-1 h-fit">${status}</span>`);

                        Toastr.fire({
                            icon: "success",
                            title: "Successfully updated category",
                        });
                    });


            });
        };
    </script>
@endpush
