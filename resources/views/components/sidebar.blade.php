<div class="sticky">
    <div class="app-sidebar__overlay" data-bs-toggle="sidebar"></div>
    <div class="app-sidebar bg-dark">
        <div class="side-header bg-dark" style="border-bottom: 0px;">
            <a class="header-brand1" href="index.html">
                <img src="{{ url('assets/images/logo/logopilwp.png') }}" class="header-brand-img desktop-logo" alt="logo">
                <img src="{{ url('assets/images/logo/logopilwp.png') }}" class="header-brand-img toggle-logo" alt="logo">
                <img src="{{ url('assets/images/logo/logopilwp.png') }}" class="header-brand-img light-logo" alt="logo">
                <img src="{{ url('assets/images/logo/logopilwp.png') }}" class="header-brand-img light-logo1" alt="logo">
            </a>
            <!-- LOGO -->
        </div>
        <div class="main-sidemenu">
            <div class="slide-left disabled" id="slide-left"><svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24" viewBox="0 0 24 24"><path d="M13.293 6.293 7.586 12l5.707 5.707 1.414-1.414L10.414 12l4.293-4.293z"/></svg></div>
            <ul class="side-menu">
                <li class="sub-category text-white">
                    <h3>Menu</h3>
                </li>
                <li class="slide {{ request()->is('dashboard') ?'bg-primary' : '' }}" style="border-radius: 5px;">
                    <a class="side-menu__item has-link" data-bs-toggle="slide" href="{{ route('dashboard.index') }}"><i class="side-menu__icon fe fe-home text-white"></i><span class="side-menu__label text-white">Dashboard</span></a>
                </li>
                <li class="slide">
                    <a class="side-menu__item {{ request()->is('marketing/overview') || request()->is('marketing/export') || request()->is('marketing/export/create') || request()->is('marketing/export/*') || request()->is('marketing/import') || request()->is('marketing/import/create') || request()->is('marketing/import/*') || request()->is('marketing/report') ?'bg-primary' : '' }}" style="border-radius: 5px;" data-bs-toggle="slide" href="javascript:void(0)"><i class="side-menu__icon fe fe-bar-chart-2 text-white"></i><span class="side-menu__label text-white">Marketing</span><i class="angle fe fe-chevron-right text-white"></i></a>
                    <ul class="slide-menu"  style="display: {{ request()->is('marketing/overview') || request()->is('marketing/export') || request()->is('marketing/export/create') || request()->is('marketing/export/*') || request()->is('marketing/import') || request()->is('marketing/import/create') || request()->is('marketing/import/*') || request()->is('marketing/report') ?'block' : 'none' }}">
                        <li class="side-menu-label1 text-white"><a href="javascript:void(0)">Marketing</a></li>
                        <li><a href="{{ route('marketing.overview.index') }}" class="slide-item {{ request()->is('marketing/overview') ?'text-primary' : 'text-white' }}"> Overview</a></li>
                        <li><a href="{{ route('marketing.export.index') }}" class="slide-item {{ request()->is('marketing/export') || request()->is('marketing/export/create') || request()->is('marketing/export/*') ?'text-primary' : 'text-white' }}"> Export</a></li>
                        <li><a href="{{ route('marketing.import.index') }}" class="slide-item {{ request()->is('marketing/import') || request()->is('marketing/import/create') || request()->is('marketing/import/*') ?'text-primary' : 'text-white' }}"> Import</a></li>
                        <li><a href="{{ route('marketing.report.index') }}" class="slide-item {{ request()->is('marketing/report') ?'text-primary' : 'text-white' }}"> Report</a></li>
                    </ul>
                </li>
                <li class="slide">
                    <a class="side-menu__item {{ request()->is('operation/overview') || request()->is('operation/export') || request()->is('operation/export/create') || request()->is('operation/export/*') || request()->is('operation/import') || request()->is('operation/import/create') || request()->is('operation/import/*') || request()->is('operation/report') || request()->is('operation/report/*') ?'bg-primary' : '' }}" style="border-radius: 5px;" data-bs-toggle="slide" href="javascript:void(0)"><i class="side-menu__icon fe fe-maximize-2 text-white"></i><span class="side-menu__label text-white">Operation</span><i class="angle fe fe-chevron-right text-white"></i></a>
                    <ul class="slide-menu" style="display: {{ request()->is('operation/overview') || request()->is('operation/export') || request()->is('operation/export/create') || request()->is('operation/export/*') || request()->is('operation/import') || request()->is('operation/import/create') || request()->is('operation/import/*') || request()->is('operation/report') || request()->is('operation/report/*') ?'block' : 'none' }}">
                        <li class="side-menu-label1"><a href="javascript:void(0)">Operation</a></li>
                        <li><a href="{{ route('operation.export.index') }}" class="slide-item {{ request()->is('operation/export') || request()->is('operation/export/create') || request()->is('operation/export/*') ?'text-primary' : 'text-white' }}"> Export</a></li>
                        <li><a href="{{ route('operation.import.index') }}" class="slide-item {{ request()->is('operation/import') || request()->is('operation/import/create') || request()->is('operation/import/*') ?'text-primary' : 'text-white' }}"> Import</a></li>
                        <li><a href="{{ route('operation.report.index') }}" class="slide-item {{ request()->is('operation/report') || request()->is('operation/report/*') ?'text-primary' : 'text-white' }}"> Report</a></li>
                    </ul>
                </li>
                <li class="slide {{ request()->is('realtime-tracking') || request()->is('realtime-tracking/*') ?'bg-primary' : '' }}"  style="border-radius: 5px;">
                    <a href="{{ route('realtime-tracking.index') }}" class="side-menu__item has-link" data-bs-toggle="slide" href=""><i class="side-menu__icon fe fe-send text-white"></i><span class="side-menu__label text-white">Realtime Tracking</span></a>
                </li>

                <li class="slide">
                    <a class="side-menu__item {{ request()->is('finance/master-data') || request()->is('finance/master-data/*') || request()->is('finance/piutang') || request()->is('finance/piutang/*') ?'bg-primary' : '' }}" data-bs-toggle="slide" href="javascript:void(0)" style="border-radius: 5px;"><i class="side-menu__icon fe fe-pie-chart text-white"></i><span class="side-menu__label text-white">Finance</span><i class="angle fe fe-chevron-right text-white"></i></a>
                    <ul class="slide-menu"  style="display: {{ request()->is('finance/master-data') || request()->is('finance/master-data/*') || request()->is('finance/piutang') || request()->is('finance/piutang/*')  ?'block' : 'none' }}">
                        <li class="side-menu-label1 text-white"><a href="javascript:void(0)">Finance</a></li>
                        <li><a href="{{ route('finance.master-data.index') }}" class="slide-item {{ request()->is('finance/master-data') || request()->is('finance/master-data/*') ?'text-primary' : 'text-white' }}"> Data Master</a></li>
                        <li><a href="{{ route('finance.piutang.index') }}" class="slide-item {{ request()->is('finance/piutang') || request()->is('finance/piutang/*') ?'text-primary' : 'text-white' }}"> Sales</a></li>
                        <li><a href="" class="slide-item text-white"> Receipt</a></li>
                        <li><a href="" class="slide-item text-white"> Payments</a></li>
                        <li><a href="" class="slide-item text-white"> Report</a></li>
                    </ul>
                </li>

                <li class="slide" style="border-radius: 5px;">
                    <a class="side-menu__item has-link" data-bs-toggle="slide" href=""><i class="side-menu__icon fe fe-folder text-white"></i><span class="side-menu__label text-white">Report</span></a>
                </li>
                <li class="slide">
                    <a class="side-menu__item {{ request()->is('utility/user-role') || request()->is('utility/user-role/create' ) || request()->is('utility/user-list') || request()->is('utility/user-list/create') ?'bg-primary' : '' }}" style="border-radius: 5px;" data-bs-toggle="slide" href="javascript:void(0)"><i class="side-menu__icon fe fe-cpu text-white"></i><span class="side-menu__label text-white">Utility</span><i class="angle fe fe-chevron-right text-white"></i></a>
                    <ul class="slide-menu"  style="display: {{ request()->is('utility/user-role') || request()->is('utility/user-role/create' ) || request()->is('utility/user-list') || request()->is('utility/user-list/create') ?'block' : 'none' }}">
                        <li class="side-menu-label1 text-white"><a href="javascript:void(0)">Utility</a></li>
                        <li><a href="{{ route('utility.user-role.index') }}" class="slide-item {{ request()->is('utility/user-role' ) || request()->is('utility/user-role/create' ) ?'text-primary' : 'text-white' }}"> User Role</a></li>
                        <li><a href="{{ route('utility.user-list.index') }}" class="slide-item {{ request()->is('utility/user-list') || request()->is('utility/user-list/create') ?'text-primary' : 'text-white' }}"> User List</a></li>
                    </ul>
                </li>
                <li class="slide">
                    <a class="side-menu__item has-link" data-bs-toggle="slide" href="{{ route('logout') }}" onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();"><i class="side-menu__icon fe fe-log-out text-white"></i><span class="side-menu__label text-white">Logout</span></a>
                </li>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>

            </ul>
            <div class="slide-right" id="slide-right"><svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24" viewBox="0 0 24 24"><path d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z"/></svg></div>
        </div>
    </div>
</div>