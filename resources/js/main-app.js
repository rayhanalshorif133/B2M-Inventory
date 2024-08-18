
import { createApp } from 'vue';


const app = createApp({});


// Authenticated components
import NavBarComponent from './components/partials/NavBarComponent.vue';
import SideBarComponent from './components/partials/SideBarComponent.vue';
import BreadcrumbComponent from './components/partials/BreadcrumbComponent.vue';
import DashboardComponent from './components/DashboardComponent.vue';
import FooterComponent from './components/partials/FooterComponent.vue';
import TransactionTypeListComponent from './components/transaction-type/ListComponent.vue';

app.component('nav-bar-component', NavBarComponent);
app.component('side-bar-component', SideBarComponent);
app.component('breadcrumb-component', BreadcrumbComponent);

// single component
app.component('dashboard-component', DashboardComponent);
app.component('transaction-type-list-component', TransactionTypeListComponent);

// user
import UserCreateComponent from './components/user/UserCreateComponent.vue';
import UserListComponent from './components/user/UserListComponent.vue';
app.component('user-list-component', UserListComponent);
app.component('user-create-component', UserCreateComponent);

// category
import CategoryCreateComponent from './components/category/CreateComponent.vue';
import CategoryListComponent from './components/category/ListComponent.vue';

app.component('category-create-component', CategoryCreateComponent);
app.component('category-list-component', CategoryListComponent);


// Product
import ProductCreateComponent from './components/product/CreateComponent.vue';
import ProductListComponent from './components/product/ListComponent.vue';
app.component('product-create-component', ProductCreateComponent);
app.component('product-list-component', ProductListComponent);

// Purchase
import PurchaseCreateComponent from './components/purchase/CreateComponent.vue';
import PurchasePaymentListComponent from './components/purchase/PaymentListComponent.vue';
import PurchaseListComponent from './components/purchase/ListComponent.vue';
app.component('purchase-create-component', PurchaseCreateComponent);
app.component('purchase-list-component', PurchaseListComponent);
app.component('purchase-payment-list-component', PurchasePaymentListComponent);

// purchase-payment-create-component
import PurchasePaymentCreateComponent from './components/payment/purchases/CreateComponent.vue';
app.component('purchase-payment-create-component', PurchasePaymentCreateComponent);


app.component('footer-component', FooterComponent);


import TestComponent from './components/Test.vue';
app.component('test-component', TestComponent);
app.mount('#app');


