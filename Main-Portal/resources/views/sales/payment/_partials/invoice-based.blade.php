<div class="col-md-6 col-12">
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">Sales Invoice Based</h3>
        </div>

        <div class="card-body">
            <div>
                <label class="required">Select a Date:</label>
                <input type="date" id="salesInvoiceBasedDate" class="form-control" value="" />
            </div>
            <div>
                <label class="required">Select a Customer:</label>
                <select class="form-select selectedCustomerClass" id="salesInvoiceBasedSelectCustomer">
                    <option value="0" disabled selected>
                        Select a Customer
                    </option>
                </select>
            </div>
            <div class="mt-2">
                <label class="required">Select an Invoice:</label>
                <select class="form-select" id="salesInvoiceBasedSelect">
                    <option value="0" disabled selected>
                        Select an Invoice
                    </option>
                </select>
            </div>
            <div class="mt-3 border p-2 hasSelectedInvoiceInfo hidden">
                <div>
                    <p>
                        Total Amount:
                        <span id="salesInvoiceBasedTotal_amount">0</span> tk
                    </p>
                    <p>
                        Paid Amount:
                        <span id="salesInvoiceBasedPaid_amount">0</span> tk
                    </p>
                    <p>
                        Due Amount:
                        <span id="salesInvoiceBasedDue_amount">0</span> tk
                        <button class="btn btn-sm btn-info salesInvoiceBasedFullPaymentBtn" title="Full Payment">
                            <i class="fa-solid fa-caret-down"></i>
                        </button>
                    </p>
                    <div class="row">
                        <div class="col-md-6">
                            <label>Transaction Type</label>
                            <select class="form-select" id="salesInvoiceBasedTT_id">
                                <option value="0" selected>
                                    Select a Transaction Type
                                </option>
                                @foreach ($transactionTypes as $transactionType)
                                    <option value="{{ $transactionType->id }}">{{ $transactionType->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label>Pay Amount</label>
                            <div class="d-flex">
                                <input type="text" class="form-control w-full mr-1" id="salesInvoiceBasedPaymentAmount" value="0" />
                                <button disabled class="btn btn-sm btn-success salesInvoiceBasedPaymentBtn" style="width: 120px">
                                    Pay Now
                                </button>
                            </div>
                            <small class="font-weight-bold salesInvoiceBasedPaymentStatus text-danger"></small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
