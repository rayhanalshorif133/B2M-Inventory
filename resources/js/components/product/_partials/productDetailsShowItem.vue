<template>
    <div class="mt-2">
        <div v-if="showEditBtn">
            <div class="d-flex justify-content-between px-2">
                <p><b>Code:</b> {{ item.code }}</p>
                <p><b>Size:</b> {{ item.size }}</p>
                <p><b>Model:</b> {{ item.model }}</p>
                <p><b>Color:</b> {{ item.color }}</p>
            </div>
            <div class="d-flex justify-content-between px-2">
                <p><b>Current Stock:</b> {{ item.current_stock }}</p>
                <p><b>Unit Cost:</b> {{ item.unit_cost }}</p>
                <p><b>Sales Rate:</b> {{ item.sales_rate }}</p>
                <p><b>Last Purchase:</b> {{ item.last_purchase }}</p>
            </div>
        </div>
        <div v-else class="row p-2">
            <div class="form-group col-md-3 col-12">
                <label for="code" class="optional">Code</label>
                <input
                    class="form-control"
                    id="code"
                    v-model="update_code"
                    placeholder="Enter product code"
                />
            </div>
            <div class="form-group col-md-3 col-12">
                <label for="code" class="optional">Size</label>
                <input
                    class="form-control"
                    v-model="update_size"
                    placeholder="Enter product code"
                />
            </div>
            <div class="form-group col-md-3 col-12">
                <label for="code" class="optional">Model</label>
                <input
                    class="form-control"
                    v-model="update_model"
                    placeholder="Enter product code"
                />
            </div>
            <div class="form-group col-md-3 col-12">
                <label for="code" class="optional">Color</label>
                <input
                    class="form-control"
                    v-model="update_color"
                    placeholder="Enter product code"
                />
            </div>
            <div class="form-group col-md-3 col-12">
                <label for="code" class="optional">Sales Rate</label>
                <input
                    class="form-control"
                    v-model="update_sales_rate"
                    placeholder="Enter product code"
                />
            </div>
        </div>

        <button
            v-if="showEditBtn"
            @click="editAndUpdateBtn('edit')"
            class="btn btn-primary btn-sm mt-2"
        >
            <span><i class="fa-solid fa-pen-to-square"></i> Edit</span>
        </button>
        <div class="d-flex" v-else>
            <button
                class="btn btn-success btn-sm mt-2"
                @click="editAndUpdateBtn('update')"
            >
                <span><i class="fa-solid fa-check"></i> Update</span>
            </button>
            <button
                class="btn btn-danger btn-sm mt-2 mx-1"
                @click="editAndUpdateBtn('cancel')"
            >
                <span><i class="fa-solid fa-xmark"></i> cancel</span>
            </button>
        </div>
        <hr />
    </div>
</template>

<script>
import { ref, toRefs } from "vue";
export default {
    props: {
        item: {
            required: true,
            type: Object,
        },
    },
    setup(props) {
        var { item } = toRefs(props);
        var showEditBtn = ref(true);
        var update_code = ref("");
        var update_size = ref("");
        var update_model = ref("");
        var update_color = ref("");
        var update_current_stock = ref("");
        var update_unit_cost = ref("");
        var update_sales_rate = ref("");
        var update_last_purchase = ref("");

        const editAndUpdateBtn = (action) => {
            showEditBtn.value = !showEditBtn.value;


            if (action == "edit") {
                update_code.value = item.value.code;
                update_size.value = item.value.size;
                update_model.value = item.value.model;
                update_color.value = item.value.color;
                update_current_stock.value = item.value.current_stock;
                update_unit_cost.value = item.value.unit_cost;
                update_sales_rate.value = item.value.sales_rate;
                update_last_purchase.value = item.value.last_purchase;
                return false;
            }else if(action == "cancel"){
                return false;
            }else{
                const data = {
                    code: update_code.value,
                    size: update_size.value,
                    model: update_model.value,
                    color: update_color.value,
                    sales_rate: update_sales_rate.value,
                };
                axios
                    .put(
                        `/product/update/${item.value.id}?type=attr-info`,
                        data
                    )
                    .then((response) => {
                        const data = response.data.data;
                        item.value.code = data.code;
                        item.value.size = data.size;
                        item.value.model = data.model;
                        item.value.color = data.color;
                        item.value.sales_rate = data.sales_rate;
                        Toastr.fire({
                            icon: "success",
                            title: "Product successfully updated",
                        });
                    });
            }
        };

        return {
            showEditBtn,
            update_code,
            update_size,
            update_model,
            update_color,
            update_current_stock,
            update_unit_cost,
            update_sales_rate,
            update_last_purchase,
            editAndUpdateBtn,
        };
    },
};
</script>

<style></style>
