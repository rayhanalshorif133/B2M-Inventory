@extends('layouts.app', ['title' => 'Sales List'])

@section('content')
    <div class="content-wrapper">



        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Sales Due Collection</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item">
                                <a href="{{ route('home') }}" class="text-capitalize">home</a>
                                <span class="text-gray"> / </span>
                                <span class="text-gray">Sales Due Collection</span>
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
                        <h3 class="card-title">Sales list</h3>
                        <div class="ml-auto">
                            <button class="btn btn-sm btn-success mx-2" id="exportToExcel">
                                Export to Excel
                            </button>
                            <a class="btn btn-sm btn-success" href="/sales/create">
                                Create New Sales
                            </a>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive" style="width: 100%">
                            <table class="table table-bordered display table-hover nowrap" id="salesDueCollectionList"
                                style="width: 100%">
                                <thead>
                                    <tr>
                                        <th style="width: 10px">#</th>
                                        <th style="width: 10px">Customer Name</th>
                                        <th style="width: 10px">Phone Number</th>
                                        <th style="width: 10px">Due Amount</th>
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


        <div class="modal fade" id="quickSalesPay" tabindex="-1" aria-labelledby="quickSalesPayLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header card-outline card-info">
                        <h5 class="modal-title" id="quickSalesPayLabel">
                            Payment Received
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                            onclick="quickSalesPayModalHide()"></button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <input type="hidden" id="customerId" name="customerId" />
                            <div>
                                <p>
                                    <b>Customer Name:</b>
                                    <span id="customerName"></span>
                                </p>
                                <p>
                                    <b>Customer Phone Number: </b>
                                    <span id="customerPhoneNumber"></span>
                                </p>
                                <p>
                                    <b>Total Due: </b>
                                    <span id="totalDue"></span>
                                </p>
                            </div>
                            <div class="mt-3">
                                <div class="col-12 mt-1">
                                    <label>Transaction Type</label>
                                    <select class="form-select" id="transactionType">
                                        <option value="0" selected>Select a transaction type</option>
                                        @foreach ($transactionTypes as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-12 mt-1">
                                    <label>Received Amount</label>
                                    <div class="d-flex">
                                        <input type="number" class="form-control w-full mr-1" id="paymentAmount" />
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" onclick="quickSalesPayModalHide()">
                            Close
                        </button>
                        <button type="button" class="btn btn-primary" onclick="handleSubmit()">
                            Submit
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection



@push('scripts')
    <script>
        var quickSalesPay = false;
        $(() => {

            handleDataTable();

            $("#exportToExcel").click(() => $(".exportToExcel").click());

            $(document).on("click", ".paymentBtn", function() {

                quickSalesPay = new bootstrap.Modal(document.getElementById(
                    'quickSalesPay')); // Create the modal instance
                quickSalesPay.show();


                const id = $(this).data("id");
                const dueAmount = $(this).data("due_amount");
                const contact = $(this).data("contact");
                const name = $(this).data("name");

                $('#customerName').text(name);
                $('#customerId').val(id);
                $('#customerPhoneNumber').text(contact);
                $('#totalDue').text(dueAmount + ' tk');


            });


        });



        const handleDataTable = () => {

            $('#salesDueCollectionList').DataTable().clear().destroy();
            url = '/sales/due-amount?fetch=1';
            table = $('#salesDueCollectionList').DataTable({
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
                            return row.name;
                        },
                        targets: 0,
                    },

                    {
                        render: function(data, type, row) {
                            return row.contact;
                        },
                        targets: 0,
                    },
                    {
                        render: function(data, type, row) {
                            return row.due_amount;
                        },
                        targets: 0,
                    },


                    {
                        render: function(data, type, row) {
                            const btns = `<div class="btn-group">
                                <button type="button" class="btn btn-success btn-sm paymentBtn btn-auto" data-due_amount="${row.due_amount}" data-contact="${row.contact}" data-name="${row.name}" data-id="${row.id}">
                                    Received Now <i class="fa-solid fa-check"></i>
                                </button>
                            </div>`;
                            return btns;
                        },
                        targets: 0,
                    },
                ]
            });

        };


        const quickSalesPayModalHide = () => {
            quickSalesPay.hide()
        };


        const handleSubmit = (event) => {



            const data = {
                payment_amount: $("#paymentAmount").val(),
                customer_id: $("#customerId").val(),
                transaction_type_id: $("#transactionType").val(),
            };



            axios.post("/payment/sales/pay", data).then((response) => {
                if (response.data.status == true) {
                    Toastr.fire({
                        icon: "success",
                        title: "Payment successful",
                    });
                    setTimeout(() => {
                        window.location.assign(`/payment/sales/pay-slip/${response.data.data}`);
                    }, 1000);
                }
            });

        };
    </script>
@endpush
