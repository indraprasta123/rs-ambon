<?php
// Menonaktifkan pelaporan kesalahan PHP
error_reporting(0);
// Mengatur zona waktu default ke Asia/Jakarta
date_default_timezone_set('Asia/Jakarta');
// Menggabungkan host dan URI untuk mendapatkan URL penuh
$pacth_url = 'localhost' . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"] . '';
// -------------- Koneksi Database ------------

// Informasi koneksi database
$DB_HOST = 'localhost'; // Alamat host database
$DB_USER = 'root'; // User Database
$DB_PASSWD = ''; // Password Database
$DB_NAME = 'db_absensi'; // Nama database

// -------------- Koneksi Database ------------

//Mendefinisikan konstanta untuk host database, user, password, dan nama database.
@define("DB_HOST", $DB_HOST);
@define("DB_USER", $DB_USER);
@define("DB_PASSWD", $DB_PASSWD);
@define("DB_NAME", $DB_NAME);
// Membuat koneksi ke database MySQL
$connection = new mysqli($DB_HOST, $DB_USER, $DB_PASSWD, $DB_NAME);
// Memeriksa apakah koneksi berhasil
if ($connection->connect_error) {
	// Menampilkan pesan kesalahan jika koneksi gagal
	echo 'Gagal koneksi ke database';
} else {
	// Menjalankan query untuk mendapatkan data dari tabel sw_site
	$query_site = "SELECT * FROM sw_site LIMIT 1";
	$result_site = $connection->query($query_site);
	// Mengambil hasil query sebagai array asosiatif
	$row_site = $result_site->fetch_assoc();
	// Mengekstrak data array ke dalam variabel
	extract($row_site);
}
// Mendefinisikan fungsi base_url jika belum ada
if (!function_exists('base_url')) {
	function base_url($atRoot = FALSE, $atCore = FALSE, $parse = FALSE)
	{
		// Jika HTTP_HOST tersedia, buat URL dasar
		if (isset($_SERVER['HTTP_HOST'])) {
			// Menentukan apakah menggunakan HTTP atau HTTPS
			$http = isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== 'off' ? 'https' : 'http';
			// Mengambil nama host
			$hostname = $_SERVER['HTTP_HOST'];
			// Mengambil direktori skrip
			$dir = str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);
			// Mengambil bagian core dari direktori
			//$core = preg_split('@/@', str_replace($_SERVER['DOCUMENT_ROOT'], '', realpath(dirname(__FILE__))), NULL, PREG_SPLIT_NO_EMPTY);
			$core = preg_split('@/@', str_replace($_SERVER['DOCUMENT_ROOT'], '', realpath(dirname(__FILE__))), PREG_SPLIT_NO_EMPTY);
			$core = $core[0];
			// Menentukan template URL berdasarkan parameter
			$tmplt = $atRoot ? ($atCore ? "%s://%s/%s/" : "%s://%s/") : ($atCore ? "%s://%s/%s/" : "%s://%s%s");
			$end = $atRoot ? ($atCore ? $core : $hostname) : ($atCore ? $core : $dir);
			// Membuat URL dasar menggunakan sprintf
			$base_url = sprintf($tmplt, $http, $hostname, $end);
		} else
			// Default URL jika HTTP_HOST tidak tersedia
			$base_url = 'http://localhost/';
		// Jika parameter parse diaktifkan, parse URL
		if ($parse) {
			$base_url = parse_url($base_url);
			if (isset($base_url['path'])) if ($base_url['path'] == '/')
				$base_url['path'] = '';
		}
		// Mengembalikan URL dasar
		return $base_url;
	}
}
// Mendapatkan URL dasar
$base_url = base_url();
