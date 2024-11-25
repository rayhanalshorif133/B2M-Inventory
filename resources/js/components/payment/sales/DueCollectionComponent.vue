<template>
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Sales Due list</h3>
                </div>

                <div class="card-body">
                    <DataTable
                        :data="data"
                        :columns="columns"
                        class="table table-bordered display table-hover"
                        :ref="table"
                    >
                        <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th style="width: 10px">Customer Name</th>
                                <th style="width: 10px">Phone Number</th>
                                <th style="width: 10px">Due Amount</th>
                                <th style="width: 10px">Actions</th>
                            </tr>
                        </thead>
                    </DataTable>
                </div>
            </div>
        </div>
        <div
            class="modal fade"
            id="quickSalesPay"
            tabindex="-1"
            aria-labelledby="quickSalesPayLabel"
            aria-hidden="true"
        >
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header card-outline card-info">
                        <h5 class="modal-title" id="quickSalesPayLabel">
                            Payment Received
                        </h5>
                        <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"
                            aria-label="Close"
                            @click="hideModalQuickSalesPay"
                        ></button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div>
                                <p>
                                    <b>Customer Name:</b>
                                    <span>{{ customer_name }}</span>
                                </p>
                                <p>
                                    <b>Customer Phone Number: </b>
                                    <span>{{ customer_phone_number }}</span>
                                </p>
                                <p>
                                    <b>Total Due:</b>
                                    <span>{{ total_due }} tk</span>
                                </p>
                            </div>
                            <div class="mt-3">
                                <div class="col-12 mt-1">
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
                                <div class="col-12 mt-1">
                                    <label>Received Amount</label>
                                    <div class="d-flex">
                                        <input
                                            type="text"
                                            class="form-control w-full mr-1"
                                            v-model="paymentAmount"
                                        />
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button
                            type="button"
                            class="btn btn-secondary"
                            data-bs-dismiss="modal"
                            @click="hideModalQuickSalesPay"
                        >
                            Close
                        </button>
                        <button
                            type="button"
                            class="btn btn-primary"
                            @click="handleSubmit"
                        >
                            Submit
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
<style>
@import "datatables.net-dt";
</style>
<script setup>
import DataTable from "datatables.net-vue3";
import DataTablesCore from "datatables.net";
import { ref, onMounted } from "vue";
import axios from "axios";

DataTable.use(DataTablesCore);

var data = ref([]);
var paymentID = ref();
var showModal = ref();
var quickSalesPay = ref();
var paymentData = ref();
var paymentAmount = ref(0);
var customerId = ref(0);
var transactionTypeId = ref(0);
var customer_name = ref("");
var customer_phone_number = ref("0");
var seletedTransactionType = ref("0");
var total_due = ref(0);
var transactionTypesList = ref("");

const fetchTransactionTypes = () => {
    axios.get("/transaction-types/fetch").then((response) => {
        if (response.data.status == true) {
            transactionTypesList.value = response.data.data;
        }
    });
};

axios.get("/sales/due-amount?fetch=1").then(function (response) {
    const GET_DATA = response.data.data;
    GET_DATA.length > 0 &&
        GET_DATA.map(function (item, index) {
            const btns = `<div class="btn-group">
                    <button type="button" class="btn btn-success btn-sm paymentBtn btn-auto" data-due_amount="${item.due_amount}" data-contact="${item.contact}" data-name="${item.name}" data-id="${item.id}">
                             Received Now <i class="fa-solid fa-check"></i>
                    </button>
                </div>`;
            const date = `<span>${item.created_date}</span> <span class="d-none">${item.receipt_no}</span>`;
            var PUTDATA = [
                index + 1,
                item.name,
                item.contact,
                item.due_amount,
                btns,
            ];
            data.value.push(PUTDATA);
        });
});

const closeModal = (event) => {
    showModal.value.hide();
};

const handleSubmit = (event) => {
    const data = {
        payment_amount: paymentAmount.value,
        customer_id: customerId.value,
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

const hideModalQuickSalesPay = (event) => {
    quickSalesPay.value.hide();
};

// Fetch data on component mount
onMounted(() => {
    fetchTransactionTypes();
    document.addEventListener("click", (event) => {
        if (event.target.closest(".paymentBtn")) {
            customerId.value = event.target
                .closest(".btn")
                .getAttribute("data-id");
            customer_name.value = event.target
                .closest(".btn")
                .getAttribute("data-name");
            customer_phone_number.value = event.target
                .closest(".btn")
                .getAttribute("data-contact");
            total_due.value = event.target
                .closest(".btn")
                .getAttribute("data-due_amount");
            quickSalesPay.value = new bootstrap.Modal(
                document.getElementById("quickSalesPay"),
                {
                    keyboard: false,
                }
            );

            quickSalesPay.value.show();
        }
    });
});
</script>
