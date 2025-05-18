{{-- This file is used for menu items by any Backpack v6 theme --}}
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"> {{ trans('backpack::base.dashboard') }}</a></li>

<x-backpack::menu-item title="Mặt hàng" :link="backpack_url('product')" />
<x-backpack::menu-item title="Phân loại"  :link="backpack_url('category')" />
<x-backpack::menu-item title="Nhà cung cấp"  :link="backpack_url('supplier')" />
<x-backpack::menu-item title="Sản phẩm của nhà cung cấp" :link="backpack_url('product-supplier')" />

<x-backpack::menu-dropdown title="Phân quyền">
<!--    <x-backpack::menu-dropdown-header title="Authentication" />    -->
    <x-backpack::menu-dropdown-item title="Người dùng" icon="la la-user" :link="backpack_url('user')" />
    <x-backpack::menu-dropdown-item title="Vai trò" icon="la la-group" :link="backpack_url('role')" />
    <x-backpack::menu-dropdown-item title="Quyền truy cập" icon="la la-key" :link="backpack_url('permission')" />
</x-backpack::menu-dropdown>