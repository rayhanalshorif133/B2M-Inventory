<template>
    <section class="content overflow-x-hidden">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Update Return Sales</h3>
                    </div>
                    <div class="card-body">
                        <form>
                            <div class="row">
                                <div class="col-12 col-md-7 col-lg-7">
                                    <div class="form-group d-flex">
                                        <label
                                            for="customer"
                                            class="d-flex mx-1"
                                            >Customer
                                            <span class="text-danger mx-1"
                                                >*</span
                                            ></label
                                        >
                                        <select
                                            class="form-control"
                                            id="customer"
                                            v-model="selectedCustomer"
                                        >
                                            <option
                                                v-for="item in customers"
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
                                                data-target="#addNewCustomerModal"
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
                                        :fetchCustomers="fetchCustomers"
                                    ></add-new-supplier-modal>
                                </div>
                                <div class="col-12">
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
                                                                    item.return_qty
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
                                                                    item.sales_rate
                                                                "
                                                                @input="
                                                                    (e) => {
                                                                        handleItemValueChange(
                                                                            e,
                                                                            item,
                                                                            'sales_rate'
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
                                                                >Return
                                                                Amount</label
                                                            >
                                                            <input
                                                                type="text"
                                                                class="form-control"
                                                                v-model="
                                                                    paid_amount
                                                                "
                                                                placeholder="Return amount"
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
import axios from "axios";
export default {
    setup() {
        var customers = ref([]);
        var selected_transaction_type = ref("");
        var selectedCustomer = ref("");
        var productCustomizations = ref([]);
        var transactionTypes = ref([]);
        var total_qty = ref(0);
        var total_amount = ref(0);
        var sales_price_input = ref(0);
        var sales_price_input = ref(0);
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
            axios.get(`/sales/return/fetch/${id}`).then((response) => {
                const data = response.data.data;
                getdata.value = data;
                paid_amount.value = data.salesReturn.return_amount;
                due_amount.value = data.salesReturn.due_amount;
                note.value = data.salesReturn.note;
                selected_transaction_type.value = 1;
                invoice_date.value = data.salesReturn.invoice_date;
                if (data.salesReturnDetails.length > 0) {
                    data.salesReturnDetails.map((item) => {
                        const SET_VALUE = {
                            id: item.id,
                            p_code: item.product_attribute.code,
                            product_attribute_id: item.product_attribute.id,
                            p_name: item.product_attribute.product.name,
                            product_id: item.product_attribute.product.id,
                            p_color: item.product_attribute.color,
                            p_model: item.product_attribute.model,
                            p_size: item.product_attribute.size,
                            p_model: item.product_attribute.model,
                            sales_rate: item.sales_rate,
                            sales_rate: item.sales_rate,
                            return_qty: item.return_qty,
                            discount: item.discount,
                            total: item.total,
                        };
                        productCustomizations.value = [
                            ...productCustomizations.value,
                            SET_VALUE,
                        ];
                    });
                }
                fetchCustomers();
                totalCalculations();
            });
        };

        const totalCalculations = () => {
            total_qty.value = 0;
            total_amount.value = 0;
            productCustomizations.value.map((item, index) => {
                total_qty.value += parseInt(item.return_qty);
                total_amount.value += parseInt(item.total);
            });
            grand_total_amount.value = total_amount.value;

            due_amount.value =
                parseFloat(total_amount.value) - parseFloat(paid_amount.value);
        };

        const fetchCustomers = () => {
            axios.get("/customer/fetch").then((response) => {
                const data = response.data.data;
                customers.value = data;
                selectedCustomer.value =
                    getdata.value?.salesReturn?.customer_id;
            });
        };

        const fetchTransationTypes = () => {
            axios.get("/transaction-types/fetch").then((response) => {
                const data = response.data.data;
                transactionTypes.value = data;
            });
        };

        const handleSubmit = () => {
            if (!selected_transaction_type.value) {
                Toastr.fire({
                    icon: "error",
                    title: "Please Selected a transaction type",
                });
                return false;
            }

            if (!selectedCustomer.value) {
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

            if (
                productCustomizations.value.length == 1 &&
                parseInt(productCustomizations.value[0].return_qty) == 0
            ) {
                Toastr.fire({
                    icon: "error",
                    title: "Please add some return qty",
                });
                return false;
            }

            const data = {
                sales_return_id: window.getId(),
                customer_id: selectedCustomer.value,
                invoice_date: invoice_date.value,
                total_amount: total_amount.value,
                sub_amount: 0,
                transaction_type_id: selected_transaction_type.value,
                return_amount: paid_amount.value,
                grand_total_amount: 0,
                productCustomizations: productCustomizations.value,
                note: note.value,
            };

             isSubmitBtn.value = true;
             handleSubmitName.value = "Prosessing ...";

            axios
                .put(`/sales/return/${data.sales_return_id}/edit/`, data)
                .then((response) => {
                    const data = response.data.data;
                    const status = response.data.status;
                    if (status == true) {
                        Toastr.fire({
                            icon: "success",
                            title: "Successfully Updated",
                        });
                         setTimeout(() => {
                             window.location.href = `/sales/return/invoice/${data.id}`;
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

        const handleItemValueChange = (e, item, type) => {
            console.clear();
            const value = e.target.value == "" ? 0 : parseFloat(e.target.value);
            if (type == "qty") {
                item.return_qty = value;
            } else if (type == "sales_rate") {
                item.sales_rate = value;
            } else if (type == "discount") {
                if (parseFloat(item.sales_rate) < parseFloat(value)) {
                    Toastr.fire({
                        icon: "error",
                        title: "Invalid discount price",
                    });
                    item.discount = parseFloat(item.sales_rate) - 1;
                    item.total =
                        (parseFloat(item.sales_rate) -
                            parseFloat(item.discount)) *
                        parseInt(item.return_qty);
                    return false;
                }
                item.discount = value;
            }
            item.total =
                (parseFloat(item.sales_rate) - parseFloat(item.discount)) *
                parseInt(item.return_qty);
            totalCalculations();
        };

        const removeItem = (id) => {
            productCustomizations.value = productCustomizations.value.filter(
                (item) => item.id != id
            );
        };

        return {
            paid_amount,
            selectedCustomer,
            sub_amount,
            grand_total_amount,
            customers,
            total_qty,
            total_amount,
            sales_price_input,
            transactionTypes,
            productCustomizations,
            selected_transaction_type,
            invoice_date,
            isSubmitBtn,
            due_amount,
            getdata,
            note,
            handleSubmitName,
            handleSubmit,
            removeItem,
            handleItemValueChange,
            fetchTransationTypes,
            fetchCustomers,
        };
    },
};
</script>
