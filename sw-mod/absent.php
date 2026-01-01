<?php
if ($mod == '') {
    header('location:../404'); // Jika $mod kosong, arahkan ke halaman 404
    echo 'kosong'; // Menampilkan pesan "kosong"
} else {
    include_once 'sw-mod/sw-header.php'; // Menginclude file header

    // Memeriksa apakah cookie COOKIES_MEMBER dan COOKIES_COOKIES tidak diset
    if (!isset($_COOKIE['COOKIES_MEMBER']) && !isset($_COOKIE['COOKIES_COOKIES'])) {
        setcookie('COOKIES_MEMBER', '', 0, '/');// Menghapus cookie COOKIES_MEMBER
        setcookie('COOKIES_COOKIES', '', 0, '/'); // Menghapus cookie COOKIES_COOKIES
        // Login tidak ditemukan
        setcookie("COOKIES_MEMBER", "", time() - $expired_cookie); // Menghapus cookie COOKIES_MEMBER dengan waktu kadaluarsa negatif
        setcookie("COOKIES_COOKIES", "", time() - $expired_cookie); // Menghapus cookie COOKIES_COOKIES dengan waktu kadaluarsa negatif
        session_destroy(); // Menghancurkan sesi
        header("location:./"); // Arahkan ke halaman utama
    } else {
        // Menampilkan tampilan aplikasi jika cookie ditemukan
        echo '<!-- App Capsule -->
    <div id="appCapsule">
        <!-- Wallet Card -->
        <div class="section wallet-card-section pt-1">
            <div class="wallet-card">
                <div class="balance">
                    <div class="left">
                        <span class="title"> Selamat ' . $salam . '</span>
                        <h4>' . ucfirst($row_user['employees_name']) . '</h4>
                    </div>
                    <div class="right">
                        <span class="title">' . tgl_ind($date) . ' </span>
                        <h4><span class="clock"></span></h4>
                    </div>

                </div>
                <!-- * Balance -->
                <div class="text-center">
                <!--<h3>' . tgl_ind($date) . ' - <span class="clock"></span></h3>-->
                <p>Lat-Long: <span class="latitude" id="latitude"></span></p></div>
                <div class="wallet-footer text-center">
                    <div class="webcam-capture-body text-center">
                        <div class="webcam-capture"></div>
                        <div class="form-group basic">';
        if ($result_absent->num_rows > 0) { // Jika ada data absen
            echo '
                                <button class="btn btn-success btn-lg btn-block" onClick="captureimage(0)"><ion-icon name="camera-outline"></ion-icon>Absen Pulang</button>';
        } else {
            echo '
                                <button class="btn btn-success btn-lg btn-block" onClick="captureimage(0)"><ion-icon name="camera-outline"></ion-icon>Absen Masuk</button>';
        }
        echo '
                        </div>';
        echo '
                    </div>
                </div>
                <!-- * Wallet Footer -->
            </div>
        </div>
        <!-- Card -->
    </div>
    <!-- * App Capsule -->
';

    }
    include_once 'sw-mod/sw-footer.php'; // Menginclude file footer
} ?>