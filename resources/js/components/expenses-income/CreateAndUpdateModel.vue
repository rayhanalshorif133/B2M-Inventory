<template>
    <div>
        <!-- Create Modal -->
        <div
            class="modal fade"
            id="createOrUpdateExpAndIncome"
            tabindex="-1"
            aria-labelledby="createOrUpdateExpAndIncomeLabel"
            aria-hidden="true"
        >
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5
                            class="modal-title"
                            id="createOrUpdateExpAndIncomeLabel"
                        >
                            <span v-if="actionType == 'create'"
                                >Create New Exp. and Income</span
                            >
                            <span v-else>Update Exp. and Income</span>
                        </h5>
                        <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"
                            aria-label="Close"
                            @click="hideModal"
                        ></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="selectCategory" class="required"
                                        >Select a Category</label
                                    >
                                    <select
                                        class="custom-select"
                                        v-model="selectCategory"
                                        id="selectCategory"
                                    >
                                        <option value="0" selected disabled>
                                            Choice a Category
                                        </option>
                                        <option
                                            v-for="(item, index) in categories"
                                            :value="item.id"
                                            :key="index"
                                        >
                                            {{ item.name }}
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="selectCategory" class="required"
                                        >Select a Head</label
                                    >
                                    <select
                                        class="custom-select"
                                        v-model="selectHead"
                                        id="selectHead"
                                        @change="handleSelectHead"
                                    >
                                        <option value="0" selected disabled>
                                            Choice a Head
                                        </option>
                                        <option
                                            v-for="(item, index) in heads"
                                            :value="item.id"
                                            :key="index"
                                        >
                                            {{ item.name }}
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="selectCategory" class="required"
                                        >Select a Type</label
                                    >
                                    <select
                                        class="custom-select"
                                        id="selectCategory"
                                        v-model="selectType"
                                    >
                                        <option value="0" selected disabled>
                                            Choice a Type
                                        </option>
                                        <option value="1">Income</option>
                                        <option value="2">Expense</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="selectCategory" class="required"
                                        >Select a Date</label
                                    >
                                    <input
                                        v-model="selectDate"
                                        type="date"
                                        class="form-control"
                                    />
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="selectCategory" class="required"
                                        >Select a Transaction Type</label
                                    >
                                    <select
                                        class="custom-select"
                                        v-model="selectTransactionType"
                                        id="selectTransactionType"
                                        v-if="actionType == 'create'"
                                    >
                                        <option value="0" selected disabled>
                                            Choice a Transaction Type
                                        </option>
                                        <option
                                            v-for="(
                                                item, index
                                            ) in transactionTypes"
                                            :value="item.id"
                                            :key="index"
                                        >
                                            {{ item.name }}
                                        </option>
                                    </select>
                                    <select
                                        class="custom-select"
                                        v-model="selectTransactionType"
                                        id="selectTransactionType"
                                        v-else
                                    >
                                        <option
                                            v-for="(
                                                item, index
                                            ) in transactionTypes"
                                            :value="item.id"
                                            :key="index"
                                        >
                                            {{ item.name }}
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="selectCategory" class="required"
                                        >Amount</label
                                    >
                                    <input
                                        type="number"
                                        class="form-control"
                                        placeholder="Enter a amount"
                                        name="amount"
                                        v-model="amount"
                                    />
                                </div>
                            </div>
                            <div class="col-12 col-md-12">
                                <div class="form-group">
                                    <label for="selectCategory" class="optional"
                                        >Note</label
                                    >
                                    <textarea
                                        type="text"
                                        class="form-control"
                                        placeholder="Enter a note"
                                        name="note"
                                        v-model="note"
                                    />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button
                            type="button"
                            class="btn btn-secondary"
                            data-bs-dismiss="modal"
                            @click="hideModal"
                        >
                            Close
                        </button>
                        <button
                            type="button"
                            data-bs-dismiss="modal"
                            @click="handleSubmit('create')"
                            class="btn btn-primary"
                            v-if="actionType == 'create'"
                        >
                            Submit
                        </button>
                        <button
                            type="button"
                            data-bs-dismiss="modal"
                            @click="handleSubmit('update')"
                            class="btn btn-primary"
                            v-else
                        >
                            Submit
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";
import moment from "moment/moment";
import { onMounted, ref, toRefs, watchEffect } from "vue";

export default {
    props: {
        actionType: {
            type: String,
            required: true,
        },
        id: {
            type: Number,
            required: false,
        },
        hideModal: {
            type: Function,
            required: true,
        },
    },
    setup(props) {
        var categories = ref([]);
        var selectCategory = ref();
        var heads = ref([]);
        var selectType = ref("0");
        var selectHead = ref();
        var note = ref("");
        var amount = ref("");
        var GET_ID = ref("0");
        var transactionTypes = ref([]);
        var selectTransactionType = ref();
        const result = moment().format("YYYY-MM-DD");
        var selectDate = ref(result);

        onMounted(() => {
            axios.get("/expense-income/fetch?type=create").then((response) => {
                const data = response.data.data;
                categories.value = data.expensesIncomeCategories;
                heads.value = data.expensesIncomeHeads;
                transactionTypes.value = data.transactionTypes;
            });
        });

        watchEffect(() => {
            var { actionType, id } = toRefs(props);
            if (actionType.value == "update") {
                GET_ID.value = id.value;
                axios
                    .get(`/expense-income/fetch/${id.value}`)
                    .then((response) => {
                        const data = response.data.data;
                        selectCategory.value =
                            data.expenses_income_categories_id;
                        selectHead.value = data.expenses_income_heads_id;
                        selectTransactionType.value = data.transaction_type_id;
                        selectType.value = data.type;
                        amount.value = data.amount;
                        note.value = data.note;
                        selectDate.value = data.date;
                    });
            } else {
                selectCategory.value = "0";
                selectHead.value = "0";
                selectTransactionType.value = "0";
                selectType.value = "0";
            }
        }, [props]);

        const handleSubmit = (type) => {
            var data = {
                date: selectDate.value,
                type: selectType.value,
                category_id: selectCategory.value,
                head_id: selectHead.value,
                transactionType_id: selectTransactionType.value,
                note: note.value,
                amount: amount.value,
                id: GET_ID.value,
            };
            if (type == "create") {
                axios.post("/expense-income/create", data).then((response) => {
                    handleResponseRequest(response);
                });
            }else{
                axios.put("/expense-income/update", data).then((response) => {
                    handleResponseRequest(response);
                });
            }
        };
        return {
            categories,
            selectDate,
            note,
            amount,
            selectType,
            selectCategory,
            heads,
            selectHead,
            transactionTypes,
            selectTransactionType,
            handleSubmit,
        };
    },
};
</script>

<style></style>
