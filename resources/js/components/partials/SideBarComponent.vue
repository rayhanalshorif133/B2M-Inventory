<template>
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <a href="/home" class="brand-link underline-none">
            <img
                :src="companyLogo"
                alt="AdminLTE Logo"
                class="brand-image img-circle elevation-3"
            />
            <span class="brand-text font-weight-light">Inventory</span>
        </a>

        <div class="sidebar">
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <img
                        :src="userImage"
                        class="img-circle elevation-2"
                        alt="User Image"
                    />
                </div>
                <div class="info">
                    <a
                        href="/user/profile"
                        class="d-block underline-none"
                        >{{ userName }}</a
                    >
                </div>
            </div>

            <div class="form-inline">
                <div class="input-group" data-widget="sidebar-search">
                    <input
                        class="form-control form-control-sidebar text-white"
                        type="search"
                        placeholder="Search"
                        aria-label="Search"
                    />
                    <div class="input-group-append">
                        <button class="btn btn-sidebar">
                            <i class="fas fa-search fa-fw"></i>
                        </button>
                    </div>
                </div>
            </div>

            <nav class="mt-2">
                <ul
                    class="nav nav-pills nav-sidebar flex-column"
                    data-widget="treeview"
                    role="menu"
                    data-accordion="false"
                >
                    <li class="nav-item menu-open">
                        <a href="/home" :class="setNavLink('/home')">
                            <i
                                class="nav-icon text-cyan fas fa-tachometer-alt"
                            ></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                    <li
                        :class="
                            isMenuOpen([
                                '/sales/return/list',
                                '/sales/create',
                                '/sales/*/edit/',
                                '/sales/return/*/edit/',
                                '/sales/list',
                                '/payment/sales/pay',
                                '/sales/payment-list',
                                '/sales/return/create',
                                '/sales/due-amount',
                            ])
                        "
                    >
                        <a
                            href="#"
                            :class="setNavLink('/sales/create')"
                        >
                            <i
                                class="text-cyan nav-icon fa-solid fa-hand-holding-dollar"
                            ></i>
                            <p>
                                Sales
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li :class="setNavItem('/sales/create')">
                                <a
                                    href="/sales/create"
                                    :class="setNavLink('/sales/create')"
                                >
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>New Sales</p>
                                </a>
                            </li>
                            <li
                                :class="
                                    setNavItem('/sales/list') ||
                                    setNavItem('/sales/*/edit')
                                "
                            >
                                <a
                                    href="/sales/list"
                                    :class="
                                        setNavLink('/sales/list') ||
                                        setNavLink('/sales/*/edit')
                                    "
                                >
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Sales List</p>
                                </a>
                            </li>
                            <li :class="setNavItem('/sales/return/create')">
                                <a
                                    href="/sales/return/create"
                                    :class="setNavLink('/sales/return/create')"
                                >
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>New Sales Return</p>
                                </a>
                            </li>
                            <li :class="setNavItem('/sales/return/list')">
                                <a
                                    href="/sales/return/list"
                                    :class="setNavLink('/sales/return/list')"
                                >
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Sales Return List</p>
                                </a>
                            </li>
                            <li :class="setNavItem('/sales/due-amount')">
                                <a
                                    href="/sales/due-amount"
                                    :class="setNavLink('/sales/due-amount')"
                                >
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Sales Due Amount</p>
                                </a>
                            </li>
                            <li :class="setNavItem('/payment/sales/pay')">
                                <a
                                    href="/payment/sales/pay"
                                    :class="setNavLink('/payment/sales/pay')"
                                >
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>New Sales Payment</p>
                                </a>
                            </li>

                            <li :class="setNavItem('/sales/payment-list')">
                                <a
                                    href="/sales/payment-list"
                                    :class="setNavLink('/sales/payment-list')"
                                >
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Sales Payment List</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li
                        :class="
                            isMenuOpen([
                                '/purchase/return/list',
                                '/purchase/create',
                                '/purchase/*/edit/',
                                '/purchase/return/*/edit/',
                                '/purchase/list',
                                '/payment/purchase/pay',
                                '/purchase/payment-list',
                                '/purchase/return/create',
                                '/purchase/due-amount',
                            ])
                        "
                    >
                        <a href="#" :class="setNavLink('/purchase/create')" id="sidebar_open_purchase">
                            <i
                                class="text-cyan nav-icon fa-solid fa-cart-shopping"
                            ></i>
                            <p>
                                Purchase
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li :class="setNavItem('/purchase/create')">
                                <a
                                    :href="tour_ongoing? '/purchase/create?tour=going' : '/purchase/create'"
                                    :class="setNavLink('/purchase/create')"
                                >
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>New Purchase</p>
                                </a>
                            </li>
                            <li
                                :class="
                                    setNavItem('/purchase/list') ||
                                    setNavItem('/purchase/*/edit')
                                "
                            >
                                <a
                                    :href="tour_ongoing? '/purchase/list?tour=going' : '/purchase/list'"
                                    :class="
                                        setNavLink('/purchase/list') ||
                                        setNavLink('/purchase/*/edit')
                                    "
                                >
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Purchase List</p>
                                </a>
                            </li>
                            <li :class="setNavItem('/purchase/return/create')">
                                <a
                                    :href="tour_ongoing? '/purchase/return/create?tour=going' : '/purchase/return/create'"
                                    :class="
                                        setNavLink('/purchase/return/create')
                                    "
                                >
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>New Purchase Return</p>
                                </a>
                            </li>
                            <li :class="setNavItem('/purchase/return/list')">
                                <a
                                    :href="tour_ongoing? '/purchase/return/list?tour=going' : '/purchase/return/list'"
                                    :class="setNavLink('/purchase/return/list')"
                                >
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Purchase Return List</p>
                                </a>
                            </li>
                            <li :class="setNavItem('/purchase/due-amount')">
                                <a
                                    :href="tour_ongoing? '/purchase/due-amount?tour=going' : '/purchase/due-amount'"
                                    :class="setNavLink('/purchase/due-amount')"
                                >
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Purchase Due Amount</p>
                                </a>
                            </li>
                            <li :class="setNavItem('/payment/purchase/pay')">
                                <a
                                    :href="tour_ongoing? '/payment/purchase/pay?tour=going' : '/payment/purchase/pay'"
                                    :class="setNavLink('/payment/purchase/pay')"
                                >
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>New Purchase Payment</p>
                                </a>
                            </li>

                            <li :class="setNavItem('/purchase/payment-list')">
                                <a
                                    :href="tour_ongoing? '/purchase/payment-list?tour=going' : '/purchase/payment-list'"
                                    :class="
                                        setNavLink('/purchase/payment-list')
                                    "
                                >
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Purchase Payment List</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li
                        :class="
                            isMenuOpen([
                                '/expense-income/',
                                '/expense-income/',
                                '/expense-income/category',
                                '/expense-income/head',
                                '/expense-income',
                            ])
                        "
                    >
                        <a href="#" :class="setNavLink('/expense-income/')">
                            <i
                                class="nav-icon text-cyan fa-solid fa-money-bill-transfer"
                            ></i>
                            <p>
                                Expense and Income
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li :class="setNavItem('/expense-income/')">
                                <a
                                    href="/expense-income/"
                                    :class="setNavLink('/expense-income/')"
                                >
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Entry & List</p>
                                </a>
                            </li>
                            <li :class="setNavItem('/expense-income/category')">
                                <a
                                    href="/expense-income/category"
                                    :class="
                                        setNavLink('/expense-income/category')
                                    "
                                >
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Category</p>
                                </a>
                            </li>
                            <li :class="setNavItem('/expense-income/head')">
                                <a
                                    href="/expense-income/head"
                                    :class="setNavLink('/expense-income/head')"
                                >
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Head</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li
                        :class="
                            isMenuOpen([
                                '/report/current-stock',
                                '/category/create',
                                '/category/list',
                                '/product/create',
                                '/product/list',
                            ])
                        "
                    >
                        <a
                            href="#"
                            :class="
                                setNavLink('/report/current-stock') ||
                                setNavLink('/category/create') ||
                                setNavLink('/category/list') ||
                                setNavLink('/product/create') ||
                                setNavLink('/product/list')
                            "
                            id="sidebar_inventory"
                        >
                            <i
                                class="fa-solid text-cyan fa-clipboard-list mx-2"
                                style="font-size: 1.3rem"
                            ></i>
                            <p>
                                Inventory
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li :class="setNavItem('/report/current-stock')">
                                <a
                                    href="/report/current-stock"
                                    :class="setNavLink('/report/current-stock')"
                                >
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Stock Report</p>
                                </a>
                            </li>
                            <li :class="setNavItem('/category/create')" id="sidebar_add_new_category">
                                <a
                                    :href="tour_ongoing? '/category/create?tour=going' : '/category/create'"
                                    :class="setNavLink('/category/create')"
                                >
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Add New Category</p>
                                </a>
                            </li>
                            <li :class="setNavItem('/category/list')">
                                <a
                                    :href="tour_ongoing? '/category/list?tour=going' : '/category/list'"
                                    :class="setNavLink('/category/list')"
                                >
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Category List</p>
                                </a>
                            </li>
                            <li :class="setNavItem('/product/create')">
                                <a
                                    :href="tour_ongoing? '/product/create?tour=going' : '/product/create'"
                                    :class="setNavLink('/product/create')"
                                >
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Add New Product</p>
                                </a>
                            </li>
                            <li :class="setNavItem('/product/list')">
                                <a
                                    :href="tour_ongoing? '/product/list?tour=going' : '/product/list'"
                                    :class="setNavLink('/product/list')"
                                >
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Product List</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li
                        :class="
                            isMenuOpen([
                                '/report/purchase',
                                '/report/purchase-return',
                                '/report/purchase-payment',
                                '/report/sales',
                                '/report/sales-return',
                                '/report/sales-payment',
                                '/report/profit-loss',
                            ])
                        "
                    >
                        <a href="#" :class="setNavLink('/report/purchase')" >
                            <i class="nav-icon fa fa-bar-chart text-cyan"></i>
                            <p>
                                Report
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li :class="setNavItem('/report/profit-loss')">
                                <a
                                    href="/report/profit-loss"
                                    :class="setNavLink('/report/profit-loss')"
                                >
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Profit & Loss</p>
                                </a>
                            </li>
                            <li :class="setNavItem('/report/purchase')">
                                <a
                                    href="/report/purchase"
                                    :class="setNavLink('/report/purchase')"
                                >
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Purchase Report</p>
                                </a>
                            </li>

                            <li :class="setNavItem('/report/purchase-return')">
                                <a
                                    href="/report/purchase-return"
                                    :class="
                                        setNavLink('/report/purchase-return')
                                    "
                                >
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Purchase Report Return</p>
                                </a>
                            </li>
                            <li :class="setNavItem('/report/purchase-payment')">
                                <a
                                    href="/report/purchase-payment"
                                    :class="
                                        setNavLink('/report/purchase-payment')
                                    "
                                >
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Purchase Payment</p>
                                </a>
                            </li>
                            <li :class="setNavItem('/report/sales')">
                                <a
                                    href="/report/sales"
                                    :class="setNavLink('/report/sales')"
                                >
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Sales Report</p>
                                </a>
                            </li>
                            <li :class="setNavItem('/report/sales-return')">
                                <a
                                    href="/report/sales-return"
                                    :class="setNavLink('/report/sales-return')"
                                >
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Sales Return Report</p>
                                </a>
                            </li>
                            <li :class="setNavItem('/report/sales-payment')">
                                <a
                                    href="/report/sales-payment"
                                    :class="setNavLink('/report/sales-payment')"
                                >
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Sales Payment</p>
                                </a>
                            </li>
                        </ul>
                    </li>


                    <li
                        :class="
                            isMenuOpen([
                                '/ledger/customer',
                                '/ledger/supplier',
                                '/ledger/product',
                            ])
                        "
                    >
                        <a
                            href="#"
                            :class="
                                setNavLink('/ledger/customer') ||
                                setNavLink('/ledger/supplier') ||
                                setNavLink('/ledger/product')
                            "
                        >
                            <i class="nav-icon fas fa-bullseye text-cyan"></i>
                            <p>
                                Ledger
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li :class="setNavItem('/ledger/customer')">
                                <a
                                    href="/ledger/customer"
                                    :class="setNavLink('/ledger/customer')"
                                >
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Customer</p>
                                </a>
                            </li>

                            <!-- <li :class="setNavItem('/ledger/supplier')">
                                <a
                                    href="/ledger/supplier"
                                    :class="setNavLink('/ledger/supplier')"
                                >
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Supplier</p>
                                </a>
                            </li>

                            <li :class="setNavItem('/ledger/product')">
                                <a
                                    href="/ledger/product"
                                    :class="setNavLink('/ledger/product')"
                                >
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Product</p>
                                </a>
                            </li> -->
                        </ul>
                    </li>


                    <li
                        :class="
                            isMenuOpen([
                                '/user/create',
                                '/user/list',
                                '/transaction-types',
                                '/customer/list',
                                '/supplier/list',
                            ])
                        "
                    >
                        <a href="#" :class="setNavLink('/user/create')">
                            <i class="nav-icon fas fa-cogs text-cyan"></i>
                            <p>
                                Settings
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li :class="setNavItem('/transaction-types')">
                                <a
                                    href="/transaction-types"
                                    :class="setNavLink('/transaction-types')"
                                >
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Transaction Types</p>
                                </a>
                            </li>
                            <li :class="setNavItem('/customer/list')">
                                <a
                                    href="/customer/list"
                                    :class="setNavLink('/customer/list')"
                                >
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Customer List</p>
                                </a>
                            </li>
                            <li :class="setNavItem('/supplier/list')">
                                <a
                                    href="/supplier/list"
                                    :class="setNavLink('/supplier/list')"
                                >
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Supplier List</p>
                                </a>
                            </li>
                            <li :class="setNavItem('/user/create')">
                                <a
                                    href="/user/create"
                                    :class="setNavLink('/user/create')"
                                >
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Add New User</p>
                                </a>
                            </li>
                            <li :class="setNavItem('/user/list')">
                                <a
                                    href="/user/list"
                                    :class="setNavLink('/user/list')"
                                >
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>User List</p>
                                </a>
                            </li>

                            <li class="nav-item d-none">
                                <a href="#" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Manage User Role</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </nav>
        </div>
    </aside>
