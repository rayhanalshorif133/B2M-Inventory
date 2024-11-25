<script setup>
import DataTable from "datatables.net-vue3";
import DataTablesCore from "datatables.net";
import "datatables.net-select";
import axios from "axios"; // Make sure axios is imported
import { ref, onMounted } from "vue";
import ShowDetailsComponent from "./ShowComponent.vue";
import * as XLSX from "xlsx";

import "datatables.net-buttons";
import "datatables.net-buttons/js/buttons.html5";
// Initialize DataTables with core features
DataTable.use(DataTablesCore);

const options = {
    responsive: true,
    select: false,
};

const data = ref([]); // Reactive variable to hold table data
const table = ref(null); // Reference to the DataTable component
var showProductDetailId = ref(null);
var showModal = ref(null);

const fetchData = () => {
    axios.get("/product/list?type=fetch").then(function (response) {
        const GET_DATA = response.data.data;

        if (GET_DATA.length > 0) {
            data.value = GET_DATA.map((item, index) => {
                const status = `<span class="badge ${
                    item.status == 1 ? "bg-success" : "bg-danger"
                }">
                    ${item.status == 1 ? "Active" : "Inavtice"}</span>`;
                const btns = `
                    <div class="btn-group">
                      <button type="button" class="btn btn-info btn-sm text-white showBtn"
                        data-id="${item.id}">
                        <i class="fa-regular fa-eye"></i> Show
                      </button>
                      <button type="button" class="btn statusBtn ${
                          item.status == 0 ? "btn-success" : "btn-danger"
                      } btn-sm text-white" data-id="${item.id}">
                        ${
                            item.status == 0 ? "Active" : "Inavtice"
                        } <i class="fa-solid ${
                    item.status == 0 ? "fa-check" : "fa-xmark"
                }"></i>
                      </button>
                    </div>`;
                return [
                    index + 1,
                    item.name,
                    item.category.name,
                    item.sub_category.name,
                    status,
                    btns,
                ];
            });
        }
    });
};

const exportToExcel = () => {
    // Create a new workbook and add a worksheet with the data
    const worksheet = XLSX.utils.json_to_sheet(
        data.value.map((item) => ({
            "#": item[0],
            Name: item[1],
            Category: item[2],
            "Sub Category": item[3],
            Status:
                item[4] == '<span class="badge badge-success">Active</span>'
                    ? "active"
                    : "inactive",
        }))
    );

    const workbook = XLSX.utils.book_new();
    XLSX.utils.book_append_sheet(workbook, worksheet, "Products");

    // Generate Excel file and trigger download
    XLSX.writeFile(workbook, "product.xlsx");
};

var fetchProductData = ref();

const handleShowDetails = () => {
    // Event delegation to handle clicks on dynamically generated buttons
    document.addEventListener("click", (event) => {
        if (event.target.closest(".showBtn")) {
            const id = event.target.closest(".btn").getAttribute("data-id");
            fetchDetailsProductData(id);
            const modalElement = document.getElementById("showProductDetails");
            showModal.value = new bootstrap.Modal(modalElement);
            showModal.value.show();
        }
        if (event.target.closest(".statusBtn")) {
            const id = event.target.closest(".btn").getAttribute("data-id");
            handleStatusBtn(id);
        }
    });
};

const fetchDetailsProductData = (id) => {
    axios.get(`/product/show-product-details/${id}`).then((response) => {
        fetchProductData.value = response.data.data;
    });
    return true;
};

const handleStatusBtn = (id) => {
    Swal.fire({
        title: "Are you sure?",
        text: "You want to change this status!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, change it!",
    }).then((result) => {
        if (result.isConfirmed) {
            axios.put(`/product/update/${id}?type=status`).then((response) => {
                console.log(response.data.data);
                fetchData();
                Swal.fire({
                    title: "Success!",
                    text: "Product status has been changed!.",
                    icon: "success",
                });
            });
        }
    });
};

const closeModal = (event) => {
    showModal.value.hide();
    fetchData();
};

// Fetch data on component mount
onMounted(() => {
    fetchData();
    handleShowDetails();
});
</script>
<template>
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header d-flex">
                    <h3 class="card-title">Product List</h3>

                    <div class="ml-auto">
                        <a
                            class="btn btn-primary btn-fit"
                            href="/product/create"
                            >Create</a
                        >
                    </div>
                </div>

                <div class="card-body">
                    <DataTable
                        :data="data"
                        :options="options"
                        class="table table-bordered display table-hover"
                        :ref="table"
                    >
                        <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Sub Category</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                    </DataTable>
                </div>
                <show-details-component
                    :productData="fetchProductData"
                    :closeModal="closeModal"
                ></show-details-component>
            </div>
        </div>
    </section>
</template>
<style>
@import "datatables.net-dt";
</style>
