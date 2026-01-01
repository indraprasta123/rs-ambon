<?php
// Memeriksa apakah koneksi ada
if (empty($connection)) {
  // Jika tidak ada koneksi, redirect ke halaman utama
  header('location:../../');
} else {
  // Jika koneksi ada, masukkan file yang diperlukan
  include_once 'sw-mod/sw-panel.php'; // Memasukkan file panel admin
  require_once '../sw-library/phpqrcode/qrlib.php'; // Memasukkan library QR Code

  echo '
  <div class="content-wrapper">'; // Memulai wrapper konten

  // Menangani berbagai operasi berdasarkan parameter 'op'
  switch (@$_GET['op']) {
    default:
      // Menampilkan header dan breadcrumb
      echo '
<section class="content-header">
  <h1>Data<small> Lokasi</small></h1>
    <ol class="breadcrumb">
      <li><a href="./"><i class="fa fa-dashboard"></i> Beranda</a></li>
      <li class="active">Data Lokasi</li>
    </ol>
</section>';
      // Menampilkan konten utama
      echo '
<section class="content">
  <div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
      <div class="box box-solid">
        <div class="box-header with-border">
          <h3 class="box-title"><b>Data Lokasi RSU AMBON</b></h3>
          <div class="box-tools pull-right">';
      // Menampilkan tombol tambah jika level pengguna adalah 1
      if ($level_user == 1) {
        echo '
            <button type="button" class="btn btn-success btn-flat" data-toggle="modal" data-target="#modalAdd"><i class="fa fa-plus"></i> Tambah Baru</button>';
      } else {
        // Menampilkan tombol tambah yang dinonaktifkan jika level pengguna bukan 1
        echo '
            <button type="button" class="btn btn-success btn-flat access-failed"><i class="fa fa-plus"></i> Tambah Baru</button>';
      }
      echo '
          </div>
        </div>
        <div class="box-body">
          <div class="table-responsive">
            <table id="swdatatable" class="table table-bordered">
              <thead>
              <tr>
                <th style="width:20px" class="text-center">No</th>
                <th>Ruang kerja</th>
                <th>Lokasi</th>
                <th class="text-center">Jumlah Karyawan</th>
                <th style="width:150px" class="text-center">Aksi</th>
              </tr>
              </thead>
              <tbody>';
      // Mengambil data lokasi dari database
      $query = "SELECT building_id, name, address FROM building ORDER BY building_id DESC";
      $result = $connection->query($query);
      if ($result->num_rows > 0) {
        $no = 0;
        while ($row = $result->fetch_assoc()) {
          // Menghitung jumlah karyawan di setiap lokasi
          $employees_count = "SELECT id FROM employees WHERE building_id='$row[building_id]'";
          $result_count = $connection->query($employees_count);
          $no++;
          echo '
                <tr>
                  <td class="text-center">' . $no . '</td>
                  <td>' . $row['name'] . '</td>
                  <td>' . $row['address'] . '</td>
                  <td class="text-center"><span class="badge bg-yellow">' . $result_count->num_rows . '</span></td>
                  <td class="text-right">
                    <div class="btn-group">';
          // Menampilkan tombol edit dan hapus berdasarkan level pengguna
          if ($level_user == 1) {
            echo '
                      <a href="#modalEdit" class="btn btn-warning btn-xs enable-tooltip" title="Edit" data-toggle="modal"
            onclick="getElementById(\'txtid\').value=\'' . $row['building_id'] . '\';getElementById(\'txtname\').value=\'' . $row['name'] . '\';getElementById(\'txtaddress\').value=\'' . $row['address'] . '\';"><i class="fa fa-pencil-square-o"></i> Ubah</a>
                      <button data-id="' . epm_encode($row['building_id']) . '" class="btn btn-xs btn-danger delete" title="Hapus"><i class="fa fa-trash-o"></i> Hapus</button>';
          } else {
            // Tombol edit dan hapus dinonaktifkan jika level pengguna bukan 1
            echo '
                      <button type="button" class="btn btn-warning btn-xs access-failed enable-tooltip" title="Edit"><i class="fa fa-pencil-square-o"></i> Ubah</button>
                      <button type="button" class="btn btn-xs btn-danger access-failed" title="Hapus"><i class="fa fa-trash-o"></i> Hapus</button>';
          }
          echo '
                    </div>
                  </td>
                </tr>';
        }
      }
      echo '
              </tbody>
            </table>
          </div>
      </div>
    </div>
  </div> 
</section>

<!-- Add -->
<div class="modal fade" id="modalAdd" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Tambah Baru</h4>
      </div>
      <form class="form validate add-lokasi">
      <div class="modal-body">
        <div class="form-group">
            <label>Ruang kerja</label>
            <input type="text" class="form-control" name="name" required>
        </div>

        <div class="form-group">
            <label>Lokasi</label>
            <textarea class="form-control address" name="address" rows="3" required></textarea>
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary pull-left"><i class="fa fa-check"></i> Simpan</button>
        <button type="button" class="btn btn-danger pull-right" data-dismiss="modal"><i class="fa fa-remove"></i> Batal</button>
      </div>
    </form>
    </div>
  </div>
</div>

<!-- MODAL EDIT -->
<div class="modal fade" id="modalEdit" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Update Data</h4>
      </div>
      <form class="form update-lokasi" method="post">
       <input type="hidden" name="id" id="txtid" required value="" readonly>
      <div class="modal-body">
          <div class="form-group">
              <label>Ruang kerja</label>
              <input type="text" class="form-control" id="txtname" name="name" required>
          </div>

          <div class="form-group">
            <label>Lokasi</label>
            <textarea class="form-control address" id="txtaddress" name="address" rows="3" required></textarea>
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary pull-left"><i class="fa fa-check"></i> Simpan</button>
        <button type="button" class="btn btn-danger pull-right" data-dismiss="modal"><i class="fa fa-remove"></i> Batal</button>
      </div>
    </form>
    </div>
  </div>
</div>';
      break;
  }
  echo '</div>'; // Menutup wrapper konten
}
?>