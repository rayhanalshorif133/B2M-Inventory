<template>
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Supplier List</h3>
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
                                <th>Email</th>
                                <th>Contact</th>
                                <th>Address</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                    </DataTable>
                </div>
            </div>
        </div>
        <div
            class="modal fade"
            id="editSupplier"
            tabindex="-1"
            aria-labelledby="editSupplierLabel"
            aria-hidden="true"
        >
            <div class="modal-dialog modal-defult">
                <div class="modal-content">
                    <div
                        class="modal-header bg-navy"
                        style="padding: 15px 20px"
                    >
                        <h5 class="modal-title" id="editSupplierLabel">
                            Supplier Update
                        </h5>
                        <button type="button" :onclick="hideModel">
                            <i class="fa fa-xmark" style="font-size: 20px"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="name" class="form-label">Name</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="name"
                                        v-model="supplierInfo.name"
                                        required
                                    />
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="contact" class="form-label">Contact</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="contact"
                                        v-model="supplierInfo.contact"
                                        required
                                    />
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="address" class="form-label">Address</label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="address"
                                        v-model="supplierInfo.address"
                                        required
                                    />
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input
                                        type="email"
                                        class="form-control"
                                        id="email"
                                        v-model="supplierInfo.email"
                                        required
                                    />
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="others_info" class="form-label">Other Information</label>
                                    <textarea
                                        class="form-control"
                                        id="others_info"
                                        v-model="supplierInfo.others_info"
                                        rows="3"
                                    ></textarea>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button
                            type="button"
                            class="btn btn-secondary text-white"
                            :onclick="hideModel"
                        >
                            Close
                        </button>
                        <button
                            type="button"
                            class="btn btn-navy"
                            :onclick="handleSubmit"
                        >
                            Update
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

var showModal = ref();
const supplierInfo = ref({
    name: "",
    id: "",
    contact: "",
    address: "",
    email: "",
    others_info: "",
});

const hideModel = () => {
    showModal.value.hide();
};

var data = ref([]);

const fetchSupplier = () => {
    axios.get("/supplier/list?type=fetch").then(function (response) {
        const GET_DATA = response.data.data;
        data.value = [];
        GET_DATA.length > 0 &&
            GET_DATA.map(function (item, index) {
                const btns = `<div class="btn-group" data-id="${item.id}">
                    <button type="button" class="btn btn-info btn-sm editBtn" >
                     <i class="fa-regular fa-pen-to-square"></i> Edit
                    </button>
                    <button type="button" class="btn btn-danger btn-sm deleteBtn">
                    Delete <i class="fa-solid fa-trash"></i>
                    </button>
                </div>`;
                var PUTDATA = [
                    index + 1,
                    item.name,
                    item.email,
                    item.contact,
                    item.address,
                    statusDesign(item.status),
                    btns,
                ];
                data.value.push(PUTDATA);
            });
    });
};

const statusDesign = (status) => {
    if (status === 1) {
        return '<span class="badge bg-success">Active</span>';
    } else if (status === 0) {
        return '<span class="badge bg-danger">Inactive</span>';
    } else {
        return '<span class="badge bg-secondary">Unknown</span>';
    }
};

const handleEdit = () => {
    // Event delegation to handle clicks on dynamically generated buttons
    document.addEventListener("click", (event) => {
        if (event.target.closest(".editBtn")) {
            const id = event.target
                .closest(".btn-group")
                .getAttribute("data-id");
            const modalElement = document.getElementById("editSupplier");
            showModal.value = new bootstrap.Modal(modalElement);
            axios.get(`/supplier/fetch?supplier_id=${id}`).then((res) => {
                supplierInfo.value = res.data.data;
                showModal.value.show();
            });
        }
        if (event.target.closest(".deleteBtn")) {
            const id = event.target
                .closest(".btn-group")
                .getAttribute("data-id");
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
                    axios.delete(`/supplier/${id}/delete`).then((res) => {
                        const { data } = res.data;

                        Swal.fire({
                            title: "Deleted!",
                            text: data,
                            icon: "success",
                        });

                        fetchSupplier();
                    });
                }
            });
        }
    });
};

const handleSubmit = () => {
    axios.put(`/supplier/update`, supplierInfo.value).then((res) => {
        fetchSupplier();
        hideModel();
    });
};

onMounted(() => {
    handleEdit();
    fetchSupplier();
});
</script>
