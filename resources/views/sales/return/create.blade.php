@extends('layouts.app', ['title' => 'Sales Return'])

@section('content')
    <div class="content-wrapper">


        <breadcrumb-component :title="'Sales Return'" :items="{{ json_encode(['home', 'Sales Return']) }}">
        </breadcrumb-component>

        <sales-return-create-component></sales-return-create-component>

        <div>
            <section class="content">
                <div class="container-fluid">
                    <div class="row mx-2">
                        <div class="card card-navy p-0">
                            <div class="card-header w-100 bg-navy">
                                <h3 class="card-title">Sales Return</h3>
                            </div>
                            <div class="card-body row">
                                <div class="col-md-4 col-12">
                                    <div class="card card-outline card-info">
                                        <div class="card-header">
                                            <h3 class="card-title">
                                                Find Returnable Invoice
                                            </h3>
                                        </div>
                                        <div class="card-body">
                                            <div>
                                                <label class="required">Select a Date:</label>
                                                <input type="date" id="selectedDate" class="form-control" />
                                            </div>
                                            <div>
                                                <label class="required">Select a Customer:</label>
                                                <select class="form-select" name="selectedCustomer" id="selectedCustomer">
                                                    <option disabled selected value="0">Select a Customer</option>
                                                </select>
                                            </div>
                                            <div class="mt-2">
                                                <label class="required">Select an Invoice:</label>
                                                <select class="form-select" name="selectedInvoice" id="selectedInvoice">
                                                    <option disabled selected value="0">Select an Invoice</option>
                                                </select>
                                            </div>
                                            {{-- @if ($getSales)
                                            <div class="mt-3 border p-2">
                                                <div>
                                                    <h5><b>Sales Info:</b></h5>
                                                    <p>
                                                        <b>Total Amount:</b>
                                                        {{ $getTotalAmount }} tk
                                                    </p>
                                                    <p>
                                                        <b>Paid Amount:</b>
                                                        {{ $getSales->paid_amount }} tk
                                                    </p>
                                                    <p>
                                                        <b>Due Amount:</b>
                                                        {{ $getSales->due_amount }} tk
                                                    </p>
                                                </div>
                                            </div>
                                        @endif --}}

                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-8 col-12">
                                    <div class="card card-outline card-primary">
                                        <div class="card-header">
                                            <h3 class="card-title">Product Informations</h3>
                                        </div>
                                        <div class="card-body">
                                            {{-- <table class="table table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                    <th scope="col" class="bg-success">#</th>
                                                    <th scope="col" class="bg-success">Particulars</th>
                                                    <th scope="col" class="bg-success">Qty</th>
                                                    <th scope="col" class="bg-success">Sales Rate</th>
                                                    <th scope="col" class="bg-success">Discount</th>
                                                    <th scope="col" class="w-25 bg-success">Return Qty</th>
                                                    <th scope="col" class="text-end bg-success">Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($salesDetailsList as $item)
                                                    <tr>
                                                        <td class="d-flex-item-center">
                                                            <button type="button" class="btn btn-sm btn-danger mt-2"
                                                                onclick="removeItem({{ $item->id }})">
                                                                <i class="fa-solid fa-xmark"></i>
                                                            </button>
                                                        </td>
                                                        <td>
                                                            {{ $item->product_attribute->code }}<br />
                                                            {{ $item->product_attribute->color }}<br />
                                                            {{ $item->product_attribute->model }}
                                                        </td>
                                                        <td>{{ $item->qty }}</td>
                                                        <td>{{ $item->sales_rate }}</td>
                                                        <td>{{ $item->discount }}</td>
                                                        <td>
                                                            <input type="number" class="form-control"
                                                                value="{{ $item->return_qty }}"
                                                                onchange="handleReturnQty(this, {{ $item->id }})" />
                                                        </td>
                                                        <td class="text-end">{{ $item->total }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td class="text-end bg-success" colspan="6">Total Amount:</td>
                                                    <td class="text-end bg-success">{{ $getSales->total_amount }}</td>
                                                </tr>
                                            </tfoot>
                                        </table>

                                        <div class="product_customization_note_amount mt-1">
                                            <div class="product_customization_note">
                                                <label class="mt-2 mx-2 w-8rem">Note:</label>
                                                <textarea class="form-control" placeholder="Note">{{ $note }}</textarea>
                                            </div>
                                            <div class="flex-column product_customization_amount">
                                                <div class="d-flex mt-1">
                                                    <div>
                                                        <label class="w-8rem">Transaction Type</label>
                                                        <select class="form-control w-fit" id="transaction_type"
                                                            name="transaction_type">
                                                            <option selected disabled value="">Transaction Type
                                                            </option>
                                                            @foreach ($transactionTypes as $item)
                                                                <option value="{{ $item->id }}">{{ $item->name }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="mx-2">
                                                        <label class="mx-2 w-8rem">Return Amount</label>
                                                        <input type="number" class="form-control"
                                                            placeholder="Return amount" name="return_amount"
                                                            value="{{ $return_amount }}"
                                                            onchange="handleReturnAmount(this)" />
                                                    </div>
                                                </div>
                                                <div class="d-flex mt-1 justify-content-end">
                                                    <label>Due Amount: {{ $due_amount }}</label>
                                                </div>
                                                <div class="d-flex mt-1 justify-content-end">
                                                    <button type="button" class="btn btn-success btn-sm"
                                                        onclick="submitBtn()" @disabled($submitBtnStatus)>
                                                        {{ $submitBtnText }}
                                                    </button>
                                                </div>
                                            </div>
                                        </div> --}}
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
        var salesList = [];
        $(() => {
            const today = new Date();
            const formattedDate = today.toISOString().split('T')[0]; // Extracts the date in YYYY-MM-DD format
            $("#selectedDate").val(formattedDate);
            fetchSipplier(formattedDate);
            handleChange();
        });

        const fetchSipplier = (date) => {

            axios.get(`/customer/fetch?type=sales-return&date=${date}`)
                .then((response) => {
                    const data = response.data.data;
                    var customerList = [];
                    salesList = data;

                    data.length > 0 &&
                        data.map((item) => {
                            customerList = [
                                ...customerList,
                                item.customer,
                            ];
                        });
                    // unique customer name
                    customerList = customerList.filter(
                        (customer, index, self) =>
                        index ===
                        self.findIndex((s) => s.id === customer.id)
                    );

                    $("#selectedCustomer").empty();
                    $("#selectedCustomer").append('<option disabled selected value="0">Select a Customer</option>');
                    customerList.forEach(customer => {
                        $("#selectedCustomer").append(new Option(customer.name, customer.id));
                    });
                });
        };

        const handleChange = () => {

            $("#selectedDate").on('change', function(e) {
                fetchSipplier($(this).val())
            });

            $("#selectedCustomer").on('change', function(e) {
                const selectedCustomerId = $(this).val();
                const invoiceList = salesList.filter(
                    (item) => item.customer_id == selectedCustomerId
                );

                $("#selectedInvoice").empty();
                $("#selectedInvoice").append('<option disabled selected value="0">Select a Invoice</option>');

                invoiceList.forEach(item => {
                    $("#selectedInvoice").append(new Option(item.code, item.id));
                });
            });
        };
    </script>
@endpush
