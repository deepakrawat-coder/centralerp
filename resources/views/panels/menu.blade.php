<div class="page-main-header">
    <div class="main-header-right row m-0">
        <div class="main-header-left">
            <div class="logo-wrapper"><a href="index.html"><img class="img-fluid" src="../assets/images/logo/logo.png"
                        alt=""></a></div>
        </div>
        <div class="toggle-sidebar"><i class="status_toggle middle" data-feather="align-center" id="sidebar-toggle"></i>
        </div>
        <div class="left-menu-header col">
            <ul>
                <li class="position-relative">
                    <form class="form-inline search-form">
                        <div class="search-bg"><i class="fa fa-search"></i></div>
                        <input class="form-control-plaintext" id="search-bar" placeholder="Search here.....">
                    </form>
                    <span class="d-sm-none mobile-search search-bg"><i class="fa fa-search"></i></span>
                    <ul class="list-group mt-2" id="search-results"
                        style="position:absolute; z-index:1000;width: 100%;"></ul>
                </li>
            </ul>
        </div>
        <div class="nav-right col pull-right right-menu">
            <ul class="nav-menus">
                <li>
                    <button class="btn btn-dark rounded-pill px-2 py-1 fs-6"
                        onclick="loadUniversities({{ session()->get('University_table_id') }})"><i
                            class="ri-swap-3-fill "></i> Change university</button>
                </li>
                <li>
                    <div class="mode"><i class="fa fa-moon-o"></i></div>
                </li>
                <li><a class="text-dark" href="#!" onclick="javascript:toggleFullScreen()"><i
                            data-feather="maximize"></i></a></li>
                <li class="onhover-dropdown">
                    <div class="media profile-media"><img class="rounded-circle"
                            src="../assets/images/avtar/emoji/9.png" alt=""></div>
                    <ul class="profile-dropdown onhover-show-div">
                        <li><a href="user-profile.html"><i data-feather="user"></i><span>Account </span></a></li>
                        <li><a href="user-profile.html"><i data-feather="mail"></i><span>Inbox</span></a></li>
                        <li><a href="kanban.html"><i data-feather="file-text"></i><span>Taskboard</span></a></li>
                        <li><a href="edit-profile.html"><i data-feather="settings"></i><span>Settings</span></a></li>
                        <li><a class="btn btn-light w-100" id="logoutBtn"><i data-feather="log-in"></i>Log out</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
        <div class="d-lg-none col mobile-toggle pull-right"><i data-feather="more-horizontal"></i></div>
    </div>
</div>
