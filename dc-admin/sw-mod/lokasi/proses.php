<?php
session_start();
// Memeriksa apakah sesi pengguna aktif
if (empty($_SESSION['SESSION_USER']) && empty($_SESSION['SESSION_ID'])) {
  // Jika sesi tidak aktif, arahkan ke halaman login
  header('location:../../login/');
  exit;
} else {
  // Memasukkan file konfigurasi dan fungsi yang diperlukan
  require_once '../../../sw-library/sw-config.php'; // Konfigurasi database
  require_once '../../login/login_session.php'; // Memeriksa sesi login
  include '../../../sw-library/sw-function.php'; // Memasukkan fungsi tambahan

  // Menangani berbagai aksi berdasarkan parameter 'action'
  switch (@$_GET['action']) {
    case 'add':
      // Fungsi untuk menghasilkan kode acak
      function acakangkahuruf($panjang)
      {
        $karakter = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $string = '';
        for ($i = 0; $i < $panjang; $i++) {
          $pos = rand(0, strlen($karakter) - 1);
          $string .= $karakter[$pos];
        }
        return $string;
      }
      // Menghasilkan kode dengan format 'SWXXX/YYYY'
      $code = 'SW' . acakangkahuruf(3) . '/' . $year . '';

      $error = array();
      // Memeriksa apakah input 'name' kosong
      if (empty($_POST['name'])) {
        $error[] = 'tidak boleh kosong';
      } else {
        $name = mysqli_real_escape_string($connection, $_POST['name']);
      }
      // Memeriksa apakah input 'address' kosong
      if (empty($_POST['address'])) {
        $error[] = 'tidak boleh kosong';
      } else {
        $address = mysqli_real_escape_string($connection, $_POST['address']);
      }
      // Jika tidak ada error, lakukan penyimpanan data
      if (empty($error)) {

        $add = "INSERT INTO  building (code,name,address,building_scanner) values('$code','$name','$address','')";
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

    /* ------------------------------
        Update
    ---------------------------------*/
    case 'update':
      $error = array();
      // Memeriksa apakah input 'id' kosong
      if (empty($_POST['id'])) {
        $error[] = 'ID tidak boleh kosong';
      } else {
        $id = mysqli_real_escape_string($connection, $_POST['id']);
      }
      // Memeriksa apakah input 'name' kosong
      if (empty($_POST['name'])) {
        $error[] = 'tidak boleh kosong';
      } else {
        $name = mysqli_real_escape_string($connection, $_POST['name']);
      }
      // Memeriksa apakah input 'address' kosong
      if (empty($_POST['address'])) {
        $error[] = 'tidak boleh kosong';
      } else {
        $address = mysqli_real_escape_string($connection, $_POST['address']);
      }
      // Jika tidak ada error, lakukan pembaruan data
      if (empty($error)) {
        $update = "UPDATE building SET name='$name',
            address='$address' WHERE building_id='$id'";
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
      // Mendapatkan ID yang akan dihapus
      $id = mysqli_real_escape_string($connection, epm_decode($_POST['id']));
      $query = "SELECT building.building_id,employees.building_id FROM building,employees WHERE building.building_id=employees.building_id AND employees.building_id='$id'";
      $result = $connection->query($query);
      if (!$result->num_rows > 0) {
        $deleted = "DELETE FROM building WHERE building_id='$id'";
        if ($connection->query($deleted) === true) {
          echo 'success';
        } else {
          //tidak berhasil
          echo 'Data tidak berhasil dihapus.!';
          die($connection->error . __LINE__);

        }
      } else {
        echo 'Lokasi digunakan, Data tidak dapat dihapus.!';
      }
      break;

  }

}
