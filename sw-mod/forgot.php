<?php
if ($mod == '') {
    header('location:../404'); // Jika kosong, arahkan ke halaman 404
    echo 'kosong'; // Menampilkan pesan "kosong"
} else {
    include_once 'sw-mod/sw-header.php'; // Menginclude file header

    // Memeriksa apakah cookie COOKIES_MEMBER atau COOKIES_COOKIES tidak diset
    if (!isset($_COOKIE['COOKIES_MEMBER']) or !isset($_COOKIE['COOKIES_COOKIES'])) {

        // Mengambil kode karyawan terbesar dari database
        $query = mysqli_query($connection, "SELECT max( employees_code) as kodeTerbesar FROM employees");
        $data = mysqli_fetch_array($query);
        $kode_karyawan = $data['kodeTerbesar'];
        $urutan = (int) substr($kode_karyawan, 3, 3); // Memotong bagian angka dari kode karyawan
        $urutan++; // Meningkatkan urutan untuk kode karyawan baru
        $huruf = "OM"; // Inisial untuk kode karyawan
        $kode_karyawan = $huruf . sprintf("%03s", $urutan); // Menyusun kode karyawan baru

        // Menampilkan form untuk reset password
        echo '
 <!-- App Capsule -->
    <div id="appCapsule">
        <div class="section mt-1 text-center">
            <h1>Lupa Password</h1>
            <h4>Masukkan email yang terdaftar untuk meyetal ulang password</h4>
        </div>
        <div class="section mb-5 p-2">
            <form id="form-forgot">
                <div class="card">
                    <div class="card-body pb-1">
    
                        <div class="form-group basic">
                            <div class="input-wrapper">
                                <label class="label">E-mail</label>
                                <input type="email" class="form-control" id="email" name="employees_email" required>
                                <i class="clear-input"><ion-icon name="close-circle"></ion-icon></i>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="form-links mt-2">
                    <div>
                        <a href=./>Sudah punya akun?</a>
                    </div>
                </div>

                <div class="form-button-group transparent">
                   <button type="submit" class="btn btn-primary btn-block btn-lg">Kirim</button>
                </div>

            </form>
        </div>

    </div>
    <!-- * App Capsule -->';
    } else {
        // Jika cookie ditemukan, maka tidak melakukan apapun (dapat diisi dengan kode lain jika diperlukan)
    }

    include_once 'sw-mod/sw-footer.php'; // Menginclude file footer
} ?>