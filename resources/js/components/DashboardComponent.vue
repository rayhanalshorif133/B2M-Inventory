<template>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-info"
                            ><i class="ion ion-bag"></i
                        ></span>
                        <div class="info-box-content">
                            <span class="text-bold text-uppercase"
                                >Total Purchase Due</span
                            >
                            <span class="info-box-number">
                                ৳ {{ financialData.totalPurchaseDue }}</span
                            >
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-warning"
                            ><i class="fa fa-dollar"></i
                        ></span>
                        <div class="info-box-content">
                            <span class="text-bold text-uppercase"
                                >Total Sales Due</span
                            >
                            <span class="info-box-number"
                                >৳ {{ financialData.totalSalesDue }}</span
                            >
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-green"
                            ><i class="fa fa-cart-plus"></i
                        ></span>
                        <div class="info-box-content">
                            <span class="text-bold text-uppercase"
                                >Total Sales Amount</span
                            >
                            <span class="info-box-number"
                                >৳ {{ financialData.totalSalesAmount }}</span
                            >
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-danger">
                            <i class="fa-regular fa-square-minus"></i
                        ></span>
                        <div class="info-box-content">
                            <span class="text-bold text-uppercase"
                                >Total Expense Amount</span
                            >
                            <span class="info-box-number"
                                >৳ {{ financialData.totalExpenseAmount }}</span
                            >
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
            </div>
            <div class="row">
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-info"
                            ><i class="ion ion-bag"></i
                        ></span>
                        <div class="info-box-content">
                            <span class="text-bold text-uppercase"
                                >Todays Total Purchase</span
                            >
                            <span class="info-box-number"
                                >৳ {{ financialData.totalsTotalPurchase }}</span
                            >
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-yellow"
                            ><i class="fa fa-dollar"></i
                        ></span>
                        <div class="info-box-content">
                            <span class="text-bold text-uppercase"
                                >Today Payment Received(Sales)</span
                            >
                            <span class="info-box-number"
                                >৳
                                {{ financialData.totalsPaymentReceived }}</span
                            >
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-green"
                            ><i class="fa fa-cart-plus"></i
                        ></span>
                        <div class="info-box-content">
                            <span class="text-bold text-uppercase"
                                >Todays Total Sales</span
                            >
                            <span class="info-box-number"
                                >৳ {{ financialData.todaysTotalsSales }}</span
                            >
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-danger">
                            <i class="fa-regular fa-square-minus"></i
                        ></span>
                        <div class="info-box-content">
                            <span class="text-bold text-uppercase"
                                >Todays Total Expense</span
                            >
                            <span class="info-box-number"
                                >৳ {{ financialData.todaysTotalsExpense }}</span
                            >
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
            </div>
        </div>
        <div class="row px-3">
            <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-success">
                    <div class="inner text-uppercase">
                        <h3>{{ financialData.customers }}</h3>
                        <p>Customers</p>
                    </div>
                    <div class="icon">
                        <i class="fa-solid fa-user-group"></i>
                    </div>

                    <a
                        href="/customer/list"
                        class="small-box-footer text-uppercase"
                        >View <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-navy">
                    <div class="inner text-uppercase">
                        <h3>{{ financialData.suppliers }}</h3>
                        <p>Suppliers</p>
                    </div>
                    <div class="icon">
                        <i class="fa-solid fa-users" style="color: #d2d2d2"></i>
                    </div>

                    <a
                        href="/supplier/list"
                        class="small-box-footer text-uppercase"
                        >View <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-primary">
                    <div class="inner text-uppercase">
                        <h3>{{ financialData.purchaseInvoice }}</h3>
                        <p>Purchase Invoice</p>
                    </div>
                    <div class="icon">
                        <i class="fa-solid fa-clipboard-list"></i>
                    </div>

                    <a
                        href="/purchase/list"
                        class="small-box-footer text-uppercase"
                        >View <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-warning">
                    <div class="inner text-uppercase">
                        <h3>{{ financialData.salesInvoice }}</h3>
                        <p>Sales Invoice</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-ios-paper-outline"></i>
                    </div>

                    <a
                        href="/sales/list"
                        class="small-box-footer text-uppercase"
                        >View <i class="fa fa-arrow-circle-right"></i>
                    </a>
                </div>
            </div>

            <!-- fix for small devices only -->
            <div class="clearfix visible-sm-block"></div>

            <!-- /.col -->
        </div>
    </section>
</template>

<script>
import { ref, onMounted } from "vue";
import axios from "axios";
export default {
    setup() {
        const financialData = ref({
            totalPurchaseDue: 0,
            totalSalesDue: 0,
            totalSalesAmount: 0,
            totalExpenseAmount: 0,
            totalsTotalPurchase: 0,
            totalsPaymentReceived: 0,
            todaysTotalsSales: 0,
            todaysTotalsExpense: 0,
            customers: 0,
            suppliers: 0,
            purchaseInvoice: 0,
            salesInvoice: 0,
        });

        const fetchData = () => {
            axios.get("/home?type=fetch").then((response) => {
                financialData.value = response.data.data;
            });
        };

        onMounted(() => {
            fetchData();
        });

        return { financialData };
    },
};
</script>

<style></style>
