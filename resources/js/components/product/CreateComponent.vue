<template>
    <section class="content overflow-x-hidden">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Create a new Product</h3>
                    </div>
                    <div class="card-body">
                        <nav>
                            <div
                                class="nav nav-tabs"
                                id="nav-tab"
                                role="tablist"
                            >
                                <button
                                    class="nav-link active"
                                    id="nav-home-tab"
                                    data-bs-toggle="tab"
                                    data-bs-target="#nav-home"
                                    type="button"
                                    role="tab"
                                    aria-controls="nav-home"
                                    aria-selected="true"
                                    style="--setColor: #001f3f"
                                >
                                    <span style="color: #000000">
                                        Manual (Entry)
                                    </span>
                                </button>
                                <button
                                    class="nav-link"
                                    id="nav-profile-tab"
                                    data-bs-toggle="tab"
                                    data-bs-target="#nav-profile"
                                    type="button"
                                    role="tab"
                                    aria-controls="nav-profile"
                                    aria-selected="false"
                                    style="--setColor: #34a853"
                                >
                                    <span style="color: #000000">
                                        Auto (Via File)
                                    </span>
                                </button>
                            </div>
                        </nav>
                        <div class="tab-content" id="nav-tabContent">
                            <div
                                class="tab-pane fade  show active"
                                id="nav-home"
                                role="tabpanel"
                                aria-labelledby="nav-home-tab"
                            >
                                <form class="mt-3">
                                    <div class="row">
                                        <h3 class="text-lg font-medium">
                                            Product's Basic Information
                                        </h3>
                                        <div class="col-12 col-md-4">
                                            <div class="form-group">
                                                <label
                                                    for="selectCategory"
                                                    class="required"
                                                    >Select a Category</label
                                                >
                                                <select
                                                    class="custom-select"
                                                    v-model="selectCategory"
                                                    id="selectCategory"
                                                    @change="
                                                        handleSelectCategory
                                                    "
                                                >
                                                    <option
                                                        value=""
                                                        selected
                                                        disabled
                                                    >
                                                        Choice a Category
                                                    </option>
                                                    <option
                                                        v-for="(
                                                            item, index
                                                        ) in categories"
                                                        :value="item.id"
                                                        :key="index"
                                                    >
                                                        {{ item.name }}
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-4">
                                            <div class="form-group">
                                                <label
                                                    for="selectSubCategory"
                                                    class="required"
                                                    >Select a Subcategory</label
                                                >
                                                <select
                                                    class="custom-select"
                                                    id="selectSubCategory"
                                                    v-model="subCategorySelect"
                                                >
                                                    <option
                                                        value=""
                                                        selected
                                                        disabled
                                                    >
                                                        Choice a Subcategory
                                                    </option>
                                                    <option
                                                        v-for="(
                                                            item, index
                                                        ) in subCategories"
                                                        :value="item.id"
                                                        :key="index"
                                                    >
                                                        {{ item.name }}
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-4">
                                            <div class="form-group">
                                                <label
                                                    for="productName"
                                                    class="required"
                                                    >Product Name</label
                                                >
                                                <input
                                                    class="form-control"
                                                    id="productName"
                                                    v-model="productName"
                                                    placeholder="Enter Product Name"
                                                />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card card-navy">
                                        <div class="card-header">
                                            Product Details
                                        </div>
                                        <div class="card-body">
                                            <AddNewDetailsComponent
                                                :count="0"
                                                :addBtn="true"
                                                :deleteBtn="false"
                                                :addNewVarientBtn="
                                                    addNewVarientBtn
                                                "
                                                :productDetailsBucket="
                                                    productDetailsInfos
                                                "
                                            />
                                            <span
                                                v-for="(
                                                    item, index
                                                ) in newDetailsAddedCounter"
                                                :key="index"
                                            >
                                                <AddNewDetailsComponent
                                                    :count="index + 1"
                                                    :addBtn="false"
                                                    :deleteBtn="true"
                                                    :productDetailsBucket="
                                                        productDetailsInfos
                                                    "
                                                />
                                            </span>
                                        </div>
                                    </div>

                                    <button
                                        @click="handleSubmit"
                                        type="button"
                                        class="btn btn-success btn-sm"
                                        :disabled="submitBtnStatus"
                                    >
                                        Submit
                                    </button>
                                </form>
                            </div>
                            <div
                                class="tab-pane fade"
                                id="nav-profile"
                                role="tabpanel"
                                aria-labelledby="nav-profile-tab"
                            >
                                <form class="mt-3">
                                    <div class="row">
                                        <h3 class="text-lg font-medium">
                                            Product's Basic Information
                                        </h3>
                                        <div class="col-12 col-md-4">
                                            <div class="form-group">
                                                <label
                                                    for="importFile"
                                                    class="required"
                                                    >Select a uploaded
                                                    file</label
                                                >
                                                <input
                                                    type="file"
                                                    name=""
                                                    id="importFile"
                                                    class="form-control"
                                                    @change="handleFileUpload"
                                                    accept=".xls, .xlsx"
                                                />
                                            </div>
                                        </div>
                                        <div class="col-12 col-md-4 mt-5">
                                            <div class="d-flex mt-3">
                                                <button
                                                    @click="
                                                        handleUploadFileSubmit
                                                    "
                                                    type="button"
                                                    class="btn btn-success btn-sm d-flex align-items-center mx-3"
                                                >
                                                    Upload
                                                </button>
                                                <button
                                                    @click="sampleUploadFile"
                                                    type="button"
                                                    class="btn btn-navy btn-sm d-flex align-items-center mx-3"
                                                >
                                                    Sample upload file
                                                    <i
                                                        class="fa-solid fa-download mx-2"
                                                    ></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <div class="row" v-if="jsonData">
                                    <div
                                        v-for="(
                                            row, rowIndex
                                        ) in jsonData.slice(1)"
                                        :key="rowIndex"
                                        class="col-md-4 mb-4"
                                    >
                                        <div class="card h-auto">
                                            <div class="card-body">
                                                <!-- Display each value as a box item -->
                                                <div
                                                    v-for="(
                                                        value, colIndex
                                                    ) in row"
                                                    :key="colIndex"
                                                    class="box-item"
                                                >
                                                    <span
                                                        v-if="
                                                            colIndex ===
                                                            'Product Upload Sample Template'
                                                        "
                                                        class="fw-bold"
                                                        style="font-size: 16px"
                                                    >
                                                        # {{ value }}
                                                    </span>
                                                    <span v-else
                                                        ><strong>{{
                                                            colIndex
                                                        }}</strong>
                                                        : {{ value }}</span
                                                    >
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
import { onMounted, ref } from "vue";
import AddNewDetailsComponent from "./AddNewDetailsComponent.vue";
import * as XLSX from "xlsx";
export default {
    components: {
        AddNewDetailsComponent,
    },
    setup() {
        var categories = ref([]);
        var subCategories = ref("");
        var selectCategory = ref("");
        var subCategorySelect = ref("");
        var productDetailsInfos = ref([]);
        var code_check_status = ref("d-none");
        var code_check_msg = ref("");
        var submitBtnStatus = ref(false);
        var insertNewDetails = ref([]);
        var inputedCode = ref([]);
        var selectCategoryOption = ref([]);
        var jsonData = ref(null);
        // model
        var productName = ref("");
        var xlsxUploadedData = ref();

        var newDetailsAddedCounter = ref(0);

        // new added details
        var code = ref([]);

        onMounted(() => {
            fetchCategories();
        });

        const handleFileUpload = (event) => {
            const file = event.target.files[0];

            if (file && file.type.includes("sheet")) {
                const reader = new FileReader();

                reader.onload = (e) => {
                    const data = new Uint8Array(e.target.result);
                    const workbook = XLSX.read(data, { type: "array" });

                    // Parse the first sheet
                    const sheetName = workbook.SheetNames[0];
                    const worksheet = workbook.Sheets[sheetName];

                    // Convert the sheet to JSON
                    jsonData.value = XLSX.utils.sheet_to_json(worksheet);

                    jsonData.value = Array.from(jsonData.value);

                    Toastr.fire({
                        icon: "success",
                        title: "XLSX file read successfully",
                    });
                };

                // Read the file as binary
                reader.readAsArrayBuffer(file);
            } else {
                Toastr.fire({
                    icon: "error",
                    title: "Please upload a valid XLSX file.",
                });
            }
        };

        const fetchCategories = () => {
            axios.get("/category/fetch?type=product-create").then((res) => {
                categories.value = res.data.data;
            });
        };

        const addNewVarientBtn = () => {
            newDetailsAddedCounter.value++;
        };

        const handleSelectCategory = () => {
            console.clear();
            const SELECTED_CATEGORY_ID = selectCategory.value;
            categories.value.map(function (item) {
                if (SELECTED_CATEGORY_ID == item.id) {
                    subCategories.value = item.subCategories;
                }
            });
        };



        const handleSubmit = () => {
            if (
                productName.value == "" ||
                selectCategory.value == "" ||
                subCategories.value == ""
            ) {
                Toastr.fire({
                    icon: "error",
                    title: "Product Name and Category are required",
                });
                return false;
            }

            const data = {
                productName: productName.value,
                category_id: selectCategory.value,
                sub_category_id: subCategorySelect.value,
                productDetailsInfos: productDetailsInfos.value,
            };



            sendCreateDataToBackend("/product/create", data);
        };

        const sendCreateDataToBackend = (url, data) => {
            axios.post(url, data).then(function (response) {
                const data = response.data.data;
                const message = response.data.message;
                Toastr.fire({
                    icon: message,
                    title: data,
                });

                if (message == "success") {
                    setTimeout(() => {
                        window.location.href = "/product/list";
                    }, 1600);
                }
            });
        };

        const sampleUploadFile = () => {
            console.clear();
            const data = [];
            var listItem = 1;
            categories.value.forEach((category) => {
                category.subCategories.map((item, index) => {
                    data.push({
                        List: listItem,
                        Category: category.name,
                        Subcategories: item.name,
                        "Product Name": "",
                        "Product Code (optional)": "",
                        "Product Size (optional)": "",
                        "Product Model (optional)": "",
                        "Product Color (optional)": "",
                        "Current Stock (optional)": "",
                        "Unit Cost (optional)": "",
                        "Sales Rate (optional)": "",
                        "Last Purchase (optional)": "",
                    });
                    listItem++;
                });
            });

            // Create a worksheet from the data
            const wsData = XLSX.utils.json_to_sheet(data);
            wsData["!cols"] = [
                { wch: 5 }, // Width for List column
                { wch: 15 }, // Width for Category column
                { wch: 20 }, // Width for Subcategories column
                { wch: 15 }, // Width for Subcategories column
                { wch: 20 }, // Width for Subcategories column
                { wch: 20 }, // Width for Subcategories column
                { wch: 22 }, // Width for Subcategories column
                { wch: 19.6 }, // Width for Subcategories column
                { wch: 20 }, // Width for Subcategories column
                { wch: 15.5 }, // Width for Subcategories column
                { wch: 17 }, // Width for Subcategories column
                { wch: 20 }, // Width for Subcategories column
            ];

            XLSX.utils.sheet_add_aoa(
                wsData,
                [
                    [
                        "Product Upload Sample Template",
                        "Category",
                        "Subcategories",
                        "Product Name",
                        "Product Code (optional)",
                        "Product Size (optional)",
                        "Product Model (optional)",
                        "Product Color (optional)",
                        "Current Stock (optional)",
                        "Unit Cost (optional)",
                        "Sales Rate (optional)",
                        "Last Purchase (optional)",
                    ],
                ],
                { origin: "A1" }
            );
            const wb = XLSX.utils.book_new();

            if (!wsData["!merges"]) wsData["!merges"] = [];
            wsData["!merges"].push({ s: { r: 0, c: 0 }, e: { r: 0, c: 11 } });

            XLSX.utils.sheet_add_json(wsData, data, { origin: "A2" });
            XLSX.utils.book_append_sheet(wb, wsData, "Categories");

            XLSX.writeFile(wb, "product_upload_template.xlsx");
        };

        const handleUploadFileSubmit = () => {
            console.clear();
            var data = [];
            jsonData.value.slice(1).map((item, index) => {

                const findCategory = categories.value.find(
                    (category) => category.name === item["Category"]
                );

                // Extract the category name or fallback to a default value
                const category_id = findCategory ? findCategory.id : "none";
                const findSubCategory = findCategory.subCategories.find(
                    (subCategory) => subCategory.name === item["Subcategories"]
                );
                const subcategories_id = findSubCategory
                    ? findSubCategory.id
                    : "none";

                data.push({
                    category: item["Category"],
                    category_id: category_id,
                    subcategories: item["Subcategories"],
                    sub_category_id: subcategories_id,
                    productName: item["Product Name"],
                    productCode: item["Product Code (optional)"],
                    productColor: item["Product Color (optional)"],
                    productModel: item["Product Model (optional)"],
                    currentStock: item["Current Stock (optional)"],
                    productSize: item["Product Size (optional)"],
                    salesRate: item["Sales Rate (optional)"],
                    unitCost: item["Unit Cost (optional)"],
                    lastPurchase: item["Last Purchase (optional)"],
                });

            });
            xlsxUploadedData.value = data;
            sendCreateDataToBackend("/product/create?type=xlsx",{data: xlsxUploadedData.value});
        };

        return {
            sampleUploadFile,
            handleSubmit,
            categories,
            handleFileUpload,
            selectCategory,
            handleSelectCategory,
            jsonData,
            subCategories,
            subCategorySelect,
            productName,
            addNewVarientBtn,
            productDetailsInfos,
            code_check_status,
            selectCategoryOption,
            code_check_msg,
            handleUploadFileSubmit,
            code,
            inputedCode,
            submitBtnStatus,
            insertNewDetails,
            newDetailsAddedCounter,
        };
    },
};
</script>
