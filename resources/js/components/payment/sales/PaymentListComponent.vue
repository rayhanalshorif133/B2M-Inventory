<template>
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Sales Payment list</h3>
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
                                <th style="width: 10px">Invoice Date</th>
                                <th style="width: 10px">Customer Name</th>
                                <th style="width: 10px">Payment Amount</th>
                                <th style="width: 10px">Actions</th>
                            </tr>
                        </thead>
                    </DataTable>
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
var paymentData = ref();

axios.get("/sales/payment-list?fetch=1").then(function (response) {
    const GET_DATA = response.data.data;
    GET_DATA.length > 0 &&
        GET_DATA.map(function (item, index) {
            const btns = `<div class="btn-group">
                    <a href="/payment/sales/pay-slip/${item.id}" type="button" class="btn btn-success btn-sm">
                     <i class="fa-regular fa-eye"></i> Pay Slip
                    </a>
                    <button type="button" class="btn btn-info btn-sm paymentEditBtn btn-fit" data-id="${item.id}">
                            <i class="fa-solid fa-pen-to-square"></i> Edit
                    </button>
                    <button type="button" class="btn btn-danger btn-sm">
                    Delete <i class="fa-solid fa-trash"></i>
                    </button>
                </div>`;
            const date = `<span>${item.created_date}</span> <span class="d-none">${item.receipt_no}</span>`;
            var PUTDATA = [
                index + 1,
                date,
                item.customer.name,
                item.amount,
                btns,
            ];
            data.value.push(PUTDATA);
        });
});


// Fetch data on component mount
onMounted(() => {
    document.addEventListener("click", (event) => {
        if (event.target.closest(".paymentEditBtn")) {
            // const id = event.target.closest(".btn").getAttribute("data-id");
            // axios.get(`/payment/fetch/${id}?type=sales`).then((response) => {
            //     paymentData.value = response.data.data;
            //     const modalElement = document.getElementById("paymentEditModal");
            //     showModal.value = new bootstrap.Modal(modalElement);
            //     showModal.value.show();
            // });
        }
    });
});

</script>
