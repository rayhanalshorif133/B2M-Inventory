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
                            @click="showModal('new')"
                        >
                            Add New
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
        <!-- Modal -->
        <div
            class="modal fade"
            id="transactionTypeModal"
            tabindex="-1"
            aria-labelledby="transactionTypeModalLabel"
            aria-hidden="true"
        >
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="transactionTypeModalLabel">
                            {{ modal_title }}
                        </h5>
                        <button
                            type="button"
                            class="btn-close"
                            @click="hideModal"
                        ></button>
                    </div>
                    <div class="modal-body">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="name" class="d-flex mx-1"
                                    >Transaction Type Name
                                    <span class="text-danger mx-1"
                                        >*</span
                                    ></label
                                >
                                <input
                                    class="form-control"
                                    id="name"
                                    v-model="name"
                                    placeholder="Enter a Transaction Type Name"
                                />
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button
                            type="button"
                            class="btn btn-secondary"
                            @click="hideModal"
                        >
                            Close
                        </button>
                        <button
                            type="button"
                            @click="submitBtn"
                            class="btn btn-primary"
                        >
                            Save
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
var name = ref("");
var modal = ref("");
var modal_title = ref("Create New Transaction Type");
var __type = ref("new");
var __get_id = ref("");

axios.get("/transaction-types").then(function (response) {
    const GET_DATA = response.data.data;
    GET_DATA.length > 0 &&
        GET_DATA.map(function (item, index) {
            const btns = `<div class="btn-group">
                    <button type="button" class="btn btn-success btn-sm editBtn" data-id="${item.id}" data-name="${item.name}">
                     <i class="fa-solid fa-pen-to-square"></i> Edit
                    </button>
                    <button type="button" class="btn btn-danger btn-sm deleteBtn" data-id="${item.id}">
                    Delete <i class="fa-solid fa-trash"></i>
                    </button>
                </div>`;
            var PUTDATA = [index + 1, item.name, item.added_by.name, btns];
            data.value.push(PUTDATA);
        });
});

const submitBtn = () => {
    if (__type.value == "new") {
        axios
            .post("/transaction-types/create", { name: name.value })
            .then((response) => {
                const data = response.data.data;
                const message = response.data.message;
                Toastr.fire({
                    icon: message,
                    title: data,
                });
                setTimeout(() => {
                    location.reload();
                }, 1000);
            });
    } else {
        axios
            .put("/transaction-types/update", {
                name: name.value,
                tt_id: __get_id.value,
            })
            .then((response) => {
                const data = response.data.data;
                const message = response.data.message;
                Toastr.fire({
                    icon: message,
                    title: data,
                });
                setTimeout(() => {
                    location.reload();
                }, 1000);
            });
    }
};

const hideModal = () => {
    modal.value.hide();
};

const handleShowDetails = () => {
    // Event delegation to handle clicks on dynamically generated buttons
    document.addEventListener("click", (event) => {
        if (event.target.closest(".editBtn")) {
            __get_id.value = event.target
                .closest(".btn")
                .getAttribute("data-id");
            const getName = event.target
                .closest(".btn")
                .getAttribute("data-name");
            name.value = getName;
            __type.value = "update";
            modal_title.value = "Update Transaction Type";
            showModal("update");
        }
    });
};

const showModal = (type) => {
    const modalElement = document.getElementById("transactionTypeModal");
    modal.value = new bootstrap.Modal(modalElement);
    modal.value.show();
    if (type == "new") {
        name.value = "";
        modal_title.value = "Create a new transaction type";
    }
};

const handleDeleteBtn = () => {
    // Event delegation to handle clicks on dynamically generated buttons
    document.addEventListener("click", (event) => {
        if (event.target.closest(".deleteBtn")) {
            const id = event.target.closest(".btn").getAttribute("data-id");
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
                        .delete(`/transaction-types/${id}/delete`)
                        .then((result) => {
                            const data = result.data.data;
                            const message = result.data.message;
                            Toastr.fire({
                                icon: message,
                                title: data,
                            });
                            setTimeout(() => {
                                location.reload();
                            }, 1000);
                        });
                } else {
                    Swal.fire({
                        title: "Cancelled",
                        text: "Your imaginary file is safe :)",
                        icon: "error",
                    });
                }
            });
        }
    });
};

// Fetch data on component mount
onMounted(() => {
    handleShowDetails();
    handleDeleteBtn();
});
</script>
