<template>
    <div
        class="modal fade"
        id="showProductDetails"
        tabindex="-1"
        aria-labelledby="showProductDetailsLabel"
        aria-hidden="true"
    >
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="showProductDetailsLabel">
                        Product Details
                    </h5>
                    <button
                        type="button"
                        class="btn-close"
                        @click="closeModal"
                    ></button>
                </div>
                <div class="modal-body">
                    <div class="card card-navy" v-if="productData">
                        <h5 class="card-header">Product Details</h5>
                        <show-attributes-info
                            :productDetails="productData.ProductAttributes"
                            :product_id="productData.product.id"
                        ></show-attributes-info>
                    </div>
                </div>
                <div class="modal-footer">
                    <button
                        type="button"
                        class="btn btn-secondary text-white"
                        @click="closeModal"
                    >
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { ref, toRefs, onMounted } from "vue";
import ShowBasicInfo from "./_partials/ShowBasicInfo.vue";
import ShowAttributesInfo from "./_partials/ShowAttributesInfo.vue";
export default {
    components: {
        ShowBasicInfo,
        ShowAttributesInfo,
    },

    props: {
        productData: {
            required: true,
            type: Object,
        },
        closeModal: {
            required: true,
            type: Function,
        }
    },
    setup(props) {


    },
};
</script>

<style></style>
