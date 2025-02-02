<template>
    <div class="col-md-6 col-12">
        <div class="card card-outline card-primary">
            <div class="card-header">
                <h3 class="card-title">Sales Invoice Based</h3>
            </div>

            <div class="card-body">
                <div>
                    <label class="required">Select a Date:</label>
                    <input
                        type="date"
                        v-model="selectedInoviceDate"
                        @change="fetchInvoiceByDate"
                        class="form-control"
                    />
                </div>
                <div>
                    <label class="required">Select a Customer:</label>
                    <select
                        class="form-select"
                        :class="selectedCustomerClass"
                        v-model="selectedCustomer"
                        @change="choiceCustomer"
                    >
                        <option value="0" disabled selected>
                            Select a Customer
                        </option>
                        <option
                            v-for="item in customerList"
                            :key="item.id"
                            :value="item.id"
                        >
                            {{ item.name }}
                        </option>
                    </select>
                </div>
                <div class="mt-2">
                    <label class="required">Select a Inovice:</label>
                    <select
                        class="form-select"
                        :class="selectedInvoiceClass"
                        v-model="selectedInvoice"
                        @change="choiceInvoice"
                    >
                        <option value="0" disabled selected>
                            Select a invoice
                        </option>
                        <option
                            v-for="item in invoiceList"
                            :key="item.id"
                            :value="item.id"
                        >
                            {{ item.code }}
                        </option>
                    </select>
                </div>
                <div class="mt-3 border p-2" :class="hasSelectedInvoiceInfo">
                    <div>
                        <p>
                            Total Amount:
                            {{ selectedInvoiceInfo.total_amount }}
                            tk
                        </p>
                        <p>
                            Paid Amount:
                            {{ selectedInvoiceInfo.paid_amount }} tk
                        </p>
                        <p>
                            Due Amount:
                            {{ selectedInvoiceInfo.due_amount }}
                            tk
                            <button
                                class="btn btn-sm btn-info"
                                title="Full Payment"
                                @click="payFullPayment"
                            >
                                <i class="fa-solid fa-caret-down"></i>
                            </button>
                        </p>
                        <div class="row">
                            <div class="col-md-6">
                                <label>Transation Type</label>
                                <select
                                    class="form-select"
                                    v-model="seletedTransactionType"
                                >
                                    <option value="0" selected>
                                        Select a transaction Types
                                    </option>
                                    <option
                                        v-for="item in transactionTypesList"
                                        :key="item.id"
                                        :value="item.id"
                                    >
                                        {{ item.name }}
                                    </option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label>Pay Amount</label>
                                <div class="d-flex">
                                    <input
                                        type="text"
                                        class="form-control w-full mr-1"
                                        v-model="paymentAmount"
                                    />
                                    <button
                                        class="btn btn-sm btn-success"
                                        style="width: 120px"
                                        @click="payNow"
                                        :disabled="payNowBtn.status"
                                    >
                                        {{ payNowBtn.name }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { ref } from "vue";
export default {
    setup() {
        var selectedInoviceDate = ref();
        var selectedInvoice = ref("0");
        var selectedInvoiceClass = ref("");
        var selectedCustomerClass = ref("");
        var selectedCustomer = ref("0");
        var invoiceList = ref("");
        var transactionTypesList = ref("");
        var seletedTransactionType = ref("0");
        var customerList = ref([]);
        var selectedInvoiceInfo = ref(false);
        var paymentAmount = ref("");
        var hasSelectedInvoiceInfo = ref("d-none");
        var payNowBtn = ref({
            status: false,
            name: "Pay Now",
        });

        // transaction-types

        const fetchTransactionTypes = () => {
            axios.get("/transaction-types/fetch").then((response) => {
                if (response.data.status == true) {
                    transactionTypesList.value = response.data.data;
                }
            });
        };

        fetchTransactionTypes();

        const fetchInvoiceByDate = () => {
            axios
                .get(`/sales/fetch-invoice/?date=${selectedInoviceDate.value}`)
                .then((response) => {
                    const data = response.data.data;
                    selectedInvoice.value = "0";
                    if (data.length > 0) {
                        data.map((item) => {
                            customerList.value.push(item.customer);
                        });

                        customerList.value = customerList.value.filter(
                            (item, index, self) =>
                                index ===
                                self.findIndex((s) => s.name === item.name)
                        );


                        selectedCustomerClass.value = "form-select-green";
                    } else {
                        selectedCustomerClass.value = "form-select-red";
                        invoiceList.value = [];
                    }
                });
            setTimeout(() => {
                selectedInvoiceClass.value = "";
            }, 2000);
        };

        const choiceInvoice = () => {
            axios
                .get(`/sales/fetch-invoice/?sales_id=${selectedInvoice.value}`)
                .then((response) => {
                    const data = response.data.data;
                    selectedInvoiceInfo.value = data;
                    selectedInvoiceInfo.value.due_amount =
                        data.total_amount - data.paid_amount;
                    hasSelectedInvoiceInfo.value = "";
                });
        };

        const choiceCustomer = () => {
            axios
                .get(
                    `/sales/fetch-invoice/?date=${selectedInoviceDate.value}&customer_id=${selectedCustomer.value}`
                )
                .then((response) => {
                    const data = response.data.data;
                    if (data.length > 0) {
                        invoiceList.value = data;
                        selectedInvoiceClass.value = "form-select-green";
                    } else {
                        invoiceList.value = [];
                        selectedInvoiceClass.value = "form-select-red";
                    }
                });
        };

        const payFullPayment = () => {
            paymentAmount.value = selectedInvoiceInfo.value.due_amount;
        };

        const payNow = () => {
            if (seletedTransactionType.value == "0") {
                Toastr.fire({
                    icon: "error",
                    title: "Please select a transaction type",
                });
                return false;
            }

            if (
                paymentAmount.value == "" ||
                parseFloat(paymentAmount.value) >
                    parseFloat(selectedInvoiceInfo.value.due_amount)
            ) {
                Toastr.fire({
                    icon: "error",
                    title: "Please enter a valid payment amount",
                });
                return false;
            }

            payNowBtn.value.name = "Processing ...";
            payNowBtn.value.status = true;

            const data = {
                sales_id: selectedInvoice.value,
                customer_id: selectedCustomer.value,
                payment_amount: paymentAmount.value,
                transaction_type_id: seletedTransactionType.value,
            };
            axios.post("/payment/sales/pay", data).then((response) => {
                console.clear();
                if (response.data.status == true) {
                    Toastr.fire({
                        icon: "success",
                        title: "Payment successful",
                    });


                    setTimeout(() => {
                        window.location.assign(
                            `/payment/sales/pay-slip/${response.data.data}`
                        );
                    }, 1000);
                }
            });
        };

        return {
            selectedInoviceDate,
            selectedInvoice,
            selectedInvoiceClass,
            invoiceList,
            seletedTransactionType,
            transactionTypesList,
            selectedCustomerClass,
            selectedCustomer,
            selectedInvoiceInfo,
            hasSelectedInvoiceInfo,
            customerList,
            payNowBtn,
            paymentAmount,
            payFullPayment,
            fetchInvoiceByDate,
            choiceInvoice,
            choiceCustomer,
            payNow,
        };
    },
};
</script>

<style></style>
