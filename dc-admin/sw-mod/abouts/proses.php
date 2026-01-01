<?php
session_start(); // Memulai sesi PHP

// Memeriksa apakah SESSION_ADMIN dan SESSION_ID_ADMIN kosong
if (empty($_SESSION['SESSION_ADMIN']) && empty($_SESSION['SESSION_ID_ADMIN'])) {
  // Jika kosong, arahkan ke halaman login
  header('location:../../login/');
  exit();
} else {
  // Jika sesi tidak kosong, lanjutkan memeriksa
  require_once '../../../sw-library/config.php'; // Mengimpor konfigurasi database
  require_once '../../login/login_session.php'; // Mengimpor skrip sesi login
  include ('../../../sw-library/sw-function.php'); // Mengimpor fungsi tambahan

  $salt = '$%DSuTyr47542@#&*!=QxR094{a911}+'; // Salt untuk enkripsi password
  $modul = '';
  $aksi = '';

  // Mengambil nilai modul dan aksi dari POST jika tersedia
  if (!empty($_POST['modul'])) {
    $modul = htmlentities($_POST['modul']);
  }
  if (!empty($_POST['aksi'])) {
    $aksi = htmlentities($_POST['aksi']);
  }

  $extensionList = array("jpg", "png", "ico"); // Daftar ekstensi file yang diizinkan

  // Jika modul adalah 'abouts' dan aksi adalah 'update'
  if ($modul == 'abouts' and $aksi == 'update') {
    $error = array(); // Array untuk menampung pesan error

    // Memeriksa apakah username kosong
    if (empty($_POST['username'])) {
      $error[] = 'Username tidak boleh kosong';
    } else {
      $username = mysqli_real_escape_string($connection, $_POST['username']);
    }

    // Memeriksa apakah fullname kosong
    if (empty($_POST['fullname'])) {
      $error[] = 'Fullname tidak boleh kosong';
    } else {
      $fullname = mysqli_real_escape_string($connection, $_POST['fullname']);
    }

    // Memeriksa apakah email kosong
    if (empty($_POST['email'])) {
      $error[] = 'Email tidak boleh kosong';
    } else {
      $email = mysqli_real_escape_string($connection, $_POST['email']);
    }

    $password = mysqli_real_escape_string($connection, $_POST['password']);
    $password_baru = mysqli_real_escape_string($connection, hash('sha256', $salt . $password));

    // Jika password kosong, lakukan pembaruan tanpa mengganti password
    if ($password == '') {
      if (empty($error)) {
        // Membuat pesan email
        $pesan = '<html><body>';
        $pesan .= 'Saat ini [' . $fullname . '] Sedang mengganti Password baru<br>';
        $pesan .= '[Detail Akun] :';
        $pesan .= 'Nama : ' . $fullname . '<br>Email : ' . $user_email . '<br>Username :' . $username . '<br><b>Password Baru : ' . $password . '</b><br><br><br>Harap simpan baik-baik akun Anda.<br><br>';
        $pesan .= 'Hormat Kami,<br>' . $site_name . '<br>Email otomatis, Mohon tidak membalas email ini"';
        $pesan .= "</body></html>";
        $to = $user_email;
        $subject = '' . $fullname . ' Sedang Online';
        $headers = "From: " . $site_name . " <" . $site_email_domain . ">\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

        // Update data pengguna di database
        $update = "UPDATE sw_user SET username='$username', fullname='$fullname', email='$email' WHERE user_id='1'";
        if ($connection->query($update) === false) {
          die($connection->error . __LINE__);
          _goto('../../?mod=' . $modul . '&alert=error'); // Error
          $_SESSION['messages'] = 'Data tidak dapat disimpan...!';
        } else {
          _goto('../../?mod=' . $modul . '&alert=success'); // Sukses
          $_SESSION['messages'] = 'Password baru berhasil disimpan..!';
          mail($to, $subject, $pesan, $headers); // Kirim email
        }
      } else {
        // Jika ada error, arahkan ke halaman error
        foreach ($error as $key => $values) {
          _goto('../../?mod=' . $modul . '&alert=error');
          $_SESSION['messages'] = 'Bidang inputan tidak boleh ada yang kosong..!';
        }
      }
    } else {
      // Update data pengguna termasuk password baru di database
      $update = "UPDATE sw_user SET username='$username', password='$password_baru', fullname='$fullname', email='$email' WHERE user_id='1'";
      if ($connection->query($update) === false) {
        _goto('../../?mod=' . $modul . '&alert=error'); // Error
        $_SESSION['messages'] = 'Data tidak dapat disimpan...!';
      } else {
        _goto('../../?mod=' . $modul . '&alert=success'); // Sukses
        $_SESSION['messages'] = 'Data berhasil disimpan..!';
      }
    }
  }
}
?>