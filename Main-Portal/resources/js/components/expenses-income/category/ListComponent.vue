<template>
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Expencse Category list</h3>
                    <button
                        type="button"
                        class="btn btn-sm btn-primary card-tools"
                        data-bs-toggle="modal"
                        data-bs-target="#addExpCategory"
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
            :update_name="update_name"
            :id="id"
            :closeModal="closeModal"
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
var showModal = ref();
var paymentData = ref();

axios.get("/expense-income/category?type=fetch").then(function (response) {
    const GET_DATA = response.data.data;
    GET_DATA.length > 0 &&
        GET_DATA.map(function (item, index) {
            const btns = `<div class="btn-group">
                    <button type="button" class="btn btn-info btn-sm editBtnExpenseIncomeCategory btn-fit" data-id="${item.id}" data-name="${item.name}">
                            <i class="fa-solid fa-pen-to-square"></i> Edit
                    </button>
                    <button type="button" class="btn btn-danger btn-sm deleteBtnExpenseIncome" data-id="${item.id}">
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
        if (event.target.closest(".editBtnExpenseIncomeCategory")) {
            id.value = event.target.closest(".btn").getAttribute("data-id");
            update_name.value = event.target
                .closest(".btn")
                .getAttribute("data-name");
            const modalElement = document.getElementById("updateExpCategory");
            showModal.value = new bootstrap.Modal(modalElement);
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
                        .delete(`/expense-income/category/${GETID}/delete`)
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
