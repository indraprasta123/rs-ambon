<?php
// Memulai sesi
session_start();

// Memeriksa apakah sesi user dan sesi ID kosong
if (empty($_SESSION['SESSION_USER']) && empty($_SESSION['SESSION_ID'])) {
  // Jika kosong, redirect ke halaman login
  header('location:../../login/');
  exit;
} else {
  // Menyertakan file konfigurasi, sesi login, dan fungsi
  require_once '../../../sw-library/sw-config.php';
  require_once '../../login/login_session.php';
  include ('../../../sw-library/sw-function.php');

  // Memeriksa nilai 'action' dari parameter GET
  switch (@$_GET['action']) {

    // untuk menambah data
    case 'add':
      $error = array();

      // Memeriksa apakah nama shift kosong
      if (empty($_POST['shift_name'])) {
        $error[] = 'tidak boleh kosong';
      } else {
        $shift_name = mysqli_real_escape_string($connection, $_POST['shift_name']);
      }

      // Memeriksa apakah waktu masuk kosong
      if (empty($_POST['time_in'])) {
        $error[] = 'tidak boleh kosong';
      } else {
        $time_in = mysqli_real_escape_string($connection, $_POST['time_in']);
      }

      // Memeriksa apakah waktu keluar kosong
      if (empty($_POST['time_out'])) {
        $error[] = 'tidak boleh kosong';
      } else {
        $time_out = mysqli_real_escape_string($connection, $_POST['time_out']);
      }

      // Jika tidak ada error, menambahkan data ke database
      if (empty($error)) {
        $add = "INSERT INTO shift (shift_name, time_in, time_out) values('$shift_name','$time_in','$time_out')";
        if ($connection->query($add) === false) {
          die($connection->error . __LINE__);
          echo 'Data tidak berhasil disimpan!';
        } else {
          echo 'success';
        }
      } else {
        echo 'Bidang inputan masih ada yang kosong..!';
      }
      break;

    // Kasus untuk memperbarui data
    case 'update':
      $error = array();

      // Memeriksa apakah ID kosong
      if (empty($_POST['id'])) {
        $error[] = 'ID tidak boleh kosong';
      } else {
        $id = mysqli_real_escape_string($connection, $_POST['id']);
      }

      // Memeriksa apakah nama shift kosong
      if (empty($_POST['shift_name'])) {
        $error[] = 'tidak boleh kosong';
      } else {
        $shift_name = mysqli_real_escape_string($connection, $_POST['shift_name']);
      }

      // Memeriksa apakah waktu masuk kosong
      if (empty($_POST['time_in'])) {
        $error[] = 'tidak boleh kosong';
      } else {
        $time_in = mysqli_real_escape_string($connection, $_POST['time_in']);
      }

      // Memeriksa apakah waktu keluar kosong
      if (empty($_POST['time_out'])) {
        $error[] = 'tidak boleh kosong';
      } else {
        $time_out = mysqli_real_escape_string($connection, $_POST['time_out']);
      }

      // Jika tidak ada error, memperbarui data di database
      if (empty($error)) {
        $update = "UPDATE shift SET shift_name='$shift_name', time_in='$time_in', time_out='$time_out' WHERE shift_id='$id'";
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

    // Kasus untuk menghapus data
    case 'delete':
      $id = mysqli_real_escape_string($connection, epm_decode($_POST['id']));
      $query = "SELECT shift.shift_id, employees.shift_id FROM shift, employees WHERE shift.shift_id=employees.shift_id AND employees.shift_id='$id'";
      $result = $connection->query($query);

      // Memeriksa apakah data dapat dihapus
      if (!$result->num_rows > 0) {
        $deleted = "DELETE FROM shift WHERE shift_id='$id'";
        if ($connection->query($deleted) === true) {
          echo 'success';
        } else {
          echo 'Data tidak berhasil dihapus.!';
          die($connection->error . __LINE__);
        }
      } else {
        echo 'Lokasi digunakan, Data tidak dapat dihapus.!';
      }
      break;
  }
}
?>