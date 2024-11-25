<template>
    <div>
        <section class="content">
            <div class="container-fluid">
                <div class="row mx-2">
                    <div class="card card-navy p-0">
                        <div class="card-header w-100 bg-navy">
                            <h3 class="card-title">Sales Return</h3>
                        </div>
                        <div class="card-body row">
                            <div class="col-md-4 col-12">
                                <div class="card card-outline card-info">
                                    <div class="card-header">
                                        <h3 class="card-title">
                                            Find Returnable Invoice
                                        </h3>
                                    </div>
                                    <div class="card-body">
                                        <div>
                                            <label class="required"
                                                >Select a Date:</label
                                            >
                                            <input
                                                type="date"
                                                v-model="selectedDate"
                                                @change="fetchSipplier"
                                                class="form-control"
                                            />
                                        </div>
                                        <div>
                                            <label class="required"
                                                >Select a Customer:</label
                                            ><select
                                                class="form-select"
                                                v-model="selectedCustomer"
                                                @change="handleChangeCustomer"
                                            >
                                                <option
                                                    disabled=""
                                                    selected=""
                                                    value="0"
                                                >
                                                    Select a Customer
                                                </option>
                                                <option
                                                    v-for="(
                                                        item, index
                                                    ) in customerList"
                                                    :key="index"
                                                    :value="item.id"
                                                >
                                                    {{ item.name }}
                                                </option>
                                            </select>
                                        </div>
                                        <div class="mt-2">
                                            <label class="required"
                                                >Select a Inovice:</label
                                            ><select
                                                class="form-select"
                                                v-model="selectedInvoice"
                                                @change="handleSelectedInovice"
                                            >
                                                <option
                                                    disabled=""
                                                    selected=""
                                                    value="0"
                                                >
                                                    Select a invoice
                                                </option>
                                                <option
                                                    v-for="(
                                                        item, index
                                                    ) in invoiceList"
                                                    :key="index"
                                                    :value="item.id"
                                                >
                                                    {{ item.code }}
                                                </option>
                                            </select>
                                        </div>
                                        <div
                                            class="mt-3 border p-2"
                                            v-if="getSales"
                                        >
                                            <div>
                                                <h5><b>Sales Info:</b></h5>
                                                <p>
                                                    <b>Total Amount:</b>
                                                    {{ getTotalAmount }}
                                                    tk
                                                </p>
                                                <p>
                                                    <b>Paid Amount:</b>
                                                    {{
                                                        getSales.paid_amount
                                                    }}
                                                    tk
                                                </p>
                                                <p>
                                                    <b> Due Amount:</b>
                                                    {{ getSales.due_amount }}
                                                    tk
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8 col-12">
                                <div class="card card-outline card-primary">
                                    <div class="card-header">
                                        <h3 class="card-title">
                                            Product Informations
                                        </h3>
                                    </div>
                                    <div class="card-body">
                                        <table
                                            class="table table-striped table-bordered"
                                        >
                                            <thead>
                                                <tr>
                                                    <th
                                                        scope="col"
                                                        class="bg-success"
                                                    >
                                                        #
                                                    </th>
                                                    <th
                                                        scope="col"
                                                        class="bg-success"
                                                    >
                                                        Particulars
                                                    </th>
                                                    <th
                                                        scope="col"
                                                        class="bg-success"
                                                    >
                                                        Qty
                                                    </th>
                                                    <th
                                                        scope="col"
                                                        class="bg-success"
                                                    >
                                                        Sales Rate
                                                    </th>
                                                    <th
                                                        scope="col"
                                                        class="bg-success"
                                                    >
                                                        Discount
                                                    </th>
                                                    <th
                                                        scope="col"
                                                        class="w-25 bg-success"
                                                    >
                                                        Return Qty
                                                    </th>
                                                    <th
                                                        scope="col"
                                                        class="text-end bg-success"
                                                    >
                                                        Total
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr
                                                    v-for="(
                                                        item, index
                                                    ) in salesDetailsList"
                                                    :key="index"
                                                >
                                                    <td
                                                        class="d-flex-item-center"
                                                    >
                                                        <button
                                                            @click="
                                                                removeItem(item)
                                                            "
                                                            class="btn btn-sm btn-danger mt-2"
                                                        >
                                                            <i
                                                                class="fa-solid fa-xmark"
                                                            ></i>
                                                        </button>
                                                    </td>
                                                    <td>
                                                        {{
                                                            item
                                                                .product_attribute
                                                                .code
                                                        }}
                                                        <br />
                                                        {{
                                                            item
                                                                .product_attribute
                                                                .color
                                                        }}
                                                        <br />
                                                        {{
                                                            item
                                                                .product_attribute
                                                                .model
                                                        }}
                                                    </td>
                                                    <td>{{ item.qty }}</td>
                                                    <td>
                                                        {{ item.sales_rate }}
                                                    </td>
                                                    <td>
                                                        {{ item.discount }}
                                                    </td>
                                                    <td>
                                                        <input
                                                            type="number"
                                                            @input="
                                                                (e) =>
                                                                    handleReturnQty(
                                                                        e,
                                                                        item
                                                                    )
                                                            "
                                                            class="form-control"
                                                            :class="
                                                                item.custom_class
                                                            "
                                                            :value="
                                                                item.return_qty
                                                            "
                                                        />
                                                    </td>
                                                    <td class="text-end">
                                                        {{ item.total }}
                                                    </td>
                                                </tr>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td
                                                        class="text-end bg-success"
                                                        colspan="6"
                                                    >
                                                        Total Amount:
                                                    </td>
                                                    <td
                                                        class="text-end bg-success"
                                                    >
                                                        {{
                                                            getSales.total_amount
                                                        }}
                                                    </td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                        <div
                                            class="product_customization_note_amount mt-1"
                                        >
                                            <div
                                                class="product_customization_note"
                                            >
                                                <label class="mt-2 mx-2 w-8rem"
                                                    >Note:</label
                                                ><textarea
                                                    type="text"
                                                    class="form-control"
                                                    placeholder="Note"
                                                    v-model="note"
                                                ></textarea>
                                            </div>
                                            <div
                                                class="flex-column product_customization_amount"
                                            >
                                                <div class="d-flex mt-1">
                                                    <div>
                                                        <label class="w-8rem"
                                                            >Transaction
                                                            Type</label
                                                        ><select
                                                            class="form-control w-fit"
                                                            id="transaction_type"
                                                            v-model="
                                                                transaction_type
                                                            "
                                                        >
                                                            <option
                                                                selected=""
                                                                disabled=""
                                                                value=""
                                                            >
                                                                Transaction Type
                                                            </option>
                                                            <option
                                                                v-for="item in transactionTypes"
                                                                :value="item.id"
                                                                :key="item.id"
                                                            >
                                                                {{ item.name }}
                                                            </option>
                                                        </select>
                                                    </div>
                                                    <div class="mx-2">
                                                        <label
                                                            class="mx-2 w-8rem"
                                                            >Return
                                                            Amount</label
                                                        ><input
                                                            type="number"
                                                            class="form-control"
                                                            placeholder="Return amount"
                                                            @input="
                                                                handleReturnAmount
                                                            "
                                                            v-model="
                                                                return_amount
                                                            "
                                                        />
                                                    </div>
                                                </div>
                                                <div
                                                    class="d-flex mt-1 justify-content-end"
                                                >
                                                    <label
                                                        >Due Amount:
                                                        {{ due_amount }}</label
                                                    >
                                                </div>
                                                <div
                                                    class="d-flex mt-1 justify-content-end"
                                                >
                                                    <button
                                                        class="btn btn-success btn-sm"
                                                        type="button"
                                                        @click="submitBtn"
                                                        :disabled="
                                                            submitBtnStatus
                                                        "
                                                    >
                                                        {{ submitBtnText }}
                                                    </button>
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
    </div>
