<template>
    <div class="col-md-12 col-lg-4">
        <div class="card card-navy">
            <div class="card-header">Product Details</div>
            <div class="card-body">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th colspan="4" class="text-center text-capitalize">
                                {{ product_name }}
                            </th>
                        </tr>
                        <tr>
                            <th>Attribute</th>
                            <th>Sales Rate</th>
                            <th>Stock</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="item in productAttributes" :key="item.id">
                            <td>
                                <small class="text-xs font-semibold" >{{
                                    item.code
                                }}</small>
                                <br :v-if="item.code"/>
                                <small class="text-xs font-semibold">{{
                                    item.color
                                }}</small>
                                <br v-if="item.color" />
                                <small class="text-xs font-semibold">{{
                                    item.model
                                }}</small>
                                <br v-if="item.model"/>
                                <small class="text-xs font-semibold">{{
                                    item.size
                                }}</small>
                            </td>
                            <td>{{ item.sales_rate }}</td>
                            <td>{{ item.current_stock }}</td>
                            <td>
                                <button
                                    type="button"
                                    class="btn btn-sm btn-success"
                                    @click="addToCustomization(item.id)"
                                >
                                    Add
                                    <i class="fa fa-plus"></i>
                                </button>
                            </td>
                        </tr>
                        <tr v-if="productAttributes.length == 0">
                            <td
                                colspan="4"
                                class="text-center text-danger font-semibold"
                            >
                                Not Found
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
import { ref, toRefs, reactive } from "vue";
export default {
    props: {
        productAttributes: {
            type: Array,
        },
        productCustomizations: {
            type: Array,
        },
        product_name: {
            type: String,
        },
        productAddedQty:{
            type: Object,
        }

    },
    setup(props) {
        const { productCustomizations,productAddedQty } = toRefs(props);
        const addToCustomization = (attrb_id) => {
            axios
                .get(`/product/fetch-attribute?product_attribute_id=${attrb_id}`)
                .then((response) => {
                    const data = response.data.data;

                    var has_customizations = productCustomizations.value.find((item) => item.id == data.id);
                    if(has_customizations){
                        productAddedQty.value(data.id)
                    }else{
                        const customizations = {
                            id: data.id,
                            code: data.code,
                            product_name: data.product.name,
                            product_id: data.product.id,
                            model: data.model,
                            color: data.color,
                            size: data.size,
                            qty: 0,
                            purchase_price: data.last_purchase ? data.last_purchase : 0,
                            sales_price: data.sales_rate? data.sales_rate: 0,
                            discount: 0,
                            total : 0,
                            discount_input_class : '',
                        };
                        productCustomizations.value.push(customizations);

                    }
                });
        };

        return {
            addToCustomization,
        };
    },
};
</script>

<style></style>
