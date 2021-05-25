<div class="sidebar" data-color="orange">
        <!--
        Tip 1: You can change the color of the sidebar using: data-color="blue | green | orange | red | yellow"
    -->
        <div class="logo text-center">
          <!-- <a href="http://www.creative-tim.com" class="simple-text logo-mini">
          </a> -->
          <a href="http://www.creative-tim.com" class="simple-text logo-normal">
            Manager tambah ilmu
          </a>
        </div>
        <div class="sidebar-wrapper" id="sidebar-wrapper">
          <ul class="nav">
            <li class="{{ (request()->is('admin/dashboard')) ? 'active' : '' }}">
              <a href="{{ route('dashboard') }}">
                <i class="now-ui-icons location_world"></i>
                <p>Dashboard</p>
              </a>
            </li>
            <li class="{{ (request()->is('admin/transaksi*')) ? 'active' : '' }}">
              <a href="{{ route('home-transaksi-manual') }}">
                <i class="now-ui-icons business_money-coins"></i>
                <p>
                     @livewire('admin.manualtransaksi.notif-count')

                </p>
              </a>
            </li>
            <li class="{{ (request()->is('admin/kel-mentor*')) ? 'active' : '' }}">
              <a href="{{ route('kel-mentor.index') }}">
                <i class="now-ui-icons users_single-02"></i>
                <p>Mentor</p>
              </a>
            </li>
            <li class="{{ (request()->is('admin/kel-kememberan*')) ? 'active' : '' }}">
              <a href="{{ route('kel-kememberan.index') }}">
                <i class="now-ui-icons files_paper"></i>
                <p>Kememberan</p>
              </a>
            </li>
            <li class="{{ (request()->is('admin/kelas*')) ? 'active' : '' }}">
              <a href="{{ route('kelas.index') }}">
                <i class="now-ui-icons education_hat"></i>
                <p>Kelas</p>
              </a>
            </li>
            <li class="{{ (request()->is('admin/hadiah*')) ? 'active' : '' }}">
              <a href="{{ route('index-hadiah') }}">
                <i class="now-ui-icons design_app"></i>
                <p>
                    @livewire('admin.hadiah.notif-count')
                </p>
              </a>
            </li>
          </ul>
        </div>
      </div>
