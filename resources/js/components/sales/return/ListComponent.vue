<template>
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Purchases Return list</h3>
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
                                <th>Customer Name</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                    </DataTable>
                </div>
            </div>
        </div>
        <show-return-details-component
            :closeModal="closeModal"
            :fetchShowData="fetchShowData"
            :salesReturnEditLink="salesReturnEditLink"
        ></show-return-details-component>
    </section>
</template>
<style>
@import "datatables.net-dt";
</style>
<script setup>
import DataTable from "datatables.net-vue3";
import ShowReturnDetailsComponent from "./ShowComponent.vue";
import DataTablesCore from "datatables.net";
import { ref, onMounted } from "vue";

DataTable.use(DataTablesCore);

var data = ref([]);

var showModal = ref();
var fetchShowData = ref();
var salesReturnEditLink = ref("");

const fetchData = () => {
    axios.get("/sales/return/list?type=fetch").then(function (response) {
        const GET_DATA = response.data.data;
        console.log(GET_DATA);
        GET_DATA.length > 0 &&
            GET_DATA.map(function (item, index) {
                const btns = `
                    <div class="btn-group">
                        <button type="button" class="btn btn-success btn-sm showBtn btn-fit" data-id="${item.id}">
                         <i class="fa-regular fa-eye"></i> View
                        </button>
                        <a href="/sales/return/invoice/${item.id}" type="button" class="btn btn-primary btn-sm print btn-fit">
                         <i class="fa-solid fa-print"></i> Print
                        </a>
                        <button type="button" class="btn btn-danger btn-sm deleteBtn btn-fit" data-id="${item.id}">
                            <i class="fa-solid fa-trash"></i> Delete
                        </button>
                    </div>`;
                const status =
                    item.status == "0"
                        ? `<span class="badge badge-danger">Inactive</span>`
                        : `<span class="badge badge-success">Active</span>`;
                var name = item.customer ? item.customer.name : "No Assign";
                var PUTDATA = [
                    item.id,
                    item.code,
                    item.invoice_date,
                    name,
                    btns,
                ];
                data.value.push(PUTDATA);
            });
    });
};
const fetchDetailsSalesData = (id) => {
    axios.get(`/sales/return/fetch/${id}`).then((response) => {
        fetchShowData.value = response.data.data;
        const modalElement = document.getElementById(
            "showReturnSalesDetails"
        );
        salesReturnEditLink.value = `/sales/return/${id}/edit/`;
        showModal.value = new bootstrap.Modal(modalElement);
        showModal.value.show();
    });
};

const handleShowDetails = () => {
    document.addEventListener("click", (event) => {
        if (event.target.closest(".showBtn")) {
            const id = event.target.closest(".btn").getAttribute("data-id");
            fetchDetailsSalesData(id);
        }
    });
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
                    axios.delete(`/sales/${id}/delete`).then((result) => {
                        console.log(result.data.data);
                    });
                    Swal.fire({
                        title: "Deleted!",
                        text: "Your file has been deleted.",
                        icon: "success",
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

const closeModal = (event) => {
    showModal.value.hide();
};

// Fetch data on component mount
onMounted(() => {
    fetchData();
    handleShowDetails();
    handleDeleteBtn();
});
</script>
