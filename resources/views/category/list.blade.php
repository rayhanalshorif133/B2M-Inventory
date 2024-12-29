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
            <div class="col-md-12">
                <div class="timeline">
                    <div class="time-label">
                        <span class="bg-navy w-100 d-flex justify-content-between">
                            <div class="pl-3 d-flex-centerd h-30px">
                                <span>
                                    Category Name
                                    <i class="fa-solid fa-check"></i>
                                    <i class="fa-solid fa-xmark hidden"></i>
                                </span>
                                <span>
                                    <input type="text" class="form-control hidden" />
                                </span>
                            </div>
                            <div class="btn-group mx-2">
                                <span class="btn btn-success btn-sm mx-1">Active</span>
                                <span class="btn btn-danger btn-sm mx-1 hidden">Inactive</span>
                                <span>
                                    <span class="btn btn-sm btn-info h-30px">
                                        <i class="fa-regular fa-pen-to-square"></i>
                                        Edit
                                    </span>
                                    <span class="btn btn-sm btn-purple h-30px hidden">
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

                    <div>
                        <i class="fas fa-tag bg-navy"></i>
                        <div class="timeline-item d-flex justify-content-between">
                            <h3 class="timeline-header text-navy">
                                <span>Subcategory Name</span>
                                <span>
                                    <input type="text" class="form-control hidden" />
                                </span>
                                <i class="fa-solid fa-check mx-1"></i>
                                <i class="fa-solid fa-xmark mx-1 hidden"></i>
                            </h3>
                            <div class="btn-group mx-2 d-flex-centerd">
                                <span class="btn btn-success btn-sm mx-1">Active</span>
                                <span class="btn btn-danger btn-sm mx-1 hidden">Inactive</span>
                                <span>
                                    <span class="btn btn-sm btn-teal h-30px">
                                        <i class="fa-regular fa-pen-to-square"></i>
                                        Edit
                                    </span>
                                    <span class="btn btn-sm btn-success h-30px hidden">
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

                    <div class="cursor-pointer addNewSubCategoryBtn">
                        <i class="fas fa-plus add-new-sub-btn-bg-success"></i>
                        <div class="timeline-item-add-new d-flex">
                            <h3 class="timeline-header col-2 text-white add-new-sub-btn-bg-success">
                                Add New Item
                            </h3>
                            <div class="mx-5 col-8 d-flex">
                                <input type="text" class="form-control" placeholder="Enter new Sub Category Name" />
                                <button type="button" class="btn btn-sm btn-success ml-2">
                                    Submit
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 mx-auto hidden">
                <p class="alert alert-danger text-center" style="font-size: 20px;" role="alert">
                    <b>Notice:</b> Empty Category List
                </p>
            </div>

        </div>
    </div>
@endsection
