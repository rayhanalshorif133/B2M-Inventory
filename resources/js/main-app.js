
import { createApp } from 'vue';

import { createVuetify } from 'vuetify';
import 'vuetify/styles';
import { aliases, mdi } from 'vuetify/iconsets/mdi-svg';


const vuetify = createVuetify({
    icons: {
      defaultSet: 'mdi',
      aliases,
      sets: {
        mdi,
      },
    },
  });

const app = createApp({});

app.use(vuetify);


// Authenticated components
import NavBarComponent from './components/partials/NavBarComponent.vue';
import SideBarComponent from './components/partials/SideBarComponent.vue';
import TipsSkipComponent from './components/partials/TipsSkipComponent.vue';
import BreadcrumbComponent from './components/partials/BreadcrumbComponent.vue';
import DashboardComponent from './components/DashboardComponent.vue';
import FooterComponent from './components/partials/FooterComponent.vue';
import TransactionTypeListComponent from './components/transaction-type/ListComponent.vue';

app.component('nav-bar-component', NavBarComponent);
app.component('side-bar-component', SideBarComponent);
app.component('breadcrumb-component', BreadcrumbComponent);
app.component('tips-skip-component', TipsSkipComponent);

// single component
app.component('dashboard-component', DashboardComponent);
app.component('transaction-type-list-component', TransactionTypeListComponent);

// user
import UserCreateComponent from './components/user/UserCreateComponent.vue';
import UserListComponent from './components/user/UserListComponent.vue';
import UserProfileComponent from './components/user/UserProfileComponent.vue';
app.component('user-list-component', UserListComponent);
app.component('user-create-component', UserCreateComponent);
app.component('user-profile-component', UserProfileComponent);

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
import PurchaseListComponent from './components/purchase/ListComponent.vue';
import PurchaseEditComponent from './components/purchase/EditComponent.vue';

app.component('purchase-create-component', PurchaseCreateComponent);
app.component('purchase-list-component', PurchaseListComponent);
app.component('purchase-edit-component', PurchaseEditComponent);



// purchase return
import ReturnListComponent from './components/purchase/return/ListComponent.vue';
import ReturnCreateComponent from './components/purchase/return/CreateComponent.vue';
import ReturnEditComponent from './components/purchase/return/EditComponent.vue';

app.component('purchase-return-list-component', ReturnListComponent);
app.component('purchase-return-create-component', ReturnCreateComponent);
app.component('purchase-return-edit-component', ReturnEditComponent);



// purchase-payment-create-component
import PurchasePaymentCreateComponent from './components/payment/purchases/CreateComponent.vue';
import PurchasePaymentListComponent from './components/payment/purchases/PaymentListComponent.vue';
import PurchaseDueCollectionComponent from './components/payment/purchases/DueCollectionComponent.vue';
app.component('purchase-payment-create-component', PurchasePaymentCreateComponent);
app.component('purchase-payment-list-component', PurchasePaymentListComponent);
app.component('purchase-due-collection-component', PurchaseDueCollectionComponent);



// Sales
import SalesCreateComponent from './components/sales/CreateComponent.vue';
import SalesListComponent from './components/sales/ListComponent.vue';
import SalesEditComponent from './components/sales/EditComponent.vue';

app.component('sales-create-component', SalesCreateComponent);
app.component('sales-list-component', SalesListComponent);
app.component('sales-edit-component', SalesEditComponent);


// sales-payment-create-component
import SalesPaymentCreateComponent from './components/payment/sales/CreateComponent.vue';
import SalesPaymentListComponent from './components/payment/sales/PaymentListComponent.vue';
import SalesDueCollectionComponent from './components/payment/sales/DueCollectionComponent.vue';
app.component('sales-payment-create-component', SalesPaymentCreateComponent);
app.component('sales-payment-list-component', SalesPaymentListComponent);
app.component('sales-due-collection-component', SalesDueCollectionComponent);


// payment-edit-component
import PaymentEditComponent from './components/payment/EditComponent.vue';
app.component('payment-edit-component', PaymentEditComponent);



// sales return
import SalesReturnListComponent from './components/sales/return/ListComponent.vue';
import SalesReturnCreateComponent from './components/sales/return/CreateComponent.vue';
import SalesReturnEditComponent from './components/sales/return/EditComponent.vue';
app.component('sales-return-list-component', SalesReturnListComponent);
app.component('sales-return-create-component', SalesReturnCreateComponent);
app.component('sales-return-edit-component', SalesReturnEditComponent);



/* <--- Expenses Income ---> */

// Categories
import ExpencseCategoryListComponent from './components/expenses-income/category/ListComponent.vue'
app.component('expencse-category-list-component', ExpencseCategoryListComponent);


// Head
import ExpencseHeadListComponent from './components/expenses-income/head/ListComponent.vue'
app.component('expencse-head-list-component', ExpencseHeadListComponent);

// Entry
import ExpencseIncomeListComponent from './components/expenses-income/ListComponent.vue'
app.component('expencse-income-list-component', ExpencseIncomeListComponent);


// Report components
import ReportCurrentStockComponent from './components/report/CurrentStockComponent.vue';
import ReportProfitLossComponent from './components/report/ProfitLossComponent.vue';
app.component('report-current-stock-component', ReportCurrentStockComponent);
app.component('report-profit-loss-component', ReportProfitLossComponent);


// For Purchase
import ReportPurchaseComponent from './components/report/purchase/IndexComponent.vue';
import ReportPurchaseComponentReturn from './components/report/purchase/ReturnComponent.vue';
import ReportPurchaseComponentPayment from './components/report/purchase/PaymentComponent.vue';

app.component('report-purchase-component', ReportPurchaseComponent);
app.component('report-purchase-return-component', ReportPurchaseComponentReturn);
app.component('report-purchase-payment-component', ReportPurchaseComponentPayment);

//  For Sales
import ReportSalesComponent from './components/report/sales/IndexComponent.vue';
import ReportSalesComponentReturn from './components/report/sales/ReturnComponent.vue';
import ReportSalesComponentPayment from './components/report/sales/PaymentComponent.vue';

app.component('report-sales-component', ReportSalesComponent);
app.component('report-sales-return-component', ReportSalesComponentReturn);
app.component('report-sales-payment-component', ReportSalesComponentPayment);


// customer
import CustomerListComponent from './components/customer/IndexComponent.vue';
import LedgerComponent from './components/customer/LedgerComponent.vue';
app.component('customer-list-component', CustomerListComponent);
app.component('customer-ledger-component', LedgerComponent);

// supplier
import SupplierListComponent from './components/supplier/IndexComponent.vue';
app.component('supplier-list-component', SupplierListComponent);




app.component('footer-component', FooterComponent);


import TestComponent from './components/Test.vue';
app.component('test-component', TestComponent);
app.mount('#app');

