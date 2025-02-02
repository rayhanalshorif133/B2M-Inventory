<template>
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div
                    class="card-header justify-content-between d-flex"
                    style="background-color: #008bb5"
                >
                    <h3 class="card-title text-white">Profit & Loss</h3>
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
                        <div class="col-12 col-md-3 col-sm-6 my-6">
                            <button
                                type="button"
                                class="btn btn-sm btn-navy"
                                @click="filterNowBtn"
                            >
                                Filter Now
                            </button>
                        </div>
                    </div>

                    <nav class="mb-2 d-flex justify-content-between">
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <button
                                class="nav-link active"
                                id="item-wise-profit-tab"
                                data-bs-toggle="tab"
                                data-bs-target="#item-wise-profit"
                                type="button"
                                role="tab"
                                aria-controls="item-wise-profit"
                                aria-selected="true"
                                @click="activeTab('item')"
                                style="--setColor: #008BB5;"
                            >
                                <span style="color: #000000">
                                    Item Wise Profit
                                </span>
                            </button>
                            <button
                                class="nav-link"
                                id="nav-invoice-tab"
                                data-bs-toggle="tab"
                                data-bs-target="#nav-invoice"
                                type="button"
                                role="tab"
                                aria-controls="nav-invoice"
                                aria-selected="false"
                                @click="activeTab('invoice')"
                                style="--setColor: #157347;"
                            >
                                <span style="color: #000000">
                                    Invoice Wise Profit
                                </span>
                            </button>
                        </div>
                        <div class="d-flex mt-1">
                            <button
                                @click="exportToExcel"
                                class="btn btn-success mx-1 py-1 h-fit px-3 btn-sm"
                            >
                                Excel <i class="fa-solid fa-file-lines"></i>
                            </button>
                            <button
                                @click="exportToPrint"
                                class="btn btn-danger mx-1 py-1 h-fit px-3 btn-sm"
                            >
                                Print <i class="fa-solid fa-print"></i>
                            </button>
                        </div>
                    </nav>
                    <div class="tab-content" id="nav-tabContent">
                        <div
                            class="tab-pane fade show active"
                            id="item-wise-profit"
                            role="tabpanel"
                            aria-labelledby="item-wise-profit-tab"
                        >
                            <DataTable
                                :data="dataItemWiseProfit"
                                :columns="columnsItemWiseProfit"
                                class="table table-bordered display table-hover"
                                :ref="table"
                                :options="tableOptionsForItem"
                            >
                            </DataTable>
                        </div>
                        <div
                            class="tab-pane fade"
                            id="nav-invoice"
                            role="tabpanel"
                            aria-labelledby="nav-invoice-tab"
                        >
                            <DataTable
                                :data="dataInvoiceWiseProfit"
                                :columns="columnsInvoiceWiseProfit"
                                class="table table-bordered display table-hover"
                                :ref="table"
                                :options="tableOptionsForInvoice"
                            >
                            </DataTable>
                        </div>
                    </div>
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

// Register DataTables core
DataTable.use(DataTablesCore);
var dataItemWiseProfit = ref([]);
var dataInvoiceWiseProfit = ref([]);

// ColumnsItemWiseProfit for DataTable
const columnsItemWiseProfit = ref([
    { title: "Item Code", data: "p_code" },
    { title: "Item Details", data: "item_details" },
    { title: "Sales Quantity", data: "sales_quantity" },
    { title: "Sales Price (৳)", data: "sales_price" },
    { title: "Unit Cost (৳)", data: "unit_cost" },
    { title: "Discount (৳)", data: "discount" },
    { title: "Gross Profit (৳)", data: "gross_profit" },
]);

const columnsInvoiceWiseProfit = ref([
    { title: "#", data: "list" },
    { title: "Invoice Number", data: "invoice_number" },
    { title: "Sales Date", data: "sales_date" },
    { title: "Customer Name", data: "customer_name" },
    { title: "Sales Price (৳)", data: "sales_price" },
    { title: "Unit Cost (৳)", data: "total_unit_cost" },
    { title: "Discount (৳)", data: "discount" },
    { title: "Gross Profit (৳)", data: "gross_profit" },
]);

