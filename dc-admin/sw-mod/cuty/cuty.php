<?php
// Mengecek apakah koneksi database tidak ada atau kosong
if (empty($connection)) {
  // Jika tidak ada koneksi, redirect ke halaman utama
  header('location:../../');
} else {
  // Jika ada koneksi, masukkan panel dan tampilkan konten
  include_once 'sw-mod/sw-panel.php';
  echo '
  <div class="content-wrapper">';

  // Memeriksa parameter 'op' di URL dan menentukan tampilan yang sesuai
  switch (@$_GET['op']) {

    // Jika parameter 'op' tidak sesuai dengan yang diharapkan
    default:
      echo '
<section class="content-header">
  <h1>Data<small> Permohonan Cuti</small></h1>
    <ol class="breadcrumb">
      <li><a href="./"><i class="fa fa-dashboard"></i> Beranda</a></li>
      <li class="active">Data Permohonan Cuti</li>
    </ol>
</section>';
      echo '
<section class="content">
  <div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
      <div class="box box-solid">
        <div class="box-header with-border">
          <h3 class="box-title"><b>Data Permohonan Cuti</b></h3>
        </div>
        <div class="box-body">
          <div class="table-responsive">
            <table id="swdatatable" class="table table-bordered">
              <thead>
                <tr>
                  <th style="width: 10px">No</th>
                  <th>Nama</th>
                  <th>Cuti Dari</th>
                  <th>Sampai</th>
                  <th>Masuk Kerja</th>
                  <th class="text-center">Jumlah Cuti</th>
                  <th>Keperluan Cuti</th>
                  <th>Status</th>
                  <th style="width:150px" class="text-center">Aksi</th>
                </tr>
              </thead>
              <tbody>';

      // Query untuk mengambil data permohonan cuti
      $query = "SELECT employees.employees_name,cuty.* FROM employees,cuty WHERE employees.id=cuty.employees_id order by cuty.cuty_id DESC";
      $result = $connection->query($query);

      // Memeriksa jika ada hasil dari query
      if ($result->num_rows > 0) {
        $no = 0;
        // Mengambil setiap baris hasil query
        while ($row = $result->fetch_assoc()) {
          // Menentukan status berdasarkan nilai cuty_status
          if ($row['cuty_status'] == '1') {
            $status = '<span class="text-primary">Disetujui</span>';
          } elseif ($row['cuty_status'] == '2') {
            $status = '<span class="text-danger">Tidak Disetujui</span>';
          } else {
            $status = '<span class="text-muted">Menunggu</span>';
          }
          $no++;
          echo '
      <tr>
        <td class="text-center">' . $no . '</td>
        <td>' . $row['employees_name'] . '</td>
        <td>' . tgl_ind($row['cuty_start']) . '</td>
        <td>' . tgl_ind($row['cuty_end']) . '</td>
        <td>' . tgl_ind($row['date_work']) . '</td>
        <td class="text-center"><label class="label label-warning">' . $row['cuty_total'] . '</label></td>
        <td>' . strip_tags($row['cuty_description']) . '</td>
        <td>' . $status . '</td>
        <td class="text-center">
          <div class="btn-group">';
          // Menampilkan tombol aksi berdasarkan level_user
          if ($level_user == 1) {
            echo '
            <div class="btn-group">
              <button type="button" class="btn btn-warning btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Proses
                <span class="caret"></span>
                <span class="sr-only">Toggle Dropdown</span>
              </button>
              <ul class="dropdown-menu" role="menu">
                <li><a href="javascript:void(0);" data-id="' . $row['cuty_id'] . '" data-status="1" class="update-status">Setujui</a></li>
                <li><a href="javascript:void(0);" data-id="' . $row['cuty_id'] . '" data-status="2" class="update-status">Tidak disetujui</a></li>
              </ul>
            </div>
            <a href="' . $mod . '/print?action=print&id=' . epm_encode($row['cuty_id']) . '" target="_blank"  class="btn btn-xs btn-danger delete" title="Print"><i class="fa fa-print" aria-hidden="true"></i> Print</a>';
          } else {
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
</section>';
      break;

    // Jika parameter 'op' adalah 'add'
    case 'add':
      echo '
<section class="content-header">
  <h1>Tambah Data<small> Permohonan</small></h1>
    <ol class="breadcrumb">
      <li><a href="./"><i class="fa fa-dashboard"></i> Beranda</a></li>
      <li><a href="./Permohonan"> Data Permohonan</a></li>
      <li class="active">Tambah Permohonan</li>
    </ol>
</section>';
      echo '
<section class="content">
  <div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
      <div class="box box-solid">
        <div class="box-header with-border">
          <h3 class="box-title"><b>Tambah Data Permohonan</b></h3>
        </div>

        <div class="box-body">
            <form class="form-horizontal validate add-Permohonan">
              <div class="box-body">

                <!-- Input untuk Kode Permohonan -->
                <div class="form-group">
                  <label class="col-sm-2 control-label">Kode Permohonan</label>
                  <div class="col-sm-6">
                    <input type="text" class="form-control" name="employees_code" required>
                  </div>
                </div>

                <!-- Input untuk Nama -->
                <div class="form-group">
                  <label class="col-sm-2 control-label">Nama</label>
                  <div class="col-sm-6">
                    <input type="text" class="form-control" name="employees_name" required>
                  </div>
                </div>

                <!-- Input untuk Email -->
                <div class="form-group">
                  <label class="col-sm-2 control-label">Email</label>
                  <div class="col-sm-6">
                    <input type="text" class="form-control" name="employees_email" required>
                  </div>
                </div>

                <!-- Input untuk Password -->
                <div class="form-group">
                  <label class="col-sm-2 control-label">Password</label>
                  <div class="col-sm-6">
                    <input type="password" class="form-control" name="employees_password" required>
                  </div>
                </div>

                <!-- Input untuk Jabatan -->
                <div class="form-group">
                  <label class="col-sm-2 control-label">Jabatan</label>
                  <div class="col-sm-6">
                   <select class="form-control" name="position_id" required="">
                      <option value="">- Pilih -</option>';
      $query = "SELECT * from position order by position_name ASC";
      $result = $connection->query($query);
      while ($row = $result->fetch_assoc()) {
        echo '<option value="' . $row['position_id'] . '">' . $row['position_name'] . '</option>';
      }
      echo '
                  </select>
                  </div>
                </div>

                <!-- Input untuk Shift -->
                <div class="form-group">
                  <label class="col-sm-2 control-label">Shift</label>
                  <div class="col-sm-6">
                   <select class="form-control" name="shift_id" required="">
                      <option value="">- Pilih -</option>';
      $query = "SELECT shift_id,shift_name from shift order by shift_name ASC";
      $result = $connection->query($query);
      while ($row = $result->fetch_assoc()) {
        echo '<option value="' . $row['shift_id'] . '">' . $row['shift_name'] . '</option>';
      }
      echo '
                  </select>
                  </div>
                </div>

                <!-- Input untuk Penempatan -->
                <div class="form-group">
                  <label class="col-sm-2 control-label">Penempatan</label>
                  <div class="col-sm-6">
                   <select class="form-control" name="building_id" id="building" required="">
                      <option value="">- Pilih -</option>';
      $query = "SELECT building_id,building_name FROM building ORDER BY building_name ASC";
      $result = $connection->query($query);
      while ($row = $result->fetch_assoc()) {
        echo '<option value="' . $row['building_id'] . '">' . $row['building_name'] . '</option>';
      }
      echo '
                   </select>
                  </div>
                </div>

                <!-- Input untuk Alamat -->
                <div class="form-group">
                  <label class="col-sm-2 control-label">Alamat</label>
                  <div class="col-sm-6">
                    <textarea class="form-control" name="employess_address" required></textarea>
                  </div>
                </div>

                <!-- Tombol untuk menyimpan data -->
                <div class="form-group">
                  <div class="col-sm-10">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="./" class="btn btn-default">Kembali</a>
                  </div>
                </div>

              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
</section>';
      break;

    // Case 'edit': Menampilkan formulir untuk mengedit data permohonan
    case 'edit':
      // Jika 'id' ada di query string
      if (isset($_GET['id']) && !empty($_GET['id'])) {
        $id = epm_decode($_GET['id']);

        // Query untuk mengambil data berdasarkan ID
        $query = "SELECT * FROM cuty WHERE cuty_id='" . $id . "'";
        $result = $connection->query($query);

        if ($result->num_rows > 0) {
          $row = $result->fetch_assoc();

          echo '
          <section class="content-header">
            <h1>Edit Data<small> Permohonan</small></h1>
              <ol class="breadcrumb">
                <li><a href="./"><i class="fa fa-dashboard"></i> Beranda</a></li>
                <li><a href="./Permohonan"> Data Permohonan</a></li>
                <li class="active">Edit Permohonan</li>
              </ol>
          </section>';

          echo '
          <section class="content">
            <div class="row">
              <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="box box-solid">
                  <div class="box-header with-border">
                    <h3 class="box-title"><b>Edit Data Permohonan</b></h3>
                  </div>
                  <div class="box-body">
                    <form class="form-horizontal validate edit-Permohonan">
                      <input type="hidden" name="cuty_id" value="' . $row['cuty_id'] . '">
                      <div class="box-body">
                      
                        <!-- Input untuk Kode Permohonan -->
                        <div class="form-group">
                          <label class="col-sm-2 control-label">Kode Permohonan</label>
                          <div class="col-sm-6">
                            <input type="text" class="form-control" name="cuty_code" value="' . $row['cuty_code'] . '" required>
                          </div>
                        </div>
                        
                        <!-- Input untuk Nama -->
                        <div class="form-group">
                          <label class="col-sm-2 control-label">Nama</label>
                          <div class="col-sm-6">
                            <input type="text" class="form-control" name="cuty_name" value="' . $row['cuty_name'] . '" required>
                          </div>
                        </div>
                        
                        <!-- Input untuk Alamat -->
                        <div class="form-group">
                          <label class="col-sm-2 control-label">Alamat</label>
                          <div class="col-sm-6">
                            <textarea class="form-control" name="cuty_address" required>' . $row['cuty_address'] . '</textarea>
                          </div>
                        </div>
                        
                        <!-- Tombol untuk menyimpan perubahan -->
                        <div class="form-group">
                          <div class="col-sm-10">
                            <button type="submit" class="btn btn-primary">Simpan</button>
                            <a href="./" class="btn btn-default">Kembali</a>
                          </div>
                        </div>
                        
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </section>';
        } else {
          // Jika tidak ada data yang ditemukan dengan ID yang diberikan
          echo '<section class="content">
                <div class="alert alert-danger">
                  <strong>Data tidak ditemukan.</strong>
                </div>
              </section>';
        }
      } else {
        // Jika ID tidak ada di query string
        echo '<section class="content">
              <div class="alert alert-danger">
                <strong>ID tidak valid.</strong>
              </div>
            </section>';
      }
      break;
  }
}
?>