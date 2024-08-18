import { createApp } from 'vue';


const invoice_app = createApp({});

import PurchaseInvoiceComponent from './components/purchase/InvoiceComponent.vue';
invoice_app.component('purchase-invoice-component', PurchaseInvoiceComponent);
invoice_app.mount('#invoice_app');
