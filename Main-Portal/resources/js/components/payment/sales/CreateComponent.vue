<template>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <invoice-based-component></invoice-based-component>
                <customer-based-component></customer-based-component>
            </div>
        </div>
    </section>
</template>

<script>
import { ref } from "vue";
import InvoiceBasedComponent from "./InvoiceBasedComponent.vue";
import CustomerBasedComponent from "./CustomerBasedComponent.vue";
export default {
    components: {
        InvoiceBasedComponent,
        CustomerBasedComponent,
    },
    setup() {

        console.log('Invoice based component');
    },
};
</script>

<style></style>
