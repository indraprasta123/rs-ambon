<?php //error_reporting(0);

// Memulai output buffering
ob_start();
// Memulai session
session_start();
// Menyertakan file konfigurasi dan fungsi
include_once 'sw-library/sw-config.php';
include_once 'sw-library/sw-function.php';
//ob_start("minify_html");

// Mengatur variabel koneksi database
$dbhostsql = DB_HOST;
$dbusersql = DB_USER;
$dbpasswordsql = DB_PASSWD;
$dbnamesql = DB_NAME;

// Membuat koneksi ke database
$connection = mysqli_connect($dbhostsql, $dbusersql, $dbpasswordsql, $dbnamesql) or die(mysqli_error($connection));

// Memeriksa apakah cookie 'COOKIES_MEMBER' dan 'COOKIES_COOKIES' ada
if (!isset($_COOKIE['COOKIES_MEMBER']) && !isset($_COOKIE['COOKIES_COOKIES'])) {
  // Jika tidak ada cookie, pengguna tidak diarahkan ke halaman login
  //header('location:./login/');

} else {
  // Jika ada cookie, menyimpan nilai cookie dalam variabel
  $COOKIES_COOKIES = '';
  $COOKIES_MEMBER = '';
  if (!empty($_COOKIE['COOKIES_COOKIES'])) {
    $COOKIES_COOKIES = $_COOKIE['COOKIES_COOKIES'];
  }
  if (!empty($_COOKIE['COOKIES_MEMBER'])) {
    $COOKIES_MEMBER = epm_decode($_COOKIE['COOKIES_MEMBER']);
  }
  // Menyertakan file untuk pengelolaan cookie
  require_once 'sw-mod/out/sw-cookies.php';
  // Mengambil data absen berdasarkan ID karyawan dan tanggal
  $query_absent = "SELECT employees_id,time_in,time_out FROM presence WHERE employees_id='$row_user[id]' AND presence_date='$date'";
  $result_absent = $connection->query($query_absent);
  // $row_absent     = $result_absent->fetch_assoc();
}

// Mengambil informasi dari database untuk digunakan di halaman
$website_url = $row_site['site_url'];
$website_name = $row_site['site_name'];
$website_phone = $row_site['site_phone'];
$website_addres = $row_site['site_address'];
$meta_description = $row_site['site_description'];
$meta_keyword = $row_site['site_description'];
$website_logo = $row_site['site_logo'];
$website_email = $row_site['site_email'];
// Mengambil parameter 'alert' dari URL, jika ada
if (!empty($_GET['alert'])) {
  $alert = mysqli_escape_string($connection, @$_GET['alert']);
}
// Mengambil pesan dari session, jika ada
$messages = '';
if (!empty($_SESSION['messages'])) {
  $messages = $_SESSION['messages'];
}
// Menetapkan modul default
$mod = "home";
// Mengambil parameter 'mod' dari URL, jika ada
if (!empty($_GET['mod'])) {
  $mod = mysqli_escape_string($connection, @$_GET['mod']);
} else {
  $mod = 'home';
}
// Memeriksa apakah file modul yang diminta ada
if (file_exists("sw-mod/$mod.php")) {
  require_once ("sw-mod/$mod.php");
} else {
  require_once ("sw-mod/home.php");
}

?>