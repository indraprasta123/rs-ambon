<?php
if ($mod == '') {
    header('location:../404'); // Jika tidak ada modul yang dipanggil, redirect ke halaman 404 dan tampilkan pesan 'kosong'
    echo 'kosong';
} else {
    include_once 'sw-mod/sw-header.php'; // Menyertakan file header

    // Memeriksa apakah cookie 'COOKIES_MEMBER' tidak ada
    if (!isset($_COOKIE['COOKIES_MEMBER'])) {

        // Mengambil kode karyawan terbesar dari database
        $query = mysqli_query($connection, "SELECT max( employees_code) as kodeTerbesar FROM employees");
        $data = mysqli_fetch_array($query);
        $kode_karyawan = $data['kodeTerbesar'];
        $urutan = (int) substr($kode_karyawan, 3, 3);
        $urutan++;
        $huruf = "OM";
        $kode_karyawan = $huruf . sprintf("%03s", $urutan);

        echo '
 
 <!-- App Capsule -->
    <div id="appCapsule">

        <div class="section mt-2 text-center">
            <h1>Masuk YA</h1>
            <h4>Isi formulir untuk masuk</h4>
        </div>
        <div class="section mb-5 p-2">

            <form id="form-login">
                <div class="card">
                    <div class="card-body pb-1">
                        <div class="form-group basic">
                            <div class="input-wrapper">
                                <label class="label" for="email1">E-mail</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="E-mail Anda">
                                <i class="clear-input"><ion-icon name="close-circle"></ion-icon></i>
                            </div>
                        </div>
        
                        <div class="form-group basic">
                            <div class="input-wrapper">
                                <label class="label" for="password1">Password</label>
                                <input type="password" class="form-control" id="password" name="password" placeholder="Kata sandi Anda">
                                <i class="clear-input"><ion-icon name="close-circle"></ion-icon></i>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-links mt-2">
                    <div>
                        <a href="registrasi">Mendaftar</a>
                    </div>
                    <div><a href="forgot" class="text-muted">Lupa Password?</a></div>
                </div>
                <div class="form-button-group transparent">
                   <button type="submit" class="btn btn-primary btn-block masuk"><ion-icon name="log-in-outline"></ion-icon> Masuk</button>
                </div>
            </form>
        </div>
    </div>
    <!-- * App Capsule -->';
    } else {
        // Jika cookie 'COOKIES_MEMBER' ada, redirect ke halaman utama
        header('location:./');
    }

    include_once 'sw-mod/sw-footer.php'; // Menyertakan file footer
} ?>