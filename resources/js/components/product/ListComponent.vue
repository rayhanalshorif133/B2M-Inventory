<template>
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header d-flex">
                    <h3 class="card-title">Product List</h3>
                    <a class="btn btn-primary ml-auto" href="/product/create">Create</a>
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
                                <th>Category</th>
                                <th>Sub Category</th>
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

axios.get("/product/list").then(function (response) {
    const GET_DATA = response.data.data;
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
            var PUTDATA = [
                index + 1,
                item.name,
                item.category.name,
                item.sub_category.name,
                btns,
            ];
            data.value.push(PUTDATA);
        });
});
</script>
