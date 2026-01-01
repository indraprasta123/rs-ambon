<?php
session_start(); // Memulai sesi

// Cek apakah sesi pengguna dan ID sesi ada, jika tidak, arahkan ke halaman login
if (empty($_SESSION['SESSION_USER']) && empty($_SESSION['SESSION_ID'])) {
  header('location:../../login/');
  exit;
} else {
  require_once '../../../sw-library/sw-config.php'; // Memasukkan konfigurasi
  require_once '../../login/login_session.php'; // Memasukkan session login
  include ('../../../sw-library/sw-function.php'); // Memasukkan fungsi-fungsi tambahan

  $extensionList = array("jpg", "png", "ico"); // Daftar ekstensi file yang diperbolehkan

  // Pilih aksi berdasarkan parameter GET 'action'
  switch (@$_GET['action']) {

    /* ------------------------------
        Update
    ---------------------------------*/
    case 'update':

      // Cek level akses pengguna
      if ($level_user == 1) {
        $error = array(); // Array untuk menyimpan error

        // Validasi dan sanitasi inputan
        if (empty($_POST['site_name'])) {
          $error[] = 'tidak boleh kosong';
        } else {
          $site_name = mysqli_real_escape_string($connection, $_POST['site_name']);
        }

        if (empty($_POST['site_description'])) {
          $error[] = 'tidak boleh kosong';
        } else {
          $site_description = mysqli_real_escape_string($connection, $_POST['site_description']);
        }

        if (empty($_POST['site_phone'])) {
          $error[] = 'tidak boleh kosong';
        } else {
          $site_phone = mysqli_real_escape_string($connection, $_POST['site_phone']);
        }

        if (empty($_POST['site_address'])) {
          $error[] = 'tidak boleh kosong';
        } else {
          $site_address = mysqli_real_escape_string($connection, $_POST['site_address']);
        }

        if (empty($_POST['site_email'])) {
          $error[] = 'tidak boleh kosong';
        } else {
          $site_email = mysqli_real_escape_string($connection, $_POST['site_email']);
        }

        if (empty($_POST['site_email_domain'])) {
          $error[] = 'tidak boleh kosong';
        } else {
          $site_email_domain = mysqli_real_escape_string($connection, $_POST['site_email_domain']);
        }

        if (empty($_POST['site_url'])) {
          $error[] = 'tidak boleh kosong';
        } else {
          $site_url = mysqli_real_escape_string($connection, $_POST['site_url']);
        }

        $site_logo = $_FILES['site_logo']["name"]; // Nama file logo
        $file_tmp = $_FILES['site_logo']['tmp_name']; // Nama file sementara
        $ukuran_file = $_FILES['site_logo']['size']; // Ukuran file

        // Jika tidak ada file logo yang diupload
        if ($site_logo == '') {
          if (empty($error)) {
            $update = "UPDATE sw_site SET site_url='$site_url',
                                    site_name='$site_name',
                                    site_phone='$site_phone',
                                    site_address='$site_address',
                                    site_description='$site_description',
                                    site_email='$site_email',
                                    site_email_domain='$site_email_domain' WHERE site_id='1'";
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
          // Jika ada file logo yang diupload
          $query = mysqli_query($connection, "SELECT site_logo FROM sw_site WHERE site_id='1'");
          $data = mysqli_fetch_assoc($query);
          $images_delete = strip_tags($data['site_logo']);
          $tmpfile = "../../../sw-content/" . $images_delete;

          // Hapus file logo lama jika ada
          if (file_exists("../../../sw-content/$images_delete")) {
            unlink($tmpfile);
          }

          $x = explode('.', $site_logo);
          $ekstensi = strtolower(end($x)); // Ekstensi file
          $nama_file = seo_title($site_logo); // Nama file tanpa ekstensi
          $nama_file_unik = $nama_file . '.' . $ekstensi; // Nama file unik
          $namaDir = '../../../sw-content/';
          $pathFile = $namaDir;

          // Validasi ekstensi file dan ukuran file
          if (in_array($ekstensi, $extensionList) === true) {
            if ($ukuran_file < 1044070) {
              $update = "UPDATE sw_site SET site_url='$site_url',
                                        site_name='$site_name',
                                        site_phone='$site_phone',
                                        site_address='$site_address',
                                        site_description='$site_description',
                                        site_logo='$nama_file_unik',
                                        site_email='$site_email',
                                        site_email_domain='$site_email_domain' WHERE site_id='1'" or die($connection->error . __LINE__);
              if ($connection->query($update) === false) {
                echo 'Data tidak berhasil disimpan!';
              } else {
                echo 'success';
                move_uploaded_file($file_tmp, '../../../sw-content/' . $nama_file_unik); // Pindahkan file ke direktori
              }
            } else {
              echo 'Ukuran File terlalu besar, File harus berukuran maksimal 1MB!';
            }
          } else {
            echo 'Format file yang diupload tidak diperbolehkan, Format harus JPG, PNG!';
          }
        }

      } else {
        echo 'Anda tidak memiliki hak akses!';
      }

      // =========================
      // Update Profile
      // =========================
      break;

    case 'profile':
      // Cek level akses pengguna
      if ($level_user == 1) {
        $error = array(); // Array untuk menyimpan error

        // Validasi dan sanitasi inputan
        if (empty($_POST['site_company'])) {
          $error[] = 'tidak boleh kosong';
        } else {
          $site_company = anti_injection($_POST['site_company']);
        }

        if (empty($_POST['site_manager'])) {
          $error[] = 'tidak boleh kosong';
        } else {
          $site_manager = anti_injection($_POST['site_manager']);
        }

        if (empty($_POST['site_director'])) {
          $error[] = 'tidak boleh kosong';
        } else {
          $site_director = anti_injection($_POST['site_director']);
        }

        if (empty($error)) {
          $update = "UPDATE sw_site SET site_company='$site_company',
                                    site_manager='$site_manager',
                                    site_director='$site_director' WHERE site_id='1'";
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
        echo 'Anda tidak memiliki hak akses!';
      }

      break;
  }
}
