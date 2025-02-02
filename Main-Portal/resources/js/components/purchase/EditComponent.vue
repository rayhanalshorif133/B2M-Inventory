<template>
    <section class="content overflow-x-hidden">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Update Purchase</h3>
                    </div>
                    <div class="card-body">
                        <form>
                            <div class="row">
                                <div class="col-12 col-md-7 col-lg-7">
                                    <div class="form-group d-flex">
                                        <label
                                            for="supplier"
                                            class="d-flex mx-1"
                                            >Supplier
                                            <span class="text-danger mx-1"
                                                >*</span
                                            ></label
                                        >
                                        <select
                                            class="form-control"
                                            id="supplier"
                                            name="supplier"
                                            v-model="selectedSupplier"
                                        >
                                            <option
                                                v-for="item in suppliers"
                                                :value="item.id"
                                                :key="item.id"
                                            >
                                                {{ item.name }}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 col-md-5 col-lg-5">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <button
                                                data-toggle="modal"
                                                data-target="#addNewSupplierModal"
                                                class="btn btn-navy btn-sm h-2"
                                                type="button"
                                            >
                                                <i class="fa fa-plus"></i> Add
                                                New
                                            </button>
                                        </div>
                                        <div class="col-md-8 d-flex">
                                            <label
                                                for="supplier"
                                                class="d-flex mx-1 w-8rem"
                                                >Invoice Time:
                                                <span class="text-danger mx-1"
                                                    >*</span
                                                ></label
                                            >
                                            <input
                                                type="date"
                                                v-model="invoice_date"
                                                class="form-control w-10rem"
                                            />
                                        </div>
                                    </div>
                                    <add-new-supplier-modal
                                        :fetchSuppliers="fetchSuppliers"
                                    ></add-new-supplier-modal>
                                </div>
                                <div class="col-12 col-md-7 col-lg-7">
                                    <div class="form-group d-flex">
                                        <label for="Product" class="d-flex mx-1"
                                            >Product
                                            <span class="text-danger mx-1"
                                                >*</span
                                            ></label
                                        >
                                        <select
                                            class="form-control"
                                            id="product"
                                            name="product"
                                            v-model="selectedProduct"
                                            @change="handleProductChange"
                                        >
                                            <option value="" selected disabled>
                                                Select a product
                                            </option>
                                            <option
                                                v-for="item in products"
                                                :value="item.id"
                                                :key="item.id"
                                            >
                                                {{ item.name }}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 col-md-5 col-lg-5 row">
                                    <input
                                        type="text"
                                        id="barcode"
                                        class="form-control"
                                        placeholder="Barcode"
                                    />
                                </div>
                                <div class="col-md-12 col-lg-4">
                                    <div class="card card-navy">
                                        <div class="card-header">
                                            Product Details
                                        </div>
                                        <div class="card-body">
                                            <table
                                                class="table table-striped table-bordered"
                                            >
                                                <thead>
                                                    <tr>
                                                        <th
                                                            colspan="4"
                                                            class="text-center text-capitalize"
                                                        >
                                                            {{ product_name }}
                                                        </th>
                                                    </tr>
                                                    <tr>
                                                        <th>Attribute</th>
                                                        <th>Sales Rate</th>
                                                        <th>Stock</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr
                                                        v-for="item in productAttributes"
                                                        :key="item.id"
                                                    >
                                                        <td>
                                                            <small
                                                                class="text-xs font-semibold"
                                                                >{{
                                                                    item.code
                                                                }}</small
                                                            >
                                                            <br
                                                                :v-if="
                                                                    item.code
                                                                "
                                                            />
                                                            <small
                                                                class="text-xs font-semibold"
                                                                >{{
                                                                    item.color
                                                                }}</small
                                                            >
                                                            <br
                                                                v-if="
                                                                    item.color
                                                                "
                                                            />
                                                            <small
                                                                class="text-xs font-semibold"
                                                                >{{
                                                                    item.model
                                                                }}</small
                                                            >
                                                            <br
                                                                v-if="
                                                                    item.model
                                                                "
                                                            />
                                                            <small
                                                                class="text-xs font-semibold"
                                                                >{{
                                                                    item.size
                                                                }}</small
                                                            >
                                                        </td>
                                                        <td>
                                                            {{
                                                                item.sales_rate
                                                            }}
                                                        </td>
                                                        <td>
                                                            {{
                                                                item.current_stock
                                                            }}
                                                        </td>
                                                        <td>
                                                            <button
                                                                type="button"
                                                                class="btn btn-sm btn-success"
                                                                @click="
                                                                    addToProductCustomization(
                                                                        item
                                                                    )
                                                                "
                                                            >
                                                                Add
                                                                <i
                                                                    class="fa fa-plus"
                                                                ></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                    <tr
                                                        v-if="
                                                            productAttributes.length ==
                                                            0
                                                        "
                                                    >
                                                        <td
                                                            colspan="4"
                                                            class="text-center text-danger font-semibold"
                                                        >
                                                            Not Found
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-8 col-md-12">
                                    <div class="card card-success">
                                        <div class="card-header">
                                            Product Customization
                                        </div>
                                        <div class="card-body">
                                            <table
                                                class="table table-striped table-bordered"
                                            >
                                                <thead>
                                                    <th>#</th>
                                                    <th>Particulars</th>
                                                    <th>Qty</th>
                                                    <th class="text-center">
                                                        Rate <br />
                                                        <small>Purchases</small>
                                                    </th>
                                                    <th class="text-center">
                                                        Rate <br />
                                                        <small>Sales</small>
                                                    </th>
                                                    <th>Discount</th>
                                                    <th>Total</th>
                                                </thead>
                                                <tbody>
                                                    <tr
                                                        class=""
                                                        v-for="(
                                                            item, index
                                                        ) in productCustomizations"
                                                        :key="index"
                                                    >
                                                        <td>
                                                            <button
                                                                type="button"
                                                                class="btn btn-sm btn-danger"
                                                                @click="
                                                                    removeItem(
                                                                        item.id
                                                                    )
                                                                "
                                                            >
                                                                <i
                                                                    class="fa fa-minus"
                                                                ></i>
                                                            </button>
                                                        </td>
                                                        <td>
                                                            {{ item.p_code }}
                                                            <span
                                                                v-if="
                                                                    item.p_name
                                                                "
                                                                >-</span
                                                            >
                                                            {{ item.p_name }}
                                                            <br />
                                                            <small>
                                                                {{
                                                                    item.p_model
                                                                }}
                                                                <span
                                                                    v-if="
                                                                        item.p_color
                                                                    "
                                                                    >-</span
                                                                >
                                                                {{
                                                                    item.p_color
                                                                }}
                                                                <span
                                                                    v-if="
                                                                        item.p_size
                                                                    "
                                                                    >-</span
                                                                >
                                                                {{
                                                                    item.p_size
                                                                }}
                                                            </small>
                                                        </td>
                                                        <td>
                                                            <input
                                                                type="number"
                                                                class="form-control"
                                                                :value="
                                                                    item.qty
                                                                "
                                                                @input="
                                                                    (e) => {
                                                                        handleItemValueChange(
                                                                            e,
                                                                            item,
                                                                            'qty'
                                                                        );
                                                                    }
                                                                "
                                                            />
                                                        </td>
                                                        <td>
                                                            <input
                                                                type="number"
                                                                class="form-control"
                                                                :value="
                                                                    item.purchase_rate
                                                                "
                                                                @input="
                                                                    (e) => {
                                                                        handleItemValueChange(
                                                                            e,
                                                                            item,
                                                                            'purchase_rate'
                                                                        );
                                                                    }
                                                                "
                                                            />
                                                        </td>
                                                        <td>
                                                            {{
                                                                item.sales_rate
                                                            }}
                                                        </td>
                                                        <td>
                                                            <input
                                                                type="number"
                                                                class="form-control"
                                                                :value="
                                                                    item.discount
                                                                "
                                                                @input="
                                                                    (e) => {
                                                                        handleItemValueChange(
                                                                            e,
                                                                            item,
                                                                            'discount'
                                                                        );
                                                                    }
                                                                "
                                                            />
                                                        </td>
                                                        <td>
                                                            {{ item.total }}
                                                        </td>
                                                    </tr>
                                                </tbody>
                                                <tfoot>
                                                    <td
                                                        colspan="2"
                                                        class="bg-success text-end"
                                                    >
                                                        Total
                                                    </td>
                                                    <td
                                                        class="bg-success text-center"
                                                    >
                                                        {{ total_qty }}
                                                    </td>
                                                    <td
                                                        class="bg-success text-center"
                                                    ></td>
                                                    <td
                                                        class="bg-success text-center"
                                                    ></td>
                                                    <td
                                                        class="bg-success text-center"
                                                    ></td>
                                                    <td
                                                        class="bg-success text-center"
                                                    >
                                                        {{ total_amount }}
                                                    </td>
                                                </tfoot>
                                            </table>
                                            <div
                                                class="product_customization_note_amount mt-1"
                                            >
                                                <div
                                                    class="product_customization_note"
                                                >
                                                    <label
                                                        class="mt-2 mx-2 w-8rem"
                                                        >Note:</label
                                                    >
                                                    <textarea
                                                        type="text"
                                                        class="form-control"
                                                        v-model="note"
                                                        placeholder="Note"
                                                    ></textarea>
                                                </div>
                                                <div
                                                    class="flex-column product_customization_amount"
                                                >
                                                    <div class="d-flex mt-1">
                                                        <div>
                                                            <label
                                                                class="w-8rem"
                                                                >Transaction
                                                                Type</label
                                                            >
                                                            <select
                                                                class="form-control w-fit"
                                                                id="transaction_type"
                                                                name="transaction_type"
                                                                v-model="
                                                                    selected_transaction_type
                                                                "
                                                            >
                                                                <option
                                                                    v-for="item in transactionTypes"
                                                                    :value="
                                                                        item.id
                                                                    "
                                                                    :key="
                                                                        item.id
                                                                    "
                                                                >
                                                                    {{
                                                                        item.name
                                                                    }}
                                                                </option>
                                                            </select>
                                                        </div>
                                                        <div class="mx-2">
                                                            <label
                                                                class="mx-2 w-8rem"
                                                                >Paid
                                                                Amount</label
                                                            >
                                                            <input
                                                                type="text"
                                                                class="form-control"
                                                                v-model="
                                                                    paid_amount
                                                                "
                                                                @input="
                                                                    setDueAmount
                                                                "
                                                                placeholder="Paid amount"
                                                            />
                                                        </div>
                                                    </div>
                                                    <div
                                                        class="d-flex mt-1 justify-content-end"
                                                    >
                                                        <label
                                                            >Due Amount:
                                                            {{
                                                                due_amount
                                                            }}</label
                                                        >
                                                    </div>
                                                    <div
                                                        class="d-flex mt-1 justify-content-end"
                                                    >
                                                        <button
                                                            class="btn btn-success btn-sm"
                                                            type="button"
                                                            :disabled="
                                                                isSubmitBtn
                                                            "
                                                            @click="
                                                                handleSubmit
                                                            "
                                                        >
                                                            {{
                                                                handleSubmitName
                                                            }}
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
import { onMounted, ref } from "vue";
import ProductCustomizationTr from "./_partials/ProductCustomizationTr.vue";
import AddNewSupplierModal from "./AddNewSupplierModal.vue";
import ProductDetails from "./_partials/ProductDetails.vue";
import axios from "axios";
export default {
    components: {
        ProductCustomizationTr,
        AddNewSupplierModal,
        ProductDetails,
    },

    setup() {
        var suppliers = ref([]);
        var products = ref([]);
        var selectedProduct = ref("");
        var selected_transaction_type = ref("");
        var selectedSupplier = ref("");
        var productAttributes = ref([]);
        var productCustomizations = ref([]);
        var transactionTypes = ref([]);
        var product_name = ref("");
        var inputedBarcode = ref("");
        var qty_input = [];
        var total_qty = ref(0);
        var total_amount = ref(0);
        var purchase_price_input = ref(0);
        var purchase_price_input = ref(0);
        var sub_amount = ref(0);
        var grand_total_amount = ref(0);
        var paid_amount = ref(0);
        var due_amount = ref(0);
        var note = ref("");
        var handleSubmitName = ref("Submit");
        var isSubmitBtn = ref(false);
        var getdata = ref();

        var invoice_date = ref();

        onMounted(() => {
            fetchData();

            fetchTransationTypes();
            totalCalculations();
        });

        const fetchData = () => {
            const id = window.getId();
            axios.get(`/purchase/fetch/${id}`).then((response) => {
                const data = response.data.data;
                getdata.value = data;
                paid_amount.value = data.purchase.paid_amount;
                due_amount.value = data.purchase.due_amount;
                note.value = data.purchase.note;
                selected_transaction_type.value = 1;
                invoice_date.value = data.purchase.invoice_date;
                if (data.purchaseDetails.length > 0) {
                    data.purchaseDetails.map((item) => {
                        const SET_VALUE = {
                            id: item.id,
                            p_code: item.product_attribute.code,
                            product_attribute_id: item.product_attribute.id,
                            p_name: item.product.name,
                            product_id: item.product.id,
                            p_color: item.product_attribute.color,
                            p_model: item.product_attribute.model,
                            p_size: item.product_attribute.size,
                            p_model: item.product_attribute.model,
                            purchase_rate: item.purchase_rate,
                            sales_rate: item.sales_rate,
                            qty: item.qty,
                            discount: item.discount,
                            total: item.total,
                        };
                        productCustomizations.value = [
                            ...productCustomizations.value,
                            SET_VALUE,
                        ];
                    });
                    console.log(productCustomizations.value);
                }
                console.log(productCustomizations.value);
                fetchSuppliers();
                fetchProducts();
                totalCalculations();
            });
        };

        const totalCalculations = () => {
            total_qty.value = 0;
            total_amount.value = 0;
            productCustomizations.value.map((item, index) => {
                total_qty.value += parseInt(item.qty);
                total_amount.value += parseInt(item.total);
            });
            grand_total_amount.value = total_amount.value;

            due_amount.value =
                parseFloat(total_amount.value) - parseFloat(paid_amount.value);
        };

        const fetchSuppliers = () => {
            axios.get("/supplier/fetch").then((response) => {
                const data = response.data.data;
                suppliers.value = data;
                selectedSupplier.value = getdata.value?.purchase?.supplier_id;
            });
        };

        const fetchTransationTypes = () => {
            axios.get("/transaction-types/fetch").then((response) => {
                const data = response.data.data;
                transactionTypes.value = data;
            });
        };

        const fetchProducts = () => {
            axios.get("/product/fetch").then((response) => {
                const data = response.data.data;
                products.value = data;
            });
        };

        const handleProductChange = () => {
            const product = products.value.find(
                (item) => item.id == selectedProduct.value
            );
            product_name.value = product.name;

            axios
                .get(
                    `/product/fetch-attribute?product_id=${selectedProduct.value}`
                )
                .then((response) => {
                    const data = response.data.data;
                    productAttributes.value = data;
                });
        };

        const getProductAttributesByBarcode = (event) => {
            if (event.code == "Enter" || event.code == "NumpadEnter") {
                axios
                    .get(
                        `/product/fetch-attribute?barcode=${inputedBarcode.value}`
                    )
                    .then((response) => {
                        const data = response.data.data;
                        if (data.length > 0) {
                            product_name.value = data[0].product.name;
                        }
                        productAttributes.value = data;
                    });
            }
        };

        const hanldeSubAmount = () => {
            grand_total_amount.value =
                parseFloat(total_amount.value) - parseFloat(sub_amount.value);
        };

        const handleSubmit = () => {
            if (!selected_transaction_type.value) {
                Toastr.fire({
                    icon: "error",
                    title: "Please Selected a transaction type",
                });
                return false;
            }

            if (!selectedSupplier.value) {
                Toastr.fire({
                    icon: "error",
                    title: "Please Selected a Supplier",
                });
                return false;
            }

            if (productCustomizations.value.length == 0) {
                Toastr.fire({
                    icon: "error",
                    title: "Please add product for customizations",
                });
                return false;
            }

            const data = {
                purchase_id: window.getId(),
                supplier_id: selectedSupplier.value,
                invoice_date: invoice_date.value,
                total_amount: total_amount.value,
                sub_amount: 0,
                transaction_type_id: selected_transaction_type.value,
                paid_amount: paid_amount.value,
                grand_total_amount: 0,
                productCustomizations: productCustomizations.value,
                note: note.value,
            };

            isSubmitBtn.value = true;
            handleSubmitName.value = "Prosessing ...";

            axios
                .put(`/purchase/${data.purchase_id}/edit/`, data)
                .then((response) => {
                    const data = response.data.data;
                    const status = response.data.status;
                    if (status == true) {
                        Toastr.fire({
                            icon: "success",
                            title: "Successfully created Purchases",
                        });

                        setTimeout(() => {
                            window.location.href = `/purchase/invoice/${data.id}`;
                        }, 1600);
                    } else {
                        Toastr.fire({
                            icon: "error",
                            title: "Something went wrong, Please try again.!",
                        });

                        isSubmitBtn.value = false;
                        handleSubmitName.value = "Submit";
                    }
                });
        };

        const setDueAmount = () => {
            if (total_amount.value < paid_amount.value) {
                Toastr.fire({
                    icon: "error",
                    title: "Paid amount is too large.!",
                });

                setTimeout(() => {
                    paid_amount.value = 0;
                    due_amount.value = total_amount.value;
                }, 1600);
                return false;
            }
            due_amount.value = total_amount.value - paid_amount.value;
        };

        // New

        const addToProductCustomization = (item) => {
            const hasAlreadyAdded = productCustomizations.value.find(function (
                pc_item
            ) {
                return pc_item.product_attribute_id === item.id;
            });

            if (hasAlreadyAdded) {
                hasAlreadyAdded.qty = parseInt(hasAlreadyAdded.qty) + 1;
                hasAlreadyAdded.total =
                    (parseFloat(hasAlreadyAdded.purchase_rate) -
                        parseFloat(hasAlreadyAdded.discount)) *
                    parseInt(hasAlreadyAdded.qty);
                totalCalculations();
                return false;
            } else {
                const SET_VALUE = {
                    id: item.id,
                    p_code: item.code,
                    product_attribute_id: item.id,
                    p_name: item.product.name,
                    product_id: item.product.id,
                    p_color: item.color,
                    p_model: item.model,
                    p_size: item.size,
                    purchase_rate: item.last_purchase ? item.last_purchase : 0,
                    sales_rate: item.sales_rate,
                    qty: 0,
                    discount: 0,
                    total: 0,
                };

                productCustomizations.value.push(SET_VALUE);
                totalCalculations();
                return false;
            }
        };

        const handleItemValueChange = (e, item, type) => {
            console.clear();
            const value = e.target.value == "" ? 0 : parseFloat(e.target.value);
            if (type == "qty") {
                item.qty = value;
            } else if (type == "purchase_rate") {
                item.purchase_rate = value;
            } else if (type == "discount") {
                if (parseFloat(item.purchase_rate) < parseFloat(value)) {
                    Toastr.fire({
                        icon: "error",
                        title: "Invalid discount price",
                    });
                    item.discount = parseFloat(item.purchase_rate) - 1;
                    item.total =
                        (parseFloat(item.purchase_rate) -
                            parseFloat(item.discount)) *
                        parseInt(item.qty);
                    return false;
                }
                item.discount = value;
            }
            item.total =
                (parseFloat(item.purchase_rate) - parseFloat(item.discount)) *
                parseInt(item.qty);
            totalCalculations();
        };

        const removeItem = (id) => {
            productCustomizations.value = productCustomizations.value.filter(
                (item) => item.id != id
            );
        };

        return {
            paid_amount,
            selectedSupplier,
            sub_amount,
            grand_total_amount,
            suppliers,
            products,
            selectedProduct,
            qty_input,
            total_qty,
            total_amount,
            productAttributes,
            inputedBarcode,
            purchase_price_input,
            transactionTypes,
            productCustomizations,
            selected_transaction_type,
            invoice_date,
            product_name,
            isSubmitBtn,
            due_amount,
            getdata,
            note,
            handleSubmitName,
            handleSubmit,
            removeItem,
            handleItemValueChange,
            hanldeSubAmount,
            setDueAmount,
            fetchTransationTypes,
            fetchSuppliers,
            addToProductCustomization,
            handleProductChange,
            getProductAttributesByBarcode,
        };
    },
};
</script>
