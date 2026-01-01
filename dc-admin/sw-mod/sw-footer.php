<?php if (empty($connection)) { // Cek apakah koneksi database ada
    // Arahkan ke halaman 404 jika koneksi tidak ada
    header('location:./404');
  } else {
    // Set modul default
    $mod = "home";
    // Ambil parameter 'mod' dari URL dan bersihkan dari karakter HTML
    $mod = htmlentities(@$_GET['mod']);
    // Fungsi untuk menghasilkan angka dari 1 hingga 500
    function get_numbers()
    {
      for ($i = 1; $i <= 500; $i++) {
        yield $i;
      }
    }
    // Inisialisasi generator angka
    $result = get_numbers();
    // Fungsi untuk mengkonversi ukuran memori menjadi format yang lebih mudah dibaca
    function convert($size)
    {
      $unit = array('b', 'kb', 'mb', 'gb', 'tb', 'pb');
      return @round($size / pow(1024, ($i = floor(log($size, 1024)))), 2) . ' ' . $unit[$i];
    }
    echo '
  <footer class="main-footer">
    <div class="pull-right hidden-xs">Theme LTE / 
      ' . convert(memory_get_usage()) . '
    </div>
     &copy; ' . DATE('Y') . ' ' . $site_name . ' | Design With <span id="credits"><a class="credits" href="https://yazcorp.id" target="_blank" id="credits">Fileo Sofio Hattalaibessy </a> - All Rights Reserved</span>
  </footer>
</div>
<!-- wrapper -->
<script src="./sw-assets/js/jquery-2.2.3.min.js"></script>
<script src="./sw-assets/js/jquery-ui.min.js"></script>
<script src="./sw-assets/js/bootstrap.min.js"></script>
<script src="./sw-assets/js/jquery.slimscroll.min.js"></script>
<script src="./sw-assets/js/adminlte.js"></script>
<script src="./sw-assets/js/app.js"></script>
<script src="./sw-assets/js/demo.js"></script>
<script src="./sw-assets/js/sweetalert.min.js"></script>
<script src="plugins/chart.js/Chart.min.js"></script>
<script src="./sw-assets/js/simple-lightbox.min.js"></script>
<script src="./sw-assets/js/validasi/jquery.validate.js"></script>
<script src="./sw-assets/js/validasi/messages_id.js"></script>';
    // Tambahkan skrip tambahan jika modul adalah 'shift'
    if ($mod == 'shift') {
      echo '
<script src="./sw-assets/plugins/datepicker/bootstrap-datepicker.js"></script>
<script src="./sw-assets/plugins/timepicker/bootstrap-timepicker.min.js"></script>';
    }
    // Tambahkan skrip dan stylesheet tambahan untuk beberapa modul
    if ($mod == 'karyawan' or $mod == 'jabatan' or $mod == 'shift' or $mod == 'lokasi' or $mod == 'user' or $mod == 'absensi' or $mod == 'cuty') {
      echo '
<link rel="stylesheet" href="./sw-assets/plugins/datatables/dataTables.bootstrap.css">
<script src="./sw-assets/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="./sw-assets/plugins/datatables/dataTables.bootstrap.min.js"></script>';
    }
    // Tambahkan skrip tambahan jika modul adalah 'absensi'
    if ($mod == 'absensi') {
      echo '
<script src="../sw-mod/sw-assets/js/plugins/magnific-popup/jquery.magnific-popup.min.js"></script>';
    }
    // Sertakan skrip modul spesifik jika ada
    if (file_exists('sw-mod/' . $mod . '/scripts.js')) {
      echo '
  <script src="sw-mod/' . $mod . '/scripts.js"></script>';
    }
    // JavaScript untuk validasi form dan alert akses gagal
    echo '
  <script type="text/javascript">
  	$(document).ready(function() {
  		$(".validate").validate();
  	});
    
    $(document).ready(function() {
      $(".validate2").validate();
    });
    $(document).on("click", ".access-failed", function(){ 
      swal({title:"Error!", text: "Anda tidak memiliki hak akses!", icon:"error",timer:2000,});  
    });
  </script>'; ?>
  <!-- </body></html> -->
  </body>

  </html>
<?PHP } ?>