</template>

<script>
import { ref, onMounted } from "vue";
import axios from "axios";
export default {
    setup() {
        var selectedDate = ref(moment().format("yyyy-MM-DD"));
        var salesList = ref("");
        var customerList = ref("");
        var invoiceList = ref("");
        var selectedCustomer = ref("0");
        var selectedInvoice = ref("0");
        var salesDetailsList = ref("");
        var getSales = ref("");
        var due_amount = ref(0);
        var return_amount = ref("");
        var transactionTypes = ref("");
        var note = ref("");
        var transaction_type = ref("");
        var getTotalAmount = ref(0);
        var submitBtnText = ref("Submit");
        var submitBtnStatus = ref(true);

        const fetchSipplier = () => {
            selectedCustomer.value = "0";
            selectedInvoice.value = "0";
            axios
                .get(
                    `/customer/fetch?type=sales-return&date=${selectedDate.value}`
                )
                .then((response) => {
                    const data = response.data.data;
                    salesList.value = data;
                    customerList.value = [];
                    invoiceList.value = [];
                    salesList.value.length > 0 &&
                        salesList.value.map((item) => {
                            customerList.value = [
                                ...customerList.value,
                                item.customer,
                            ];
                        });
                    // unique customer name
                    customerList.value = customerList.value.filter(
                        (customer, index, self) =>
                            index ===
                            self.findIndex((s) => s.id === customer.id)
                    );
                });
        };

        const handleChangeCustomer = () => {
            invoiceList.value = salesList.value.filter(
                (item) => item.customer_id == selectedCustomer.value
            );
            selectedInvoice.value = "0";
        };

        const handleSelectedInovice = () => {
            axios
                .get(
                    `/sales/fetch-invoice?type=sales-return&sales_id=${selectedInvoice.value}`
                )
                .then((response) => {
                    const { sales, salesDetails } = response.data.data;
                    getSales.value = sales;
                    getTotalAmount.value = getSales.value.total_amount;
                    salesDetailsList.value = salesDetails;
                    salesDetailsList.value.forEach((item) => {
                        item.return_qty = item.qty; // You can set the value to any default you prefer
                        item.custom_class = "";
                    });

                    submitBtnStatus.value = false;
                });
        };

        const handleReturnQty = (e, item) => {
            var inputReturnQty = isNaN(parseInt(e.target.value))
                ? 0
                : parseInt(e.target.value);
            item.return_qty = inputReturnQty == 0 ? "" : inputReturnQty;
            const { sales_rate, qty, discount, total } = item;
            if (inputReturnQty > parseInt(qty)) {
                item.custom_class = "form-control-red";
                Toastr.fire({
                    icon: "error",
                    title: "Quantity is out of range",
                });
                item.total = 0;
                setTimeout(() => {
                    item.return_qty = qty;
                    item.total =
                        (parseFloat(sales_rate) - parseFloat(discount)) *
                        qty;
                    item.custom_class = "";
                    calculateReturnTotalAmount();
                }, 2000);
                calculateReturnTotalAmount();
                return false;
            } else {
                item.custom_class = "";
            }
            item.total =
                (parseFloat(sales_rate) - parseFloat(discount)) *
                item.return_qty;
            calculateReturnTotalAmount();
        };

        const calculateReturnTotalAmount = () => {
            getSales.value.total_amount = 0;
            salesDetailsList.value.forEach((item) => {
                getSales.value.total_amount += parseFloat(item.total);
            });
        };

        const submitBtn = () => {
            if (transaction_type.value == "") {
                Toastr.fire({
                    icon: "error",
                    title: "Please select a transaction",
                });
                return false;
            }
            const data = {
                sales_id: selectedInvoice.value,
                note: note.value,
                transaction_type_id: transaction_type.value,
                total_amount: getSales.value.total_amount,
                due_amount: due_amount.value,
                return_amount: return_amount.value,
                product_details: salesDetailsList.value,
            };



            submitBtnText.value = "Processing...";
            submitBtnStatus.status = false;

            axios.post("/sales/return/create", data).then((response) => {
                const { data, status } = response.data;
                if (status == true) {
                    Toastr.fire({
                        icon: "success",
                        title: "Sales Return successful",
                    });

                    setTimeout(() => {
                        window.location.href = `/sales/return/invoice/${data.id}`;
                    }, 1600);
                }
            });
        };

        const fetchTransationTypes = () => {
            axios.get("/transaction-types/fetch").then((response) => {
                const data = response.data.data;
                transactionTypes.value = data;
            });
        };

        const handleReturnAmount = () => {
            if (
                parseFloat(getSales.value.total_amount) <
                parseFloat(return_amount.value)
            ) {
                setTimeout(() => {
                    return_amount.value = getSales.value.total_amount;
                }, 2500);

                Toastr.fire({
                    icon: "error",
                    title: "Return amount is not valid",
                });

                due_amount.value = 0;
                return false;
            }

            due_amount.value =
                parseFloat(getSales.value.total_amount) -
                parseFloat(return_amount.value);
        };

        const removeItem = (removeItem) => {
            salesDetailsList.value = salesDetailsList.value.filter(item => item.id !== removeItem.id);
        };

        onMounted(() => {
            fetchSipplier();
            fetchTransationTypes();
        });

        return {
            submitBtnStatus,
            selectedDate,
            customerList,
            selectedCustomer,
            selectedInvoice,
            invoiceList,
            getSales,
            getTotalAmount,
            salesDetailsList,
            return_amount,
            note,
            transaction_type,
            due_amount,
            submitBtnText,
            handleReturnAmount,
            transactionTypes,
            handleSelectedInovice,
            fetchSipplier,
            handleChangeCustomer,
            removeItem,
            submitBtn,
            handleReturnQty,
        };
    },
};
</script>

<style></style>
