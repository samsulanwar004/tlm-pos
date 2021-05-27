<!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('dashboard.index') }}" class="brand-link">
      <img src="{{ asset('images/admin_images/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">TLM POS</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{ asset('images/admin_images/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="{{ url('profile') }}" class="d-block">{{Auth::user()->name}}</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="{{ route('dashboard.index') }}" class="nav-link" menu="dashboard">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>Dashboard</p>
            </a>
          </li>
          <li class="nav-item has-treeview" menu="master">
            <a href="#" class="nav-link">
              <i class="nav-icon far fa-hdd"></i>
              <p>
                Master
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <x-menu.li label="Tenant" route="master.tenant.index" menu="tenant"/>
            </ul>
          </li>
          <li class="nav-item">
            <a href="{{ route('pos.index') }}" class="nav-link" menu="pos">
              <i class="nav-icon fas fa-cash-register"></i>
              <p>Point Of Sale</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('history.index') }}" class="nav-link" menu="history">
              <i class="nav-icon fas fa-history"></i>
              <p>History</p>
            </a>
          </li>
          <li class="nav-item has-treeview" menu="report">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-book"></i>
              <p>
                Report
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <x-menu.li label="Report Order" route="report.order.index" menu="report_order"/>
            </ul>
          </li>
          @if(Auth::user()->hasAnyRole(['super-admin']))
            <li class="nav-item has-treeview" menu="administrator">
              <a href="#" class="nav-link">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                  Administrator
                  <i class="right fas fa-angle-left"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <x-menu.li label="User" route="administrator.user.index" menu="user"/>
                <x-menu.li label="Role" route="administrator.role.index" menu="role"/>
                <x-menu.li label="Permission" route="administrator.permission.index" menu="permission"/>
              </ul>
            </li>
          @endif
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>