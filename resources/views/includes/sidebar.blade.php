<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('pengajar.index') }}">
                <div class="sidebar-brand-text" style="color: gold">
                    @if (Auth::user()->role === 'admin')
                        Management
                    @else
                        Penegmbang
                    @endif
                </div>
            </a>
            <li class="nav-item {{ (request()->is('pengembang/dashboard')) ? 'active' : '' }}">
                @if (Auth::user()->role === 'admin')
                    <a class="nav-link" href="{{ route('pendapatan') }}">
                    <span>Dashboard</span></a>
                @else
                    <a class="nav-link" href="{{ route('dashboard') }}">
                    <span>Dashboard</span></a>
                @endif
            </li>
            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item {{ (request()->is('pengembang/pengajar*')) ? 'active' : '' }}">

                @if (Auth::user()->role === 'admin')
                    <a class="nav-link" href="{{ route('kel-mentor.index') }}">
                @else
                    <a class="nav-link" href="{{ route('pengajar.index') }}">
                @endif
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