</template>

<script>
import { onMounted, ref, watchEffect } from "vue";
import axios from "axios";
export default {
    setup() {
        var userName = ref();
        var userImage = ref();
        var companyLogo = ref();
        var tour_ongoing = ref(false);

        watchEffect(() => {
            const tour = sessionStorage.getItem('tour');
            if(tour){
                tour_ongoing = true;
            }
        });

        const fetchSidebarData = () => {
            axios.get("/user/sidebar/data-fetch").then((response) => {
                const data = response.data.data;
                userName.value = data.name;
                userImage.value = data.image;
                companyLogo.value =  data.company.logo;
                if(companyLogo.value === 'Invalid image format'){
                    companyLogo.value = '/images/inventory_logo.png';
                }
            });
        };

        const isMenuOpen = (items) => {
            var get_url = new URL(window.location.href).pathname;
            const has_id = get_url.match(/\d+/);
            if (has_id != undefined) {
                const get_id = has_id[0];
                get_url = get_url.replace(get_id, "*");
            }

            if (items && items.includes(get_url)) {
                return "nav-item menu-is-opening menu-open";
            } else {
                return "nav-item";
            }
        };

        const setNavItem = (navItem) => {
            var get_url = new URL(window.location.href).pathname;

            const has_id = get_url.match(/\d+/);
            if (has_id != undefined) {
                const get_id = has_id[0];
                get_url = get_url.replace(get_id, "*");
            }

            if (get_url == navItem) {
                return "nav-item active";
            } else {
                return "nav-item";
            }
        };

        const setNavLink = (navLink) => {
            var get_url = new URL(window.location.href).pathname;

            const has_id = get_url.match(/\d+/);
            if (has_id != undefined) {
                const get_id = has_id[0];
                get_url = get_url.replace(get_id, "*");
            }

            if (get_url == navLink) {
                return "nav-link active";
            } else {
                return "nav-link";
            }
        };

        onMounted(() => {
            fetchSidebarData();
        });

        return {
            isMenuOpen,
            setNavItem,
            setNavLink,
            userName,
            companyLogo,
            userImage,
            tour_ongoing,
        };
    },
};
</script>

<style></style>
