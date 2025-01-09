@extends('layouts.app', ['title' => 'Purchase Return'])

@section('content')
    <div class="content-wrapper">




        <purchase-return-create-component></purchase-return-create-component>
        <div>
            <section class="content">
                <div class="container-fluid">
                    <div class="row mx-2">
                        <div class="card card-navy p-0" style="width: 100%">
                            <div class="card-header w-100 bg-navy">
                                <h3 class="card-title">Purchase Return</h3>
                            </div>
                            <div class="card-body row" style="width: 100%">
                                <div class="col-md-4 col-12">
                                    <div class="card card-outline card-info">
                                        <div class="card-header">
                                            <h3 class="card-title">
                                                Find Returnable Invoice
                                            </h3>
                                        </div>
                                        <div class="card-body">
                                            <div>
                                                <label class="required form-label">Select a Date:</label>
                                                <input type="date" id="selectedDate" class="form-control" />
                                            </div>
                                            <div>
                                                <label class="required form-label">Select a Supplier:</label>
                                                <select class="custom-select" name="selectedSupplier" id="selectedSupplier">
                                                    <option disabled selected value="0">Select a Supplier</option>
                                                </select>
                                            </div>
                                            <div class="mt-2">
                                                <label class="required form-label">Select an Invoice:</label>
                                                <select class="custom-select" name="selectedInvoice" id="selectedInvoice">
                                                    <option disabled selected value="0">Select an Invoice</option>
                                                </select>
                                            </div>

                                            <div class="mt-3 border p-2 purchase_info d-none">
                                                <div>
                                                    <h5><b>purchase Info:</b></h5>
                                                    <p>
                                                        <b>Total Amount:</b>
                                                        <span class="purchase_total_amount mx-1"></span> tk
                                                    </p>
                                                    <p>
                                                        <b>Paid Amount:</b>
                                                        <span class="purchase_paid_amount mx-1"></span> tk
                                                    </p>
                                                    <p>
                                                        <b>Due Amount:</b>
                                                        <span class="purchase_due_amount mx-1"></span> tk
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-8 col-12">
                                    <div class="card card-outline card-primary">
                                        <div class="card-header">
                                            <h3 class="card-title">Product Informations</h3>
                                        </div>
                                        <div class="card-body">
                                            <table class="table table-striped table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th scope="col" class="bg-success">#</th>
                                                        <th scope="col" class="bg-success">Particulars</th>
                                                        <th scope="col" class="bg-success">Qty</th>
                                                        <th scope="col" class="bg-success">purchase Rate</th>
                                                        <th scope="col" class="bg-success">Discount</th>
                                                        <th scope="col" class="w-25 bg-success">Resturn Qty</th>
                                                        <th scope="col" class="text-end bg-success">Total</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="purchaseDetailsBody"></tbody>
                                                <tfoot>
                                                    <tr>
                                                        <td class="text-end bg-success" colspan="6">Total Amount:</td>
                                                        <td class="text-end bg-success total_amount"></td>
                                                    </tr>
                                                </tfoot>
                                            </table>

                                            <div class="product_customization_note_amount mt-1">
                                                <div class="product_customization_note">
                                                    <label class="mt-2 mx-2 w-8rem">Note:</label>
                                                    <textarea class="form-control" id="note" placeholder="Note"></textarea>
                                                </div>
                                                <div class="flex-column product_customization_amount">
                                                    <div class="d-flex mt-1">
                                                        <div>
                                                            <label class="w-8rem">Transaction Type</label>
                                                            <select class="form-control w-fit" id="transactionType">
                                                                <option selected disabled value="">Transaction Type
                                                                </option>
                                                                @foreach ($transactionTypes as $item)
                                                                    <option value="{{ $item->id }}">
                                                                        {{ $item->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="mx-2">
                                                            <label class="mx-2 w-8rem">Return Amount</label>
                                                            <input type="number" class="form-control return_amount"
                                                                placeholder="Return amount" value="0" />
                                                        </div>
                                                    </div>
                                                    <div class="d-flex mt-1 justify-content-end">
                                                        <label>Due Amount: <span id="due_amount">0</span></label>
                                                    </div>
                                                    <div class="d-flex mt-1 justify-content-end">
                                                        <button type="button" class="btn btn-success btn-sm submitBtn"
                                                            onclick="submitBtn()">
                                                            Submit
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        var purchaseList = [];
        var purchaseDetailsData = [];
        var returnAmount = 0;
        $(() => {
            const today = new Date();
            const formattedDate = today.toISOString().split('T')[0]; // Extracts the date in YYYY-MM-DD format
            $("#selectedDate").val(formattedDate);
            fetchSupplier(formattedDate);
            handleChange();
            $('.submitBtn').prop('disabled', true);

        });

        const fetchSupplier = (date) => {

            axios.get(`/supplier/fetch?type=purchase-return&date=${date}`)
                .then((response) => {
                    const data = response.data.data;
                    console.log(data);
                    var supplierList = [];
                    purchaseList = data;

                    data.length > 0 &&
                        data.map((item) => {
                            supplierList = [
                                ...supplierList,
                                item.Supplier,
                            ];
                        });
                    // unique Supplier name
                    supplierList = supplierList.filter(
                        (Supplier, index, self) =>
                        index ===
                        self.findIndex((s) => s.id === Supplier.id)
                    );

                    $("#selectedSupplier").empty();
                    $("#selectedSupplier").append('<option disabled selected value="0">Select a Supplier</option>');
                    supplierList.forEach(item => {
                        $("#selectedSupplier").append(new Option(item.name, item.id));
                    });
                });
        };

        const handleChange = () => {

            $("#selectedDate").on('change', function(e) {
                fetchSupplier($(this).val())
            });

            $("#selectedSupplier").on('change', function(e) {
                const selectedSupplierId = $(this).val();
                const invoiceList = purchaseList.filter(
                    (item) => item.Supplier_id == selectedSupplierId
                );

                $("#selectedInvoice").empty();
                $("#selectedInvoice").append('<option disabled selected value="0">Select a Invoice</option>');

                invoiceList.forEach(item => {
                    $("#selectedInvoice").append(new Option(item.code, item.id));
                });
            });

            $("#selectedInvoice").on('change', function() {
                const selectedInvoice = $(this).val();
                axios
                    .get(
                        `/purchase/fetch-invoice?type=purchase-return&purchase_id=${selectedInvoice}`
                    )
                    .then((response) => {
                        const {
                            purchase,
                            purchaseDetails
                        } = response.data.data;
                        if (purchase) {
                            $(".purchase_info").removeClass('d-none');
                            $(".purchase_total_amount").text(purchase.total_amount);
                            $(".purchase_paid_amount").text(purchase.paid_amount);
                            $(".purchase_due_amount").text(purchase.due_amount);
                        }
                        console.log(purchaseDetails);
                        purchaseDetailsInsert(purchaseDetails);
                        $('.submitBtn').prop('disabled', false);
                    });
            });


            $(".return_amount").on("keyup", function() {
                returnAmount = parseFloat($(this).val());
                const total_amount = parseFloat($('.total_amount').text());
                const dueAmount = total_amount - returnAmount;
                $('#due_amount').text(dueAmount);;

            });



        };









        function purchaseDetailsInsert(data, hasSame = true) {
            purchaseDetailsData = data;
            const tbody = $('#purchaseDetailsBody');
            tbody.empty();

            var total_amount = 0;
            data.forEach((item) => {
                if (hasSame == true) {
                    item.return_qty = item.qty;
                }
                total_amount += parseFloat(item.total);
                const row = `
            <tr>
                <td class="d-flex-item-center">
                    <button type="button" class="btn btn-sm btn-danger mt-2" onclick="removeItem(${item.id})">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </td>
                <td>
                    ${item.product_attribute.code}<br />
                    ${item.product_attribute.color ? `<span>${item.product_attribute.color}</span><br />` : ''}
                    ${item.product_attribute.model ? `<span>${item.product_attribute.model}</span>` : ''}
                </td>
                <td>${item.qty}</td>
                <td>${item.purchase_rate}</td>
                <td>${item.discount}</td>
                <td>
                    <input type="number" class="form-control handleReturnQty" data-item_id="${item.id}" value="${item.return_qty}"/>
                </td>
                <td class="text-end">${item.total}</td>
            </tr>
        `;
                tbody.append(row);
            });

            $(".total_amount").text(total_amount);

            $(".handleReturnQty").on('blur', function(e) {
                $(this).removeClass("form-control-red");
                $('.submitBtn').prop('disabled', false);

                const returnQty = parseInt($(this).val());
                const itemId = $(this).data('item_id');
                const item = data.find(d => d.id === itemId);
                item.total = parseInt($(this).val()) * item.purchase_rate;
                item.return_qty = parseInt($(this).val());

                if (returnQty > item.qty) {
                    Toastr.fire({
                        icon: "error",
                        title: "Quantity is out of range",
                    });
                    $(this).addClass("form-control-red");
                    $('.submitBtn').prop('disabled', true);
                    return false;
                }

                purchaseDetailsInsert(data, false);
            });
        }



        const submitBtn = () => {

            const data = {
                purchase_id: $("#selectedInvoice").val(),
                note: $("#note").val(),
                transaction_type_id: $("#transactionType").val(),
                total_amount: parseFloat($('.total_amount').text()),
                due_amount: parseFloat($('#due_amount').text()),
                return_amount: returnAmount,
                product_details: purchaseDetailsData,
            };



            $('.submitBtn').text('Processing');
            $('.submitBtn').prop('disabled', true);


            axios.post("/purchase/return/create", data).then((response) => {
                const {
                    data,
                    status
                } = response.data;

                if (status == true) {
                    Toastr.fire({
                        icon: "success",
                        title: "purchase Return successful",
                    });

                    setTimeout(() => {
                        window.location.href = `/purchase/return/invoice/${data.id}`;
                    }, 1600);
                } else {
                    $('.submitBtn').text('Submit');
                    $('.submitBtn').prop('disabled', false);
                }
            });

        };
    </script>
@endpush
