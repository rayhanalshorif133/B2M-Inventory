<template>
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Expencse Head list</h3>
                    <button
                        type="button"
                        class="btn btn-sm btn-primary card-tools"
                        data-bs-toggle="modal"
                        data-bs-target="#addExpHead"
                    >
                        Add New
                    </button>
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
                                <th style="width: 10px">Name</th>
                                <th style="width: 10px">Category Name</th>
                                <th style="width: 10px">Added By</th>
                                <th style="width: 10px">Status</th>
                                <th style="width: 10px">Actions</th>
                            </tr>
                        </thead>
                    </DataTable>
                </div>
            </div>
        </div>
        <create-and-update-model
            :item_value="GET_ITEM_VALUE"
            :closeModal="closeModal"
            :categories="categories"
        ></create-and-update-model>
    </section>
</template>
<style>
@import "datatables.net-dt";
</style>
<script setup>
import DataTable from "datatables.net-vue3";
import DataTablesCore from "datatables.net";
import CreateAndUpdateModel from "./CreateAndUpdateModel.vue";
import { ref, onMounted } from "vue";
import axios from "axios";

DataTable.use(DataTablesCore);

var data = ref([]);
var GET_ITEM_VALUE = ref("");
var updateSelectCategory = ref("0");
var showModal = ref();

axios.get("/expense-income/head?type=fetch").then(function (response) {
    const GET_DATA = response.data.data;
    GET_DATA.length > 0 &&
        GET_DATA.map(function (item, index) {
            const SET_DATA =
                item.id +
                "-" +
                item.name +
                "-" +
                item.expenses_income_categories_id;
            const btns = `<div class="btn-group">
                    <button type="button" class="btn btn-info btn-sm editBtnExpenseIncomeHead btn-fit" data-item-value="${SET_DATA}">
                            <i class="fa-solid fa-pen-to-square"></i> Edit
                    </button>
                    <button type="button" class="btn btn-danger btn-sm deleteBtnExpenseIncomeHead" data-id="${item.id}">
                        Delete <i class="fa-solid fa-trash"></i>
                    </button>
                </div>`;
            const status = `<span class="badge ${
                item.status == 1 ? "bg-success" : "bg-danger"
            }">
                    ${item.status == 1 ? "Active" : "Inavtice"}</span>`;
            var PUTDATA = [
                index + 1,
                item.name,
                item.expenses_income_categories.name,
                item.added_by.name,
                status,
                btns,
            ];
            data.value.push(PUTDATA);
        });
});

const closeModal = (event) => {
    showModal.value.hide();
};

// Fetch data on component mount
onMounted(() => {
    document.addEventListener("click", (event) => {
        if (event.target.closest(".editBtnExpenseIncomeHead")) {
            GET_ITEM_VALUE.value = event.target
                .closest(".btn")
                .getAttribute("data-item-value");
            const modalElement = document.getElementById("updateExpHead");
            showModal.value = new bootstrap.Modal(modalElement);
            showModal.value.show();
        }

        if (event.target.closest(".deleteBtnExpenseIncomeHead")) {
            const GETID = event.target.closest(".btn").getAttribute("data-id");
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!",
            }).then((result) => {
                if (result.isConfirmed) {
                    axios
                        .delete(`/expense-income/head/${GETID}/delete`)
                        .then((response) => {
                            const data = response.data.data;
                            const message = response.data.message;

                            Toastr.fire({
                                icon: message,
                                title: data,
                            });

                            Swal.fire({
                                title: "Deleted!",
                                text: "Your file has been deleted.",
                                icon: "success",
                            });
                            if (message == "success") {
                                setTimeout(() => {
                                    window.location.reload();
                                }, 1000);
                            }
                        });
                }
            });
        }
    });
});
</script>
