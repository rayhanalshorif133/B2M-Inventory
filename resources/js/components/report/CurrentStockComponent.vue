<template>
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header justify-content-between d-flex">
                    <h3 class="card-title">Current Stock List</h3>
                    <!-- Export Button -->
                </div>

                <div class="card-body">
                    <div class="d-flex">
                        <button
                            @click="exportToExcel"
                            class="btn btn-success mx-1 py-1 h-fit px-3 btn-sm"
                        >
                            Excel <i class="fa-solid fa-file-lines"></i>
                        </button>
                        <button
                            @click="exportToCopy"
                            class="btn btn-info mx-1 py-1 h-fit px-3 btn-sm"
                        >
                            Copy <i class="fa-solid fa-copy"></i>
                        </button>
                        <button
                            @click="exportToPrint"
                            class="btn btn-danger mx-1 py-1 h-fit px-3 btn-sm"
                        >
                            Print <i class="fa-solid fa-print"></i>
                        </button>
                    </div>
                    <DataTable
                        :data="data"
                        :columns="columns"
                        class="table table-bordered display table-hover"
                        :ref="table"
                        :options="tableOptions"
                    >
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Product Details</th>
                                <th scope="col">Current Stock</th>
                                <th scope="col">
                                    Last Purchase <br />
                                    Price
                                </th>
                                <th scope="col">
                                    Last Sales <br />
                                    Price
                                </th>
                                <th scope="col">Unit Cost</th>
                                <th scope="col">
                                    Total <br />
                                    Stock Value
                                </th>
                            </tr>
                        </thead>
                    </DataTable>
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
import { ref, onMounted, computed } from "vue";
import axios from "axios";
import * as XLSX from "xlsx";

// Register DataTables core
DataTable.use(DataTablesCore);

const data = ref([]);
const totalStockPrice = ref(0);
const fetchShowData = ref();
const salesEditLink = ref("");

// Columns for DataTable
const columns = ref([
    { title: "#", data: "index" },
    { title: "Product Details", data: "product_details" },
    { title: "Current Stock", data: "current_stock" },
    { title: "Last Purchase Price", data: "last_purchase" },
    { title: "Last Sales Price", data: "sales_rate" },
    { title: "Unit Cost", data: "unit_cost" },
    { title: "Total Stock Value", data: "stock_value" },
]);

const tableOptions = {
    order: [], // Default order on load
    paging: true,
    searching: true,
    // Other options as needed
};

// Fetch data from the API
const fetchData = async () => {
    try {
        const response = await axios.get("/report/current-stock?type=fetch");
        const GET_DATA = response.data.data;
        if (GET_DATA.length > 0) {
            var formattedData = GET_DATA.map((item, index) => {
                const product_details = `${item.product.name} (${item.model}-${item.color}-${item.size})`;
                const stock_value =
                    parseFloat(item.unit_cost) * parseFloat(item.current_stock);

                return {
                    index: index + 1,
                    product_details,
                    current_stock: item.current_stock,
                    last_purchase: item.last_purchase,
                    sales_rate: item.sales_rate,
                    unit_cost: item.unit_cost,
                    stock_value: stock_value.toFixed(2),
                };
            });

            // Set the data to the table

            // Update total stock price
            totalStockPrice.value = formattedData
                .reduce((sum, item) => sum + parseFloat(item.stock_value), 0)
                .toFixed(2);

            const newDATA = [
                {
                    index: "",
                    product_details: "",
                    current_stock: "",
                    last_purchase: "",
                    sales_rate: "",
                    unit_cost: "Total",
                    stock_value: totalStockPrice.value,
                },
            ];

            formattedData.push(...newDATA);

            data.value = formattedData;
        }
    } catch (error) {
        console.error("Error fetching data:", error);
    }
};

