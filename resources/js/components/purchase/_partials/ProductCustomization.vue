<template>
    <div class="col-12 col-lg-8 col-md-12">
        <div class="card card-success">
            <div class="card-header">Product Customization</div>
            <div class="card-body">
                <table class="table table-striped table-bordered">
                    <thead>
                        <th>#</th>
                        <th>Particulars</th>
                        <th>Qty</th>
                        <th class="text-center">Rate <br/> <small>Purchases</small></th>
                        <th class="text-center">Rate <br/> <small>Sales</small></th>
                        <th>Discount</th>
                        <th>Total</th>
                    </thead>
                    <tbody>
                        <product-customization-tr
                            v-for="productCustomization in productCustomizations"
                            :key="productCustomization.id"
                            :productCustomization="productCustomization"
                            :removeItem="removeItem"
                            :qtyInput="qty_input[1]"
                        ></product-customization-tr>
                    </tbody>
                    <tfoot>
                        <td colspan="2" class="bg-success text-end">Total</td>
                        <td class="bg-success text-center">{{ total_stock }}</td>
                        <td class="bg-success text-center">12029</td>
                        <td class="bg-success text-center"></td>
                        <td class="bg-success text-center"></td>
                        <td class="bg-success text-center">12029</td>
                    </tfoot>
                </table>
                <div class="d-flex justify-content-end mt-1">
                    <div class="d-flex flex-column">
                        <div class="d-flex">
                            <label class="mt-2 mx-2 w-8rem">Sub:</label>
                            <input
                                type="text"
                                class="form-control"
                                placeholder="Enter sub amount"
                            />
                        </div>
                        <div class="d-flex mt-1">
                            <label class="mt-2 mx-2 w-8rem">Grand Total:</label>
                            <h4
                                class="text-semibold font-base text-green grand-total"
                            >
                                28203 /=
                            </h4>
                        </div>
                        <div class="d-flex mt-1">
                            <div>
                                <label class="w-8rem">Transaction Type</label>
                                <select
                                    class="form-control w-fit"
                                    id="supplier"
                                    name="supplier"
                                >
                                    <option value="" selected disabled>
                                        Transaction Type
                                    </option>
                                    <option value="1">Name 1</option>
                                    <option value="1">Name 2</option>
                                </select>
                            </div>
                            <div class="mx-2">
                                <label class="mx-2 w-8rem">Amount</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    placeholder="Paid amount"
                                />
                            </div>
                        </div>
                        <div class="d-flex mt-1 justify-content-end">
                            <button
                                class="btn btn-success btn-sm"
                                type="button"
                            >
                                Submit
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { onMounted, toRefs, ref } from "vue";
import ProductCustomizationTr from "./ProductCustomizationTr.vue";
export default {
    components: {
        ProductCustomizationTr,
    },
    props: {
        productCustomizations: {
            type: Array,
        },
        removeItem:{
            type:Function
        },
        qty_input:{
            type:Array
        }
    },

    setup(props) {
        const total_stock = ref(0);
        return {total_stock};
    },
};
</script>
