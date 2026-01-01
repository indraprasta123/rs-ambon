<?php
session_start(); // Memulai sesi PHP
require_once '../../sw-library/sw-config.php'; // Mengimpor konfigurasi database
include_once '../../sw-library/sw-function.php'; // Mengimpor fungsi tambahan

// Membuat salt untuk enkripsi password
$salt = '$%DSuTyr47542@#&*!=QxR094{a911}+';
$ip_login = $_SERVER['REMOTE_ADDR']; // Mendapatkan alamat IP pengguna yang login
$created_login = date('Y-m-d H:i:s'); // Mendapatkan waktu login
$iB = getBrowser(); // Mendapatkan informasi browser pengguna
$browser = $iB['name'] . ' ' . $iB['version']; // Menggabungkan nama dan versi browser

if (isset($_GET['username'])) { // Memeriksa apakah parameter username tersedia

	$username = htmlentities($_GET['username']); // Mengambil username dan mencegah XSS
	$password = hash('sha256', $salt . $_GET['password']); // Menggabungkan password dengan salt dan meng-hash-nya
	$session = md5(rand(1000, 9999) . rand(19078, 9999) . date('ymdhisss')); // Membuat session ID unik

	// Mengupdate waktu login dan session di database
	$update = mysqli_query($connection, "UPDATE user SET created_login='$created_login', session='-' WHERE password='$password'") or die(mysqli_error($connection));

	// Mengecek apakah username dan password ada di database
	$query_login = "SELECT * FROM user WHERE username='$username' AND password='$password'";
	$result_login = $connection->query($query_login);
	$login_num = $result_login->num_rows; // Menghitung jumlah baris yang cocok
	$row = $result_login->fetch_assoc(); // Mengambil baris hasil query

	// Menyimpan informasi sesi pengguna
	$SESSION_USER = $row['session'];
	$SESSION_ID = strip_tags($row['user_id']); // Mengamankan user_id dari karakter berbahaya
	$fullname = $row['fullname'];
	$username = strip_tags($row['username']); // Mengamankan username dari karakter berbahaya

	// Membuat pesan notifikasi login
	$pesan = "Saat ini [" . $fullname . "] Sedang Membuka Halaman Admin
    [Detail Akun] :
    Nama  	  : " . $fullname . "
    Username  : " . $username . "
    Ip		  : " . $ip_login . "
    Tgl Login : " . $created_login . "
    Browser   : " . $browser . "
    \n
    Hormat Kami,\nTim YAZCORP.id\n
    Pesan noreply";

	$to = 'emailanda@gmail.com'; // Ganti dengan email Anda
	$subject = 'Admin Online';
	$headers = "From: $site_email_domain <$site_email_domain>\r\n"; // Mengatur header email

	if ($login_num == '0') {
		// Jika login gagal, kirim respon error
		echo '{"response":{"error": "0"}}';
	} else {
		// Jika login berhasil, kirim respon sukses
		echo '{"response":{"error": "1"}}';

		// Menyimpan informasi sesi ke dalam variabel sesi PHP
		$_SESSION['SESSION_USER'] = $SESSION_USER;
		$_SESSION['SESSION_ID'] = $SESSION_ID;

		// Aktifkan jika ingin mengirim notifikasi login melalui email
		// mail($to, $subject, $pesan, $headers); 
	}
}
?>