import { createApp } from 'vue';


const pay_slip = createApp({});

import PaySlipComponent from './components/purchase/PaySlipComponent.vue';
pay_slip.component('purchase-pay-slip-component', PaySlipComponent);
pay_slip.mount('#purchasePaySlipApp');
