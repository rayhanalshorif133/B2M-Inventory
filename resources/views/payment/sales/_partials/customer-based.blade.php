<div class="col-md-6 col-12">
    <div class="card card-outline card-info">
        <div class="card-header">
            <h3 class="card-title">Customer Based</h3>
        </div>

        <div class="card-body">
            <div>
                <label class="required">Select a Date:</label>
                <input type="date" id="salesCustomerBasedDate" class="form-control" value="" />
            </div>
            <div>
                <label class="required">Select a Customer:</label>
                <select class="form-select selectedCustomerBasedClass" id="salesCustomerBasedSelectCustomer">
                    <option value="0" disabled selected>
                        Select a Customer
                    </option>
                </select>
            </div>

            <div class="mt-3 border p-2">
                <div>
                    <p>
                        Due Amount:
                        <span id="salesCustomerBasedDueAmount"></span> tk
                        <button class="btn btn-sm btn-info" title="Full Payment">
                            <i class="fa-solid fa-caret-down"></i>
                        </button>
                    </p>
                    <div class="row">
                        <div class="col-md-6">
                            <label>Transaction Type</label>
                            <select class="form-select" id="salesCustomerBasedTT_id">
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
                                <input type="text" class="form-control w-full mr-1" value="0" />
                                <button class="btn btn-sm btn-success" style="width: 170px">
                                    Pay Now
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- If no due amount -->
            <div class="mt-3">
                <div class="alert alert-danger" role="alert">
                    No due amount.
                </div>
            </div>
        </div>
    </div>
</div>
