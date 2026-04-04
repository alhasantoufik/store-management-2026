<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">
    <div data-simplebar class="h-100">
        <div id="sidebar-menu">
            <ul class="metismenu list-unstyled" id="side-menu">

                <!-- Dashboard -->

                <li class="{{ request()->routeIs(['admin.dashboard']) ? 'mm-active' : '' }}">
                    <a href="{{ route('admin.dashboard') }}" class="waves-effect">
                        <i class="fas fa-home"></i>
                        <span>ড্যাশবোর্ড</span>
                    </a>
                </li>

                <li class="{{ request()->routeIs(['products.index']) ? 'mm-active' : '' }}">
                    <a href="{{ route('products.index') }}" class="waves-effect">
                        <i class="fas fa-list-ul"></i>
                        <span>Products</span>
                    </a>
                </li>


                <li class="{{ request()->routeIs(['stocks.index']) ? 'mm-active' : '' }}">
                    <a href="{{ route('stocks.index') }}" class="waves-effect">
                        <i class="fas fa-list-ul"></i>
                        <span>Stocks In</span>
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
                        <i class="fas fa-list-ul"></i>
                        <span>Brands</span>
                    </a>
                </li>

                <li class="{{ request()->routeIs('admin.admins.*') ? 'mm-active sidebarParentActive' : '' }}">
                    <a href="javascript:void(0);" class="has-arrow waves-effect">
                        <i class="fas fa-user-shield"></i>
                        <span>অ্যাডমিন</span>
                    </a>
                    <ul class="sub-menu">


                        <li><a href="{{ route('admin.admins.create') }}">নতুন অ্যাডমিন</a></li>



                        <li><a href="{{ route('admin.admins.index') }}">সকল অ্যাডমিন</a></li>


                    </ul>
                </li>




                <li class="{{ request()->routeIs('admin.sms.*') ? 'mm-active' : '' }}">
                    <a href="javascript:void(0);" class="has-arrow waves-effect">
                        <i class="fas fa-sms"></i>
                        <span>এসএমএস সিস্টেম</span>
                    </a>
                    <ul class="sub-menu">

                        <li class="{{ request()->routeIs('admin.sms.summary') ? 'mm-active' : '' }}">
                            <a href="{{ route('admin.sms.summary') }}">
                                সেন্ট এসএমএস
                            </a>
                        </li>

                        <li class="{{ request()->routeIs('admin.sms.send') ? 'mm-active' : '' }}">
                            <a href="{{ route('admin.sms.send') }}">
                                এসএমএস সামারি
                            </a>
                        </li>

                        @if(auth()->check() && auth()->user()->name === 'Developer' && auth()->user()->role === 'admin')
                        <li class="{{ request()->routeIs('admin.sms.module') ? 'mm-active' : '' }}">
                            <a href="{{ route('admin.sms.module') }}">
                                এসএমএস লিমিট
                            </a>
                        </li>
                        @endif

                    </ul>
                </li>


                <!-- Settings -->

                <li class="{{ request()->routeIs(['profile.setting', 'system.index']) ? 'mm-active sidebarParentActive' : '' }}">
                    <a href="javascript:void(0);" class="has-arrow waves-effect">
                        <i class="fas fa-cog"></i>
                        <span>সেটিংস</span>
                    </a>
                    <ul class="sub-menu">


                        <li><a href="{{ route('profile.setting') }}">প্রোফাইল সেটিংস</a></li>
                        <li><a href="{{ route('system.index') }}">সিস্টেম সেটিংস</a></li>


                    </ul>
                </li>


            </ul>
        </div>
    </div>
</div>
<!-- Left Sidebar End -->