<template>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <invoice-based-component></invoice-based-component>
                <supplier-based-component></supplier-based-component>
            </div>
        </div>
    </section>
</template>

<script>
import { ref } from "vue";
import InvoiceBasedComponent from "./InvoiceBasedComponent.vue";
import SupplierBasedComponent from "./SupplierBasedComponent.vue";
export default {
    components: {
        InvoiceBasedComponent,
        SupplierBasedComponent,
    },
    setup() {

        console.log('Invoice based component');
    },
};
</script>

<style></style>
