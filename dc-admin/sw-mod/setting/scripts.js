// Fungsi untuk memuat pengaturan umum dari server
function loadSettingUmum() {
  $("#load").html(
    '<div class="text-center"><div class="spinner-border" role="status"></div><p>Loading data...</p></div>'
  );
  $("#load").load("sw-mod/setting/form.php?action=setting");
}

// Fungsi untuk memuat pengaturan profil dari server
function loadSettingProfile() {
  $("#load").html(
    '<div class="text-center"><div class="spinner-border" role="status"></div><p>Loading data...</p></div>'
  );
  $("#load").load("sw-mod/setting/form.php?action=profile");
}

// Fungsi yang dijalankan saat dokumen sudah siap
$(document).ready(function () {
  // Fungsi untuk menampilkan indikator loading
  function loading() {
    $(".loading").show(); // Menampilkan elemen loading
    $(".loading").delay(1500).fadeOut(500); // Menyembunyikan elemen loading setelah 1,5 detik
  }

  // Memuat pengaturan umum saat halaman dimuat
  loadSettingUmum();

  /* -------------------- Edit ------------------- */
  // Menangani pengiriman form dengan kelas '.update-setting' di dalam elemen '#load'
  $("#load").on("submit", ".update-setting", function (e) {
    if ($("#site_url").val() == "") {
      // Menampilkan pesan error jika ada bidang kosong
      swal({
        title: "Oops!",
        text: "Harap bidang inputan tidak boleh ada yang kosong.!",
        icon: "error",
        timer: 1500,
      });
      loading();
      return false;
    } else {
      loading(); // Menampilkan indikator loading
      e.preventDefault(); // Mencegah pengiriman form standar
      $.ajax({
        url: "sw-mod/setting/proses.php?action=update",
        type: "POST",
        data: new FormData(this),
        processData: false,
        contentType: false,
        cache: false,
        async: false,
        beforeSend: function () {
          loading(); // Menampilkan indikator loading sebelum mengirimkan permintaan
        },
        success: function (data) {
          if (data == "success") {
            // Menampilkan pesan sukses dan memuat ulang pengaturan umum
            swal({
              title: "Berhasil!",
              text: "Data berhasil disimpan.!",
              icon: "success",
              timer: 1500,
            });
            $("#modalEdit").modal("hide"); // Menutup modal setelah berhasil
            //setTimeout(function(){ location.reload(); }, 1500);
            loadSettingUmum(); // Memuat ulang pengaturan umum
          } else {
            // Menampilkan pesan error jika terjadi kesalahan
            swal({ title: "Oops!", text: data, icon: "error", timer: 1500 });
          }
        },
        complete: function () {
          $(".loading").hide(); // Menyembunyikan indikator loading setelah selesai
        },
      });
    }
  });

  /* -------------------- Edit Profile ------------------- */
  // Menangani pengiriman form dengan kelas '.update-profile' di dalam elemen '#load'
  $("#load").on("submit", ".update-profile", function (e) {
    if ($("#site_manager").val() == "") {
      // Menampilkan pesan error jika ada bidang kosong
      swal({
        title: "Oops!",
        text: "Harap bidang inputan tidak boleh ada yang kosong.!",
        icon: "error",
        timer: 1500,
      });
      loading();
      return false;
    } else {
      loading(); // Menampilkan indikator loading
      e.preventDefault(); // Mencegah pengiriman form standar
      $.ajax({
        url: "sw-mod/setting/proses.php?action=profile",
        type: "POST",
        data: new FormData(this),
        processData: false,
        contentType: false,
        cache: false,
        async: false,
        beforeSend: function () {
          loading(); // Menampilkan indikator loading sebelum mengirimkan permintaan
        },
        success: function (data) {
          if (data == "success") {
            // Menampilkan pesan sukses dan memuat ulang pengaturan profil
            swal({
              title: "Berhasil!",
              text: "Data berhasil disimpan.!",
              icon: "success",
              timer: 1500,
            });
            loadSettingProfile(); // Memuat ulang pengaturan profil
          } else {
            // Menampilkan pesan error jika terjadi kesalahan
            swal({ title: "Oops!", text: data, icon: "error", timer: 1500 });
          }
        },
        complete: function () {
          $(".loading").hide(); // Menyembunyikan indikator loading setelah selesai
        },
      });
    }
  });

  // Menangani klik pada tombol cetak
  $(".btn-print").on("click", function () {
    $("#printarea").show(); // Menampilkan area yang akan dicetak
    window.print(); // Memanggil dialog cetak
  });
});