const exportToExcel = async () => {
    // Create a worksheet from the data
    const response = await axios.get("/user/fetch-auth");
    const company = response.data.data.company;
    const ws = XLSX.utils.json_to_sheet(data.value);

    // Get the current date
    const currentDate = new Date();

    // Format the date as YYYY-MM-DD
    const formattedDate = `${currentDate.getFullYear()}-${(
        currentDate.getMonth() + 1
    )
        .toString()
        .padStart(2, "0")}-${currentDate
        .getDate()
        .toString()
        .padStart(2, "0")}`;

    // Add company name in the first row
    ws["A1"] = {
        v: `Company Name: ${company.name} - Date - (${formattedDate})`,
        s: {
            font: { bold: true, fontSize: 16 },
            alignment: {
                horizontal: "center", // Center the text horizontally
                vertical: "center", // Center the text vertically
            },
        },
    };

    // Merge cells from A1 to G1 (A1 to G1 represents columns 0 to 6)
    ws["!merges"] = [
        { s: { r: 0, c: 0 }, e: { r: 0, c: 6 } }, // Merge from A1 (0,0) to G1 (0,6)
    ];

    // Move the actual data to start from row 2
    XLSX.utils.sheet_add_json(ws, data.value, { origin: "A2" });

    // Create a new workbook
    const wb = XLSX.utils.book_new();

    // Append the worksheet to the workbook
    XLSX.utils.book_append_sheet(wb, ws, "Current Stocks Data");

    // Create a dynamic file name
    const fileName = `Current Stocks ${formattedDate}.xlsx`;

    // Export the workbook to a file with the dynamic name
    XLSX.writeFile(wb, fileName);
};

const exportToCopy = () => {
    // Prepare the CSV header
    const headers = columns.value.map((col) => col.title).join(",") + "\n";

    // Prepare the CSV rows
    const rows = data.value
        .map((item) => {
            return [
                item.index,
                item.product_details.replace(/<a[^>]*>(.*?)<\/a>/, "$1"), // Remove HTML tags
                item.current_stock,
                item.last_purchase,
                item.sales_rate,
                item.unit_cost,
                item.stock_value,
            ].join(",");
        })
        .join("\n");

    // Combine headers and rows
    const csvContent = headers + rows;

    // Copy the CSV content to the clipboard
    navigator.clipboard
        .writeText(csvContent)
        .then(() => {
            Toastr.fire({
                icon: "success", // e.g., 'success', 'error', 'warning', 'info'
                title: "Copied",
            });
        })
        .catch((err) => {
            console.error("Could not copy text: ", err);
        });
};

const exportToPrint = async () => {
    // Prepare the HTML for the table

    const response = await axios.get("/user/fetch-auth");
    const company = response.data.data.company;
    const currentDate = new Date();

    // Format the date as YYYY-MM-DD (you can change the format as needed)
    const formattedDate = `${currentDate.getFullYear()}-${(
        currentDate.getMonth() + 1
    )
        .toString()
        .padStart(2, "0")}-${currentDate
        .getDate()
        .toString()
        .padStart(2, "0")}`;

    let html = `
<html>
<head>
    <title>Current Stock</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Current Stock</h2>
        <h3 class="text-center">
            <b>Company Name:</b> ${company.name}
        </h3>
        <h4 class="text-center">
            <b>Date:</b> ${formattedDate}
        </h4>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    ${columns.value
                        .map((col) => `<th>${col.title}</th>`)
                        .join("")}
                </tr>
            </thead>
            <tbody>
                ${data.value
                    .map(
                        (item) => `
                    <tr>
                        <td>${item.index}</td>
                        <td>${item.product_details.replace(
                            /<a[^>]*>(.*?)<\/a>/,
                            "$1"
                        )}</td>
                        <td>${item.current_stock}</td>
                        <td>${item.last_purchase}</td>
                        <td>${item.sales_rate}</td>
                        <td>${item.unit_cost}</td>
                        <td>${item.stock_value}</td>
                    </tr>
                `
                    )
                    .join("")}
            </tbody>
        </table>
    </div>

</body>

</html>
`;

    // Open a new window and print the content
    const printWindow = window.open("", "_blank");
    printWindow.document.write(html);
    printWindow.document.close();
    printWindow.focus();
    // printWindow.close();
    // Listen for the print dialog to close and automatically close the window
    printWindow.onafterprint = function () {
        printWindow.close();
    };

    // Trigger the print dialog
    printWindow.print();
};

// Fetch data on component mount
onMounted(() => {
    fetchData();
});
</script>
