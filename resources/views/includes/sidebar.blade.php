<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('pengajar.index') }}">
                <div class="sidebar-brand-text" style="color: gold">
                    @if (Auth::user()->role === 'admin')
                        Management Admin
                    @else
                        Pengembang
                    @endif
                </div>
            </a>
            <li class="nav-item {{ (request()->is('pengembang/dashboard')) ? 'active' : '' }}">
                @if (Auth::user()->role === 'admin')
                    <a class="nav-link" href="{{ route('pendapatan') }}">
                    <span>Dashboard</span></a>
                @else
                    <a class="nav-link" href="{{ route('dashboard') }}">
                    <span>Dashboard Pengembang</span></a>
                @endif
            </li>
            <!-- Divider -->
            <hr class="sidebar-divider my-0">
            @if (Auth::user()->role === 'admin')
                <li class="nav-item {{ (request()->is('admin/kel-kememberan*')) ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('kel-kememberan.index') }}">
                        <span>Kememberan</span>
                    </a>
                </li>
                <hr class="sidebar-divider my-0">
            @endif
            @if (Auth::user()->role === 'admin')
                <li class="nav-item {{ (request()->is('admin/kel-berlangganan*')) ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('kel-berlangganan.index') }}">
                        <span>Berlangganan</span>
                    </a>
                </li>
                <hr class="sidebar-divider my-0">
            @endif

            @if (Auth::user()->role === 'admin')
                <li class="nav-item {{ (request()->is('admin/kel-transaksi*')) ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('kel-transaksi') }}">
                        <span>Transaksi</span>
                    </a>
                </li>
                <hr class="sidebar-divider my-0">
            @endif

            @if (Auth::user()->role === 'admin')
                <li class="nav-item {{ (request()->is('admin/kel-pengembang*')) ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('kel-pengembang.index') }}">
                        <span>Pengembang</span>
                    </a>
                </li>
                <hr class="sidebar-divider my-0">
            @endif

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
