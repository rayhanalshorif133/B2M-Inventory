<template>
    <div class="col-md-6 col-12">
        <div class="card card-outline card-info">
            <div class="card-header">
                <h3 class="card-title">Customer Based</h3>
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

                <div
                    class="mt-3 border p-2"
                    :class="hasSelectedCustomerInfo"
                    v-if="hasDueAmount"
                >
                    <div>
                        <p>
                            Due Amount:
                            {{ dueAmount }}
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
                                        style="width: 170px"
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
                <div v-else class="mt-3">
                    <div class="alert alert-danger" role="alert">
                        No due amount.
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
        var transactionTypesList = ref("");
        var seletedTransactionType = ref("0");
        var customerList = ref([]);
        var dueAmount = ref(0);
        var paymentAmount = ref("");
        var hasSelectedCustomerInfo = ref("d-none");
        var payNowBtn = ref({
            status: false,
            name: "Received Now",
        });
        var hasDueAmount = ref(true);

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
                .get(
                    `/sales/fetch-invoice/?date=${selectedInoviceDate.value}`
                )
                .then((response) => {
                    const data = response.data.data;
                    if (data.length > 0) {
                        data.map((item) => {
                            customerList.value.push(item.customer);
                        });

                        customerList.value = customerList.value.filter(
                            (customer, index, self) =>
                                index ===
                                self.findIndex((s) => s.name === customer.name)
                        );

                        selectedCustomerClass.value = "form-select-green";
                    } else {
                        selectedCustomerClass.value = "form-select-red";
                    }
                });
            setTimeout(() => {
                selectedInvoiceClass.value = "";
            }, 2000);
        };

        const choiceCustomer = () => {
            axios
                .get(
                    `/sales/fetch-invoice/?date=${selectedInoviceDate.value}&customer_id=${selectedCustomer.value}&type=customer`
                )
                .then((response) => {
                    const data = response.data.data;
                    dueAmount.value = data;

                    if (dueAmount.value == 0) {
                        hasDueAmount.value = false;
                    } else {
                        hasDueAmount.value = true;
                    }
                    hasSelectedCustomerInfo.value = "";
                });
        };

        const payFullPayment = () => {
            paymentAmount.value = dueAmount.value;
        };

        const payNow = () => {
            if (seletedTransactionType.value == "0") {
                Toastr.fire({
                    icon: "error",
                    title: "Please select a transaction type",
                });
                return false;
            }

            if (paymentAmount.value == "") {
                Toastr.fire({
                    icon: "error",
                    title: "Please enter a payment amount",
                });
                return false;
            }

            if (paymentAmount.value > dueAmount.value) {
                Toastr.fire({
                    icon: "error",
                    title: "Please enter valid payment amount",
                });
                paymentAmount.value = "";
                return false;
            }

            payNowBtn.value.name = "Processing ...";
            payNowBtn.value.status = true;

            const data = {
                payment_amount: paymentAmount.value,
                customer_id: selectedCustomer.value,
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
                        window.location.assign(`/payment/sales/pay-slip/${response.data.data}`);
                    }, 1000);
                }
            });
        };

        return {
            selectedInoviceDate,
            selectedInvoice,
            selectedInvoiceClass,
            seletedTransactionType,
            transactionTypesList,
            selectedCustomerClass,
            selectedCustomer,
            hasSelectedCustomerInfo,
            customerList,
            payNowBtn,
            dueAmount,
            paymentAmount,
            hasDueAmount,
            payFullPayment,
            fetchInvoiceByDate,
            choiceCustomer,
            payNow,
        };
    },
};
</script>

<style></style>
