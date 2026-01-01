<?php
if ($mod == '') {
    // Jika variabel kosong, pengguna akan diarahkan ke halaman 404 dan pesan 'kosong' ditampilkan.
    header('location:../404');
    echo 'kosong';
} else {
    include_once 'sw-mod/sw-header.php'; // Menyertakan file header

    // Memeriksa apakah cookie 'COOKIES_MEMBER' atau 'COOKIES_COOKIES' tidak ada
    if (!isset($_COOKIE['COOKIES_MEMBER']) or !isset($_COOKIE['COOKIES_COOKIES'])) {
        echo '
 <!-- App Capsule -->
    <div id="appCapsule">
        <div class="section text-center">
            <h1>Mendaftar</h1>
        </div>
        <div class="section mb-5 p-2">
            <form id="form-registrasi">
                <div class="card">
                    <div class="card-body pb-1">
                        <div class="form-group basic">
                            <div class="input-wrapper">
                                <label class="label">NIK</label>
                                <input type="text" class="form-control" id="employees_code" name="employees_code" required>
                                <i class="clear-input"><ion-icon name="close-circle"></ion-icon></i>
                            </div>
                        </div>

                        <div class="form-group basic">
                            <div class="input-wrapper">
                                <label class="label">Nama</label>
                                <input type="text" class="form-control" id="name" name="employees_name" required>
                                <i class="clear-input"><ion-icon name="close-circle"></ion-icon></i>
                            </div>
                        </div>

                        <div class="form-group basic">
                            <div class="input-wrapper">
                                <label class="label">E-mail</label>
                                <input type="email" class="form-control" id="email" name="employees_email" required>
                                <i class="clear-input"><ion-icon name="close-circle"></ion-icon></i>
                            </div>
                        </div>

                        <div class="form-group basic">
                            <div class="input-wrapper">
                                <label class="label">Pangkat</label>
                                <input type="text" class="form-control" id="pangkat" name="pangkat" required>
                                <i class="clear-input"><ion-icon name="close-circle"></ion-icon></i>
                            </div>
                        </div>

                        <div class="form-group basic">
                            <div class="input-wrapper">
                                <label class="label">Jabatan</label>
                                <select class="form-control" name="position_id" id="position_id"  required="">
                                  <option value="">- Pilih -</option>';
        // Mengambil dan menampilkan opsi jabatan dari database
        $query = "SELECT * from position order by position_name ASC";
        $result = $connection->query($query);
        while ($row = $result->fetch_assoc()) {
            echo '<option value="' . $row['position_id'] . '">' . $row['position_name'] . '</option>';
        }
        echo '
                                </select>
                            </div>
                        </div>

                        <div class="form-group basic">
                            <div class="input-wrapper">
                                <label class="label">Nama Jam Kerja</label>
                                <select class="form-control" name="shift_id" id="shift_id" required="">
                                  <option value="">- Pilih -</option>';
        // Mengambil dan menampilkan opsi jam kerja dari database
        $query = "SELECT shift_id,shift_name from shift order by shift_name ASC";
        $result = $connection->query($query);
        while ($row = $result->fetch_assoc()) {
            echo '<option value="' . $row['shift_id'] . '">' . $row['shift_name'] . '</option>';
        }
        echo '
                                </select>
                            </div>
                        </div>

                        <div class="form-group basic">
                            <div class="input-wrapper">
                                <label class="label">Ruang</label>
                                <select class="form-control" name="building_id" id="building" required="">
                                  <option value="">- Pilih -</option>';
        // Mengambil dan menampilkan opsi ruang dari database
        $query = "SELECT building_id,name,address from building order by name ASC";
        $result = $connection->query($query);
        while ($row = $result->fetch_assoc()) {
            echo '<option value="' . $row['building_id'] . '">' . $row['name'] . '</option>';
        }
        echo '
                              </select>
                            </div>
                        </div>

                        <div class="form-group basic">
                            <div class="input-wrapper">
                                <label class="label">Tempat dan Tanggal lahir</label>
                                <input type="text" class="form-control" id="born" name="born" required>
                                <i class="clear-input"><ion-icon name="close-circle"></ion-icon></i>
                            </div>
                        </div>

                        <div class="form-group basic">
                            <div class="input-wrapper">
                                <label class="label">Alamat Rumah</label>
                                <input type="text" class="form-control" id="employess_address" name="employess_address" required>
                                <i class="clear-input"><ion-icon name="close-circle"></ion-icon></i>
                            </div>
                        </div>
        
                        <div class="form-group basic">
                            <div class="input-wrapper">
                                <label class="label" for="password1">Password</label>
                                <input type="password" class="form-control" id="password" name="employees_password" placeholder="Passworb baru">
                                <i class="clear-input"><ion-icon name="close-circle"></ion-icon></i>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="form-links mt-2">
                    <div>
                        <a href=./>Sudah punya akun?</a>
                    </div>
                    <div><a href="forgot" class="text-muted">Lupa Password?</a></div>
                </div>

                <div class="form-button-group transparent">
                   <button type="submit" class="btn btn-danger btn-block btn-lg">Mendaftar</button>
                </div>

            </form>
        </div>

    </div>
    <!-- * App Capsule -->';
    } else {
        // Jika pengguna sudah memiliki cookie
        // Konten lainnya dapat ditempatkan di sini
    }

    include_once 'sw-mod/sw-footer.php'; // Menyertakan file footer
} ?>