const tableOptionsForItem = {
    order: [], // Default order on load
    paging: true,
    searching: true,
    headerCallback: function (thead, tbody) {
        $(thead).addClass("table-primary");
        $(tbody).addClass("table-primary");
    },
};

const tableOptionsForInvoice = {
    order: [], // Default order on load
    paging: true,
    searching: true,
    headerCallback: function (thead, tbody) {
        $(thead).addClass("table-success");
        $(tbody).addClass("table-success");
    },
};

const selectedStartDate = ref("");
const selectedEndDate = ref("");
const totalGrossProfit = ref(0);
const totalSalesPrice = ref(0);
const totalDiscount = ref(0);
const totalUnitCost = ref(0);
const getActiveTab = ref("item");

const filterNowBtn = () => {
    fetchData(selectedStartDate.value, selectedEndDate.value);
};

const fetchData = async (from = "", to = "") => {
    try {
        const response = await axios.get(
            `/report/profit-loss?type=fetch&based=${getActiveTab.value}&start_date=${from}&end_date=${to}`
        );
        const GET_DATA = response.data.data;
        if (getActiveTab.value == "item") {
            SET_DATA_FOR_ITEM_BASED(GET_DATA);
        } else {
            SET_DATA_FOR_INVOICE_BASED(GET_DATA);
        }
    } catch (error) {
        console.error("Error fetching data:", error);
    }
};

const SET_DATA_FOR_ITEM_BASED = (GET_DATA) => {
    if (GET_DATA.length > 0) {
        var formattedData = GET_DATA.map((item, index) => {
            const item_details = `${item.product_name} - (${item.p_color})`;
            const sales_price = (
                parseFloat(item.total_sales_rate) * parseInt(item.total_qty)
            ).toFixed(2);
            const GET_UnitCostAndDiscount =
                parseFloat(item.total_unit_cost) +
                parseFloat(item.total_discount);
            var gross_profit = (
                parseFloat(sales_price) - parseFloat(GET_UnitCostAndDiscount)
            ).toFixed(2);

            return {
                p_code: item.p_code,
                item_details,
                sales_quantity: item.total_qty,
                sales_price,
                unit_cost: parseFloat(item.total_unit_cost).toFixed(2),
                discount: parseFloat(item.total_discount).toFixed(2),
                gross_profit,
            };
        });

        //  Update total
        totalGrossProfit.value = 0;
        totalGrossProfit.value = formattedData
            .reduce((sum, item) => sum + parseFloat(item.gross_profit), 0)
            .toFixed(2);

        const newDATA = [
            {
                p_code: "",
                item_details: " ",
                sales_quantity: " ",
                sales_price: "",
                unit_cost: "",
                discount: "Total",
                gross_profit: totalGrossProfit.value,
            },
        ];

        formattedData.push(...newDATA);

        dataItemWiseProfit.value = formattedData;
    } else {
        dataItemWiseProfit.value = [];
    }
};

const SET_DATA_FOR_INVOICE_BASED = (GET_DATA) => {
    console.clear();
    if (GET_DATA.length > 0) {
        var formattedData = GET_DATA.map((item, index) => {
            var gross_profit = (
                parseFloat(item.total_amount) -
                (parseFloat(item.salesDetails.total_unit_cost) +
                    parseFloat(item.salesDetails.total_discount))
            ).toFixed(2);
            return {
                list: index + 1,
                invoice_number: item.code,
                sales_date: item.created_date,
                customer_name: item.customer.name,
                sales_price: item.total_amount,
                total_unit_cost: item.salesDetails.total_unit_cost,
                discount: item.salesDetails.total_discount,
                gross_profit,
            };
        });

        totalGrossProfit.value = 0;
        totalSalesPrice.value = 0;
        totalUnitCost.value = 0;
        totalDiscount.value = 0;
        totalGrossProfit.value = formattedData
            .reduce((sum, item) => sum + parseFloat(item.gross_profit), 0)
            .toFixed(2);
        totalSalesPrice.value = formattedData
            .reduce((sum, item) => sum + parseFloat(item.sales_price), 0)
            .toFixed(2);
        totalUnitCost.value = formattedData
            .reduce((sum, item) => sum + parseFloat(item.total_unit_cost), 0)
            .toFixed(2);
        totalDiscount.value = formattedData
            .reduce((sum, item) => sum + parseFloat(item.discount), 0)
            .toFixed(2);

        const newDATA = [
            {
                list: "",
                invoice_number: " ",
                sales_date: " ",
                customer_name: "Total",
                sales_price: totalSalesPrice.value,
                total_unit_cost: totalUnitCost.value,
                discount: totalDiscount.value,
                gross_profit: totalGrossProfit.value,
            },
        ];

        formattedData.push(...newDATA);

        dataInvoiceWiseProfit.value = formattedData;
    } else {
        dataInvoiceWiseProfit.value = [];
    }
};

