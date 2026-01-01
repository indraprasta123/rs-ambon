<?php
session_start(); // Memulai sesi PHP

require_once '../../sw-library/sw-config.php'; // Mengimpor konfigurasi database
require_once '../login/login_session.php'; // Mengimpor skrip sesi login

$time_logout = date('Y-m-d H:i:s'); // Mendapatkan waktu logout

// Mengupdate waktu terakhir login dan mengosongkan sesi di database
$update = mysqli_query($connection, "UPDATE user SET last_login='$time_logout', session='-' WHERE user_id='$user_id'") or die(mysqli_error($connection));

// Menghapus variabel sesi
unset($_SESSION['SESSION_USER']);
unset($_SESSION['SESSION_ID']);

session_destroy();

// Mengarahkan ke halaman login
header('Location: ./login/');
exit(); // Menghentikan eksekusi skrip
?>