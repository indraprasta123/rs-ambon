$(document).ready(function () {
  // Inisialisasi DataTables dengan pengaturan tampilan
  $("#swdatatable").dataTable({
    iDisplayLength: 20,
    aLengthMenu: [
      [20, 30, 50, -1],
      [20, 30, 50, "All"],
    ],
  });

  // Fungsi untuk menampilkan dan menyembunyikan elemen loading
  function loading() {
    $(".loading").show();
    $(".loading").delay(1500).fadeOut(500);
  }

  /* ----------- Add ------------*/
  // Menangani pengiriman formulir untuk menambahkan lokasi baru
  $(".add-lokasi").submit(function (e) {
    // Periksa apakah semua bidang input kosong
    if (
      // Periksa apakah semua bidang input kosong
      $("input[type=text]").val() == "" &&
      $("textarea.address").val() == ""
    ) {
      swal({
        title: "Oops!",
        text: "Harap bidang inputan tidak boleh ada yang kosong.!",
        icon: "error",
        timer: 1500,
      });
      return false; // Hentikan pengiriman formulir
      loading(); // Tampilkan elemen loading
    } else {
      loading();
      e.preventDefault(); // Hentikan pengiriman formulir standar
      $.ajax({
        url: "sw-mod/lokasi/proses.php?action=add", // URL untuk permintaan AJAX
        type: "POST", // Metode permintaan
        data: new FormData(this), // Data formulir
        processData: false,
        contentType: false,
        cache: false,
        async: false,
        beforeSend: function () {
          loading(); // Tampilkan elemen loading sebelum mengirim permintaan
        },
        success: function (data) {
          if (data == "success") {
            swal({
              title: "Berhasil!",
              text: "Data lokasi  berhasil disimpan.!",
              icon: "success",
              timer: 1500,
            });
            $("#modalAdd").modal("hide"); // Sembunyikan modal setelah berhasil
            setTimeout(function () {
              location.reload();
            }, 1500); // Muat ulang halaman setelah 1,5 detik
          } else {
            swal({ title: "Oops!", text: data, icon: "error", timer: 1500 });
          }
        },
        complete: function () {
          $(".loading").hide(); // Sembunyikan elemen loading setelah permintaan selesai
        },
      });
    }
  });

  /* -------------------- Edit ------------------- */
  // Menangani pengiriman formulir untuk memperbarui lokasi yang ada
  $(".update-lokasi").submit(function (e) {
    if ($("#txtname").val() == "") {
      swal({
        title: "Oops!",
        text: "Harap bidang inputan tidak boleh ada yang kosong.!",
        icon: "error",
        timer: 1500,
      });
      loading(); // Tampilkan elemen loading
      return false; // Hentikan pengiriman formulir
    } else {
      loading();
      e.preventDefault(); // Hentikan pengiriman formulir standar
      $.ajax({
        url: "sw-mod/lokasi/proses.php?action=update", // URL untuk permintaan AJAX
        type: "POST", //Metode permintaan
        data: new FormData(this), // Data formulir
        processData: false,
        contentType: false,
        cache: false,
        async: false,
        beforeSend: function () {
          loading(); // Tampilkan elemen loading sebelum mengirim permintaan
        },
        success: function (data) {
          if (data == "success") {
            swal({
              title: "Berhasil!",
              text: "Data Lokasi berhasil disimpan.!",
              icon: "success",
              timer: 1500,
            });
            $("#modalEdit").modal("hide");
            setTimeout(function () {
              location.reload();
            }, 1500); // Muat ulang halaman setelah 1,5 detik
          } else {
            swal({ title: "Oops!", text: data, icon: "error", timer: 1500 });
          }
        },
        complete: function () {
          $(".loading").hide(); // Sembunyikan elemen loading setelah permintaan selesai
        },
      });
    }
  });

  /*------------ Delete -------------*/
  // Menangani klik tombol hapus untuk menghapus data
  $(document).on("click", ".delete", function () {
    var id = $(this).attr("data-id"); // Ambil ID data dari atribut
    swal({
      text: "Anda yakin menghapus data ini?",
      icon: "warning",
      buttons: {
        cancel: true,
        confirm: true,
      },
      value: "delete",
    }).then((value) => {
      if (value) {
        loading();
        $.ajax({
          url: "sw-mod/lokasi/proses.php?action=delete", // URL untuk permintaan AJAX
          type: "POST", // Metode permintaan
          data: { id: id }, // Data untuk dikirim
          success: function (data) {
            if (data == "success") {
              swal({
                title: "Berhasil!",
                text: "Data berhasil dihapus.!",
                icon: "success",
                timer: 1500, // Muat ulang halaman setelah 1,5 detik
              });
              setTimeout(function () {
                location.reload();
              }, 1500);
            } else {
              swal({ title: "Gagal!", text: data, icon: "error", timer: 1500 });
            }
          },
        });
      } else {
        return false; // Jika tidak dikonfirmasi, tidak melakukan apa-apa
      }
    });
  });
  // Menangani klik tombol cetak untuk mencetak area tertentu
  $(".btn-print").on("click", function () {
    $("#printarea").show(); // Tampilkan area cetak
    window.print(); // menjlankan pencetakan
  });
});
