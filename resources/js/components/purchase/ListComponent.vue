<template>
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Purchases list</h3>
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
                                <th>Code</th>
                                <th>Invoice Date</th>
                                <th>Suppler Name</th>
                                <th>Actions</th>
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

axios.get("/purchase/list").then(function (response) {
    const GET_DATA = response.data.data;
    GET_DATA.length > 0 &&
        GET_DATA.map(function (item, index) {
            console.log(item);
            const btns = `<div class="btn-group">
                    <button type="button" class="btn btn-info btn-sm">
                     <i class="fa-regular fa-pen-to-square"></i> Edit
                    </button>
                    <button type="button" class="btn btn-danger btn-sm">
                    Delete <i class="fa-solid fa-trash"></i>
                    </button>
                </div>`;
            var name = item.supplier ? item.supplier.name : 'No Assign'
            var PUTDATA = [item.id, item.code,item.invoice_date,name,btns];
            data.value.push(PUTDATA);
        });
});
</script>
