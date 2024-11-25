<template>
    <div class="card-body">
        <div v-if="pBasicInfoBox" class="row">
            <div class="card-text col-12 col-md-4">
                <b>Product Name:</b> <br />
                {{ product.name }}
            </div>
            <div class="card-text col-12 col-md-4">
                <b>Product category:</b> <br />
                {{ product.category.name }}
            </div>
            <div class="card-text col-12 col-md-4">
                <b>Product sub category:</b> <br />
                {{ product.sub_category.name }}
            </div>
        </div>
        <div v-else class="row">
            <div class="col-12 col-md-4">
                <div class="form-group">
                    <label for="productName" class="required"
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
            <div class="col-12 col-md-4">
                <div class="form-group">
                    <label for="selectCategory" class="required"
                        >Select a Category</label
                    >
                    <select
                        class="custom-select"
                        v-model="selectCategory"
                        id="selectCategory"
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
            </div>
            <div class="col-12 col-md-4">
                <div class="form-group">
                    <label for="selectCategory" class="required"
                        >Select a Sub Category</label
                    >
                    <select
                        class="custom-select"
                        v-model="selectSubCategory"
                        id="selectCategory"
                    >
                        <option
                            v-for="(item, index) in subCategories"
                            :value="item.id"
                            :key="index"
                        >
                            {{ item.name }}
                        </option>
                    </select>
                </div>
            </div>
        </div>

        <button
            v-if="pBasicInfoBox"
            class="btn btn-primary btn-sm mt-2"
            @click="pEditBasicInfoBtn('edit')"
        >
            <span><i class="fa-solid fa-pen-to-square"></i> Edit</span>
        </button>
        <div class="d-flex" v-else>
            <button
                class="btn btn-success btn-sm mt-2 mx-1"
                @click="pEditBasicInfoBtn('update')"
            >
                <span><i class="fa-solid fa-check"></i> Update</span>
            </button>
            <button
                class="btn btn-danger btn-sm mt-2 mx-1"
                @click="pEditBasicInfoBtn('cancel')"
            >
                <span><i class="fa-solid fa-xmark"></i> cancel</span>
            </button>
        </div>
    </div>
</template>

<script>
import { ref, toRefs } from "vue";
export default {
    props: {
        product: {
            required: true,
            type: Object,
        },
    },
    setup(props) {
        var { product } = toRefs(props);
        var pBasicInfoBox = ref(true);
        var productName = ref();
        var categories = ref([]);
        var subCategories = ref([]);
        var selectCategory = ref();
        var selectSubCategory = ref();

        const pEditBasicInfoBtn = (action) => {
            console.clear();
            pBasicInfoBox.value = !pBasicInfoBox.value;
            if (action == "edit") {
                fetchCategories();
                productName.value = product.value.name;
                selectCategory.value = product.value.category_id;
                selectSubCategory.value = product.value.sub_category_id;
            } else if (action == "cancel") {
                return false;
            } else {
                updateProductBasicInfo();
            }
        };

        const updateProductBasicInfo = () => {
            if (!productName.value) {
                Toastr.fire({
                    icon: "error",
                    title: "Product name is required",
                });
                return false;
            }
            axios
                .put(`/product/update/${product.value.id}?type=basic-info`, {
                    name: productName.value,
                    category_id: selectCategory.value,
                    sub_category_id: selectSubCategory.value,
                })
                .then((response) => {
                    const data = response.data.data;
                    product.value.name = data.name;
                    product.value.category_id = data.category_id;
                    product.value.sub_category_id = data.sub_category_id;
                    product.value.category.name = data.category.name;
                    product.value.sub_category.name = data.sub_category.name;
                    Toastr.fire({
                        icon: "success",
                        title: "Product successfully updated",
                    });
                });
        };

        const fetchCategories = () => {
            axios.get("/category/fetch?type=product-create").then((res) => {
                categories.value = res.data.data;

                categories.value.length > 0 &&
                    categories.value.map((item) => {
                        if (selectCategory.value == item.id) {
                            subCategories.value = item.subCategories;
                        }
                        console.log(subCategories.value);
                    });
            });

            // subCategories
        };

        return {
            pBasicInfoBox,
            productName,
            categories,
            subCategories,
            selectCategory,
            selectSubCategory,
            pEditBasicInfoBtn,
        };
    },
};
</script>

<style></style>
