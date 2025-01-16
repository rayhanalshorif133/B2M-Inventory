@extends('layouts.app', ['title' => 'Dashboard'])

@section('content')
    <div class="content-wrapper">





        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Dashboard</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item">
                                <a href="{{ route('home') }}" class="text-capitalize">home</a>
                                <span class="text-gray"> / </span>
                                <span class="text-gray">Dashboard</span>
                            </li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <div class="info-box">
                            <span class="info-box-icon bg-info"><i class="ion ion-bag"></i></span>
                            <div class="info-box-content">
                                <span class="text-bold text-uppercase">Total Purchase Due</span>
                                <span class="info-box-number" id="totalPurchaseDue">৳ 0</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <div class="info-box">
                            <span class="info-box-icon bg-warning"><i class="fa fa-dollar"></i></span>
                            <div class="info-box-content">
                                <span class="text-bold text-uppercase">Total Sales Due</span>
                                <span class="info-box-number" id="totalSalesDue">৳ 0</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <div class="info-box">
                            <span class="info-box-icon bg-green"><i class="fa fa-cart-plus"></i></span>
                            <div class="info-box-content">
                                <span class="text-bold text-uppercase">Total Sales Amount</span>
                                <span class="info-box-number" id="totalSalesAmount">৳ 0</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <div class="info-box">
                            <span class="info-box-icon bg-danger"><i class="fa-regular fa-square-minus"></i></span>
                            <div class="info-box-content">
                                <span class="text-bold text-uppercase">Total Expense Amount</span>
                                <span class="info-box-number" id="totalExpenseAmount">৳ 0</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <div class="info-box">
                            <span class="info-box-icon bg-info"><i class="ion ion-bag"></i></span>
                            <div class="info-box-content">
                                <span class="text-bold text-uppercase">Today's Total Purchase</span>
                                <span class="info-box-number" id="todaysTotalPurchase">৳ 0</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <div class="info-box">
                            <span class="info-box-icon bg-yellow"><i class="fa fa-dollar"></i></span>
                            <div class="info-box-content">
                                <span class="text-bold text-uppercase">Today Payment Received (Sales)</span>
                                <span class="info-box-number" id="todaysPaymentReceived">৳ 0</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <div class="info-box">
                            <span class="info-box-icon bg-green"><i class="fa fa-cart-plus"></i></span>
                            <div class="info-box-content">
                                <span class="text-bold text-uppercase">Today's Total Sales</span>
                                <span class="info-box-number" id="todaysTotalSales">৳ 0</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <div class="info-box">
                            <span class="info-box-icon bg-danger"><i class="fa-regular fa-square-minus"></i></span>
                            <div class="info-box-content">
                                <span class="text-bold text-uppercase">Today's Total Expense</span>
                                <span class="info-box-number" id="todaysTotalExpense">৳ 0</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row px-3">
                    <div class="col-lg-3 col-xs-6">
                        <div class="small-box bg-success">
                            <div class="inner text-uppercase">
                                <h3 id="customers">0</h3>
                                <p>Customers</p>
                            </div>
                            <div class="icon">
                                <i class="fa-solid fa-user-group"></i>
                            </div>
                            <a href="/customer/list" class="small-box-footer text-uppercase">View <i
                                    class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-xs-6">
                        <div class="small-box bg-navy">
                            <div class="inner text-uppercase">
                                <h3 id="suppliers">0</h3>
                                <p>Suppliers</p>
                            </div>
                            <div class="icon">
                                <i class="fa-solid fa-users" style="color: #d2d2d2"></i>
                            </div>
                            <a href="/supplier/list" class="small-box-footer text-uppercase">View <i
                                    class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-xs-6">
                        <div class="small-box bg-primary">
                            <div class="inner text-uppercase">
                                <h3 id="purchaseInvoice">0</h3>
                                <p>Purchase Invoice</p>
                            </div>
                            <div class="icon">
                                <i class="fa-solid fa-clipboard-list"></i>
                            </div>
                            <a href="/purchase/list" class="small-box-footer text-uppercase">View <i
                                    class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-xs-6">
                        <div class="small-box bg-warning">
                            <div class="inner text-uppercase">
                                <h3 id="salesInvoice">0</h3>
                                <p>Sales Invoice</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-ios-paper-outline"></i>
                            </div>
                            <a href="/sales/list" class="small-box-footer text-uppercase">View <i
                                    class="fa fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </section>






    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            function fetchData() {
                $.ajax({
                    url: "/home?type=fetch",
                    method: "GET",
                    success: function(response) {
                        const data = response.data;
                        $("#totalPurchaseDue").text(`৳ ${data.totalPurchaseDue}`);
                        $("#totalSalesDue").text(`৳ ${data.totalSalesDue - data.totalsPaymentReceived}`);
                        $("#totalSalesAmount").text(`৳ ${data.totalSalesAmount}`);
                        $("#totalExpenseAmount").text(`৳ ${data.totalExpenseAmount}`);
                        $("#todaysTotalPurchase").text(`৳ ${data.totalsTotalPurchase}`);
                        $("#todaysPaymentReceived").text(`৳ ${data.totalsPaymentReceived}`);
                        $("#todaysTotalSales").text(`৳ ${data.todaysTotalsSales}`);
                        $("#todaysTotalExpense").text(`৳ ${data.todaysTotalsExpense}`);
                        $("#customers").text(data.customers);
                        $("#suppliers").text(data.suppliers);
                        $("#purchaseInvoice").text(data.purchaseInvoice);
                        $("#salesInvoice").text(data.salesInvoice);
                    },
                    error: function(error) {
                        console.error("Error fetching data:", error);
                    },
                });
            }

            fetchData();
        });
    </script>
@endpush
