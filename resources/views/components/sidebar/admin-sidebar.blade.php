@php $userRole = Auth::user()->role @endphp

{{-- admin --}}

@if ($userRole == 'Admin')

    <x-sidebar-dashboard>
        <x-sidebar-menu-dashboard href="index" title="Dashboard" icon="heroicon-s-home" />


        <x-sidebar-menu-dropdown-dashboard routeName="product.*" title="Product" icon="heroicon-m-squares-plus">
            <x-sidebar-menu-dropdown-item-dashboard routeName="product.index" title="Product Management"
                icon="heroicon-s-cube" />
            <x-sidebar-menu-dropdown-item-dashboard routeName="category.index" title="Category Product"
                icon="heroicon-o-tag" />
            <x-sidebar-menu-dropdown-item-dashboard routeName="attribute.index" title="Product Attribute"
                icon="heroicon-o-adjustments-horizontal" />
        </x-sidebar-menu-dropdown-dashboard>

        <x-sidebar-menu-dropdown-dashboard routeName="stock.*" title="Stock" icon="heroicon-s-square-3-stack-3d">
            <x-sidebar-menu-dropdown-item-dashboard routeName="stock.index" title="History Transaction"
                icon="heroicon-o-clock" />
            <x-sidebar-menu-dropdown-item-dashboard routeName="opname.index" title="Stock Opname"
                icon="heroicon-o-clipboard-document-check" />
        </x-sidebar-menu-dropdown-dashboard>

        <x-sidebar-menu-dashboard href="supplier.index" title="Supplier" icon="heroicon-o-truck" />
        <x-sidebar-menu-dashboard href="user.index" title="User" icon="heroicon-s-user" />
        <x-sidebar-menu-dashboard href="setting.index" title="Setting" icon="heroicon-s-cog-6-tooth" />
    </x-sidebar-dashboard>
@endif



@if ($userRole == 'Manager Gudang')
    <x-sidebar-dashboard>
        <x-sidebar-menu-dashboard href="index" title="Dashboard" icon="heroicon-s-home" />

        <x-sidebar-menu-dashboard href="product.manager" title="Product" icon="heroicon-s-cube" />
        <x-sidebar-menu-dashboard href="supplier.show.manager" title="Supplier" icon="heroicon-o-truck" />
        <x-sidebar-menu-dropdown-dashboard routeName="stock.*" title="Stock" icon="heroicon-s-square-3-stack-3d">
            <x-sidebar-menu-dropdown-item-dashboard routeName="stock.manager" title="Transaction"
                icon="heroicon-s-shopping-cart" />
            <x-sidebar-menu-dropdown-item-dashboard routeName="opname.manager" title="Stock Opname"
                icon="heroicon-o-clipboard-document-check" />
        </x-sidebar-menu-dropdown-dashboard>
    </x-sidebar-dashboard>
@endif



@if ($userRole == 'Staff Gudang')
    <x-sidebar-dashboard>
        <x-sidebar-menu-dashboard href="index" title="Dashboard" icon="heroicon-s-home" />
        <x-sidebar-menu-dropdown-dashboard routeName="stock.*" title="Stock" icon="heroicon-s-square-3-stack-3d">
            <x-sidebar-menu-dropdown-item-dashboard routeName="stock.staff" title="Confirmation Stock"
                icon="heroicon-s-shopping-cart" />
        </x-sidebar-menu-dropdown-dashboard>
    </x-sidebar-dashboard>
@endif