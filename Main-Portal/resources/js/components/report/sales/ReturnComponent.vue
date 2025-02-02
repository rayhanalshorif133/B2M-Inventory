<template>
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div
                    class="card-header justify-content-between d-flex"
                    style="background-color: #004869"
                >
                    <h3 class="card-title" style="color: #fff">
                        Sales Report List
                    </h3>
                    <!-- Export Button -->
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-md-3 col-sm-6">
                            From Date :
                            <input
                                type="date"
                                class="form-control"
                                v-model="selectedStartDate"
                            />
                        </div>
                        <div class="col-12 col-md-3 col-sm-6">
                            To Date :
                            <input
                                type="date"
                                class="form-control"
                                v-model="selectedEndDate"
                            />
                        </div>
                        <div class="col-12 col-md-3 col-sm-6">
                            Customer Name :
                            <select
                                v-model="selectedCustomer"
                                class="form-select"
                            >
                                <option disabled value="0" selected>
                                    Please select one
                                </option>
                                <option
                                    v-for="item in customers"
                                    :key="item.id"
                                    :value="item.id"
                                >
                                    {{ item.name }}
                                    <!-- Assuming each supplier has a name and an id -->
                                </option>
                            </select>
                        </div>
                        <div class="col-12 col-md-3 col-sm-6 my-6">
                            <button
                                type="button"
                                class="btn btn-sm btn-navy"
                                @click="handleFilterBtn"
                            >
                                Filter Now
                            </button>
                        </div>
                    </div>
                    <div class="d-flex my-4">
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
                        class="table table-bordered display table-hover purchase_report_table"
                        :ref="table"
                        :options="tableOptions"
                    >
                    </DataTable>
                </div>
            </div>
        </div>
    </section>
</template>

<style>
@import "datatables.net-dt";
.purchase_report_table thead th {
    background-color: #0073b7; /* Header background color */
    color: #ffffff; /* Header text color */
}
.purchase_report_table tbody tr:last-child {
    background-color: #0073b7; /* Background color for the last row */
    color: #333333; /* Text color for the last row */
}
</style>

<script setup>
import DataTable from "datatables.net-vue3";
import DataTablesCore from "datatables.net";
import { ref, onMounted, defineProps } from "vue";
import axios from "axios";
import * as XLSX from "xlsx";

// Define props
const props = defineProps({
    customers: {
        type: Object,
        required: true,
    },
});

// Register DataTables core
DataTable.use(DataTablesCore);

const data = ref([]);
const selectedCustomer = ref("0");
const selectedStartDate = ref("");
const selectedEndDate = ref("");
const totalAmount = ref(0);
const totalPaidAmount = ref(0);
const totalDueAmount = ref(0);
const fetchSuppliersData = ref(props.suppliers);

// Columns for DataTable
const columns = ref([
    { title: "#", data: "list" },
    { title: "Invoice Number", data: "invoice_number" },
    { title: "Sales Date", data: "sales_date" },
    { title: "Customer Name", data: "customer_name" },
    { title: "Invoice Total(৳)", data: "invoice_total" },
    { title: "Return Amount(৳)", data: "return_amount" },
    { title: "Due Amount(৳)", data: "due_amount" },
]);

const tableOptions = {
    order: [], // Default order on load
    paging: true,
    searching: true,
    // Other options as needed
};

const handleFilterBtn = () => {
    fetchData(
        selectedStartDate.value,
        selectedEndDate.value,
        selectedCustomer.value
    );
};

// Fetch data from the API

const fetchData = async (from, to, customer_id) => {
    try {
        const response = await axios.get(
            `/report/sales-return?type=fetch&start_date=${from}&end_date=${to}&customer_id=${customer_id}`
        );
        const GET_DATA = response.data.data;
        console.log(GET_DATA);
        if (GET_DATA.length > 0) {
            var formattedData = GET_DATA.map((item, index) => {
                return {
                    list: index + 1,
                    invoice_number: item.code,
                    sales_date: item.invoice_date,
                    customer_name: item.customer.name,
                    invoice_total: item.total_amount.toFixed(2),
                    return_amount: item.return_amount.toFixed(2),
                    due_amount: item.due_amount.toFixed(2),
                };
            });

            //  Update total
            totalAmount.value = formattedData
                .reduce((sum, item) => sum + parseFloat(item.invoice_total), 0)
                .toFixed(2);

            totalPaidAmount.value = formattedData
                .reduce((sum, item) => sum + parseFloat(item.return_amount), 0)
                .toFixed(2);

            totalDueAmount.value = formattedData
                .reduce((sum, item) => sum + parseFloat(item.due_amount), 0)
                .toFixed(2);

            const newDATA = [
                {
                    list: "",
                    invoice_number: " ",
                    sales_date: " ",
                    customer_name: "Total",
                    invoice_total: totalAmount.value,
                    return_amount: totalPaidAmount.value,
                    due_amount: totalDueAmount.value,
                },
            ];

            formattedData.push(...newDATA);

            data.value = formattedData;
        } else {
            data.value = [];
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
    XLSX.utils.book_append_sheet(wb, ws, "Sales Return Data");

    // Create a dynamic file name
    const fileName = `Sales Return ${formattedDate}.xlsx`;

    // Export the workbook to a file with the dynamic name
    XLSX.writeFile(wb, fileName);
};

const exportToCopy = () => {
    // Prepare the CSV header
    const headers = columns.value.map((col) => col.title).join(",") + "\n";

    // Prepare the CSV rows
    const rows = data.value
        .map((item, index) => {
            return [
                index + 1,
                item.invoice_number,
                item.sales_date,
                item.customer_name,
                item.invoice_total,
                item.return_amount,
                item.due_amount,
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
    <title>Sales Report</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-2 text-center">
                <img src="${company.logo}" alt="Company Logo" class="img-fluid">
            </div>

            <!-- Company details on the right -->
            <div class="col-md-10">
                <h2 class="text-center">Purchase Payment Report</h2>
                <h3 class="text-center">
                    <b>Company Name:</b> ${company.name}
                </h3>
                <h4 class="text-center">
                    <b>Date:</b> ${formattedDate}
                </h4>
            </div>
        </div>
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
                        (item, index) => `
                    <tr>
                       <td>${index + 1}</td>
                       <td>${item.invoice_number}</td>
                        <td>${item.sales_date}</td>
                        <td>${item.customer_name}</td>
                        <td>${item.invoice_total}</td>
                        <td>${item.return_amount}</td>
                        <td>${item.due_amount}</td>
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
