import { createApp } from 'vue';


const sales_pay_slip = createApp({});

import PaySlipComponent from './components/sales/PaySlipComponent.vue';
sales_pay_slip.component('sales-pay-slip-component', PaySlipComponent);
sales_pay_slip.mount('#salesPaySlipApp');
