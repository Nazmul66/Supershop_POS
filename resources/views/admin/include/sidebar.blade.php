<div class="sidebar" id="sidebar">
    <!-- Logo -->
    <div class="sidebar-logo">
        <a href="index.html" class="logo logo-normal">
            <img src="assets/img/logo.svg" alt="Img">
        </a>
        <a href="index.html" class="logo logo-white">
            <img src="assets/img/logo-white.svg" alt="Img">
        </a>
        <a href="index.html" class="logo-small">
            <img src="assets/img/logo-small.png" alt="Img">
        </a>
        <a id="toggle_btn" href="javascript:void(0);">
            <i data-feather="chevrons-left" class="feather-16"></i>
        </a>
    </div>
    <!-- /Logo -->
    <div class="modern-profile p-3 pb-0">
        <div class="text-center rounded bg-light p-3 mb-4 user-profile">
            <div class="avatar avatar-lg online mb-3">
                <img src="assets/img/customer/customer15.jpg" alt="Img" class="img-fluid rounded-circle">
            </div>
            <h6 class="fs-14 fw-bold mb-1">Adrian Herman</h6>
            <p class="fs-12 mb-0">System Admin</p>
        </div>
        <div class="sidebar-nav mb-3">
            <ul class="nav nav-tabs nav-tabs-solid nav-tabs-rounded nav-justified bg-transparent" role="tablist">
                <li class="nav-item"><a class="nav-link active border-0" href="#">Menu</a></li>
                <li class="nav-item"><a class="nav-link border-0" href="chat.html">Chats</a></li>
                <li class="nav-item"><a class="nav-link border-0" href="email.html">Inbox</a></li>
            </ul>
        </div>
    </div>
    <div class="sidebar-header p-3 pb-0 pt-2">
        <div class="text-center rounded bg-light p-2 mb-4 sidebar-profile d-flex align-items-center">
            <div class="avatar avatar-md onlin">
                <img src="assets/img/customer/customer15.jpg" alt="Img" class="img-fluid rounded-circle">
            </div>
            <div class="text-start sidebar-profile-info ms-2">
                <h6 class="fs-14 fw-bold mb-1">Adrian Herman</h6>
                <p class="fs-12">System Admin</p>
            </div>
        </div>
        <div class="d-flex align-items-center justify-content-between menu-item mb-3">
            <div>
                <a href="index.html" class="btn btn-sm btn-icon bg-light">
                    <i class="ti ti-layout-grid-remove"></i>
                </a>
            </div>
            <div>
                <a href="chat.html" class="btn btn-sm btn-icon bg-light">
                    <i class="ti ti-brand-hipchat"></i>
                </a>
            </div>
            <div>
                <a href="email.html" class="btn btn-sm btn-icon bg-light position-relative">
                    <i class="ti ti-message"></i>
                </a>
            </div>
            <div class="notification-item">
                <a href="activities.html" class="btn btn-sm btn-icon bg-light position-relative">
                    <i class="ti ti-bell"></i>
                    <span class="notification-status-dot"></span>
                </a>
            </div>
            <div class="me-0">
                <a href="general-settings.html" class="btn btn-sm btn-icon bg-light">
                    <i class="ti ti-settings"></i>
                </a>
            </div>
        </div>
    </div>

    {{-- Dashboard --}}
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
                <li class="submenu-open">
                    <h6 class="submenu-hdr">Main</h6>
                    <ul>
                        <li class="submenu">
                            <a href="javascript:void(0);" class="@yield('dashboard')"><i class="ti ti-layout-grid fs-16 me-2"></i><span>Dashboard</span><span class="menu-arrow"></span></a>
                            <ul>
                                <li><a href="{{ route('admin.dashboard') }}" class="@yield('admin-dashboard')">Admin Dashboard</a></li>
                                <li><a href="index.html">Analytics Dashboard</a></li>
                            </ul>
                        </li>

                        <li class="submenu">
                            <a href="javascript:void(0);" class="@yield('application')"><i class="ti ti-brand-apple-arcade  fs-16 me-2"></i><span>Application</span><span class="menu-arrow"></span></a>
                            <ul>
                                <li><a href="{{ route('admin.todo.index') }}" class="@yield('todo')">Todo List</a></li>
                                <li><a href="{{ route('admin.note.index') }}" class="@yield('notes')">Notes</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>


                 {{-- Inventory --}}
                <li class="submenu-open">
                    <h6 class="submenu-hdr">Inventory</h6>
                    <ul>
                        <li class="@yield('category')"><a href="{{ route('admin.category.index') }}"><i class="ti ti-list-details fs-16 me-2"></i><span>Category</span></a></li>

                        <li class="@yield('subCategory')"><a href="{{ route('admin.subcategory.index') }}"><i class="ti ti-carousel-vertical fs-16 me-2"></i><span>Sub Category</span></a></li>

                        <li class="@yield('childCategory')"><a href="{{ route('admin.childCategory.index') }}"><i class="ti ti-brand-airtable fs-16 me-2"></i><span>Child Category</span></a></li>

                        <li class="@yield('brand')"><a href="{{ route('admin.brand.index') }}"><i class="ti ti-triangles fs-16 me-2"></i><span>Brand</span></a></li>

                        <li class="@yield('unit')"><a href="{{ route('admin.unit.index') }}"><i class="ti ti-brand-unity fs-16 me-2"></i><span>Unit</span></a></li>
                    </ul>
                </li>


                {{-- Role & Permission --}}
                @if(auth("admin")->user()->can("main-admin-access"))
                    <li class="submenu-open">
                        <h6 class="submenu-hdr">User Management</h6>
                        <ul>
                            @if(auth("admin")->user()->can("index.permission"))
                                <li class="@yield('permission')"><a href="{{ route('admin.permission.index') }}"><i class="ti ti ti-key fs-16 me-2"></i><span>Permission</span></a></li>
                            @endif

                            @if(auth("admin")->user()->can("index.role"))
                                <li class="@yield('role')"><a href="{{ route('admin.role.index') }}"><i class="ti ti-jump-rope fs-16 me-2"></i><span>Role</span></a></li>
                            @endif
                            
                            @if(auth("admin")->user()->can("index.admin-role"))
                                <li class="@yield('admin-role')"><a href="{{ route('admin.admin-role.index') }}"><i class="ti ti-shield-up fs-16 me-2"></i><span>Admin</span></a></li>
                            @endif
                        </ul>
                    </li>
                @endif


                {{-- Settings --}}
                <li class="submenu-open">
                    <h6 class="submenu-hdr">Settings</h6>
                    <ul>
                        <li class="submenu">
                            <a href="javascript:void(0);" class="@yield('general-setting')"><i class="ti ti-settings fs-16 me-2"></i><span>General Settings</span><span class="menu-arrow"></span></a>
                            <ul style="display: none;">
                                <li><a href="{{ route('admin.general-settings.profile') }}" class="@yield('profile-setting')">Profile</a></li>
                                <li><a href="{{ route('admin.general-settings.security') }}" class="@yield('security-setting')">Security</a></li>
                                <li><a href="{{ route('admin.general-settings.notification') }}" class="@yield('notification-setting')">Notifications</a></li>
                            </ul>
                        </li>

                        <li class="submenu">
                            <a href="javascript:void(0);" class="@yield('website-setting')"><i class="ti ti-world fs-16 me-2"></i><span>Website Settings</span><span class="menu-arrow"></span></a>
                            <ul style="display: none;">
                                <li><a href="{{ route('admin.website-settings.system') }}" class="@yield('system-setting')">System Settings</a></li>
                                
                                <li><a href="{{ route('admin.website-settings.company') }}" class="@yield('company-setting')">Company Settings </a></li>
                                
                                <li><a href="{{ route('admin.website-settings.localization') }}" class="@yield('localization-setting')">Localization</a></li>
                                
                                <li><a href="{{ route('admin.website-settings.prefixes') }}" class="@yield('prefixes-setting')">Prefixes</a></li>
                            </ul>
                        </li>

                        <li class="submenu">
                            <a href="javascript:void(0);" class="@yield('app-setting')"><i class="ti ti-device-mobile fs-16 me-2"></i>
                                <span>App Settings</span><span class="menu-arrow"></span>
                            </a>
                            <ul style="display: none;">
                                <li><a href="{{ route('admin.app-settings.invoice') }}" class="@yield('invoice-setting')">Invoice Settings</a></li>
                                <li><a href="{{ route('admin.app-settings.invoice.template') }}" class="@yield('invoice-template')">Invoice Template</a></li>
                                <li><a href="{{ route('admin.app-settings.printer') }}" class="@yield('printer-setting')">Printer</a></li>
                                <li><a href="{{ route('admin.app-settings.pos.setting') }}" class="@yield('pos-setting')">POS</a></li>
                                <li><a href="{{ route('admin.app-settings.signature') }}" class="@yield('signature-setting')">Signature</a></li>
                            </ul>
                        </li>

                        <li class="submenu">
                            <a href="javascript:void(0);" class="@yield('system-setting')"><i class="ti ti-device-desktop fs-16 me-2"></i>
                                <span>System Settings</span><span class="menu-arrow"></span>
                            </a>
                            <ul style="display: none;">
                                <li class="submenu submenu-two"><a href="javascript:void(0);" class="@yield('system-setting')">Email<span class="menu-arrow inside-submenu"></span></a>
                                    <ul>
                                        <li><a href="{{ route('admin.system-settings.email.settings') }}" class="@yield('email-setting')">Email Settings</a></li>
                                        <li><a href="{{ route('admin.system-settings.email.template') }}" class="@yield('email-template')">Email Template</a></li>
                                    </ul>
                                </li>
                                <li><a href="{{ route('admin.system-settings.otp.setting') }}" class="@yield('otp-setting')">OTP</a></li>
                            </ul>
                        </li>

                        <li class="submenu">
                            <a href="javascript:void(0);" class="@yield('financial-setting')"><i class="ti ti-settings-dollar fs-16 me-2"></i>
                                <span>Financial Settings</span><span class="menu-arrow"></span>
                            </a>
                            <ul>
                                <li><a href="{{ route('admin.financial-settings.taxRate.settings') }}" class="@yield('taxRate-setting')">Tax Rates</a></li>
                            </ul>
                        </li>

                        <li class="submenu">
                            <a href="javascript:void(0);" class="@yield('other-setting')"><i class="ti ti-settings-2 fs-16 me-2"></i>
                                <span>Other Settings</span><span class="menu-arrow"></span>
                            </a>
                            <ul >
                                @if(auth("admin")->user()->can("list.backup"))
                                    <li><a href="{{ route('admin.other-settings.list.backup') }}" class="@yield('backup-setting')">DB Backup</a></li>
                                @endif

                                <li><a href="{{ route('admin.other-settings.banIp.setting') }}" class="@yield('ban-ip-setting')">Ban IP Address</a></li>
                            </ul>
                        </li>

                        <li>
                            <a href="{{ url('/admin/logout') }}"><i class="ti ti-logout fs-16 me-2"></i><span>Logout</span> </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>