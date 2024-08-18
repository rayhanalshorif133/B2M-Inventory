<template>
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <a href="/home" class="brand-link underline-none">
            <img
                src="/adminLTE/dist/img/AdminLTELogo.png"
                alt="AdminLTE Logo"
                class="brand-image img-circle elevation-3"
                style="opacity: 0.8"
            />
            <span class="brand-text font-weight-light">Inventory</span>
        </a>

        <div class="sidebar">
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <img
                        src="/adminLTE/dist/img/user2-160x160.jpg"
                        class="img-circle elevation-2"
                        alt="User Image"
                    />
                </div>
                <div class="info">
                    <a href="/home" class="d-block underline-none">{{
                        authUser
                    }}</a>
                </div>
            </div>

            <div class="form-inline">
                <div class="input-group" data-widget="sidebar-search">
                    <input
                        class="form-control form-control-sidebar"
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
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                    <li class="nav-header">Mangemanet</li>
                    <li :class="isMenuOpen(['/user/create', '/user/list'])">
                        <a href="#" :class="setNavLink('/user/create')">
                            <i class="nav-icon fas fa-user"></i>
                            <p>
                                User
                                <i class="fas fa-angle-left right"></i>
                                <span class="badge badge-info right">{{
                                    totalUser
                                }}</span>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li :class="setNavItem('/user/list')">
                                <a
                                    href="/user/list"
                                    :class="setNavLink('/user/list')"
                                >
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>User List</p>
                                </a>
                            </li>
                            <li :class="setNavItem('/user/create')">
                                <a
                                    href="/user/create"
                                    :class="setNavLink('/user/create')"
                                >
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Add New</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Manage Role</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li
                        :class="
                            isMenuOpen(['/category/create', '/category/list'])
                        "
                    >
                        <a href="#" :class="setNavLink('/category/create')">
                            <i class="nav-icon fas fa-tag"></i>
                            <p>
                                Category
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li :class="setNavItem('/category/list')">
                                <a
                                    href="/category/list"
                                    :class="setNavLink('/category/list')"
                                >
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Category List</p>
                                </a>
                            </li>
                            <li :class="setNavItem('/category/create')">
                                <a
                                    href="/category/create"
                                    :class="setNavLink('/category/create')"
                                >
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Add New</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li
                        :class="
                            isMenuOpen(['/product/create', '/product/list'])
                        "
                    >
                        <a href="#" :class="setNavLink('/product/create')">
                            <i class="nav-icon fa-solid fa-box-open"></i>
                            <p>
                                Product
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li :class="setNavItem('/product/list')">
                                <a
                                    href="/product/list"
                                    :class="setNavLink('/product/list')"
                                >
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Product List</p>
                                </a>
                            </li>
                            <li :class="setNavItem('/product/create')">
                                <a
                                    href="/product/create"
                                    :class="setNavLink('/product/create')"
                                >
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Add New</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item">
                        <a href="/transaction-types" :class="setNavLink('/transaction-types')">
                            <i class="nav-icon fa-solid fa-money-bill-transfer"></i>
                            <p>Transaction Types</p>
                        </a>
                    </li>

                    <li
                        :class="
                            isMenuOpen(['/purchase/create', '/purchase/list','/payment/purchase/pay','/purchase/payment-list'])
                        "
                    >
                        <a href="#" :class="setNavLink('/purchase/create')">
                            <i class="nav-icon fa-solid fa-cart-shopping"></i>
                            <p>
                                Purchase
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li :class="setNavItem('/purchase/create')">
                                <a
                                    href="/purchase/create"
                                    :class="setNavLink('/purchase/create')"
                                >
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Purchase</p>
                                </a>
                            </li>
                            <li :class="setNavItem('/purchase/list')">
                                <a
                                    href="/purchase/list"
                                    :class="setNavLink('/purchase/list')"
                                >
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Purchase List</p>
                                </a>
                            </li>
                            <li :class="setNavItem('/payment/purchase/pay')">
                                <a
                                    href="/payment/purchase/pay"
                                    :class="setNavLink('/payment/purchase/pay')"
                                >
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Payment</p>
                                </a>
                            </li>

                            <li :class="setNavItem('/purchase/payment-list')">
                                <a
                                    href="/purchase/payment-list"
                                    :class="setNavLink('/purchase/payment-list')"
                                >
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Payment List</p>
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
export default {
    data() {
        return {
            authUser: "",
            totalUser: "",
        };
    },
    props: {
        auth_user: {
            type: Object,
            required: true,
        },
        total_user: {
            type: Number,
            required: true,
        },
    },
    created() {
        this.authUser = this.auth_user.name;
        this.totalUser = this.total_user;
    },
    methods: {
        isMenuOpen(items) {
            const get_url = new URL(window.location.href).pathname;
            if (items && items.includes(get_url)) {
                return "nav-item menu-is-opening menu-open";
            } else {
                return "nav-item";
            }
        },
        setNavItem(navItem) {
            const get_url = new URL(window.location.href).pathname;
            if (get_url == navItem) {
                return "nav-item active";
            } else {
                return "nav-item";
            }
        },
        setNavLink(navLink) {
            const get_url = new URL(window.location.href).pathname;
            if (get_url == navLink) {
                return "nav-link active";
            } else {
                return "nav-link";
            }
        },
    },
};
</script>

<style></style>
