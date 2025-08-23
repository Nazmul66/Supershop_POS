<div class="settings-sidebar" id="sidebar2">
    <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: 100%; height: 639px;"><div class="sidebar-inner slimscroll" style="overflow: hidden; width: 100%; height: 291px;">
        <div id="sidebar-menu5" class="sidebar-menu">
            <h4 class="fw-bold fs-18 mb-2 pb-2">Settings</h4>
            <ul>
                <li class="submenu-open">
                    <ul>
                        <li class="submenu">
                            <a href="javascript:void(0);">
                                <i class="ti ti-settings fs-18"></i>
                                <span class="fs-14 fw-medium ms-2">General Settings</span>
                                <span class="menu-arrow"></span>
                            </a>
                            <ul>
                                <li><a href="general-settings.html">Profile</a></li>
                                <li><a href="security-settings.html">Security</a></li>
                                <li><a href="notification.html">Notifications</a></li>
                                <li><a href="connected-apps.html">Connected Apps</a></li>
                            </ul>
                        </li>
                        <li class="submenu">
                            <a href="javascript:void(0);">
                                <i class="ti ti-world fs-18"></i>
                                <span class="fs-14 fw-medium ms-2">Website Settings</span>
                                <span class="menu-arrow"></span>
                            </a>
                            <ul>
                                <li><a href="system-settings.html">System Settings</a></li>
                                <li><a href="company-settings.html">Company Settings </a></li>
                                <li><a href="localization-settings.html">Localization</a></li>
                                <li><a href="prefixes.html">Prefixes</a></li>
                                <li><a href="preference.html">Preference</a></li>
                                <li><a href="appearance.html">Appearance</a></li>
                                <li><a href="social-authentication.html">Social Authentication</a></li>
                                <li><a href="language-settings.html">Language</a></li>
                            </ul>
                        </li>

                        <li class="submenu">
                            <a href="javascript:void(0);" class="@yield('other-setting')">
                                <i class="ti ti-settings-2 fs-18"></i>
                                <span class="fs-14 fw-medium ms-2">Other Settings</span>
                                <span class="menu-arrow"></span>
                            </a>
                            <ul>
                                @if(auth("admin")->user()->can("list.backup"))
                                    <li><a href="{{ route('admin.other-settings.list.backup') }}" class="@yield('backup-setting')">DB Backup</a></li>
                                @endif

                                <li><a href="ban-ip-address.html" class="">Ban IP Address </a></li>
                            </ul>
                        </li>
                    </ul>								
                </li>
            </ul>
        </div>
    </div>
    
    <div class="slimScrollBar" style="background: rgb(204, 204, 204); width: 7px; position: absolute; top: 0px; opacity: 0.4; display: none; border-radius: 7px; z-index: 99; right: 1px; height: 217.131px;"></div><div class="slimScrollRail" style="width: 7px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 7px; background: rgb(51, 51, 51); opacity: 0.2; z-index: 90; right: 1px;"></div></div>
</div>	