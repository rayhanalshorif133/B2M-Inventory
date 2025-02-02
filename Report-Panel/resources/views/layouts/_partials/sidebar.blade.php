@php
    $currentRoute = Route::currentRouteName();
@endphp

<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="{{ asset('home') }}" class="app-brand-link">
            <span class="app-brand-logo demo">
                <img src="{{ asset('assets/images/bkash.png') }}" alt="gp logo" style="height: 28px">
            </span>
            <span class="app-brand-text demo menu-text fw-bolder ms-2"
                style="text-transform: capitalize;font-size: 24px">Bkash Game</span>
            <br />
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>


    <div class="menu-inner-shadow"></div>


    <ul class="menu-inner py-1">
        <!-- Dashboard -->
        <li class="menu-item @if ($currentRoute == 'admin.dashboard' || $currentRoute == 'admin.dashboard') active open @endif">
            <a href="{{ route('admin.dashboard') }}" class="menu-link">
                <i
                    class="menu-icon tf-icons bx bx-home-circle @if ($currentRoute == 'admin.dashboard') selectedIconPopup @endif"></i>
                <div data-i18n="Analytics" class="text-semibold">Dashboard</div>
            </a>
        </li>

        <li class="menu-item @if ($currentRoute == 'admin.campaign.index' || $currentRoute == 'admin.campaign.index') active open @endif">
            <a href="{{ route('admin.campaign.index') }}" class="menu-link">
                <i
                    class="menu-icon tf-icons bx bx-home-circle @if ($currentRoute == 'admin.campaign.index') selectedIconPopup @endif"></i>
                <div data-i18n="Analytics" class="text-semibold">Campaign</div>
            </a>
        </li>

        <li class="menu-item @if ($currentRoute == 'admin.game.index' || $currentRoute == 'admin.game.index') active open @endif">
            <a href="{{ route('admin.game.index') }}" class="menu-link">
                <i
                    class="menu-icon tf-icons bx bx-home-circle @if ($currentRoute == 'admin.game.index') selectedIconPopup @endif"></i>
                <div data-i18n="Analytics" class="text-semibold">Game</div>
            </a>
        </li>


    </ul>
</aside>
