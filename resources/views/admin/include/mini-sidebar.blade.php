<div class="settings-sidebar" id="sidebar2">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu5" class="sidebar-menu">
            <h4 class="fw-bold fs-18 mb-2 pb-2">Settings</h4>
            <ul>
                <li class="submenu-open">
                    <ul>
                        <li class="submenu">
                            <a href="javascript:void(0);" class="@yield('general-setting')">
                                <i class="ti ti-settings fs-18"></i>
                                <span class="fs-14 fw-medium ms-2">General Settings</span>
                                <span class="menu-arrow"></span>
                            </a>
                            <ul>
                                <li><a href="{{ route('admin.general-settings.profile') }}" class="@yield('profile-setting')">Profile</a></li>
                                <li><a href="{{ route('admin.general-settings.security') }}" class="@yield('security-setting')">Security</a></li>
                                <li><a href="{{ route('admin.general-settings.notification') }}" class="@yield('notification-setting')">Notifications</a></li>
                            </ul>
                        </li>

                        <li class="submenu">
                            <a href="javascript:void(0);" class="@yield('website-setting')">
                                <i class="ti ti-world fs-18"></i>
                                <span class="fs-14 fw-medium ms-2">Website Settings</span>
                                <span class="menu-arrow"></span>
                            </a>
                            <ul>
                                <li><a href="{{ route('admin.website-settings.system') }}" class="@yield('system-setting')">System Settings</a></li>
                                
                                <li><a href="{{ route('admin.website-settings.company') }}" class="@yield('company-setting')">Company Settings </a></li>
                                
                                <li><a href="{{ route('admin.website-settings.localization') }}" class="@yield('localization-setting')">Localization</a></li>
                                
                                <li><a href="{{ route('admin.website-settings.prefixes') }}" class="@yield('prefixes-setting')">Prefixes</a></li>
                            </ul>
                        </li>

                        <li class="submenu">
                            <a href="javascript:void(0);" class="@yield('app-setting')">
                                <i class="ti ti-device-mobile fs-18"></i>
                                <span class="fs-14 fw-medium ms-2">App Settings</span>
                                <span class="menu-arrow"></span>
                            </a>
                            <ul>
                                <li><a href="{{ route('admin.app-settings.invoice') }}" class="@yield('invoice-setting')">Invoice Settings</a></li>
                                <li><a href="{{ route('admin.app-settings.invoice.template') }}" class="@yield('invoice-template')">Invoice Template</a></li>
                                <li><a href="{{ route('admin.app-settings.printer.index') }}" class="@yield('printer-setting')">Printer</a></li>
                                <li><a href="{{ route('admin.app-settings.pos.setting') }}" class="@yield('pos-setting')">POS</a></li>
                                <li><a href="{{ route('admin.app-settings.signature.index') }}" class="@yield('signature-setting')">Signature</a></li>
                            </ul>
                        </li>

                        <li class="submenu">
                            <a href="javascript:void(0);" class="@yield('system-setting')">
                                <i class="ti ti-device-desktop fs-18"></i>
                                <span class="fs-14 fw-medium ms-2">System Settings</span>
                                <span class="menu-arrow"></span>
                            </a>
                            <ul style="display: none;">
                                <li><a href="{{ route('admin.system-settings.email.settings') }}" class="@yield('email-setting')">Email Settings</a></li>
                                <li><a href="{{ route('admin.system-settings.email.template') }}" class="@yield('email-template')">Email Template</a></li>
                                <li><a href="{{ route('admin.system-settings.otp.setting') }}" class="@yield('otp-setting')">OTP</a></li>
                            </ul>
                        </li>

                        <li class="submenu">
                            <a href="javascript:void(0);" class="@yield('financial-setting')">
                                <i class="ti ti-settings-dollar fs-18"></i>
                                <span class="fs-14 fw-medium ms-2">Financial Settings</span>
                                <span class="menu-arrow"></span>
                            </a>
                            <ul style="display: none;">
                                <li><a href="{{ route('admin.financial-settings.taxRate.settings') }}" class="@yield('taxRate-setting')">Tax Rates</a></li>
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

                                <li><a href="{{ route('admin.other-settings.banIp.index') }}" class="@yield('ban-ip-setting')">Ban IP Address</a></li>
                            </ul>
                        </li>
                    </ul>								
                </li>
            </ul>
        </div>
    </div>
</div>	