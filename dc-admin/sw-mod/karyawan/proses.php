<?php
session_start();

// Cek apakah sesi pengguna dan ID sesi ada, jika tidak, arahkan ke halaman login
if (empty($_SESSION['SESSION_USER']) && empty($_SESSION['SESSION_ID'])) {
  header('location:../../login/');
  exit;
} else {
  require_once '../../../sw-library/sw-config.php'; // Mengambil konfigurasi dari file konfigurasi
  require_once '../../login/login_session.php'; // Mengambil sesi login
  include ('../../../sw-library/sw-function.php'); // Mengambil fungsi tambahan

  $max_size = 2000000; // Maksimal ukuran file 2MB
  $salt = '$%DEf0&TTd#%dSuTyr47542"_-^@#&*!=QxR094{a911}+'; // Salt untuk hash password

  switch (@$_GET['action']) {

    //tambah data karyawan
    case 'add':
      $error = array(); // Array untuk menyimpan pesan kesalahan

      // Validasi kode karyawan
      if (empty($_POST['employees_code'])) {
        $error[] = 'tidak boleh kosong';
      } else {
        $employees_code = mysqli_real_escape_string($connection, $_POST['employees_code']);
      }

      // Validasi email karyawan
      if (empty($_POST['employees_email'])) {
        $error[] = 'tidak boleh kosong';
      } else {
        $employees_email = mysqli_real_escape_string($connection, $_POST['employees_email']);
      }

      // Validasi password karyawan
      if (empty($_POST['employees_password'])) {
        $error[] = 'tidak boleh kosong';
      } else {
        $employees_password = mysqli_real_escape_string($connection, hash('sha256', $salt . $_POST['employees_password']));
      }

      // Validasi nama karyawan
      if (empty($_POST['employees_name'])) {
        $error[] = 'tidak boleh kosong';
      } else {
        $employees_name = mysqli_real_escape_string($connection, $_POST['employees_name']);
      }

      //validasi pangkat
      if (empty($_POST['pangkat'])) {
        $error[] = 'tidak boleh kosong';
      } else {
        $pangkat = mysqli_real_escape_string($connection, $_POST['pangkat']);
      }

      // Validasi ID posisi
      if (empty($_POST['position_id'])) {
        $error[] = 'tidak boleh kosong';
      } else {
        $position_id = mysqli_real_escape_string($connection, $_POST['position_id']);
      }

      // Validasi ID shift
      if (empty($_POST['shift_id'])) {
        $error[] = 'tidak boleh kosong';
      } else {
        $shift_id = mysqli_real_escape_string($connection, $_POST['shift_id']);
      }

      // Validasi ID Ruang
      if (empty($_POST['building_id'])) {
        $error[] = 'tidak boleh kosong';
      } else {
        $building_id = mysqli_real_escape_string($connection, $_POST['building_id']);
      }

      // Validasi tgl lahir
      if (empty($_POST['born'])) {
        $error[] = 'tidak boleh kosong';
      } else {
        $born = mysqli_real_escape_string($connection, $_POST['born']);
      }

      // Validasi alamat rumah
      if (empty($_POST['employess_address'])) {
        $error[] = 'tidak boleh kosong';
      } else {
        $employess_address = mysqli_real_escape_string($connection, $_POST['employess_address']);
      }

      // Validasi foto
      if (empty($_FILES['photo'])) {
        $error[] = 'tidak boleh kosong';
      } else {
        $photo = $_FILES["photo"]["name"];
        $lokasi_file = $_FILES['photo']['tmp_name'];
        $ukuran_file = $_FILES['photo']['size'];
      }

      $extension = getExtension($photo); // Mendapatkan ekstensi file
      $extension = strtolower($extension); // Mengubah ekstensi menjadi huruf kecil
      $photo = strip_tags(md5($photo)); // Membuat nama file unik
      $photo = "" . $date . "" . $photo . "." . $extension . ""; // Nama file dengan ekstensi

      // Validasi format gambar
      if (($extension != "jpg") && ($extension != "jpeg") && ($extension != "gif")) {
        echo 'Gambar/Foto yang diunggah tidak sesuai dengan format, Berkas harus berformat JPG, JPEG, GIF..!';
      } else {
        // Membaca gambar sesuai format
        if ($extension == "jpg" || $extension == "jpeg") {
          $src = imagecreatefromjpeg($lokasi_file);
        } else if ($extension == "png") {
          $src = imagecreatefrompng($lokasi_file);
        } else {
          $src = imagecreatefromgif($lokasi_file);
        }
        list($width, $height) = getimagesize($lokasi_file);

        // Menentukan ukuran gambar baru
        $width_size = 400;
        $k = $width / $width_size;
        $newwidth = $width / $k;
        $newheight = $height / $k;
        $tmp = imagecreatetruecolor($newwidth, $newheight);
        imagecopyresampled($tmp, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

        if (empty($error)) {
          if ($ukuran_file <= $max_size) {
            $directory = '../../../sw-content/karyawan/' . $photo . ''; // Direktori tempat menyimpan foto karyawan
            $add = "INSERT INTO employees (
                                    employees_code,
                                    employees_email,
                                    employees_password,
                                    employees_name,
                                    pangkat,
                                    position_id,
                                    shift_id,
                                    building_id,
                                    born,
                                    employess_address,
                                    photo,
                                    created_login,
                                    created_cookies
                                ) VALUES (
                                    '$employees_code',
                                    '$employees_email',
                                    '$employees_password',
                                    '$employees_name',
                                    '$pangkat',
                                    '$position_id',
                                    '$shift_id',
                                    '$building_id',
                                    '$born',
                                    '$employess_address',
                                    '$photo',
                                    '$date $time',
                                    '-'
                                )"; // Query untuk menambahkan data karyawan ke dalam database
            if ($connection->query($add) === false) {
              die($connection->error . __LINE__); // Jika query gagal, tampilkan pesan error
              echo 'Data tidak berhasil disimpan!';
            } else {
              echo 'success';  // Jika berhasil, tampilkan pesan sukses
              imagejpeg($tmp, $directory, 90); // Menyimpan gambar yang telah diubah ukuran
            }
          } else {
            echo 'Gambar yang diunggah terlalu besar Maksimal Size 2MB..!'; // Pesan error jika ukuran file terlalu besar
          }
        } else {
          echo 'Bidang inputan masih ada yang kosong..!'; // Pesan error jika ada input yang kosong
        }
      }
      break;

    /* ------------------------------
        Update ubah data karyawan
    ---------------------------------*/
    case 'update':
      $error = array(); // Array untuk menyimpan pesan kesalahan

      // Validasi ID
      if (empty($_POST['id'])) {
        $error[] = 'ID tidak boleh kosong';
      } else {
        $id = mysqli_real_escape_string($connection, $_POST['id']);
      }

      // Validasi kode karyawan
      if (empty($_POST['employees_code'])) {
        $error[] = 'tidak boleh kosong';
      } else {
        $employees_code = mysqli_real_escape_string($connection, $_POST['employees_code']);
      }

      // Validasi nama karyawan
      if (empty($_POST['employees_name'])) {
        $error[] = 'tidak boleh kosong';
      } else {
        $employees_name = mysqli_real_escape_string($connection, $_POST['employees_name']);
      }

      // Validasi pangkat
      if (empty($_POST['pangkat'])) {
        $error[] = 'tidak boleh kosong';
      } else {
        $pangkat = mysqli_real_escape_string($connection, $_POST['pangkat']);
      }

      // Validasi ID posisi
      if (empty($_POST['position_id'])) {
        $error[] = 'tidak boleh kosong';
      } else {
        $position_id = mysqli_real_escape_string($connection, $_POST['position_id']);
      }

      // Validasi ID shift
      if (empty($_POST['shift_id'])) {
        $error[] = 'tidak boleh kosong';
      } else {
        $shift_id = mysqli_real_escape_string($connection, $_POST['shift_id']);
      }

      // Validasi ID Ruang
      if (empty($_POST['building_id'])) {
        $error[] = 'tidak boleh kosong';
      } else {
        $building_id = mysqli_real_escape_string($connection, $_POST['building_id']);
      }

      // Validasi tgl lahir
      if (empty($_POST['born'])) {
        $error[] = 'tidak boleh kosong';
      } else {
        $born = mysqli_real_escape_string($connection, $_POST['born']);
      }

      // Validasi alamat rumah
      if (empty($_POST['employess_address'])) {
        $error[] = 'tidak boleh kosong';
      } else {
        $employess_address = mysqli_real_escape_string($connection, $_POST['employess_address']);
      }

      // Mengambil foto baru
      $photo = $_FILES["photo"]["name"];
      $lokasi_file = $_FILES['photo']['tmp_name'];
      $ukuran_file = $_FILES['photo']['size'];

      // Jika tidak ada foto baru
      if ($photo == '') {
        if (empty($error)) {
          $update = "UPDATE employees SET 
                                employees_code='$employees_code',
                                employees_name='$employees_name',
                                pangkat='$pangkat',
                                position_id='$position_id',
                                shift_id='$shift_id',
                                building_id='$building_id',
                                born='$born',
                                employess_address='$employess_address' 
                                WHERE id='$id'";
          if ($connection->query($update) === false) {
            die($connection->error . __LINE__);
            echo 'Data tidak berhasil disimpan!';
          } else {
            echo 'success';
          }
        } else {
          echo 'Bidang inputan tidak boleh ada yang kosong..!';
        }
      } else {
        // Mengambil foto lama untuk dihapus
        $query = mysqli_query($connection, "SELECT photo FROM employees WHERE id='$id'");
        $data = mysqli_fetch_assoc($query);
        $images_delete = strip_tags($data['photo']);
        $tmpfile = "../../../sw-content/karyawan/" . $images_delete;
        if (file_exists("../../../sw-content/karyawan/$images_delete")) {
          unlink($tmpfile); // Menghapus foto lama
        }

        // Mengubah ekstensi foto baru
        $extension = getExtension($photo);
        $extension = strtolower($extension);
        $photo = strip_tags(md5($photo));
        $photo = "" . $date . "" . $photo . "." . $extension . "";

        // Validasi format gambar
        if (($extension != "jpg") && ($extension != "jpeg") && ($extension != "gif")) {
          echo 'Gambar/Foto yang diunggah tidak sesuai dengan format, Berkas harus berformat JPG, JPEG, GIF..!';
        } else {
          // Membaca gambar sesuai format
          if ($extension == "jpg" || $extension == "jpeg") {
            $src = imagecreatefromjpeg($lokasi_file);
          } else if ($extension == "png") {
            $src = imagecreatefrompng($lokasi_file);
          } else {
            $src = imagecreatefromgif($lokasi_file);
          }
          list($width, $height) = getimagesize($lokasi_file);

          // Menentukan ukuran gambar baru
          $width_size = 400;
          $k = $width / $width_size;
          $newwidth = $width / $k;
          $newheight = $height / $k;
          $tmp = imagecreatetruecolor($newwidth, $newheight);
          imagecopyresampled($tmp, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

          if (empty($error)) {
            if ($ukuran_file <= $max_size) {
              $directory = '../../../sw-content/karyawan/' . $photo . '';
              $update = "UPDATE employees SET 
                                        employees_code='$employees_code',
                                        employees_name='$employees_name',
                                        pangkat='$pangkat',
                                        position_id='$position_id',
                                        shift_id='$shift_id',
                                        building_id='$building_id',
                                        born='$born',
                                        employess_address='$employess_address',
                                        photo='$photo' 
                                        WHERE id='$id'";
              if ($connection->query($update) === false) {
                die($connection->error . __LINE__);
                echo 'Data tidak berhasil disimpan!';
              } else {
                echo 'success';
                imagejpeg($tmp, $directory, 90); // Menyimpan gambar yang telah diubah ukuran
              }
            } else {
              echo 'Gambar yang diunggah terlalu besar Maksimal Size 2MB..!';
            }
          }
        }
      }
      break;

    /* --------------- Update Password ------------*/
    case 'update-password':
      $error = array(); // Array untuk menyimpan pesan kesalahan

      // Validasi ID
      if (empty($_POST['id'])) {
        $error[] = 'ID tidak boleh kosong';
      } else {
        $id = mysqli_real_escape_string($connection, $_POST['id']);
      }

      // Validasi email
      if (empty($_POST['employees_email'])) {
        $error[] = 'tidak boleh kosong';
      } else {
        $employees_email = mysqli_real_escape_string($connection, $_POST['employees_email']);
      }

      // Validasi password baru
      if (empty($_POST['employees_password'])) {
        $error[] = 'tidak boleh kosong';
      } else {
        $employees_password = mysqli_real_escape_string($connection, $_POST['employees_password']);
        $password_baru = mysqli_real_escape_string($connection, hash('sha256', $salt . $employees_password));
      }

      if (empty($error)) {
        // Menyusun pesan email
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
          mail($to, $subject, $pesan, $headers); // Mengirim email pemberitahuan
        }
      } else {
        echo 'Bidang inputan tidak boleh ada yang kosong..!';
      }
      break;

    /* --------------- Delete ------------*/
    case 'delete':
      $id = mysqli_real_escape_string($connection, epm_decode($_POST['id']));

      // Mengambil foto yang akan dihapus
      $cari = mysqli_query($connection, "SELECT photo FROM employees WHERE id='$id'");
      $data = mysqli_fetch_assoc($cari);
      $images_delete = strip_tags($data['photo']);
      $directory = '../../../sw-content/karyawan/' . $images_delete . '';

      // Menghapus data karyawan
      $deleted = "DELETE FROM employees WHERE id='$id'";
      if ($connection->query($deleted) === true) {
        echo 'success';
        if (file_exists("../../../sw-content/karyawan/$images_delete")) {
          unlink($directory); // Menghapus file gambar dari server
        }
      } else {
        // Jika gagal menghapus data
        echo 'Data tidak berhasil dihapus.!';
        die($connection->error . __LINE__);
      }
      break;
  }
}
?>