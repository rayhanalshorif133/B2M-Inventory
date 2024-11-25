<script>
import axios from "axios";
import { ref, toRefs, onMounted } from "vue";

export default {
    props: {
        paymentData: { type: Object },
    },

    setup(props) {
        // transaction-types
        var transactionTypesList = ref("");
        var seletedTransactionType = ref(1);
        var paymentAmount = ref();
        var paymentAmountPlaceHolder = ref();
        var payment_id = ref();
        var paymentType = ref();

        onMounted(() => {
            const { paymentData } = toRefs(props);
            console.log(paymentData.value);
        });

        const fetchTransactionTypes = () => {
            axios.get("/transaction-types/fetch").then((response) => {
                if (response.data.status == true) {
                    transactionTypesList.value = response.data.data;
                }
            });
        };

        fetchTransactionTypes();

        const setValue = (data) => {
            payment_id.value = data.id;
            seletedTransactionType.value = data.transaction_type_id;
            paymentAmountPlaceHolder.value = data.amount;
            paymentType.value = data.type;
        };

        const handleSubmit = () => {

            const data = {
                payment_id: payment_id.value,
                transaction_type_id: seletedTransactionType.value,
                amount: paymentAmount.value? paymentAmount.value : paymentAmountPlaceHolder.value,
                type: paymentType.value,
            };

            axios.put("/payment/update", data).then((response) => {
                const data = response.data.data;
                const message = response.data.message;
                Toastr.fire({
                    icon: message,
                    title: data,
                });

                if (message == "success") {
                    setTimeout(() => {
                        window.location.reload();
                    }, 1000);
                }
            });
        };

        const handleInputAmount = (e) => {
            paymentAmount.value = e.target.value;
        };

        return {
            transactionTypesList,
            paymentAmount,
            handleSubmit,
            handleInputAmount,
            paymentAmountPlaceHolder,
            setValue,
            fetchTransactionTypes,
            seletedTransactionType,
        };
    },
};
</script>

<template>
    <div
        class="modal fade"
        id="paymentEditModal"
        tabindex="-1"
        role="dialog"
        aria-labelledby="paymentEditModalLabel"
        aria-hidden="true"
    >
        <div class="modal-dialog" role="document">
            <div class="modal-content" v-if="paymentData">
                <div class="modal-header">
                    <h5 class="modal-title" id="paymentEditModalLabel">
                        <span class="text-capitalize">{{
                            paymentData.type
                        }}</span>
                        Payment Edit
                    </h5>
                    <button
                        type="button"
                        class="close"
                        data-dismiss="modal"
                        aria-label="Close"
                    >
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div>
                        <h5><b>Payment Info:</b></h5>
                        <b>Receipt No : </b> {{ paymentData.receipt_no }}
                        <p
                            v-if="paymentData.type == 'purchase'"
                            style="margin-bottom: 0 !important"
                        >
                            <b>Supplier Name : </b>
                            {{ paymentData.supplier.name }}
                        </p>
                        <p v-else style="margin-bottom: 0 !important">
                            <b>Customer Name : </b>
                            {{ paymentData.customer.name }}
                        </p>
                        <b>Invoice Date : </b> {{ paymentData.created_date }}
                        <br />
                        <b>Paid Amount : </b> {{ paymentData.amount }} tk<br />
                    </div>
                    <div class="row">
                        <span class="d-none">{{ setValue(paymentData) }}</span>
                        <div class="col-md-6">
                            <label>Transation Type</label>
                            <select
                                class="form-select"
                                v-model="seletedTransactionType"
                            >
                                <option
                                    v-for="item in transactionTypesList"
                                    :key="item.id"
                                    :value="item.id"
                                >
                                    {{ item.name }}
                                </option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label>Pay Amount</label>
                            <div class="d-flex">
                                <input
                                    type="text"
                                    class="form-control w-full mr-1"
                                    :placeholder="paymentAmountPlaceHolder"
                                    v-model="paymentAmount"
                                    @input="handleInputAmount"
                                />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button
                        type="button"
                        class="btn btn-secondary"
                        data-dismiss="modal"
                    >
                        Close
                    </button>
                    <button
                        type="button"
                        class="btn btn-primary"
                        data-dismiss="modal"
                        @click="handleSubmit"
                    >
                        Update
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<style></style>
