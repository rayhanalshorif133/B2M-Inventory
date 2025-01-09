@php
    $title = 'Purchase List';
@endphp
@extends('layouts.app', ['title' => $title])

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
                    <div class="card-header justify-content-between d-flex">
                        <h3 class="card-title">Sales list</h3>
                        <div class="ml-auto">
                            <button class="btn btn-sm btn-success mx-2" onclick="exportToExcel()">
                                Export to Excel
                            </button>
                            <a class="btn btn-sm btn-success" href="/purchase/create">
                                Create New Purchase
                            </a>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive" style="width: 100%">
                            <table class="table table-bordered display table-hover nowrap" id="purchasesList"
                                style="width: 100%">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Code</th>
                                        <th scope="col">Invoice Date</th>
                                        <th scope="col">Supplier Name</th>
                                        <th scope="col">Total Amount</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <div class="modal fade" id="showPurchaseDetails" tabindex="-1" aria-labelledby="showPurchaseDetailsLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header" style="height: 50px">
                        <h5 class="modal-title" id="showPurchaseDetailsLabel">
                            Purchase Details
                            <a class="btn btn-sm btn-outline-primary purchaseEditLink" href="#">
                                <i class="fa-solid fa-pen" aria-hidden="true"></i>
                                Edit
                            </a>
                        </h5>
                        <button type="button" class="btn-close text-white"
                            onclick="hideShowPurchaseDetailsModal()"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <h5><b>Purchase Info:</b></h5>
                            <p class="col-md-4 col-sm-2"><b>Code:</b> <span id="purchaseCode"></span></p>
                            <p class="col-md-4 col-sm-2"><b>Invoice Date:</b> <span id="invoiceDate"></span></p>
                            <p class="col-md-4 col-sm-2"><b>Total Amount:</b> <span id="showTotalAmount"></span></p>
                            <p class="col-md-4 col-sm-2"><b>Paid Amount:</b> <span id="paidAmount"></span></p>
                            <p class="col-md-4 col-sm-2"><b>Due Amount:</b> <span id="dueAmount"></span></p>
                            <p class="col-md-4 col-sm-2"><b>Note:</b> <span id="purchaseNote"></span></p>
                            <hr />
                            <h5><b>Purchase Details:</b></h5>
                            <table class="table px-2">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Particulars</th>
                                        <th scope="col" style="width: 7rem">Qty</th>
                                        <th scope="col">Purchase Rate</th>
                                        <th scope="col" style="width: 7rem">Discount</th>
                                        <th scope="col">Total</th>
                                    </tr>
                                </thead>
                                <tbody id="purchaseDetailsBody"></tbody>
                                <tfoot>
                                    <tr style="font-size: 16px!important">
                                        <td colspan="5" class="text-end"><b>Total :</b></td>
                                        <td colspan="2" class="text-start"><span id="finalTotal"></span> tk</td>
                                    </tr>
                                    <tr style="font-size: 16px!important">
                                        <td colspan="5" class="text-end" style="font-size: 16px!important"><b>Final
                                                Discount :</b></td>
                                        <td colspan="2" class="text-start" style="font-size: 16px!important"><span
                                                id="finalDiscount"></span></td>
                                    </tr>
                                    <tr style="font-size: 16px!important">
                                        <td colspan="5" class="text-end" style="font-size: 16px!important"><b>Final
                                                Total :</b></td>
                                        <td colspan="2" class="text-start" style="font-size: 16px!important"><span
                                                id="finalTotalWithDiscount"></span> tk</td>
                                    </tr>


                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary text-white"
                            onclick="hideShowPurchaseDetailsModal()">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        var showPurchaseDetails = false;
        $(() => {
            // Toastr.fire({
            //     icon: "success",
            //     title: "Payment successful",
            // });
            handleDataTable();
        });


        const exportToExcel = () => {
            $(".exportToExcel").click();
        };



        const handleDataTable = () => {
            $('#purchasesList').DataTable().clear().destroy();
            url = '/purchase/list?type=fetch';
            $('#purchasesList').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: url, // Replace this with your API endpoint
                    type: 'GET',
                    dataSrc: function(json) {
                        return json.data;
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
                        render: function(data, type, row, meta) {
                            return row.code; // Display the row index (1-based)
                        },
                        targets: 0
                    },
                    {
                        render: function(data, type, row, meta) {
                            return row.invoice_date; // Display the row index (1-based)
                        },
                        targets: 0
                    },
                    {
                        render: function(data, type, row, meta) {
                            var name = row.supplier ? row.supplier.name : "No Assign";
                            return name; // Display the row index (1-based)
                        },
                        targets: 0
                    },
                    {
                        render: function(data, type, row, meta) {
                            return row.total_amount; // Display the row index (1-based)
                        },
                        targets: 0
                    },
                    {
                        render: function(data, type, row) {
                            const status =
                                row.status == "0" ?
                                `<span class="badge badge-danger">Inactive</span>` :
                                `<span class="badge badge-success">Active</span>`;
                            return status;
                        },
                        targets: 4
                    },
                    {
                        render: function(data, type, row) {
                            const btns = `
                    <div class="btn-group">
                        <button type="button" class="btn btn-success btn-sm showBtn btn-fit" data-id="${row.id}">
                         <i class="fa-regular fa-eye"></i> View
                        </button>
                        <a href="/purchase/invoice/${row.id}" type="button" class="btn btn-primary btn-sm print btn-fit">
                         <i class="fa-solid fa-print"></i> Print
                        </a>
                        <button type="button" class="btn btn-danger btn-sm deleteBtn btn-fit" data-id="${row.id}">
                            <i class="fa-solid fa-trash"></i> Delete
                        </button>
                    </div>`;
                            return btns;
                        },
                        targets: 5
                    }
                ]
            });


        };


        $(document).on('click', '.showBtn', function() {
            const id = $(this).attr('data-id');

            showPurchaseDetails = new bootstrap.Modal(document.getElementById(
                'showPurchaseDetails')); // Create the modal instance
            showPurchaseDetails.show();


            axios.get(`/purchase/fetch/${id}`).then((response) => {
                $(".purchaseEditLink").attr("href", `/purchase/${id}/edit`);

                const {
                    purchase,
                    purchaseDetails
                } = response.data.data;

                $("#purchaseCode").text(purchase.code);
                $("#invoiceDate").text(purchase.invoice_date);
                if (purchase.discount > 0) {
                    $("#finalDiscount").text("৳ -" + purchase.discount + " tk");
                    $("#finalDiscount").addClass("text-danger");
                } else {
                    $("#finalDiscount").text("৳ " + purchase.discount);
                    $("#finalDiscount").removeClass("text-danger");
                }

                $("#showTotalAmount").text("৳ " + purchase.grand_total);

                $("#paidAmount").text("৳ " + purchase.paid_amount);
                $("#dueAmount").text("৳ " + purchase.due_amount);
                $("#purchaseNote").text(purchase.note);


                // purchaseDetailsBody
                $('#purchaseDetailsBody').empty();

                var total_price = 0;
                // Insert rows into the table body
                $.each(purchaseDetails, function(index, item) {
                    total_price += item.total;
                    const row = `
                            <tr>
                                <td>${index + 1}</td>
                                <td>
                                    ${item.product_attribute.code}<br>
                                    ${item.product.name}
                                    ${item.product_attribute.model != null ? '|' + item.product_attribute.model : ''}
                                    ${item.product_attribute.color != null ? '|' + item.product_attribute.color : ''}<br>
                                </td>
                                <td>${item.qty}</td>
                                <td>${item.purchase_rate} tk</td>
                                <td>${item.discount} tk</td>
                                <td>${item.total} tk</td>
                            </tr>
                        `;
                    $('#purchaseDetailsBody').append(row);
                });

                $("#finalTotal").text("৳ " + total_price);
                total_price = parseFloat(total_price) - parseFloat(purchase.discount);
                $("#finalTotalWithDiscount").text("৳ " + total_price);


            });
        });

        const hideShowPurchaseDetailsModal = () => {
            showPurchaseDetails.hide();
        };
    </script>
@endpush
