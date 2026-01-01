<?php
// Menonaktifkan pelaporan kesalahan untuk menghindari menampilkan kesalahan PHP
// error_reporting(0);

/* Admin Panel
 * (c) 2024
 */

// Memulai sesi
@session_start();
// Memuat konfigurasi dan fungsi yang diperlukan
require_once '../sw-library/sw-config.php';
include_once '../sw-library/sw-function.php';
// Memeriksa apakah sesi pengguna tidak ada
if (empty($_SESSION['SESSION_USER']) && empty($_SESSION['SESSION_ID'])) {
  // Jika sesi tidak ada, arahkan ke halaman login dan hentikan eksekusi
  header('location:./login/');
  exit;
} else {
  // Memuat sesi login
  require_once './login/login_session.php';
  //ob_start("minify_html"); // Digunakan untuk minifikasi HTML (opsional)

  // Mengatur detail koneksi database
  $dbhostsql = DB_HOST;
  $dbusersql = DB_USER;
  $dbpasswordsql = DB_PASSWD;
  $dbnamesql = DB_NAME;
  // Membuat koneksi ke database
  $connection = mysqli_connect($dbhostsql, $dbusersql, $dbpasswordsql, $dbnamesql) or die(mysqli_error($connection));
  // Mengambil data dari konfigurasi situs
  $website_url = $row_site['site_url'];
  $website_name = $row_site['site_name'];
  $website_phone = $row_site['site_phone'];
  $website_addres = $row_site['site_address'];
  $meta_description = $row_site['site_description'];
  $website_logo = $row_site['site_logo'];
  $website_email = $row_site['site_email'];
  // Mendapatkan informasi browser dan hostname
  $iB = getBrowser();
  $browser = $iB['name'];
  $host_name = gethostbyaddr($_SERVER['REMOTE_ADDR']);
  $tgl_active = date('Y-m-d');
  // Menetapkan modul aktif berdasarkan parameter GET 'mod'
  if (!empty($_GET['mod'])) {
    $mod = mysqli_escape_string($connection, @$_GET['mod']);
  } else {
    $mod = 'home';
  }
  // Memuat header
  include_once 'sw-mod/sw-header.php';
  //include_once 'sw-mod/sw-footer.php';

  // Menyimpan output untuk pemrosesan lebih lanjut (opsional)
  ob_start();
  // Memuat konten berdasarkan modul yang aktif
  if (file_exists('./sw-mod/' . $mod . '/' . $mod . '.php')) {
    include ('sw-mod/' . $mod . '/' . $mod . '.php');
    include_once 'sw-mod/sw-footer.php';
    //theme_foot();
  } else {
    include ('sw-mod/home/home.php');
    include_once 'sw-mod/sw-footer.php';
    //theme_foot();
  }
}
//ob_end_flush(); // minify_html
?>