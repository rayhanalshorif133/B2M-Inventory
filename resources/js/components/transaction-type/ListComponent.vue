<template>
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header justify-content-between d-flex">
                    <h3 class="card-title w-fill">Transaction Type List</h3>
                    <div class="d-flex justify-content-end float-end w-100">
                        <button
                            type="button"
                            class="btn btn-sm btn-primary"
                        >
                            Add New (Pending)
                        </button>
                    </div>
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
                                <th>Name</th>
                                <th>Added By</th>
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

axios.get("/transaction-types").then(function (response) {
    const GET_DATA = response.data.data;
    console.log(GET_DATA);
    GET_DATA.length > 0 &&
        GET_DATA.map(function (item, index) {
            const btns = `<div class="btn-group">
                    <button type="button" class="btn btn-success btn-sm">
                     <i class="fa-regular fa-eye"></i> Show
                    </button>
                    <button type="button" class="btn btn-danger btn-sm">
                    Delete <i class="fa-solid fa-trash"></i>
                    </button>
                </div>`;
            var PUTDATA = [index + 1, item.name, item.added_by.name, btns];
            data.value.push(PUTDATA);
        });
});
</script>
