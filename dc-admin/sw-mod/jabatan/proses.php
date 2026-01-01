<?php
// Memulai sesi
session_start();

// Mengecek apakah sesi pengguna tidak ada
if (empty($_SESSION['SESSION_USER']) && empty($_SESSION['SESSION_ID'])) {
  // Jika sesi tidak ada, alihkan pengguna ke halaman login
  header('location:../../login/');
  exit;
} else {
  // Sertakan konfigurasi, sesi login, dan fungsi-fungsi yang diperlukan
  require_once '../../../sw-library/sw-config.php';
  require_once '../../login/login_session.php';
  include ('../../../sw-library/sw-function.php');

  // Mengambil tindakan berdasarkan parameter 'action' dalam URL
  switch (@$_GET['action']) {
    // Kasus untuk menambahkan data baru
    case 'add':
      $error = array();

      // Memeriksa apakah nama posisi kosong
      if (empty($_POST['position_name'])) {
        $error[] = 'tidak boleh kosong';
      } else {
        $position_name = mysqli_real_escape_string($connection, $_POST['position_name']);
      }

      // Jika tidak ada error, tambahkan data ke database
      if (empty($error)) {
        $add = "INSERT INTO position (position_name) values('$position_name')";
        if ($connection->query($add) === false) {
          die($connection->error . __LINE__);
          echo 'Data tidak berhasil disimpan!';
        } else {
          echo 'success';
        }
      } else {
        echo 'Bidang inputan tidak boleh ada yang kosong..!';
      }
      break;

    /* --------------------------------
        Update
    ---------------------------------*/
    case 'update':
      $error = array();

      // Memeriksa apakah ID kosong
      if (empty($_POST['id'])) {
        $error[] = 'ID tidak boleh kosong';
      } else {
        $id = mysqli_real_escape_string($connection, $_POST['id']);
      }

      // Memeriksa apakah nama posisi kosong
      if (empty($_POST['position_name'])) {
        $error[] = 'tidak boleh kosong';
      } else {
        $position_name = mysqli_real_escape_string($connection, $_POST['position_name']);
      }

      // Jika tidak ada error, perbarui data di database
      if (empty($error)) {
        $update = "UPDATE position SET position_name='$position_name' WHERE position_id='$id'";
        if ($connection->query($update) === false) {
          die($connection->error . __LINE__);
          echo 'Data tidak berhasil disimpan!';
        } else {
          echo 'success';
        }
      } else {
        echo 'Bidang inputan tidak boleh ada yang kosong..!';
      }
      break;

    /* --------------- Delete ------------*/
    case 'delete':
      // Mendapatkan ID yang akan dihapus setelah dekode
      $id = mysqli_real_escape_string($connection, epm_decode($_POST['id']));

      // Memeriksa apakah posisi yang akan dihapus digunakan oleh karyawan
      $query = "SELECT position.position_id, employees.position_id FROM position, employees WHERE position.position_id = employees.position_id AND employees.position_id = '$id'";
      $result = $connection->query($query);

      if (!$result->num_rows > 0) {
        // Jika tidak ada karyawan yang menggunakan posisi ini, hapus data
        $deleted = "DELETE FROM position WHERE position_id='$id'";
        if ($connection->query($deleted) === true) {
          echo 'success';
        } else {
          // Jika gagal menghapus, tampilkan pesan error
          echo 'Data tidak berhasil dihapus.!';
          die($connection->error . __LINE__);
        }
      } else {
        // Jika posisi digunakan oleh karyawan, tampilkan pesan error
        echo 'Jabatan digunakan, Data tidak dapat dihapus.!';
      }
      break;
  }
}
?>