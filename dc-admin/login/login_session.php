<?php
// Memeriksa apakah SESSION_USER dan SESSION_ID kosong
if (empty($_SESSION['SESSION_USER']) && empty($_SESSION['SESSION_ID'])) {
    // Jika kosong, arahkan ke halaman login
    header('Location:../login');
    // Hapus sesi yang ada
    unset($_SESSION['SESSION_USER']);
    unset($_SESSION['SESSION_ID']);

    session_destroy();
} else {
    // Jika sesi tidak kosong, lanjutkan memeriksa
    $SESSION_USER = '';
    $SESSION_ID = '';
    // Periksa apakah SESSION_USER tidak kosong, jika tidak, tetapkan ke variabel
    if (!empty($_SESSION['SESSION_USER'])) {
        $SESSION_USER = $_SESSION['SESSION_USER'];
    }
    // Periksa apakah SESSION_ID tidak kosong, jika tidak, tetapkan ke variabel
    if (!empty($_SESSION['SESSION_ID'])) {
        $SESSION_ID = $_SESSION['SESSION_ID'];
    }

    // Query untuk memeriksa apakah sesi pengguna ada di database
    $query_login = "SELECT * FROM user WHERE session='$SESSION_USER' AND user_id='$SESSION_ID'";
    // Menjalankan query
    $result_login = $connection->query($query_login);
    // Menghitung jumlah baris hasil query
    $log_login = $result_login->num_rows;
    // Mengambil hasil query
    $row_user = $result_login->fetch_assoc();
    // Mengekstrak hasil query ke dalam variabel
    extract($row_user);
    // Mengamankan user_id dan level_user dari karakter berbahaya
    $user_id = htmlentities($row_user['user_id']);
    $level_user = htmlentities($row_user['level']);

    // Jika hasil query kosong, sesi tidak valid
    if ($log_login == '0') {
        // Arahkan ke halaman login
        // redirect(''.$url_login.'');
        // Hapus sesi yang ada
        unset($_SESSION['SESSION_ID']);
        unset($_SESSION['SESSION_USER']);
        // Hancurkan sesi
        session_destroy();
    } else {
        // Jika sesi valid, lanjutkan ke bagian lain dari aplikasi
        #------------------------------------------------------------------------------------
        # Bagian ini dapat digunakan untuk logika tambahan setelah sesi divalidasi
        #------------------------------------------------------------------------------------
    }
}
?>