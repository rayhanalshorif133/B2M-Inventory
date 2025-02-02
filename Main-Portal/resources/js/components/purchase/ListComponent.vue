<template>
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header justify-content-between d-flex">
                    <h3 class="card-title">Purchases list</h3>
                    <div class="ml-auto">
                        <button
                            class="btn btn-sm btn-success mx-2"
                            @click="exportToExcel"
                        >
                            Export to Excel
                        </button>
                        <a
                            class="btn btn-sm btn-success"
                            href="/purchase/create"
                        >
                            Create New Purchase
                        </a>
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
                                <th scope="col">#</th>
                                <th scope="col">Code</th>
                                <th scope="col">Invoice Date</th>
                                <th scope="col">Supplier Name</th>
                                <th scope="col">Total Amount</th>
                                <th scope="col">Status</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                    </DataTable>
                </div>
            </div>
        </div>
        <show-details-component
            :closeModal="closeModal"
            :fetchShowData="fetchShowData"
            :purchaseEditLink="purchaseEditLink"
        ></show-details-component>
    </section>
</template>
<style>
@import "datatables.net-dt";
</style>
<script setup>
import DataTable from "datatables.net-vue3";
import DataTablesCore from "datatables.net";
import { ref, onMounted } from "vue";
import ShowDetailsComponent from "./ShowComponent.vue";
import axios from "axios";
import * as XLSX from "xlsx";

DataTable.use(DataTablesCore);

var data = ref([]);
var showModal = ref();
var fetchShowData = ref();
var purchaseEditLink = ref("");

const fetchData = () => {
    axios.get("/purchase/list?type=fetch").then(function (response) {
        const GET_DATA = response.data.data;
        GET_DATA.length > 0 &&
            GET_DATA.map(function (item, index) {
                const btns = `
                    <div class="btn-group">
                        <button type="button" class="btn btn-success btn-sm showBtn btn-fit" data-id="${item.id}">
                         <i class="fa-regular fa-eye"></i> View
                        </button>
                        <a href="/purchase/invoice/${item.id}" type="button" class="btn btn-primary btn-sm print btn-fit">
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
                var name = item.supplier ? item.supplier.name : "No Assign";
                var PUTDATA = [
                    item.id,
                    item.code,
                    item.invoice_date,
                    name,
                    item.total_amount,
                    status,
                    btns,
                ];
                data.value.push(PUTDATA);
            });
    });
};

const fetchDetailsPurchaseData = (id) => {
    axios.get(`/purchase/fetch/${id}`).then((response) => {
        fetchShowData.value = response.data.data;
        const modalElement = document.getElementById("showPurchaseDetails");
        purchaseEditLink.value = `/purchase/${id}/edit/`;
        showModal.value = new bootstrap.Modal(modalElement);
        showModal.value.show();
    });
};

const exportToExcel = () => {
    // Create a new workbook and add a worksheet with the data
    const worksheet = XLSX.utils.json_to_sheet(
        data.value.map((item) => ({
            "#": item[0],
            Code: item[1],
            "Invoice Date": item[2],
            "Supplier Name": item[3],
            "Total Amount": item[4],
            Status: item[5] == '<span class="badge badge-success">Active</span>'? "active" : "inactive",
        }))
    );

    const workbook = XLSX.utils.book_new();
    XLSX.utils.book_append_sheet(workbook, worksheet, "Purchases");

    // Generate Excel file and trigger download
    XLSX.writeFile(workbook, "purchases.xlsx");
};

const handleShowDetails = () => {
    // Event delegation to handle clicks on dynamically generated buttons
    document.addEventListener("click", (event) => {
        if (event.target.closest(".showBtn")) {
            const id = event.target.closest(".btn").getAttribute("data-id");
            fetchDetailsPurchaseData(id);
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
                    axios.delete(`/purchase/${id}/delete`).then((result) => {
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
