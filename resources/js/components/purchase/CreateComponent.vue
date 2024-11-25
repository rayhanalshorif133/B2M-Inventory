<template>
    <section class="content overflow-x-hidden">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Create a new Purchase</h3>
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
                                            <option value="" selected disabled>
                                                Select a supplier
                                            </option>

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
                                        v-model="inputedBarcode"
                                        @keypress="
                                            getProductAttributesByBarcode
                                        "
                                    />
                                </div>
                                <product-details
                                    :productAddedQty="productAddedQty"
                                    :productAttributes="productAttributes"
                                    :productCustomizations="
                                        productCustomizations
                                    "
                                    :product_name="product_name"
                                >
                                </product-details>
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
                                                    <product-customization-tr
                                                        v-for="productCustomization in productCustomizations"
                                                        :key="
                                                            productCustomization.id
                                                        "
                                                        :productCustomization="
                                                            productCustomization
                                                        "
                                                        :removeItem="
                                                            removeItemFromProductCustomization
                                                        "
                                                        :updateCustomizationData="
                                                            updateCustomizationData
                                                        "
                                                        :GETQtyInputValue="
                                                            GETQtyInputValue
                                                        "
                                                        :GETPurchasePriceInputValue="
                                                            GETPurchasePriceInputValue
                                                        "
                                                        :GETDiscountInputValue="
                                                            GETDiscountInputValue
                                                        "
                                                        :GETSalesPriceInputValue="
                                                            GETSalesPriceInputValue
                                                        "
                                                    ></product-customization-tr>
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
                                            <div class="product_customization_note_amount mt-1">
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
                                                                    value=""
                                                                    selected
                                                                    disabled
                                                                >
                                                                    Transaction
                                                                    Type
                                                                </option>
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
                                                            :disabled="isSubmitBtn"
                                                            @click="
                                                                handleSubmit
                                                            "
                                                        >
                                                        {{ handleSubmitName }}
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

        const result = moment().format("YYYY-MM-DD");
        var invoice_date = ref(result);

        onMounted(() => {
            fetchSuppliers();
            fetchProducts();
            fetchTransationTypes();
            totalCalculations();
        });

        const totalCalculations = () => {
            total_qty.value = 0;
            total_amount.value = 0;
            productCustomizations.value.map((item, index) => {
                total_qty.value += parseInt(item.qty);
                total_amount.value += parseInt(item.total);
            });
            grand_total_amount.value = total_amount.value;
        };

        const fetchSuppliers = () => {
            axios.get("/supplier/fetch").then((response) => {
                const data = response.data.data;
                suppliers.value = data;
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

        const removeItemFromProductCustomization = (id) => {
            productCustomizations.value = productCustomizations.value.filter(
                (item) => item.id != id
            );
        };

        const productAddedQty = (id) => {
            var GET_productCustomization = productCustomizations.value.find(
                (item) => item.id == id
            );
            GET_productCustomization.qty =
                parseInt(GET_productCustomization.qty) + 1;
            GET_productCustomization.total =
                (GET_productCustomization.purchase_price -
                    GET_productCustomization.discount) *
                GET_productCustomization.qty;
            totalCalculations();
        };

        const GETSalesPriceInputValue = (e) => {
            var getProductCustomization = productCustomizations.value.find(
                (item) => item.id == e.target.id
            );
            getProductCustomization.sales_price =
                e.target.value == "" ? 0 : parseFloat(e.target.value);
        };

        const GETQtyInputValue = (e) => {
            var getProductCustomization = productCustomizations.value.find(
                (item) => item.id == e.target.id
            );
            getProductCustomization.qty =
                e.target.value == "" ? 0 : parseFloat(e.target.value);
            updateCustomizationData(getProductCustomization);
        };

        const GETPurchasePriceInputValue = (e) => {
            var getProductCustomization = productCustomizations.value.find(
                (item) => item.id == e.target.id
            );
            getProductCustomization.purchase_price =
                e.target.value == "" ? 0 : parseFloat(e.target.value);
            getProductCustomization.discount = 0;
            updateCustomizationData(getProductCustomization);
        };

        const GETDiscountInputValue = (e) => {
            var getProductCustomization = productCustomizations.value.find(
                (item) => item.id == e.target.id
            );
            getProductCustomization.discount =
                e.target.value == "" ? 0 : parseFloat(e.target.value);
            updateCustomizationData(getProductCustomization);
        };

        const updateCustomizationData = (getProductCustomization) => {
            getProductCustomization.discount_input_class = "";

            if (
                parseFloat(getProductCustomization.discount) + 1 >
                parseFloat(getProductCustomization.purchase_price)
            ) {
                Toastr.fire({
                    icon: "error",
                    title: "Discount price is too large!",
                });
                getProductCustomization.discount_input_class =
                    "form-control-red";
                getProductCustomization.discount =
                    parseFloat(getProductCustomization.purchase_price) - 1;
                return false;
            }

            getProductCustomization.total =
                (parseFloat(getProductCustomization.purchase_price) -
                    parseFloat(getProductCustomization.discount)) *
                parseInt(getProductCustomization.qty);
            totalCalculations();
        };

        const hanldeSubAmount = () => {
            grand_total_amount.value =
                parseFloat(total_amount.value) - parseFloat(sub_amount.value);
        };

        const handleSubmit = () => {




            if (!selected_transaction_type.value ) {
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



            if(productCustomizations.value.length == 0) {
                Toastr.fire({
                    icon: "error",
                    title: "Please add product for customizations",
                });
                return false;
            }

            const data = {
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
            handleSubmitName.value = 'Prosessing ...';

            axios.post("/purchase/create", data).then((response) => {
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
                    handleSubmitName.value = 'Submit';
                }
            });
        };

        const setDueAmount = () => {
            if(total_amount.value < paid_amount.value){
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
            note,
            handleSubmitName,
            handleSubmit,
            hanldeSubAmount,
            setDueAmount,
            fetchTransationTypes,
            updateCustomizationData,
            GETQtyInputValue,
            GETPurchasePriceInputValue,
            GETDiscountInputValue,
            productAddedQty,
            removeItemFromProductCustomization,
            fetchSuppliers,
            handleProductChange,
            getProductAttributesByBarcode,
            GETSalesPriceInputValue,
        };
    },
};
</script>
