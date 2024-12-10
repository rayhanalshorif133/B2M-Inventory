@extends('layouts.app', ['title' => 'Purchase Payment List'])

@section('content')
    <div class="content-wrapper">



        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Purchase Payment List</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item">
                                <a href="{{ route('home') }}" class="text-capitalize">home</a>
                                <span class="text-gray"> / </span>
                                <span class="text-gray">Purchase Payment List</span>
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <section class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-header justify-content-between d-flex">
                        <h3 class="card-title">Purchase Payment List</h3>
                        <div class="ml-auto">
                            {{-- click --}}
                            <button class="btn btn-sm btn-success mx-2" id="exportToExcel">
                                Export to Excel
                            </button>
                            <a class="btn btn-sm btn-success" href="/payment/purchase/pay">
                                Create New Purchase Pay
                            </a>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered display table-hover nowrap" id="purchasePayList"
                                style="width: 100%">
                                <thead>
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th style="width: 10px">Invoice Date</th>
                                        <th style="width: 10px">Suppler Name</th>
                                        <th style="width: 10px">Payment Amount</th>
                                        <th style="width: 10px">Actions</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>


    </div>
@endsection


@push('scripts')
    <script>
        var paymentEditModel = false;
        $(() => {

            handleDataTable();

            $("#exportToExcel").click(() => $(".exportToExcel").click());



            $(document).on("click", ".paymentEditBtn", function() {
                const id = $(this).data("id");
                axios.get(`/payment/fetch/${id}?type=purchase`).then((response) => {
                    const data = response.data.data;
                    const modalElement = document.getElementById("paymentEditModal");
                    paymentEditModel = new bootstrap.Modal(modalElement);
                    paymentEditModel.show();
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


        const hideShowSalesDetailsModal = () => {
            showSalesDetails.hide()
        };




        const handleDataTable = () => {
            $('#purchasePayList').DataTable().clear().destroy();
            url = '/purchase/payment-list?fetch=1';
            table = $('#purchasePayList').DataTable({
                processing: true,
                serverSide: true,
                ajax: url,
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
                        render: function(data, type, row) {
                            return row.DT_RowIndex;
                        },
                        targets: 0,
                    },
                    {
                        render: function(data, type, row) {
                            const date =
                                `<span>${row.created_date}</span> <span class="d-none">${row.receipt_no}</span>`;
                            return date;
                        },
                        targets: 0,
                    },
                    {
                        render: function(data, type, row) {

                            var name = row.supplier ? row.supplier.name : "No Assign";
                            return name;
                        },
                        targets: 0,
                    },
                    {
                        render: function(data, type, row) {
                            return row.amount;
                        },
                        targets: 0,
                    },
                    {
                        render: function(data, type, row) {
                            const btns = `<div class="btn-group">
                                <a href="/payment/purchase/pay-slip/${row.id}" type="button" class="btn btn-success btn-sm text-white">
                                 <i class="fa-regular fa-eye"></i> Pay Slip
                                </a>
                                <button type="button" class="btn btn-info btn-sm paymentEditBtn btn-fit" data-id="${row.id}">
                                        <i class="fa-solid fa-pen-to-square"></i> Edit
                                </button>
                                <button type="button" class="btn btn-danger btn-sm">
                                    Delete <i class="fa-solid fa-trash"></i>
                                </button>
                            </div>`;
                            return btns;
                        },
                        targets: 0,
                    },
                ]
            });

        };
    </script>
@endpush
