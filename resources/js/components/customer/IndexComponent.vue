<template>
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Cusmoter List</h3>
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
                                <th>Actions</th>
                            </tr>
                        </thead>
                    </DataTable>
                </div>
            </div>
        </div>
        <div
            class="modal fade"
            id="editCustomer"
            tabindex="-1"
            aria-labelledby="editCustomerLabel"
            aria-hidden="true"
        >
            <div class="modal-dialog modal-defult">
                <div class="modal-content">
                    <div
                        class="modal-header bg-navy"
                        style="padding: 15px 20px"
                    >
                        <h5 class="modal-title" id="editCustomerLabel">
                            Customer Update
                        </h5>
                        <button type="button" :onclick="hideModel">
                            <i class="fa fa-xmark" style="font-size: 20px"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="name" class="form-label"
                                        >Name</label
                                    >
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="name"
                                        v-model="customerInfo.name"
                                        required
                                    />
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="contact" class="form-label"
                                        >Contact</label
                                    >
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="contact"
                                        v-model="customerInfo.contact"
                                        required
                                    />
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="address" class="form-label"
                                        >Address</label
                                    >
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="address"
                                        v-model="customerInfo.address"
                                        required
                                    />
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label"
                                        >Email</label
                                    >
                                    <input
                                        type="email"
                                        class="form-control"
                                        id="email"
                                        v-model="customerInfo.email"
                                        required
                                    />
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label for="others_info" class="form-label"
                                        >Other Information</label
                                    >
                                    <textarea
                                        class="form-control"
                                        id="others_info"
                                        v-model="customerInfo.others_info"
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
const customerInfo = ref({
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

const fetchCustomer = () => {
    axios.get("/customer/list?type=fetch").then(function (response) {
        const GET_DATA = response.data.data;
        data.value = [];
        GET_DATA.length > 0 &&
            GET_DATA.map(function (item, index) {
                const btns = `<div class="btn-group">
                    <button type="button" class="btn btn-info btn-sm editBtn" data-id="${item.id}">
                     <i class="fa-regular fa-pen-to-square"></i> Edit
                    </button>
                    <button type="button" class="btn btn-danger btn-sm">
                    Delete <i class="fa-solid fa-trash"></i>
                    </button>
                </div>`;
                var PUTDATA = [
                    index + 1,
                    item.name,
                    item.email,
                    item.contact,
                    item.address,
                    btns,
                ];
                data.value.push(PUTDATA);
            });
    });
};

const handleEdit = () => {
    // Event delegation to handle clicks on dynamically generated buttons
    document.addEventListener("click", (event) => {
        if (event.target.closest(".editBtn")) {
            const id = event.target.closest(".btn").getAttribute("data-id");
            const modalElement = document.getElementById("editCustomer");
            showModal.value = new bootstrap.Modal(modalElement);
            axios.get(`/customer/fetch?customer_id=${id}`).then((res) => {
                customerInfo.value = res.data.data;
                showModal.value.show();
            });
        }
        if (event.target.closest(".statusBtn")) {
            const id = event.target.closest(".btn").getAttribute("data-id");
            handleStatusBtn(id);
        }
    });
};

const handleSubmit = () => {
    axios.put(`/customer/update`, customerInfo.value).then((res) => {
        fetchCustomer();
        hideModel();
    });
};

onMounted(() => {
    handleEdit();
    fetchCustomer();
});
</script>
