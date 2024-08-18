<template>
    <section class="content overflow-x-hidden">
        <div class="row">
            <div class="col-md-12">
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Create a new Product</h3>
                    </div>
                    <div class="card-body">
                        <form>
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
                                            @change="handleSelectCategory"
                                        >
                                            <option value="" selected disabled>
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
                                            for="selectCategory"
                                            class="required"
                                            >Select a Subcategory</label
                                        >
                                        <select
                                            class="custom-select"
                                            id="selectCategory"
                                        >
                                            <option value="" selected disabled>
                                                Choice a Subcategory
                                            </option>
                                            <option
                                                v-for="(
                                                    item, index
                                                ) in subCategories"
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
                                    :addNewVarientBtn="addNewVarientBtn"
                                    :productDetailsBucket="productDetailsInfos"
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
                                        :productDetailsBucket="productDetailsInfos"
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
                </div>
            </div>
        </div>
    </section>
</template>

<script>
import { onMounted, ref } from "vue";
import AddNewDetailsComponent from "./AddNewDetailsComponent.vue";
export default {
    components: {
        AddNewDetailsComponent,
    },
    setup() {
        var categories = ref([]);
        var subCategories = ref("");
        var selectCategory = ref("");
        var productDetailsInfos = ref([]);
        var code_check_status = ref("d-none");
        var code_check_msg = ref("");
        var submitBtnStatus = ref(false);
        var insertNewDetails = ref([]);
        var inputedCode = ref([]);

        // model
        var productName = ref("");

        var newDetailsAddedCounter = ref(0);

        // new added details
        var code = ref([]);

        onMounted(() => {
            fetchCategories();
        });

        const fetchCategories = () => {
            axios.get("/category/fetch").then((res) => {
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
            if(productName.value == "" || selectCategory.value == "" || subCategories.value == "") {
                Toastr.fire({
                     icon: 'error',
                     title: 'Product Name and Category are required',
                 });
                 return false;
            }


            const data = {
                productName: productName.value,
                category_id: selectCategory.value,
                sub_category_id: selectCategory.value,
                productDetailsInfos: productDetailsInfos.value
            };

            axios.post("/product/create", data).then(function (response) {
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

        return {
            handleSubmit,
            categories,
            selectCategory,
            handleSelectCategory,
            subCategories,
            productName,
            addNewVarientBtn,
            productDetailsInfos,
            code_check_status,
            code_check_msg,
            code,
            inputedCode,
            submitBtnStatus,
            insertNewDetails,
            newDetailsAddedCounter,
        };
    },
};
</script>
