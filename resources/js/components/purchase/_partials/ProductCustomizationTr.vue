<template>
    <tr>
        <td>
            <button
                type="button"
                class="btn btn-sm btn-danger"
                @click="removeItem(productCustomization.id)"
            >
                <i class="fa fa-minus"></i>
            </button>
        </td>
        <td>
            {{ productCustomization.code }}
            <span v-if="productCustomization.product_name">-</span>
            {{ productCustomization.product_name }}
            <br />
            <small>
                {{ productCustomization.model }}
                <span v-if="productCustomization.color">-</span>
                {{ productCustomization.color }}
                <span v-if="productCustomization.size">-</span>
                {{ productCustomization.size }}
            </small>
        </td>
        <td>
            <input
                type="number"
                class="form-control"
                :value="productCustomization.qty"
                :id="productCustomization.id"
                @input="GETQtyInputValue"
            />
        </td>
        <td>
            <input
                type="number"
                class="form-control"
                :value="productCustomization.purchase_price"
                :id="productCustomization.id"
                @input="GETPurchasePriceInputValue"
            />
        </td>
        <td>
            <input
                type="number"
                class="form-control"
                :value="productCustomization.sales_price"
                :id="productCustomization.id"
                @input="GETSalesPriceInputValue"
            />
        </td>
        <td>
            <input
                type="number"
                class="form-control"
                :class="productCustomization.discount_input_class"
                :value="productCustomization.discount"
                :id="productCustomization.id"
                @input="GETDiscountInputValue"
            />
        </td>
        <td>{{ productCustomization.total }}</td>
    </tr>
</template>

<script>
import { onMounted, ref, toRefs } from "vue";
export default {
    props: {
        productCustomization: {
            type: Object,
        },
        purchase_price_input:{
            type: Number,
        },
        removeItem: {
            type: Function,
        },
        updateCustomizationData:{
            type: Function,
        },
        GETQtyInputValue:{
            type: Function,
        },
        GETPurchasePriceInputValue:{
            type: Function,
        },
        GETDiscountInputValue:{
            type: Function,
        },
        GETSalesPriceInputValue:{
            type: Function,
        }
    },

    setup(props) {
        var discount_input = ref(0);
        var total_price = ref(0);
        var sales_price_input = ref(0);
        var input_quantity = ref(0);
        var inputOutlineInvalidClass = ref("");

        const { productCustomization } = toRefs(props);

        onMounted(() => {
            setInitailValue();
        });





        const setInitailValue = () => {

            sales_price_input.value = parseFloat(
                productCustomization.value.sales_price
            );

            total_price.value = productCustomization.value.total;
        };

        const calculateTotal = () => {
            if (purchase_price_input.value > discount_input.value) {
                total_price.value =
                    (purchase_price_input.value - discount_input.value) *
                    qtyInput.value;
                inputOutlineInvalidClass.value = "";
            } else {
                inputOutlineInvalidClass.value = "form-control-red";
                Toastr.fire({
                    icon: "error",
                    title: "Discount price is not larger than Purchases Price!",
                });
            }
        };



        return {
            discount_input,
            total_price,
            calculateTotal,
            input_quantity,
            sales_price_input,
            inputOutlineInvalidClass,
        };
    },
};
</script>

<style></style>
