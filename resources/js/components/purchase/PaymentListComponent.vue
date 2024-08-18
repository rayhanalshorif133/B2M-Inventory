<template>
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Purchases Payment list</h3>
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
                                <th style="width: 10px">Suppler Name</th>
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
import { ref } from "vue";


DataTable.use(DataTablesCore);

var data = ref([]);

axios.get("/purchase/payment-list?fetch=1").then(function (response) {
    const GET_DATA = response.data.data;
    GET_DATA.length > 0 &&
        GET_DATA.map(function (item, index) {
            const btns = `<div class="btn-group">
                    <a href="/payment/purchase/pay-slip/${item.id}" type="button" class="btn btn-success btn-sm">
                     <i class="fa-regular fa-eye"></i> Pay Slip
                    </a>
                    <button type="button" class="btn btn-info btn-sm">
                     <i class="fa-regular fa-pen-to-square"></i> Edit
                    </button>
                    <button type="button" class="btn btn-danger btn-sm">
                    Delete <i class="fa-solid fa-trash"></i>
                    </button>
                </div>`;
            const date = `<span>${item.created_date}</span> <span class="d-none">${item.receipt_no}</span>`;
            var PUTDATA = [index + 1,date,item.supplier.name,item.amount,btns];
            data.value.push(PUTDATA);
        });
});
</script>
