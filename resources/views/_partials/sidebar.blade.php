@php
    if(Auth::check()){
        $user = \App\Models\User::select()
        ->where('company_id', Auth::user()->company_id)
        ->where('id', Auth::user()->id)
        ->with('company', 'roles')
        ->first();
    }else{
        return redirect()->route('logout');
    }


    $currentRouteName = Route::currentRouteName();
@endphp
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    @if (strlen($user->company->name) > 20)
        <a href="/home" class="brand-link underline-none d-flex flex-column justify-content-center" style="">
            <img src="{{ asset($user->company->logo) }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" />
            <span class="brand-text font-weight-light mx-auto text-center" style="font-size: 14px">{{ $user->company->name }}</span>
        </a>
    @else
        <a href="/home" class="brand-link underline-none">
            <img src="{{ asset($user->company->logo) }}" alt="AdminLTE Logo"
                class="brand-image img-circle elevation-3" />
            <span class="brand-text font-weight-light" style="font-size: 14px">{{ $user->company->name }}</span>
        </a>
    @endif

    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset($user->image) }}" class="img-circle elevation-2" alt="User Image" />
            </div>

            <div class="info">
                <a href="/user/profile" class="d-block underline-none">{{ $user->name }}</a>
            </div>
        </div>

        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar text-black" type="search" placeholder="Search"
                    aria-label="Search" />
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>

        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <li class="nav-item menu-open">
                    <a href="{{ route('home') }}" class="nav-link">
                        <i class="nav-icon text-cyan fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-item @if (
                    $currentRouteName == 'sales.index' ||
                        $currentRouteName == 'sales.create' ||
                        $currentRouteName == 'sales.edit' ||
                        $currentRouteName == 'sales.return.create' ||
                        $currentRouteName == 'payment.sales.pay' ||
                        $currentRouteName == 'sales.payment-list' ||
                        $currentRouteName == 'sales.return.index' ||
                        $currentRouteName == 'sales.due-collection') menu-is-opening menu-open @endif">
                    <a href="#" class="nav-link @if (
                        $currentRouteName == 'sales.index' ||
                            $currentRouteName == 'sales.create' ||
                            $currentRouteName == 'sales.edit' ||
                            $currentRouteName == 'sales.return.create' ||
                            $currentRouteName == 'sales.payment-list' ||
                            $currentRouteName == 'sales.return.index' ||
                            $currentRouteName == 'sales.due-collection' ||
                            $currentRouteName == 'payment.sales.pay') active menu-open @endif">
                        <i class="text-cyan nav-icon fa-solid fa-hand-holding-dollar"></i>
                        <p>
                            Sales
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('sales.create') }}"
                                class="nav-link @if ($currentRouteName == 'sales.create') active @endif">
                                <i class="far fa-circle nav-icon"></i>
                                <p>New Sales</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('sales.index') }}"
                                class="nav-link @if ($currentRouteName == 'sales.index' || $currentRouteName == 'sales.edit') active @endif">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Sales List</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('sales.return.create') }}"
                                class="nav-link @if ($currentRouteName == 'sales.return.create') active @endif">
                                <i class="far fa-circle nav-icon"></i>
                                <p>New Sales Return</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('sales.return.index') }}"
                                class="nav-link @if ($currentRouteName == 'sales.return.index') active @endif">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Sales Return List</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('sales.due-collection') }}"
                                class="nav-link @if ($currentRouteName == 'sales.due-collection') active @endif">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Sales Due Amount</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('payment.sales.pay') }}"
                                class="nav-link @if ($currentRouteName == 'payment.sales.pay') active @endif">
                                <i class="far fa-circle nav-icon"></i>
                                <p>New Sales Payment</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('sales.payment-list') }}"
                                class="nav-link @if ($currentRouteName == 'sales.payment-list') active @endif">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Sales Payment List</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li
                    class="nav-item
                @if (
                    $currentRouteName == 'purchase.index' ||
                        $currentRouteName == 'purchase.create' ||
                        $currentRouteName == 'purchase.edit' ||
                        $currentRouteName == 'purchase.return.create' ||
                        $currentRouteName == 'payment.purchase.pay' ||
                        $currentRouteName == 'purchase.payment-list' ||
                        $currentRouteName == 'purchase.return.index' ||
                        $currentRouteName == 'purchase.due-collection') menu-is-opening menu-open @endif">
                    <a href="#"
                        class="nav-link
                    @if (
                        $currentRouteName == 'purchase.index' ||
                            $currentRouteName == 'purchase.create' ||
                            $currentRouteName == 'purchase.edit' ||
                            $currentRouteName == 'purchase.return.create' ||
                            $currentRouteName == 'payment.purchase.pay' ||
                            $currentRouteName == 'purchase.payment-list' ||
                            $currentRouteName == 'purchase.return.index' ||
                            $currentRouteName == 'purchase.due-collection') active menu-open @endif"
                        id="sidebar_open_purchase">
                        <i class="text-cyan nav-icon fa-solid fa-cart-shopping"></i>
                        <p>
                            Purchase
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <!-- New Purchase -->
                        <li class="nav-item">
                            <a href="{{ route('purchase.create') }}"
                                class="nav-link @if ($currentRouteName == 'purchase.create') active @endif">
                                <i class="far fa-circle nav-icon"></i>
                                <p>New Purchase</p>
                            </a>
                        </li>
                        <!-- Purchase List -->
                        <li class="nav-item">
                            <a href="{{ route('purchase.index') }}"
                                class="nav-link @if ($currentRouteName == 'purchase.index' || $currentRouteName == 'purchase.edit') active @endif">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Purchase List</p>
                            </a>
                        </li>
                        <!-- New Purchase Return -->
                        <li class="nav-item">
                            <a href="{{ route('purchase.return.create') }}"
                                class="nav-link @if ($currentRouteName == 'purchase.return.create') active @endif">
                                <i class="far fa-circle nav-icon"></i>
                                <p>New Purchase Return</p>
                            </a>
                        </li>
                        <!-- Purchase Return List -->
                        <li class="nav-item">
                            <a href="{{ route('purchase.return.index') }}"
                                class="nav-link @if ($currentRouteName == 'purchase.return.index') active @endif">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Purchase Return List</p>
                            </a>
                        </li>
                        <!-- Purchase Due Amount -->
                        <li class="nav-item">
                            <a href="{{ route('purchase.due-collection') }}"
                                class="nav-link @if ($currentRouteName == 'purchase.due-collection') active @endif">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Purchase Due Amount</p>
                            </a>
                        </li>
                        <!-- New Purchase Payment -->
                        <li class="nav-item">
                            <a href="{{ route('payment.purchase.pay') }}"
                                class="nav-link @if ($currentRouteName == 'payment.purchase.pay') active @endif">
                                <i class="far fa-circle nav-icon"></i>
                                <p>New Purchase Payment</p>
                            </a>
                        </li>
                        <!-- Purchase Payment List -->
                        <li class="nav-item">
                            <a href="{{ route('purchase.payment-list') }}"
                                class="nav-link @if ($currentRouteName == 'purchase.payment-list') active @endif">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Purchase Payment List</p>
                            </a>
                        </li>
                    </ul>
                </li>


                <li class="nav-item @if (
                    $currentRouteName == 'expense-income.list' ||
                        $currentRouteName == 'expense-income.category.list' ||
                        $currentRouteName == 'expense-income.head.list') menu-is-opening menu-open @endif">
                    <a href="#" class="nav-link @if (
                        $currentRouteName == 'expense-income.list' ||
                            $currentRouteName == 'expense-income.category.list' ||
                            $currentRouteName == 'expense-income.head.list') active menu-open @endif">
                        <i class="nav-icon text-cyan fa-solid fa-money-bill-transfer"></i>
                        <p>
                            Expense and Income
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="/expense-income/"
                                class="nav-link @if ($currentRouteName == 'expense-income.list') active @endif">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Entry & List</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/expense-income/category"
                                class="nav-link @if ($currentRouteName == 'expense-income.category.list') active @endif">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Category</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/expense-income/head"
                                class="nav-link @if ($currentRouteName == 'expense-income.head.list') active @endif">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Head</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item @if (
                    $currentRouteName == 'report.current-stock' ||
                        $currentRouteName == 'category.create' ||
                        $currentRouteName == 'category.list' ||
                        $currentRouteName == 'product.create' ||
                        $currentRouteName == 'product.list') menu-is-opening menu-open @endif">
                    <a href="#" class="nav-link @if (
                        $currentRouteName == 'report.current-stock' ||
                            $currentRouteName == 'category.create' ||
                            $currentRouteName == 'category.list' ||
                            $currentRouteName == 'product.create' ||
                            $currentRouteName == 'product.list') active menu-open @endif">
                        <i class="fa-solid text-cyan fa-clipboard-list nav-icon" style="font-size: 1.3rem"></i>
                        <p>
                            Inventory
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('report.current-stock') }}"
                                class="nav-link @if ($currentRouteName == 'report.current-stock') active @endif">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Stock Report</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('category.create') }}"
                                class="nav-link @if ($currentRouteName == 'category.create') active @endif">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Add New Category</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('category.list') }}"
                                class="nav-link @if ($currentRouteName == 'category.list') active @endif">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Category List</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('product.create') }}"
                                class="nav-link @if ($currentRouteName == 'product.create') active @endif">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Add New Product</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('product.list') }}"
                                class="nav-link @if ($currentRouteName == 'product.list') active @endif">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Product List</p>
                            </a>
                        </li>
                    </ul>
                </li>


                <li class="nav-item @if (
                    $currentRouteName == 'report.profit-loss' ||
                        $currentRouteName == 'report.purchase' ||
                        $currentRouteName == 'report.purchase-return' ||
                        $currentRouteName == 'report.purchase-payment' ||
                        $currentRouteName == 'report.sales' ||
                        $currentRouteName == 'report.sales-return' ||
                        $currentRouteName == 'report.sales-payment') menu-is-opening menu-open @endif">
                    <a href="#" class="nav-link @if (
                        $currentRouteName == 'report.profit-loss' ||
                            $currentRouteName == 'report.purchase' ||
                            $currentRouteName == 'report.purchase-return' ||
                            $currentRouteName == 'report.purchase-payment' ||
                            $currentRouteName == 'report.sales' ||
                            $currentRouteName == 'report.sales-return' ||
                            $currentRouteName == 'report.sales-payment') active menu-open @endif">
                        <i class="nav-icon fa fa-bar-chart text-cyan"></i>
                        <p>
                            Report
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('report.profit-loss') }}"
                                class="nav-link @if ($currentRouteName == 'report.profit-loss') active @endif">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Profit & Loss</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('report.purchase') }}"
                                class="nav-link @if ($currentRouteName == 'report.purchase') active @endif">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Purchase Report</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('report.purchase-return') }}"
                                class="nav-link @if ($currentRouteName == 'report.purchase-return') active @endif">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Purchase Report Return</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('report.purchase-payment') }}"
                                class="nav-link @if ($currentRouteName == 'report.purchase-payment') active @endif">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Purchase Payment</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('report.sales') }}"
                                class="nav-link @if ($currentRouteName == 'report.sales') active @endif">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Sales Report</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('report.sales-return') }}"
                                class="nav-link @if ($currentRouteName == 'report.sales-return') active @endif">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Sales Return Report</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('report.sales-payment') }}"
                                class="nav-link @if ($currentRouteName == 'report.sales-payment') active @endif">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Sales Payment</p>
                            </a>
                        </li>
                    </ul>
                </li>


                <li class="nav-item @if ($currentRouteName == 'ledger.customer') menu-is-opening menu-open @endif">
                    <a href="#" class="nav-link @if ($currentRouteName == 'ledger.customer') active menu-open @endif">
                        <i class="nav-icon fas fa-bullseye text-cyan"></i>
                        <p>
                            Ledger
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('ledger.customer') }}"
                                class="nav-link @if ($currentRouteName == 'ledger.customer') active @endif">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Customer</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item @if (
                    $currentRouteName == 'transaction-types.index' ||
                        $currentRouteName == 'customer.list' ||
                        $currentRouteName == 'supplier.list' ||
                        $currentRouteName == 'user.list' ||
                        $currentRouteName == 'user.create') menu-is-opening menu-open @endif">
                    <a href="#" class="nav-link @if (
                        $currentRouteName == 'transaction-types.index' ||
                            $currentRouteName == 'customer.list' ||
                            $currentRouteName == 'supplier.list' ||
                            $currentRouteName == 'user.list' ||
                            $currentRouteName == 'user.create') active menu-open @endif">
                        <i class="nav-icon fas fa-cogs text-cyan"></i>
                        <p>
                            Settings
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('transaction-types.index') }}"
                                class="nav-link @if ($currentRouteName == 'transaction-types.index') active @endif">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Transaction Types</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('customer.list') }}"
                                class="nav-link @if ($currentRouteName == 'customer.list') active @endif">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Customer List</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('supplier.list') }}"
                                class="nav-link @if ($currentRouteName == 'supplier.list') active @endif">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Supplier List</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('user.create') }}"
                                class="nav-link @if ($currentRouteName == 'user.create') active @endif">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Add New User</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('user.list') }}"
                                class="nav-link @if ($currentRouteName == 'user.list') active @endif">
                                <i class="far fa-circle nav-icon"></i>
                                <p>User List</p>
                            </a>
                        </li>
                        <li class="nav-item nav-item d-none">
                            <a href="#" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Manage User Role</p>
                            </a>
                        </li>
                    </ul>
                </li>



                <!-- More sections like Inventory, Reports, and Settings follow similar structure -->


            </ul>
        </nav>

    </div>
</aside>
