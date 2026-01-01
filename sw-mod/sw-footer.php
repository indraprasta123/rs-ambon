<?php
// Memeriksa apakah koneksi database ada
if (empty($connection)) {
    // Jika tidak ada koneksi, redirect ke halaman 404
    header('location:./404');
} else {
    // Jika ada koneksi, memeriksa apakah cookie 'COOKIES_MEMBER' ada
    if (isset($_COOKIE['COOKIES_MEMBER'])) {
        echo '
<div class="appBottomMenu">
        <a href="./" class="item">
            <div class="col">
                <ion-icon name="home-outline"></ion-icon>
                <strong>Home</strong>
            </div>
        </a>

        <a href="absent" class="item">
            <div class="col">
                <ion-icon name="camera-outline"></ion-icon>
                <strong>Absen</strong>
            </div>
        </a>

        <a href="./cuty" class="item">
            <div class="col">
               <ion-icon name="calendar-outline"></ion-icon>
                <strong>Cuty</strong>
            </div>
        </a>

        <a href="./history" class="item">
            <div class="col">
                 <ion-icon name="document-text-outline"></ion-icon>
                <strong>History</strong>
            </div>
        </a>

        
        <a href="./profile" class="item">
            <div class="col">
                <ion-icon name="person-outline"></ion-icon>
                <strong>Profil</strong>
            </div>
        </a>
    </div>
<!-- * App Bottom Menu -->';
    }
    ob_end_flush();
    echo '
<footer class="text-muted text-center" style="display:none">
   <p>© 2021 - ' . $year . ' ' . $site_name . ' - Design By: <span id="credits"><a class="credits_a" href="https://yazcorp.id" target="_blank">YAZCORP.id</a></span></p>
</footer>
<!-- ///////////// Js Files ////////////////////  -->
<!-- Jquery -->
<script src="' . $base_url . 'sw-mod/sw-assets/js/lib/jquery-3.4.1.min.js"></script>
<!-- Bootstrap-->
<script src="' . $base_url . 'sw-mod/sw-assets/js/lib/popper.min.js"></script>
<script src="' . $base_url . 'sw-mod/sw-assets/js/lib/bootstrap.min.js"></script>
<!-- Ionicons -->
<script src="https://unpkg.com/ionicons@5.4.0/dist/ionicons.js"></script>
<script src="https://kit.fontawesome.com/0ccb04165b.js" crossorigin="anonymous"></script>
<!-- Base Js File -->
<script src="' . $base_url . 'sw-mod/sw-assets/js/base.js"></script>
<script src="' . $base_url . 'sw-mod/sw-assets/js/sweetalert.min.js"></script>
<script src="' . $base_url . 'sw-mod/sw-assets/js/webcamjs/webcam.min.js"></script>';
    // Memeriksa apakah modul yang aktif adalah 'history' atau 'cuty'
    if ($mod == 'history' or $mod == 'cuty') {
        echo '
<script src="' . $base_url . 'sw-mod/sw-assets/js/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="' . $base_url . 'sw-mod/sw-assets/js/plugins/datatables/dataTables.bootstrap.min.js"></script>
<script src="' . $base_url . 'sw-mod/sw-assets/js/plugins/datepicker/bootstrap-datepicker.js"></script>
<script src="' . $base_url . 'sw-mod/sw-assets/js/plugins/magnific-popup/jquery.magnific-popup.min.js"></script>
<script>
    $(".datepicker").datepicker({
        format: "dd-mm-yyyy",
        "autoclose": true
    }); 
    
</script>';
    }
    echo '
<script src="' . $base_url . '/sw-mod/sw-assets/js/sw-script.js"></script>';
    // Memeriksa apakah modul yang aktif adalah 'absent'
    if ($mod == 'absent') { ?>
        <script type="text/javascript">
            var result;
            $(document).ready(function getLocation() {
                result = document.getElementById("latitude");
                // 
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(successCallback, errorCallback);
                } else {
                    swal({ title: 'Oops!', text: 'Maaf, browser Anda tidak mendukung geolokasi HTML5.', icon: 'error', timer: 3000, });
                }
            });

            // Callback function untuk berhasil mendapatkan lokasi
            function successCallback(position) {
                result.innerHTML = "" + position.coords.latitude + "," + position.coords.longitude + "";
            }

            // Callback function untuk gagal mendapatkan lokasi
            function errorCallback(error) {
                if (error.code == 1) {
                    swal({ title: 'Oops!', text: 'Anda telah memutuskan untuk tidak membagikan posisi Anda, tetapi tidak apa-apa. Kami tidak akan meminta Anda lagi.', icon: 'error', timer: 3000, });
                } else if (error.code == 2) {
                    swal({ title: 'Oops!', text: 'Jaringan tidak aktif atau layanan penentuan posisi tidak dapat dijangkau.', icon: 'error', timer: 3000, });
                } else {
                    swal({ title: 'Oops!', text: 'Waktu percobaan habis sebelum bisa mendapatkan data lokasi.', icon: 'error', timer: 3000, });
                }
            }
            // Mulai kamera
            Webcam.set({
                width: 590, height: 460,
                image_format: 'jpeg',
                jpeg_quality: 80,
            });

            var cameras = new Array(); // Membuat array kosong untuk menyimpan ID perangkat
            navigator.mediaDevices.enumerateDevices() // Mendapatkan perangkat yang tersedia
                .then(function (devices) {
                    devices.forEach(function (device) {
                        var i = 0;
                        if (device.kind === "videoinput") { // Menyaring perangkat video
                            cameras[i] = device.deviceId; // Menyimpan ID kamera dalam array
                            i++;
                        }
                    });
                })

            // Set Camera Depan =========
            Webcam.set('constraints', {
                width: 590,
                height: 460,
                image_format: 'jpeg',
                jpeg_quality: 80,
                sourceId: cameras[0]
            });

            Webcam.attach('.webcam-capture');
            // Memuat suara shutter
            var shutter = new Audio();
            //shutter.autoplay = true;
            shutter.src = navigator.userAgent.match(/Firefox/) ? './sw-mod/sw-assets/js/webcamjs/shutter.ogg' : './sw-mod/sw-assets/js/webcamjs/shutter.mp3';
            function captureimage() {
                var latitude = $('.latitude').html();
                // Memainkan efek suara
                shutter.play();
                // Mengambil snapshot dan mendapatkan data gambar
                Webcam.snap(function (data_uri) {
                    // Menampilkan hasil di halaman
                    Webcam.upload(data_uri, './sw-proses?action=absent&latitude=' + latitude + '',
                        function (code, text) {
                            $data = '' + text + '';
                            var results = $data.split("/");
                            $results = results[0];
                            $results2 = results[1];
                            if ($results == 'success') {
                                swal({ title: 'Berhasil!', text: $results2, icon: 'success', timer: 3500, });
                                setTimeout("location.href = './';", 3600);
                            } else {
                                swal({ title: 'Oops!', text: text, icon: 'error', timer: 3500, });
                            }
                        });
                });
            }
        </script>
    <?php } ?>
    <!-- </body></html> -->
    </body>

    </html><?php } ?>