$(document).ready(function () {
  // Inisialisasi DataTable dengan pengaturan tampilan
  $("#swdatatable").dataTable({
    iDisplayLength: 20, // Jumlah baris per halaman default
    aLengthMenu: [
      [20, 30, 50, -1],
      [20, 30, 50, "All"],
    ], // Opsi jumlah baris yang dapat dipilih
  });

  // Fungsi untuk menampilkan dan menyembunyikan animasi loading
  function loading() {
    $(".loading").show();
    $(".loading").delay(1500).fadeOut(500);
  }

  /* ----------- Add ------------*/
  // Ketika form dengan kelas 'add-user' disubmit
  $(".add-user").submit(function (e) {
    // Cek jika ada input teks kosong
    if ($("input[type=text]").val() == "") {
      swal({
        title: "Oops!",
        text: "Harap bidang inputan tidak boleh ada yang kosong.!",
        icon: "error",
        timer: 1500,
      });
      return false;
      loading();
    } else {
      loading();
      e.preventDefault(); // Mencegah pengiriman form secara default
      $.ajax({
        url: "sw-mod/user/proses.php?action=add", // URL untuk permintaan AJAX
        type: "POST",
        data: new FormData(this), // Mengirim data form
        processData: false,
        contentType: false,
        cache: false,
        async: false,
        beforeSend: function () {
          loading();
        },
        success: function (data) {
          // Jika data berhasil disimpan
          if (data == "success") {
            swal({
              title: "Berhasil!",
              text: "Data User berhasil disimpan.!",
              icon: "success",
              timer: 1500,
            });
            $("#modalAdd").modal("hide"); // Menutup modal setelah berhasil
            setTimeout(function () {
              location.reload();
            }, 1500); // Merefresh halaman setelah 1,5 detik
          } else {
            // Jika terjadi error
            swal({
              title: "Oops!",
              text: data,
              icon: "error",
              timer: 1500,
            });
          }
        },
        complete: function () {
          $(".loading").hide();
        },
      });
    }
  });

  /* -------------------- Edit ------------------- */
  // Ketika form dengan kelas 'update-user' disubmit
  $(".update-user").submit(function (e) {
    // Cek jika input 'txtnama' dan 'txtemail' kosong
    if ($("#txtnama").val() == "" && $("#txtemail").val() == "") {
      swal({
        title: "Oops!",
        text: "Harap bidang inputan tidak boleh ada yang kosong.!",
        icon: "error",
        timer: 1500,
      });
      loading();
      return false;
    } else {
      loading();
      e.preventDefault(); // Mencegah pengiriman form secara default
      $.ajax({
        url: "sw-mod/user/proses.php?action=update", // URL untuk permintaan AJAX
        type: "POST",
        data: new FormData(this), // Mengirim data form
        processData: false,
        contentType: false,
        cache: false,
        async: false,
        beforeSend: function () {
          loading();
        },
        success: function (data) {
          // Jika data berhasil disimpan
          if (data == "success") {
            swal({
              title: "Berhasil!",
              text: "Data User berhasil disimpan.!",
              icon: "success",
              timer: 1500,
            });
            $("#modalEdit").modal("hide"); // Menutup modal setelah berhasil
            setTimeout(function () {
              location.reload();
            }, 1500); // Merefresh halaman setelah 1,5 detik
          } else {
            // Jika terjadi error
            swal({
              title: "Oops!",
              text: data,
              icon: "error",
              timer: 1500,
            });
          }
        },
        complete: function () {
          $(".loading").hide();
        },
      });
    }
  });

  /*------------ Delete -------------*/
  // Ketika elemen dengan kelas 'delete' diklik
  $(document).on("click", ".delete", function () {
    var id = $(this).attr("data-id"); // Mengambil ID dari atribut data-id
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
          url: "sw-mod/user/proses.php?action=delete", // URL untuk permintaan AJAX
          type: "POST",
          data: { id: id }, // Mengirim ID untuk dihapus
          success: function (data) {
            // Jika data berhasil dihapus
            if (data == "success") {
              swal({
                title: "Berhasil!",
                text: "Data berhasil dihapus.!",
                icon: "success",
                timer: 1500,
              });
              setTimeout(function () {
                location.reload();
              }, 1500); // Merefresh halaman setelah 1,5 detik
            } else {
              // Jika terjadi error
              swal({
                title: "Gagal!",
                text: data,
                icon: "error",
                timer: 1500,
              });
            }
          },
        });
      } else {
        return false;
      }
    });
  });

  // Ketika tombol dengan kelas 'btn-print' diklik
  $(".btn-print").on("click", function () {
    $("#printarea").show(); // Menampilkan area print
    window.print(); // Mencetak halaman
  });
});
