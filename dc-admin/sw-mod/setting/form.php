<?php @session_start();

require_once '../../../sw-library/sw-config.php';

// Cek apakah sesi pengguna dan ID sesi ada, jika tidak, arahkan ke halaman login
if (empty($_SESSION['SESSION_USER']) && empty($_SESSION['SESSION_ID'])) {
  header('location:../../login/');
  exit;
} else {
  require_once '../../login/login_session.php'; // Memasukkan session login
  // Pilih aksi berdasarkan parameter GET 'action'
  switch (htmlentities(@$_GET['action'])) {

    case 'setting':
      echo '
      <!-- Form untuk pengaturan situs -->
      <form id="validate" class="form-horizontal update-setting" enctype="multipart/form-data" autocomplete="off">
          <div class="form-group">
            <label class="col-sm-2 control-label">Nama </label>
            <div class="col-sm-6">
              <input type="text" name="site_name" class="form-control" value="' . $site_name . '" required="">
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-2 control-label">Deskripsi </label>
            <div class="col-sm-6">
              <textarea name="site_description" class="form-control" rows="3" required="required">' . $site_description . '</textarea>
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-2 control-label">No Telp</label>
            <div class="col-sm-6">
              <input type="text" name="site_phone"  class="form-control" value="' . $site_phone . '" required="required">
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-2 control-label">Alamat </label>
            <div class="col-sm-6">
              <input type="text" name="site_address"  class="form-control" value="' . $site_address . '" required="required">
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-2 control-label">Email</label>
            <div class="col-sm-6">
              <input type="text" name="site_email"  class="form-control" value="' . $site_email . '" required="required">
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-2 control-label">Email Domain</label>
            <div class="col-sm-6">
              <input type="text" name="site_email_domain" class="form-control" value="' . $site_email_domain . '" required="required">
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-2 control-label">Alamat Webite</label>
            <div class="col-sm-6">
              <input type="text" name="site_url" id="site_url" class="form-control" value="' . $site_url . '" required="required">
            </div>
          </div>
          <hr>
          <div class="form-group">
            <label class="col-sm-2 control-label">Logo Website</label>
            <div class="col-sm-6">';
      // Menampilkan logo saat ini jika ada, atau gambar default jika tidak ada
      if ($site_logo == NULL) {
        echo '<img height="50" src="../sw-assets/img/default-50x50.jpg">';
      } else {
        echo '<img height="50" src="../sw-content/' . $site_logo . '">';
      }
      echo '<br><br>
            <input type="file" class="btn btn-default"  name="site_logo">
            <p class="text-red">*Kosongkan apabila tidak mengganti</p>
          </div>
        </div>

        <!-- Tombol Simpan dan Reset -->
        <div class="box-footer">
          <label class="col-sm-2 control-label"></label>
          <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">';
      // Menampilkan tombol Simpan jika pengguna memiliki level yang sesuai
      if ($level_user == 1) {
        echo '
            <button type="submit" class="btn bg-blue"><i class="fa fa fa-check"></i> Simpan</button>';
      } else {
        echo '<button type="button" class="btn bg-blue access-failed"><i class="fa fa fa-check"></i> Simpan</button>';
      }
      echo '
            <button type="reset" class="btn btn-danger">Reset</button>
          </div>
        </div>
        <!-- /.box-footer -->
    </form>';

      break;

    case 'profile':
      echo '
      <!-- Form untuk pengaturan profil perusahaan -->
      <form id="validate" class="form-horizontal update-profile" autocomplete="off">
          <div class="form-group">
            <label class="col-sm-2 control-label">Nama Perusahaan</label>
            <div class="col-sm-6">
              <input type="text" name="site_company" class="form-control" value="' . $site_company . '" required="">
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-2 control-label">Nama Direktur</label>
            <div class="col-sm-6">
               <input type="text" name="site_director" class="form-control" value="' . $site_director . '" required="">
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-2 control-label">Nama Manager</label>
            <div class="col-sm-6">
               <input type="text" name="site_manager" id="site_manager" class="form-control" value="' . $site_manager . '" required="">
            </div>
          </div>
          
        <!-- Tombol Simpan dan Reset -->
        <div class="box-footer">
          <label class="col-sm-2 control-label"></label>
          <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">';
      // Menampilkan tombol Simpan jika pengguna memiliki level yang sesuai
      if ($level_user == 1) {
        echo '
            <button type="submit" class="btn bg-blue"><i class="fa fa fa-check"></i> Simpan</button>';
      } else {
        echo '<button type="button" class="btn bg-blue access-failed"><i class="fa fa fa-check"></i> Simpan</button>';
      }
      echo '
            <button type="reset" class="btn btn-danger">Reset</button>
          </div>
        </div>
        <!-- /.box-footer -->
    </form>';

      break;
  }
}
