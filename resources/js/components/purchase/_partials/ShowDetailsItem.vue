<template>
    <tr>
        <td>{{ index + 1 }}</td>
        <td>
            {{ item.product.name }}
            <br />
            {{ item.product_attribute.model }} -
            {{ item.product_attribute.size }} -
            {{ item.product_attribute.color }}
        </td>
        <td>
            <span v-if="isEdit">{{ item.qty }}</span>
            <input type="number" class="form-control" v-else v-model="qty" />
        </td>
        <td>
            <span v-if="isEdit">{{ item.purchase_rate }} tk</span>
            <input
                type="number"
                v-model="purchase_rate"
                class="form-control"
                v-else
            />
        </td>
        <td>
            {{ item.sales_rate }}
            tk
        </td>
        <td>
            <span v-if="isEdit">{{ item.discount }} tk</span>
            <input
                type="number"
                v-model="discount"
                class="form-control"
                v-else
            />
        </td>
        <td>{{ item.total }} tk</td>
    </tr>
</template>

<script>
import { ref, toRefs } from "vue";
export default {
    props: {
        item: {
            type: Object,
            required: true,
        },
        index: {
            type: Number,
            required: true,
        },
        fetchShowData: {
            type: Object,
            required: true,
        },
    },
    setup(props) {
        var isEdit = ref(true);
        var { item } = toRefs(props);
        var purchase_rate = ref(item.value.purchase_rate);
        var qty = ref(item.value.qty);
        var discount = ref(item.value.discount);
        return { isEdit, discount, purchase_rate, qty };
    },
};
</script>

<style></style>
