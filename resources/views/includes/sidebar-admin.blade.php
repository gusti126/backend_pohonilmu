<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('dashboard') }}">
                <div class="sidebar-brand-text" style="color: gold">Management Admin</div>
            </a>
            <li class="nav-item {{ (request()->is('pengembang/dashboard')) ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('dashboard') }}">
                    <span>Dashboard</span></a>
            </li>
            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item {{ (request()->is('admin/kel-mentor*')) ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('kel-mentor.index') }}">
                    <span>Mentor</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">
            <li class="nav-item {{ (request()->is('pengembang/kelas*')) ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('kelas.index') }}">
                    <span>Kelas</span></a>
            </li>
            <hr class="sidebar-divider d-none d-md-block">
            <li class="nav-item ">
                <a class="nav-link" href="{{ route('keluar') }}">
                    <span>Logout</span></a>
            </li>
            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
