@extends('layouts.app', ['title' => 'Dashboard'])

@php
    $title = 'Transaction Type List';
@endphp

@section('content')
    <div class="content-wrapper">



        @include(
            '_partials.breadcrumb',
            ['title' => $title],
            [
                'items' => [['name' => 'Home', 'url' => route('home')], ['name' => $title, 'url' => null]],
            ]
        )



        <section class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <h3 class="card-title">Transaction Type List</h3>
                        <div class="ml-auto">
                            <button class="btn btn-sm btn-navy mx-2" onclick="showModal()">
                                Add New Transaction Type
                            </button>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive" style="width: 100%">
                            <table class="table table-bordered display table-hover nowrap" id="transactionTypeList"
                                style="width: 100%">
                                <thead>
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th>Name</th>
                                        <th>Added By</th>
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

        <!-- Modal -->
        <div class="modal fade" id="transactionTypeModal" tabindex="-1" aria-labelledby="transactionTypeModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="transactionTypeModalLabel">
                            Add New Transaction Type
                        </h5>
                        <button type="button" class="btn-close" onclick="hideModal()"></button>
                    </div>
                    <div class="modal-body">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="name" class="d-flex mx-1">
                                    Transaction Type Name
                                    <span class="text-danger mx-1">*</span>
                                </label>
                                <input type="hidden" class="form-control" id="action_type" value="create" />
                                <input type="hidden" class="form-control" id="tt_id" value="" />
                                <input class="form-control" id="name" name="name" value="{{ old('name') }}"
                                    placeholder="Enter a Transaction Type Name" />
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" onclick="hideModal()">
                            Close
                        </button>
                        <button type="button" onclick="submitBtn()" class="btn btn-primary">
                            Save
                        </button>
                    </div>
                </div>
            </div>
        </div>




    </div>
@endsection


@push('scripts')
    <script>
        $(() => {
            handleDataTable();
            handleEditButton();
            handleStatusButton();
        });


        // handleStatusButton
        const handleStatusButton = () => {
            $('#transactionTypeList').on('click', '.statusBtn', function() {
                const id = $(this).data('id');
                Swal.fire({
                    title: "Are you sure?",
                    text: "You won't be able to revert this!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yes, delete it!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        axios
                            .put("/transaction-types/update?type=status", {
                                tt_id: id
                            })
                            .then((response) => {
                                const data = response.data.data;
                                const message = response.data.message;
                                setTimeout(() => {
                                    hideModal();
                                    handleDataTable();
                                }, 1000);
                            });
                        Swal.fire({
                            title: "Deleted!",
                            text: "Your file has been deleted.",
                            icon: "success"
                        });
                    }
                });

            });
        };

        // handleEditButton
        const handleEditButton = () => {
            $('#transactionTypeList').on('click', '.editBtn', function() {
                const id = $(this).data('id');
                const name = $(this).data('name');
                $('#transactionTypeModalLabel').text('Update Transaction Type');
                $('#name').val(name);
                $('#action_type').val('update');
                $('#tt_id').val(id);
                $('#transactionTypeModal').modal('show');
            });
        };




        const showModal = () => {
            $('#transactionTypeModal').modal('show');
            $('#action_type').val('create');
            $('#tt_id').val('');
            $('#name').val('');
            $('#transactionTypeModalLabel').text('Add New Transaction Type');
        };

        // hideModal
        const hideModal = () => {
            $('#transactionTypeModal').modal('hide');
        };

        // submitBtn
        const submitBtn = () => {
            const name = $('#name').val();
            const action_type = $('#action_type').val();
            if (name == '') {
                toastr.error('Transaction Type Name is required');
                return;
            }


            if (action_type == 'create') {
                axios
                    .post("/transaction-types/create", {
                        name: name
                    })
                    .then((response) => {
                        const data = response.data.data;
                        const message = response.data.message;
                        setTimeout(() => {
                            hideModal();
                            handleDataTable();
                        }, 1000);
                    });
            } else {
                const id = $('#tt_id').val();
                axios
                    .put("/transaction-types/update", {
                        tt_id: id,
                        name: name
                    })
                    .then((response) => {
                        const data = response.data.data;
                        const message = response.data.message;
                        setTimeout(() => {
                            hideModal();
                            handleDataTable();
                        }, 1000);
                    });
            }

        };



        const handleDataTable = () => {
            $('#transactionTypeList').DataTable().clear().destroy();
            url = '/transaction-types?type=fetch';
            $('#transactionTypeList').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: url,
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
                        render: function(data, type, row) {
                            return row.added_by
                                .name; // Display the name of the user who added the product
                        },
                        targets: 4
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
                             <button type="button" class="btn btn-info btn-sm text-white editBtn"
                            data-id="${row.id}" data-name="${row.name}">
                            Edit <i class="fa-solid fa-pencil"></i>
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
