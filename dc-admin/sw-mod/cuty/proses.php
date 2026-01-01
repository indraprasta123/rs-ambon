<?php
session_start();
// Mengecek apakah session pengguna kosong
if (empty($_SESSION['SESSION_USER']) && empty($_SESSION['SESSION_ID'])) {
  // Jika session kosong, arahkan pengguna ke halaman login
  header('location:../../login/');
  exit;
} else {
  // Memasukkan konfigurasi dan fungsi yang diperlukan
  require_once '../../../sw-library/sw-config.php';
  require_once '../../login/login_session.php';
  include ('../../../sw-library/sw-function.php');

  $max_size = 2000000; // Maksimum ukuran file 2MB
  $salt = '$%DEf0&TTd#%dSuTyr47542"_-^@#&*!=QxR094{a911}+';

  // Menangani aksi berdasarkan parameter 'action' di URL
  switch (@$_GET['action']) {

    /* ------------------------------
        Update status
    ---------------------------------*/
    case 'update-status':
      $error = array();

      // Mengecek apakah ID kosong
      if (empty($_POST['id'])) {
        $error[] = 'ID tidak boleh kosong';
      } else {
        $cuty_id = mysqli_real_escape_string($connection, $_POST['id']);
      }

      // Mengecek apakah status kosong
      if (empty($_GET['status'])) {
        $error[] = 'Status tidak boleh kosong';
      } else {
        $status = mysqli_real_escape_string($connection, $_GET['status']);
      }

      // Jika tidak ada error, lakukan update status
      if (empty($error)) {
        $update = "UPDATE cuty SET cuty_status='$status' WHERE cuty_id='$cuty_id'";
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

    /* --------------- Update Password ------------*/
    case 'update-password':
      $error = array();

      // Mengecek apakah ID kosong
      if (empty($_POST['id'])) {
        $error[] = 'ID tidak boleh kosong';
      } else {
        $id = mysqli_real_escape_string($connection, $_POST['id']);
      }

      // Mengecek apakah email kosong
      if (empty($_POST['employees_email'])) {
        $error[] = 'Email tidak boleh kosong';
      } else {
        $employees_email = mysqli_real_escape_string($connection, $_POST['employees_email']);
      }

      // Mengecek apakah password kosong
      if (empty($_POST['employees_password'])) {
        $error[] = 'Password tidak boleh kosong';
      } else {
        $employees_password = mysqli_real_escape_string($connection, $_POST['employees_password']);
        $password_baru = mysqli_real_escape_string($connection, hash('sha256', $salt . $employees_password));
      }

      // Jika tidak ada error, lakukan update password
      if (empty($error)) {
        $pesan = '<html><body>';
        $pesan .= 'Saat ini [' . $employees_email . '] Sedang mengganti Password baru<br>';
        $pesan .= '<b>Password Baru Anda : ' . $employees_password . '</b><br><br><br>Harap simpan baik-baik akun Anda.<br><br>';
        $pesan .= 'Hormat Kami,<br>' . $site_name . '<br>Email otomatis, Mohon tidak membalas email ini"';
        $pesan .= "</body></html>";
        $to = $employees_email;
        $subject = 'Ubah Katasandi Baru';
        $headers = "From: " . $site_name . " <" . $site_email_domain . ">\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

        $update = "UPDATE employees SET employees_password='$password_baru' WHERE id='$id'";
        if ($connection->query($update) === false) {
          die($connection->error . __LINE__);
          echo 'Data tidak berhasil disimpan!';
        } else {
          echo 'success';
          mail($to, $subject, $pesan, $headers);
        }
      } else {
        echo 'Bidang inputan tidak boleh ada yang kosong..!';
      }
      break;

    /* --------------- Delete ------------*/
    case 'delete':
      $id = mysqli_real_escape_string($connection, epm_decode($_POST['id']));

      // Mengambil data foto dari database
      $cari = mysqli_query($connection, "SELECT photo FROM employees WHERE id='$id'");
      $data = mysqli_fetch_assoc($cari);
      $images_delete = strip_tags($data['photo']);
      $directory = '../../../sw-content/karyawan/' . $images_delete;

      // Menghapus data dari database
      $deleted = "DELETE FROM employees WHERE id='$id'";
      if ($connection->query($deleted) === true) {
        echo 'success';
        // Menghapus file foto jika ada
        if (file_exists("../../../sw-content/karyawan/$images_delete")) {
          unlink($directory);
        }
      } else {
        echo 'Data tidak berhasil dihapus.!';
        die($connection->error . __LINE__);
      }
      break;
  }
}
?>