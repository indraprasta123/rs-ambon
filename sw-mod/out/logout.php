<?PHP
session_start(); // Memulai sesi PHP
require_once '../../sw-library/sw-config.php'; // Menyertakan file konfigurasi database

$expired_cookie = time() + 60 * 60 * 24 * 3; // Mengatur waktu kedaluwarsa cookie menjadi 3 hari
$COOKIES_MEMBER = ''; // Inisialisasi variabel cookie member
$COOKIES_COOKIES = ''; // Inisialisasi variabel cookie

// Memeriksa apakah cookie 'COOKIES_COOKIES' ada
if (!empty($_COOKIE['COOKIES_COOKIES'])) {
    $COOKIES_COOKIES = $_COOKIE['COOKIES_COOKIES']; // Jika ada, menyimpannya ke variabel
}

// Query untuk mengambil data karyawan berdasarkan ID dan cookie yang dibuat
$query_user = "SELECT * FROM employees where id='$COOKIES_MEMBER' AND created_cookies='$COOKIES_COOKIES'";
$result_user = $connection->query($query_user); // Eksekusi query
$row_user = $result_user->fetch_assoc(); // Mengambil hasil query dalam bentuk array asosiatif
$employees_id = $row_user['id']; // Menyimpan ID karyawan

// Menghapus cookie yang dibuat dengan mengatur 'created_cookies' menjadi '-'
$save = mysqli_query($connection, "UPDATE employees set created_cookies='-' where id='$employees_id'");

// Mengarahkan pengguna kembali ke halaman login atau beranda
header("location:./");

// Menghapus sesi dan cookie yang berkaitan dengan pengguna
unset($_SESSION['COOKIES_MEMBER']); // Menghapus sesi COOKIES_MEMBER
unset($_SESSION['COOKIES_COOKIES']); // Menghapus sesi COOKIES_COOKIES
setcookie("COOKIES_MEMBER", "", time() - 3600); // Menghapus cookie COOKIES_MEMBER
setcookie("COOKIES_COOKIES", "", time() - 3600); // Menghapus cookie COOKIES_COOKIES
setcookie('COOKIES_COOKIES', '', 0, '/'); // Menghapus cookie COOKIES_COOKIES dengan path '/'
setcookie('COOKIES_MEMBER', '', 0, '/'); // Menghapus cookie COOKIES_MEMBER dengan path '/'
session_destroy(); // Menghancurkan sesi
exit(); // Menghentikan eksekusi skrip
?>