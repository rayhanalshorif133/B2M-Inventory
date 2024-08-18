<template>
    <div :class="rowClass" class="row col-12">
        <div class="col-12 col-lg-11 col-md-11 row">
            <div class="col-12 col-sm-6 col-md-3">
                <div class="form-group">
                    <label for="code" class="optional">Product Code</label>
                    <input
                        class="form-control"
                        id="code"
                        v-model="code"
                        placeholder="Enter product code"
                        @input="checkDuplicateCode"
                        @focusout="storeData"
                    />
                    <small
                        v-html="code_check_msg"
                        :class="code_check_status"
                    ></small>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-3">
                <div class="form-group">
                    <label for="size" class="optional">Product Size</label>
                    <input
                        class="form-control"
                        id="size"
                        v-model="size"
                        @focusout="storeData"
                        placeholder="Enter product size"
                    />
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-3">
                <div class="form-group">
                    <label for="model" class="optional">Product Model</label>
                    <input
                        class="form-control"
                        id="model"
                        v-model="model"
                        @focusout="storeData"
                        placeholder="Enter product model"
                    />
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-3">
                <div class="form-group">
                    <label for="model" class="optional">Product Color</label>
                    <input
                        class="form-control"
                        id="color"
                        v-model="color"
                        @focusout="storeData"
                        placeholder="Enter product color"
                    />
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-3" v-if="show_hide_stock">
                <div class="form-group">
                    <label for="model" class="optional">Current Stock</label>
                    <input
                        class="form-control"
                        id="current_stock"
                        v-model="current_stock"
                        @focusout="storeData"
                        placeholder="Enter current stock"
                    />
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-3" v-if="show_hide_stock">
                <div class="form-group">
                    <label for="unit_cost" class="optional">Unit Cost</label>
                    <input
                        class="form-control"
                        id="unit_cost"
                        v-model="unit_cost"
                        @focusout="storeData"
                        placeholder="Enter unit cost"
                    />
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-3" v-if="show_hide_stock">
                <div class="form-group">
                    <label for="salesRate" class="optional">Sales Rate</label>
                    <input
                        class="form-control"
                        id="salesRate"
                        v-model="sales_rate"
                        @focusout="storeData"
                        placeholder="Enter sales rate"
                    />
                </div>
            </div>
            <div class="col-12 col-sm-6 col-md-3" v-if="show_hide_stock">
                <div class="form-group">
                    <label for="lastPurchase" class="optional"
                        >Last Purchase</label
                    >
                    <input
                        class="form-control"
                        id="lastPurchase"
                        v-model="lastPurchase"
                        @focusout="storeData"
                        placeholder="Enter last purchase"
                    />
                </div>
            </div>
        </div>
        <div
            class="col-12 col-lg-1 col-md-1 add_new_product_details_btn_container justify-content-start align-items-center mt-2"
        >
            <button
                type="button"
                class="btn btn-sm btn-remove d-flex"
                @click="removebtn"
                v-if="deleteBtn"
            >
                Delete
                <i class="fa-solid fa-xmark mx-1 mt-1"></i>
            </button>
            <button
                type="button"
                class="btn btn-sm btn-add d-flex"
                @click="addNewVarientBtn"
                v-if="addBtn"
            >
                Add
                <i class="fa fa-plus mx-1 mt-1"></i>
            </button>
            <a
                class="cursor-pointer text-navy text-bold d-flex-item-center"
                @click="handleAssignStockBtn"
                >Assign Stock</a
            >
        </div>
        <hr />
    </div>
</template>

<script>
import { ref, toRefs } from "vue";
export default {
    name: "AddNewDetailsComponent",
    props: {
        count: {
            type: Number,
            required: true,
        },
        addNewVarientBtn: {
            type: Function,
            required: false,
        },
        addBtn: {
            type: Boolean,
            required: false,
        },
        deleteBtn: {
            type: Boolean,
            required: false,
        },
        productDetailsBucket: {
            type: Array,
            required: false,
        },
    },
    setup(props) {
        const { productDetailsBucket, count } = toRefs(props);

        var rowClass = ref("");
        var code_check_msg = ref("");
        var code_check_status = ref(false);
        var show_hide_stock = ref(false);
        var code = ref([]);
        var sales_rate = ref([]);
        var size = ref([]);
        var color = ref([]);
        var current_stock = ref([]);
        var unit_cost = ref([]);
        var model = ref([]);
        var lastPurchase = ref([]);

        const removebtn = () => {
            rowClass.value = "d-none";
        };

        const storeData = () => {
            const data = {
                id: count.value,
                code: code.value,
                size: size.value,
                color: color.value,
                model: model.value,
                unit_cost: unit_cost.value,
                current_stock: current_stock.value,
                lastPurchase: lastPurchase.value,
                sales_rate: sales_rate.value,
            };
            let GET_Index = productDetailsBucket.value.find(
                (item) => item.id === count.value
            );
            if (GET_Index) {
                GET_Index.code = code.value;
                GET_Index.size = size.value;
                GET_Index.color = color.value;
                GET_Index.model = model.value;
                GET_Index.unit_cost = unit_cost.value;
                GET_Index.current_stock = current_stock.value;
                GET_Index.lastPurchase = lastPurchase.value;
                GET_Index.sales_rate = sales_rate.value;
            } else {
                productDetailsBucket.value.push(data);
            }
        };

        const handleAssignStockBtn = () => {
            show_hide_stock.value = !show_hide_stock.value;
        };

        const checkDuplicateCode = () => {
            code_check_status.value = "";
            if (code.value == "") {
                code_check_msg.value = "";
            }
            axios
                .get(`/product/check-duplicate-code/${code.value}`)
                .then((res) => {
                    const status = res.data.status;
                    if (status == true) {
                        code_check_status.value =
                            "d-inline text-success fw-bold";
                        code_check_msg.value =
                            "Product Code is valid." +
                            '<i class="fa-solid fa-check mx-1"></i>';
                    } else {
                        setErrorCode();
                    }
                    checkInputDuplicateProductCode();
                });
        };

        const checkInputDuplicateProductCode = () => {
            let is_already_inputed = productDetailsBucket.value.find(
                (item) => item.code === code.value
            );
            if (is_already_inputed) {
                setErrorCode();
            }
        };

        const setErrorCode = () => {
            code_check_status.value = "d-inline text-danger fw-bold";
            code_check_msg.value =
                "Product Code already exists." +
                '<i class="fa-solid fa-xmark mx-1"></i>';
        };

        return {
            checkDuplicateCode,
            removebtn,
            rowClass,
            code,
            size,
            unit_cost,
            sales_rate,
            model,
            code_check_msg,
            storeData,
            code_check_status,
            current_stock,
            show_hide_stock,
            lastPurchase,
            color,
            handleAssignStockBtn,
        };
    },
};
</script>