const activeTab = (isActive) => {
    getActiveTab.value = isActive;
    fetchData(selectedStartDate.value, selectedEndDate.value);
};

const exportToExcel = async () => {
    // Create a worksheet from the data
    const response = await axios.get("/user/fetch-auth");
    const company = response.data.data.company;
    var data = ref(dataItemWiseProfit.value);
    var margeValue = ref(6);

    if (getActiveTab.value == "invoice") {
        data.value = dataInvoiceWiseProfit.value;
        margeValue.value = 7;
    }

    var ws = XLSX.utils.json_to_sheet(data.value);
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
        { s: { r: 0, c: 0 }, e: { r: 0, c: margeValue.value } }, // Merge from A1 (0,0) to G1 (0,6)
    ];

    // Move the actual data to start from row 2
    XLSX.utils.sheet_add_json(ws, data.value, { origin: "A2" });

    // Create a new workbook
    const wb = XLSX.utils.book_new();

    // Append the worksheet to the workbook
    XLSX.utils.book_append_sheet(
        wb,
        ws,
        `${getActiveTab.value} report Data`
    );

    // Create a dynamic file name
    const fileName = `${getActiveTab.value} wise profit loss report - ${formattedDate}.xlsx`;

    // Export the workbook to a file with the dynamic name
    XLSX.writeFile(wb, fileName);
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

    var title = getActiveTab.value == "item" ? "Item" : "Invoice";

    let html = `
<html>
<head>
    <title>${title} Wise Profit & Loss Report</title>
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
                <h2 class="text-center">${title} Wise Profit & Loss Report</h2>
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
                    ${
                        getActiveTab.value == "item"
                            ? columnsItemWiseProfit.value
                                  .map((col) => `<th>${col.title}</th>`)
                                  .join("")
                            : columnsInvoiceWiseProfit.value
                                  .map((col) => `<th>${col.title}</th>`)
                                  .join("")
                    }
                </tr>
            </thead>
            <tbody>
                ${
                    getActiveTab.value == "item"
                        ? dataItemWiseProfit.value
                              .map(
                                  (item, index) => `
                    <tr>
                       <td>${item.p_code}</td>
                        <td>${item.item_details}</td>
                        <td>${item.sales_quantity}</td>
                        <td>${item.sales_price}</td>
                        <td>${item.unit_cost}</td>
                        <td>${item.discount}</td>
                        <td>${item.gross_profit}</td>
                    </tr>
                `
                              )
                              .join("")
                        : ""
                }

                ${
                    getActiveTab.value == "invoice"
                        ? dataInvoiceWiseProfit.value
                              .map(
                                  (item, index) => `
                    <tr>
                       <td>${item.list}</td>
                       <td>${item.invoice_number}</td>
                       <td>${item.sales_date}</td>
                       <td>${item.customer_name}</td>
                       <td>${item.sales_price}</td>
                       <td>${item.total_unit_cost}</td>
                       <td>${item.discount}</td>
                       <td>${item.gross_profit}</td>
                    </tr>
                `
                              )
                              .join("")
                        : ""
                }
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

onMounted(() => {
    fetchData();
});
</script>

<style></style>
