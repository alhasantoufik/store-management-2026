<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">
    <div data-simplebar class="h-100">
        <div id="sidebar-menu">
            <ul class="metismenu list-unstyled" id="side-menu">

                <!-- Dashboard -->

                <li class="{{ request()->routeIs(['admin.dashboard']) ? 'mm-active' : '' }}">
                    <a href="{{ route('admin.dashboard') }}" class="waves-effect">
                        <i class="fas fa-home"></i>
                        <span>Dashboard</span>
                    </a>
                </li>


                <li class="{{ request()->routeIs([
                        'stock.index',
                        'stockOut.index',
                        'stockReturn.index',
                        'stock.report'
                    ]) ? 'mm-active sidebarParentActive' : '' }}">
                    <a href="javascript:void(0);" class="has-arrow waves-effect">
                        <i class="fas fa-boxes"></i>
                        <span>Stock</span>
                    </a>
                    <ul class="sub-menu">
                        <li class="{{ request()->routeIs('stock.index') ? 'mm-active' : '' }}">
                            <a href="{{ route('stock.index') }}"><i class='fas fa-greater-than' style='font-size:11px'></i>Stock In</a>
                            <a href="{{ route('stock.in.index') }}"><i class='fas fa-greater-than' style='font-size:11px'></i>All Stock In</a>
                        </li>
                        <li class="{{ request()->routeIs('stockOut.index') ? 'mm-active' : '' }}">
                            <a href="{{ route('stockOut.index') }}"><i class='fas fa-greater-than' style='font-size:11px'></i>Stock Out</a>
                            <a href="{{ route('stock.out.index') }}"><i class='fas fa-greater-than' style='font-size:11px'></i>All Stock Out</a>
                        </li>
                        <li class="{{ request()->routeIs('stockReturn.index') ? 'mm-active' : '' }}">
                            <a href="{{ route('stockReturn.index') }}"><i class='fas fa-greater-than' style='font-size:11px'></i>Stock Return</a>
                            <a href="{{ route('stockReturn.all') }}"><i class='fas fa-greater-than' style='font-size:11px'></i>All Stock Return</a>
                        </li>
                        <li class="{{ request()->routeIs('admin.stocks.index') ? 'mm-active' : '' }}">
                            <a href="{{ route('admin.stocks.index') }}"><i class='fas fa-greater-than' style='font-size:11px'></i>All Stock</a>
                        </li>
                        <li class="{{ request()->routeIs('stock.report') ? 'mm-active' : '' }}">
                            <a href="{{ route('stock.report') }}"><i class='fas fa-greater-than' style='font-size:11px'></i>Stock Report</a>
                        </li>
                    </ul>
                </li>

                <li class="{{ request()->routeIs(['products.index']) ? 'mm-active' : '' }}">
                    <a href="{{ route('products.index') }}" class="waves-effect">
                        <i class="fab fa-product-hunt"></i>
                        <span>Products</span>
                    </a>
                </li>


                <li class="{{ request()->routeIs(['categories.index']) ? 'mm-active' : '' }}">
                    <a href="{{ route('categories.index') }}" class="waves-effect">
                        <i class="fas fa-list-ul"></i>
                        <span>Categories</span>
                    </a>
                </li>

                <li class="{{ request()->routeIs(['brands.index']) ? 'mm-active' : '' }}">
                    <a href="{{ route('brands.index') }}" class="waves-effect">
                        <i class="fas fa-globe"></i>
                        <span>Brands</span>
                    </a>
                </li>



                <li class="{{ request()->routeIs('cost.*') ? 'mm-active sidebarParentActive' : '' }}">
                    <a href="javascript:void(0);" class="has-arrow waves-effect">
                        <i class="fas fa-money-bill-wave"></i>
                        <span>Expense</span>
                    </a>
                    <ul class="sub-menu">
                        <li><a href="{{ route('cost.category.index') }}"><i class='fas fa-greater-than' style='font-size:11px'></i>Categories</a></li>
                        <li><a href="{{ route('cost.field.index') }}"><i class='fas fa-greater-than' style='font-size:11px'></i>Fields</a></li>
                        <li><a href="{{ route('cost.create') }}"><i class='fas fa-greater-than' style='font-size:11px'></i>Add Expense</a></li>
                        <li><a href="{{ route('cost.index') }}"><i class='fas fa-greater-than' style='font-size:11px'></i>All Expense</a></li>
                        <!-- <li><a href="{{ route('cost.all') }}"><i class='fas fa-greater-than' style='font-size:11px'></i>All Expenses</a></li> -->
                    </ul>
                </li>

                <li class="{{ request()->routeIs(['profit.report']) ? 'mm-active' : '' }}">
                    <a href="{{ route('profit.report') }}" class="waves-effect">
                        <i class="fas fa-business-time"></i>
                        <span>Profit Report</span>
                    </a>
                </li>
                <li class="{{ request()->routeIs(['expense.report']) ? 'mm-active' : '' }}">
                    <a href="{{ route('expense.report') }}" class="waves-effect">
                        <i class="fas fa-money-bill"></i>
                        <span>Expense Report</span>
                    </a>
                </li>
                <li class="{{ request()->routeIs(['cashbook.index']) ? 'mm-active' : '' }}">
                    <a href="{{ route('cashbook.index') }}" class="waves-effect">
                        <i class="fas fa-calculator"></i>
                        <span>CashBook</span>
                    </a>
                </li>

                <li class="{{ request()->routeIs('admin.admins.*') ? 'mm-active sidebarParentActive' : '' }}">
                    <a href="javascript:void(0);" class="has-arrow waves-effect">
                        <i class="fas fa-user-shield"></i>
                        <span>Admin</span>
                    </a>
                    <ul class="sub-menu">


                        <li><a href="{{ route('admin.admins.create') }}"><i class='fas fa-greater-than' style='font-size:11px'></i>New Admin</a></li>



                        <li><a href="{{ route('admin.admins.index') }}"><i class='fas fa-greater-than' style='font-size:11px'></i>All Admins</a></li>


                    </ul>
                </li>




                <li class="{{ request()->routeIs('admin.sms.*') ? 'mm-active' : '' }}">
                    <a href="javascript:void(0);" class="has-arrow waves-effect">
                        <i class="fas fa-sms"></i>
                        <span>SMS System</span>
                    </a>
                    <ul class="sub-menu">

                        <li class="{{ request()->routeIs('admin.sms.summary') ? 'mm-active' : '' }}">
                            <a href="{{ route('admin.sms.summary') }}">
                                <i class='fas fa-greater-than' style='font-size:11px'></i>Sent SMS
                            </a>
                        </li>

                        <li class="{{ request()->routeIs('admin.sms.send') ? 'mm-active' : '' }}">
                            <a href="{{ route('admin.sms.send') }}">
                                <i class='fas fa-greater-than' style='font-size:11px'></i>SMS Summary
                            </a>
                        </li>

                        @if(auth()->check() && auth()->user()->name === 'Developer' && auth()->user()->role === 'admin')
                        <li class="{{ request()->routeIs('admin.sms.module') ? 'mm-active' : '' }}">
                            <a href="{{ route('admin.sms.module') }}">
                                <i class='fas fa-greater-than' style='font-size:11px'></i>SMS Limit
                            </a>
                        </li>
                        @endif

                    </ul>
                </li>


                <!-- Settings -->

                <li class="{{ request()->routeIs(['profile.setting', 'system.index']) ? 'mm-active sidebarParentActive' : '' }}">
                    <a href="javascript:void(0);" class="has-arrow waves-effect">
                        <i class="fas fa-cog"></i>
                        <span>Settings</span>
                    </a>
                    <ul class="sub-menu">


                        <li><a href="{{ route('profile.setting') }}"><i class='fas fa-greater-than' style='font-size:11px'></i>Profile Settings</a></li>
                        <li><a href="{{ route('system.index') }}"><i class='fas fa-greater-than' style='font-size:11px'></i>System Settings</a></li>


                    </ul>
                </li>


            </ul>
        </div>
    </div>
</div>
<!-- Left Sidebar End -->