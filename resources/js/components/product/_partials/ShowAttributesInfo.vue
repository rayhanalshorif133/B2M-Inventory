<template>
    <div class="mx-4">
        <span class="py-3" v-for="item in productDetails" :key="item">
            <product-details-show-item :item="item"></product-details-show-item>
        </span>
        <span class="py-3" v-for="item in productDetailsNew" :key="item">
            <product-details-show-item :item="item"></product-details-show-item>
        </span>
        <div class="my-2">
            <div class="my-2 row" v-if="newItemAddedContainer">
                <div class="form-group col-md-3 col-12">
                    <label for="code" class="optional">Code</label>
                    <input
                        class="form-control"
                        id="code"
                        v-model="new_code"
                        placeholder="Enter product code"
                    />
                </div>
                <div class="form-group col-md-3 col-12">
                    <label for="code" class="optional">Size</label>
                    <input
                        class="form-control"
                        v-model="new_size"
                        placeholder="Enter product size"
                    />
                </div>
                <div class="form-group col-md-3 col-12">
                    <label for="code" class="optional">Model</label>
                    <input
                        class="form-control"
                        v-model="new_model"
                        placeholder="Enter product model"
                    />
                </div>
                <div class="form-group col-md-3 col-12">
                    <label for="code" class="optional">Color</label>
                    <input
                        class="form-control"
                        v-model="new_color"
                        placeholder="Enter product color"
                    />
                </div>
                <div class="form-group col-md-3 col-12">
                    <label for="code" class="optional">Current Stock</label>
                    <input
                        class="form-control"
                        v-model="new_current_stock"
                        placeholder="Enter current stock"
                    />
                </div>
                <div class="form-group col-md-3 col-12">
                    <label for="code" class="optional">Unit Cost</label>
                    <input
                        class="form-control"
                        v-model="new_unit_cost"
                        placeholder="Enter unit cost"
                    />
                </div>
                <div class="form-group col-md-3 col-12">
                    <label for="code" class="optional">Sales Rate</label>
                    <input
                        class="form-control"
                        v-model="new_sales_rate"
                        placeholder="Enter Sales Rate"
                    />
                </div>
                <div class="form-group col-md-3 col-12">
                    <label for="code" class="optional">Last Purchase</label>
                    <input
                        class="form-control"
                        v-model="new_last_purchase"
                        placeholder="Enter Last Purchase"
                    />
                </div>
            </div>
            <button
                v-if="!newItemAddedContainer"
                class="btn btn-sm btn-navy"
                @click="newItemAdd('add-new')"
            >
                <i class="fa fa-plus"></i> Added New
            </button>
            <div v-else>
                <button
                    class="btn btn-sm btn-success"
                    @click="newItemAdd('submit')"
                >
                    <i class="fa-solid fa-check"></i> Submit
                </button>
                <button
                    class="btn btn-sm btn-danger mx-2"
                    @click="newItemAdd('cancel')"
                >
                    <i class="fa-solid fa-xmark"></i> Cancel
                </button>
            </div>
        </div>
    </div>
</template>

<script>
import { ref, toRefs } from "vue";
import productDetailsShowItem from "./productDetailsShowItem.vue";
export default {
    components: {
        productDetailsShowItem,
    },
    props: {
        productDetails: {
            required: true,
            type: Object,
        },
        product_id:{
            required: true,
            type: String,
        }
    },
    setup(props) {
        var { product_id, productDetails } = toRefs(props);
        var newItemAddedContainer = ref(false);
        var productDetailsNew = ref([]);
        var new_code = ref();
        var new_size = ref();
        var new_model = ref();
        var new_color = ref();
        var new_current_stock = ref();
        var new_unit_cost = ref();
        var new_sales_rate = ref();
        var new_last_purchase = ref();

        const newItemAdd = (action) => {
            newItemAddedContainer.value = !newItemAddedContainer.value;
            if (action == "submit") {
                const data = {
                    code: new_code.value,
                    size: new_size.value,
                    model: new_model.value,
                    color: new_color.value,
                    current_stock: new_current_stock.value,
                    unit_cost: new_unit_cost.value,
                    sales_rate: new_sales_rate.value,
                    last_purchase: new_last_purchase.value,
                };

                axios
                    .put(`/product/update/${product_id.value}?type=new-added`, data)
                    .then((response) => {
                        const data = response.data.data;
                        productDetailsNew.value = [...productDetailsNew.value, data];

                        Toastr.fire({
                            icon: "success",
                            title: "Product successfully updated",
                        });
                    });
            }
        };

        return {
            newItemAddedContainer,
            new_code,
            new_size,
            new_model,
            new_color,
            new_current_stock,
            new_unit_cost,
            new_sales_rate,
            new_last_purchase,
            productDetailsNew,
            newItemAdd,
        };
    },
};
</script>

<style></style>
