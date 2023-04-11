<div class="main-sidebar">
    <aside id="sidebar-wrapper">
      <div class="sidebar-brand">
        <a href="index.html">e-Absensi</a>
      </div>
      <div class="sidebar-brand sidebar-brand-sm">
        <a href="index.html">EB</a>
      </div>
      <ul class="sidebar-menu">
          <li class="menu-header">Dashboard</li>
          <li class="nav-item dropdown {{ Request::is('admin/dashboard') ? 'active' : '' }}">
            <a href="/admin/dashboard" class="nav-link"><i class="fas fa-th-large"></i><span>Dashboard</span></a>
          </li>
          <li class="menu-header">MENU UTAMA</li>
          <li class="{{ Request::is('admin/office*') ? 'active' : '' }}"><a class="nav-link " href="{{ Route('office') }}"><i class="fa fa-users"></i> <span>Daftar Pejabat</span></a></li>
          <li class="menu-header">PENGATURAN</li>
          <li class="{{ Request::is('admin/profile') ? 'active' : '' }}"><a class="nav-link" href="{{ Route('admin-profile') }}"><i class="far fa-user"></i> <span>Profil</span></a></li>
        </ul>
    </aside>
  </div>