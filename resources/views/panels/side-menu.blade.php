<div class="page-body-wrapper sidebar-icon">
    <!-- Page Sidebar Start-->
    <header class="main-nav">
        <div class="logo-wrapper">
            <a href="{{ url('/') }}">
                <img class="img-fluid" src="{{ asset('assets/images/logo/logo.png') }}" alt="Logo">
            </a>
        </div>
        <div class="logo-icon-wrapper">
            <a href="{{ url('/') }}">
                <img class="img-fluid" src="{{ asset('assets/images/logo/logo-icon.png') }}" alt="Logo Icon">
            </a>
        </div>
        <div class="morden-logo">
            <a href="{{ url('/') }}">
                <img class="img-fluid" src="{{ asset('assets/images/logo/morden-logo.png') }}" alt="Modern Logo">
            </a>
        </div>

        <nav>
            <div class="main-navbar">
                <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>

                <div id="mainnav">
                    <ul class="nav-menu custom-scrollbar">
                        <!-- Back Button -->
                        <li class="back-btn">
                            <div class="mobile-back text-end">
                                <span>Back</span><i class="fa fa-angle-right ps-2" aria-hidden="true"></i>
                            </div>
                        </li>

                        <!-- Sample Menu -->
                        <li class="dropdown {{ request()->routeIs('sample.page') ? 'active' : '' }}">
                            <a class="nav-link menu-title" href="javascript:void(0)">
                                <i data-feather="home"></i>
                                <span>Sample</span>
                            </a>
                            <ul class="nav-submenu menu-content">
                                <li><a href="{{ route('sample.page') }}"
                                        class="{{ request()->routeIs('sample.page') ? 'active' : '' }}">Sample Page</a>
                                </li>
                                <li><a href="{{ route('university-erp.index') }}"
                                        class="{{ request()->routeIs('university-erp.*') ? 'active' : '' }}">ERP
                                        University</a></li>
                                <li>
                            </ul>
                        </li>

                        <!-- User Management -->
                        <li
                            class="dropdown 
                            {{ request()->routeIs('roles.*') || request()->routeIs('permissions.*') || request()->routeIs('users.*') ? 'active' : '' }}">
                            <a class="nav-link menu-title" href="javascript:void(0)">
                                <i data-feather="users"></i>
                                <span>User Management</span>
                            </a>
                            <ul class="nav-submenu menu-content">
                                <li><a href="{{ route('roles.index') }}"
                                        class="{{ request()->routeIs('roles.*') ? 'active' : '' }}">Roles</a></li>
                                <li><a href="{{ route('permissions.index') }}"
                                        class="{{ request()->routeIs('permissions.*') ? 'active' : '' }}">Permissions</a>
                                </li>
                                <li><a href="{{ route('users.index') }}"
                                        class="{{ request()->routeIs('users.*') ? 'active' : '' }}">Users</a></li>
                            </ul>
                        </li>
                        @if (session()->has('uni_id'))
                            <li class="dropdown">
                                <a class="nav-link menu-title" href="javascript:void(0)">
                                    <i data-feather="users"></i>
                                    <span>ERP's</span>
                                </a>
                                <ul class="nav-submenu menu-content">
                                    <li>
                                        <a
                                            href="{{ route('services.handle', ['method' => 'students', 'uni_id' => session('uni_id')]) }}">
                                            Students
                                        </a>
                                    </li>
                                    <li>
                                        <a
                                            href="{{ route('services.handle', ['method' => 'users', 'uni_id' => session('uni_id')]) }}">
                                            Users
                                        </a>
                                    </li>
                                     <li>
                                        <a
                                            href="{{ route('services.handle', ['method' => 'wallet', 'uni_id' => session('uni_id')]) }}">
                                            Wallet
                                        </a>
                                    </li>
                                     <li>
                                        <a
                                            href="{{ route('services.handle', ['method' => 'ledger', 'uni_id' => session('uni_id')]) }}">
                                            Students Ledegers
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @endif

                    </ul>
                </div>

                <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
            </div>
        </nav>
    </header>
    <!-- Page Sidebar Ends-->
