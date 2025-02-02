<template>
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Expencse & Income list</h3>
                    <button
                        type="button"
                        class="btn btn-sm btn-primary card-tools"
                        @click="openModal"
                    >
                        Add New
                    </button>
                </div>

                <div class="card-body overflow-auto">
                    <DataTable
                        :data="data"
                        :columns="columns"
                        class="table table-bordered display table-hover"
                        :ref="table"
                    >
                        <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th style="width: 10px">Date</th>
                                <th style="width: 10px">Category Name</th>
                                <th style="width: 10px">Head Name</th>
                                <th style="width: 10px">Type</th>
                                <th style="width: 10px">Amount</th>
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
            :actionType="actionType"
            :id="id"
            :hideModal="hideModal"
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
var update_name = ref("");
var id = ref("");
var actionType = ref("create");
var showModal = ref();
var paymentData = ref();

axios.get("/expense-income?type=fetch").then(function (response) {
    const GET_DATA = response.data.data;
    GET_DATA.length > 0 &&
        GET_DATA.map(function (item, index) {
            console.log(item);
            const btns = `<div class="btn-group">
                    <button type="button" class="btn btn-info btn-sm editBtnExpenseIncome btn-fit" data-id="${item.id}">
                            <i class="fa-solid fa-pen-to-square"></i> Edit
                    </button>
                    <button type="button" class="btn btn-danger btn-sm deleteBtnExpenseIncome btn-fit" data-id="${item.id}">
                        Delete <i class="fa-solid fa-trash"></i>
                    </button>
                </div>`;
            const status = `<span class="badge ${
                item.status == 1 ? "bg-success" : "bg-danger"
            }">
                    ${item.status == 1 ? "Active" : "Inavtice"}</span>`;
            const type = item.type == 1 ? "Income" : "Expense";
            var PUTDATA = [
                index + 1,
                item.date,
                item.expenses_income_category.name,
                item.expenses_income_head.name,
                type,
                item.amount,
                item.added_by.name,
                status,
                btns,
            ];
            data.value.push(PUTDATA);
        });
});

const hideModal = () => {
    showModal.value.hide();
};

const openModal = () => {
    const modalElement = document.getElementById("createOrUpdateExpAndIncome");
    showModal.value = new bootstrap.Modal(modalElement);
    actionType.value = "create";
    showModal.value.show();
};

// Fetch data on component mount
onMounted(() => {
    document.addEventListener("click", (event) => {
        if (event.target.closest(".editBtnExpenseIncome")) {
            id.value = event.target.closest(".btn").getAttribute("data-id");
            const modalElement = document.getElementById(
                "createOrUpdateExpAndIncome"
            );
            showModal.value = new bootstrap.Modal(modalElement);
            actionType.value = "update";
            showModal.value.show();
        }

        if (event.target.closest(".deleteBtnExpenseIncome")) {
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
                        .delete(`/expense-income/${GETID}/delete`)
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
                                }, 1600);
                            }
                        });
                }
            });
        }
    });
});
</script>
