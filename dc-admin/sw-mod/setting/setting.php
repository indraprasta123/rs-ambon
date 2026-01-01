<?php
// Memeriksa apakah koneksi database ada
if (empty($connection)) {
  // Jika tidak ada koneksi, redirect ke halaman utama
  header('location:../../');
} else {
  // Jika koneksi ada, menyertakan panel kontrol
  include_once 'sw-mod/sw-panel.php';
  // Menampilkan struktur HTML untuk halaman pengaturan web
  echo '
  <div class="content-wrapper">';
  // Menggunakan switch untuk menentukan tampilan berdasarkan parameter GET 'op'
  switch (@$_GET['op']) {
    default:
      // Menampilkan header konten dengan breadcrumb
      echo '
<section class="content-header">
  <h1>Setting Web</h1>
    <ol class="breadcrumb">
      <li><a href="./"><i class="fa fa-dashboard"></i> Beranda</a></li>
      <li class="active">Setting Web</li>
    </ol>
</section>';
      // Menampilkan konten utama dengan tab navigasi
      echo '
<section class="content">
  <div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

    <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#tab_1" data-toggle="tab"  onclick="loadSettingUmum();">Pengaturan Web</a></li>
              <li><a href="#tab_2" data-toggle="tab"  onclick="loadSettingProfile();">Profil</a></li>
            </ul>
            <div class="tab-content">
              <div id="load">

              </div>
            </div>
            <!-- /.tab-content -->
          </div>
          <!-- nav-tabs-custom -->


      
</div>
</section>';
      break;
  } ?>

  </div>
<?php } ?>