@php
$prefix = Request::route()->getPrefix();
$route = Route::current()->getName();
@endphp
<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar-->
    <section class="sidebar">

        <div class="user-profile">
            <div class="ulogo">
                <a href="index.html">
                    <!-- logo for regular state and mobile devices -->
                    <div class="d-flex align-items-center justify-content-center">
                        <img src="{{ asset('backend/images/logo-dark.png') }}" alt="">
                        <h3><b>diberlin</b></h3>
                    </div>
                </a>
            </div>
        </div>

        <!-- sidebar menu-->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="{{ $route == 'dashboard' ? 'active' : '' }}">
                <a href="{{ url('admin/dashboard') }}">
                    <i data-feather="pie-chart"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <li class="treeview">
                <a href="#">
                    <i data-feather="message-circle"></i>
                    <span>Application</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-right pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="chat.html"><i class="ti-more"></i>Chat</a></li>
                    <li><a href="calendar.html"><i class="ti-more"></i>Calendar</a></li>
                </ul>
            </li>

            <li class="treeview">
                <a href="#">
                    <i class="fa fa-car"></i> <span>Rental</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-right pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="mailbox_inbox.html"><i class="ti-more"></i>Inbox</a></li>
                    <li><a href="mailbox_compose.html"><i class="ti-more"></i>Compose</a></li>
                    <li><a href="mailbox_read_mail.html"><i class="ti-more"></i>Read</a></li>
                </ul>
            </li>

            <li class="treeview">
                <a href="#">
                    <i data-feather="file"></i>
                    <span>Pages</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-right pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="profile.html"><i class="ti-more"></i>Profile</a></li>
                    <li><a href="invoice.html"><i class="ti-more"></i>Invoice</a></li>
                    <li><a href="gallery.html"><i class="ti-more"></i>Gallery</a></li>
                    <li><a href="faq.html"><i class="ti-more"></i>FAQs</a></li>
                    <li><a href="timeline.html"><i class="ti-more"></i>Timeline</a></li>
                </ul>
            </li>

            <li class="header nav-small-cap">Table</li>

            <li class="treeview">
                <a href="#">
                    <i data-feather="grid"></i>
                    <span>Data Induk</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-right pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ $route == 'admin.category' ? 'active' : '' }}"><a
                            href="{{ route('admin.category') }}"><i class="ti-more"></i>Category Product</a></li>
                    <li
                        class="{{ $route == 'admin.categoryowner' || $route == 'admin.categoryowner.create' || $route == 'admin.categoryowner.edit' ? 'active' : '' }}">
                        <a href="{{ route('admin.categoryowner') }}"><i class="ti-more"></i>Type Owner</a>
                    </li>
                    <li
                        class='{{ $route == 'admin.bank' || $route == 'admin.bank.create' || $route == 'admin.bank.edit' ? 'active' : '' }}'>
                        <a href="{{ route('admin.bank') }}"><i class="ti-more"></i>Data Bank</a>
                    </li>
                </ul>
            </li>

            <!-- DATA RELASI -->
            <li class="treeview">
                <a href="#">
                    <i data-feather="grid"></i>
                    <span>Data Relasi</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-right pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li
                        class="{{ $route == 'admin.owner' || $route == 'admin.owner.create' || $route == 'admin.owner.edit' || $route == 'admin.owner.confirm' ? 'active' : '' }}">
                        <a href="{{ route('admin.owner') }}"><i class="ti-more"></i>Owner</a>
                    </li>
                    <li
                        class="{{ $route == 'admin.payowner.index' || $route == 'admin.payowner.create' || $route == 'admin.payowner.edit' ? 'active' : '' }}">
                        <a href="{{ route('admin.payowner.index') }}"><i class="ti-more"></i>Pay Owner</a>
                    </li>
                    <li class=''>
                        <a href=""><i class="ti-more"></i>Car</a>
                    </li>
                </ul>
            </li>

            <li class="header nav-small-cap">Setting</li>
            <li class="treeview">
                <a href="#">
                    <i data-feather="alert-triangle"></i>
                    <span>Management User</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-right pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="auth_login.html"><i class="ti-more"></i>Admin</a></li>
                    <li><a href="auth_register.html"><i class="ti-more"></i>User</a></li>
                </ul>
            </li>

        </ul>
    </section>

    <div class="sidebar-footer">
        <!-- item-->
        <a href="javascript:void(0)" class="link" data-toggle="tooltip" title="" data-original-title="Settings"
            aria-describedby="tooltip92529"><i class="ti-settings"></i></a>
        <!-- item-->
        <a href="mailbox_inbox.html" class="link" data-toggle="tooltip" title="" data-original-title="Email"><i
                class="ti-email"></i></a>
        <!-- item-->
        <a href="javascript:void(0)" class="link" data-toggle="tooltip" title="" data-original-title="Logout"><i
                class="ti-lock"></i></a>
    </div>
</aside>
