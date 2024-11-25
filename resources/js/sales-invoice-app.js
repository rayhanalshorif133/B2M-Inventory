import { createApp } from 'vue';


const sales_invoice_app = createApp({});

import SalesInvoiceComponent from './components/sales/invoice/SalesComponent.vue';
import SalesReturnInvoiceComponent from './components/sales/invoice/ReturnComponent.vue';
sales_invoice_app.component('sales-invoice-component', SalesInvoiceComponent);
sales_invoice_app.component('sales-return-invoice-component', SalesReturnInvoiceComponent);
sales_invoice_app.mount('#sales_invoice_app');
