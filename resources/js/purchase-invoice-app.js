import { createApp } from 'vue';


const invoice_app = createApp({});

import PurchaseInvoiceComponent from './components/purchase/invoice/PurchaseComponent.vue';
import ReturnInvoiceComponent from './components/purchase/invoice/ReturnComponent.vue';
invoice_app.component('purchase-invoice-component', PurchaseInvoiceComponent);
invoice_app.component('purchase-return-invoice-component', ReturnInvoiceComponent);
invoice_app.mount('#invoice_app');
