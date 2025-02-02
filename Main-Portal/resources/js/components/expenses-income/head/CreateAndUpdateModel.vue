<template>
    <div>
        <!-- Create Modal -->
        <div
            class="modal fade"
            id="addExpHead"
            tabindex="-1"
            aria-labelledby="addExpHeadLabel"
            aria-hidden="true"
        >
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addExpHeadLabel">
                            Add new Expencse Head
                        </h5>
                        <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"
                            aria-label="Close"
                        ></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="selectCategory" class="required"
                                >Select a Category</label
                            >
                            <select
                                class="custom-select"
                                v-model="selectCategory"
                                id="selectCategory"
                                @change="handleSelectCategory"
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
                        <div class="form-group">
                            <label for="code" class="required">Name</label
                            >
                            <input
                                class="form-control"
                                v-model="name"
                                placeholder="Enter Expencse Head Name"
                            />
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button
                            type="button"
                            class="btn btn-secondary"
                            data-bs-dismiss="modal"
                        >
                            Close
                        </button>
                        <button
                            type="button"
                            class="btn btn-primary"
                            @click="handleSubmit('create')"
                        >
                            Save
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Update Modal -->

        <div
            class="modal fade"
            id="updateExpHead"
            tabindex="-1"
            aria-labelledby="updateExpHeadLabel"
            aria-hidden="true"
        >
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="updateExpHeadLabel">
                            Update Expencse Category
                        </h5>
                        <button
                            type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"
                            aria-label="Close"
                        ></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="selectCategory" class="required"
                                >Select a Category</label
                            >
                            <select
                                class="custom-select"
                                v-model="updateSelectCategory"
                                id="selectCategory"
                                @change="handleSelectCategory"
                            >
                                <option
                                    v-for="(item, index) in categories"
                                    :value="item.id"
                                    :key="index"
                                >
                                    {{ item.name }}
                                </option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="code" class="required">Name</label
                            >
                            <input
                                class="form-control"
                                v-model="update_name"
                                placeholder="Enter Expencse Head Name"
                            />
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button
                            type="button"
                            class="btn btn-secondary"
                            @click="closeModal"
                        >
                            Close
                        </button>
                        <button
                            type="button"
                            class="btn btn-primary"
                            @click="handleSubmit('update')"
                            :isDisabled="isDisabled"
                        >
                            Update
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import axios from "axios";
import { onMounted, watchEffect, ref, toRefs } from "vue";
export default {
    props: {
        item_value: {
            type: Object,
            required: false,
        },
        closeModal: {
            type: Function,
            required: false,
        },
    },
    setup(props) {
        var name = ref();
        var update_name = ref("");
        var updateId = ref("");
        var isDisabled = ref(true);
        var selectCategory = ref("0");
        var updateSelectCategory = ref("0");
        var categories = ref([]);
        var GETVALUE = ref([]);

        watchEffect(() => {
            var { item_value } = toRefs(props);
            GETVALUE.value = item_value.value.split('-');
            updateSelectCategory.value = GETVALUE.value[2];
            update_name.value = GETVALUE.value[1];
            updateId.value = GETVALUE.value[0];
        });

        onMounted(() => {
            axios.get("/expense-income/category/fetch").then((res) => {
                categories.value = res.data.data;
            });
        });

        const handleSubmit = (type) => {
            if (type == "create") {
                axios
                    .post("/expense-income/head/create", {
                        name: name.value,
                        expIncomeCategoryId: selectCategory.value,
                    })
                    .then((response) => {
                        handleResponseRequest(response);
                    });
            } else {
                if (updateId.value == "") {
                    return false;
                }

                if( update_name.value == "") {
                    update_name.value = GETVALUE.value[1];
                }

                axios
                    .put("/expense-income/head/update", {
                        name: update_name.value,
                        expIncomeCategoryId: updateSelectCategory.value,
                        id: updateId.value,
                    })
                    .then((res) => {
                        handleResponseRequest(res);
                    });
            }
        };

        return {
            name,
            categories,
            selectCategory,
            handleSubmit,
            isDisabled,
            updateSelectCategory,
            update_name,
        };
    },
};
</script>

<style></style>
