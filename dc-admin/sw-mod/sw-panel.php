<?php
// Memeriksa apakah koneksi database tidak ada atau tidak valid
if (empty($connection)) {
  // Jika tidak ada koneksi, arahkan ke halaman 404
  header('location:./404');
} else {
  // Memulai penulisan HTML untuk sidebar
  echo '<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <div class="slimScrollDiv">
    <section class="sidebar">
      <!-- Sidebar user panel -->
    
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu">
        <li class="header">MAIN NAVIGATION</li>';
  // Menandai menu aktif berdasarkan modul yang aktif
  if ($mod == 'home') {
    echo '<li class="active">';
  } else {
    echo '<li>';
  }
  echo '<a href="./"><i class="fa fa-home"></i><span>Dashboard</span></a></li>';
  // Menu untuk Master Data, dengan sub-menu
  if ($mod == 'karyawan' or $mod == 'jabatan' or $mod == 'shift' or $mod == 'lokasi') {
    echo '<li class="active treeview">';
  } else {
    echo '<li class="treeview">';
  }
  echo '
          <a href="#">
            <i class="fa fa-database"></i> <span>Master Data</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">';
  // Menu Data Karyawan
  if ($mod == 'karyawan') {
    echo '<li class="active">';
  } else {
    echo '<li>';
  }
  echo '<a href="./karyawan"><i class="fa fa-circle-o"></i> Data Karyawan</a></li>';
  // Menu Data Jabatan
  if ($mod == 'jabatan') {
    echo '<li class="active">';
  } else {
    echo '<li>';
  }
  echo '<a href="./jabatan"><i class="fa fa-circle-o"></i> Data Jabatan</a></li>';
  // Menu Data Jam Kerja
  if ($mod == 'shift') {
    echo '<li class="active">';
  } else {
    echo '<li>';
  }
  echo '<a href="shift"><i class="fa fa-circle-o"></i> Data Jam Kerja</a></li>';
  // Menu Data Lokasi
  if ($mod == 'lokasi') {
    echo '<li class="active">';
  } else {
    echo '<li>';
  }
  echo '<a href="./lokasi"><i class="fa fa-circle-o"></i> Data Lokasi</a></li>
          </ul>
        </li>';
  // Menu Data Permohonan Cuti
  if ($mod == 'cuty') {
    echo '<li class="active">';
  } else {
    echo '<li>';
  }
  echo '<a href="./cuty"><i class="fa fa-calendar" aria-hidden="true"></i> <span>Data Permohonan Cuti</span></a></li>';

  // Menu Absensi
  if ($mod == 'absensi') {
    echo '<li class="active">';
  } else {
    echo '<li>';
  }
  echo '<a href="./absensi"><i class="fa fa-list-alt" aria-hidden="true"></i> <span>Data Absensi</span></a></li>';
  // Menu Pengaturan Web
  if ($mod == 'setting') {
    echo '<li class="active">';
  } else {
    echo '<li>';
  }
  echo '<a href="./setting"><i class="fa fa-cogs" aria-hidden="true"></i> <span>Pengaturan Web</span></a></li>';
  // Menu Admin
  if ($mod == 'user') {
    echo '<li class="active">';
  } else {
    echo '<li>';
  }
  // Menu Logout
  echo '<a href="./user"><i class="fa fa-user"></i> <span>Admin</span></a></li>'; ?>
  <li><a href="javascript:void();" onClick="location.href='./logout';"><i class="fa fa-sign-out text-red"></i>
      <span>Keluar</span></a></li>
  <?php echo '
      </ul>
    </section>
  </div>
    <!-- /.sidebar -->
  </aside>';
} ?>