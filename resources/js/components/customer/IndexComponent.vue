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
                                <th>Contact</th>
                                <th>Email</th>
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
                    <div class="modal-header">
                        <h5 class="modal-title" id="editCustomerLabel">
                            Customer Update
                        </h5>
                        <button
                            type="button"
                            class="btn-close"
                            :onclick="hideModel"
                        ></button>
                    </div>
                    <div class="modal-body">
                    </div>
                    <div class="modal-footer">
                        <button
                            type="button"
                            class="btn btn-secondary text-white"
                            :onclick="hideModel"
                        >
                            Close
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

DataTable.use(DataTablesCore);

var showModal = ref();


const hideModel = () => {
    showModal.value.hide();
};

var data = ref([]);

axios.get("/customer/list?type=fetch").then(function (response) {
    const GET_DATA = response.data.data;
    GET_DATA.length > 0 &&
        GET_DATA.map(function (item, index) {
            const btns = `<div class="btn-group">
                    <button type="button" class="btn btn-info btn-sm editBtn">
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

const handleEdit = () => {
    // Event delegation to handle clicks on dynamically generated buttons
    document.addEventListener("click", (event) => {
        if (event.target.closest(".editBtn")) {
            const id = event.target.closest(".btn").getAttribute("data-id");
            const modalElement = document.getElementById("editCustomer");
            showModal.value = new bootstrap.Modal(modalElement);
            showModal.value.show();
        }
        if (event.target.closest(".statusBtn")) {
            const id = event.target.closest(".btn").getAttribute("data-id");
            handleStatusBtn(id);
        }
    });
};

onMounted(() => {
    handleEdit();
});
</script>
