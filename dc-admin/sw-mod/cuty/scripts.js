$(document).ready(function () {
  // Inisialisasi DataTables pada elemen dengan ID 'swdatatable'
  $("#swdatatable").dataTable({
    iDisplayLength: 20, // Menampilkan 20 baris per halaman secara default
    aLengthMenu: [
      [20, 30, 50, -1],
      [20, 30, 50, "All"],
    ], // Menu pilihan jumlah baris yang ditampilkan
  });

  // Fungsi untuk menampilkan elemen loading
  function loading() {
    $(".loading").show();
    $(".loading").delay(1500).fadeOut(500);
  }

  /* -------------------- Edit ------------------- */
  // Menangani klik pada elemen dengan class 'update-status'
  $(document).on("click", ".update-status", function () {
    var id = $(this).attr("data-id"); // Mengambil ID dari atribut data-id
    var status = $(this).attr("data-status"); // Mengambil status dari atribut data-status

    // Mengirim permintaan AJAX
    $.ajax({
      url: "sw-mod/cuty/proses.php?action=update-status&status=" + status, // URL endpoint
      type: "POST", // Metode HTTP POST
      data: { id: id }, // Data yang dikirimkan
      beforeSend: function () {
        loading(); // Menampilkan elemen loading sebelum permintaan dikirim
      },
      success: function (data) {
        // Menangani respons dari server
        if (data == "success") {
          swal({
            // Menampilkan SweetAlert jika berhasil
            title: "Berhasil!",
            text: "Data berhasil disimpan.!",
            icon: "success",
            timer: 2000,
          });
          setTimeout(function () {
            location.reload(); // Memuat ulang halaman setelah 2 detik
          }, 2100);
        } else {
          swal({
            // Menampilkan SweetAlert jika gagal
            title: "Oops!",
            text: data,
            icon: "error",
            timer: 1500,
          });
        }
      },
      complete: function () {
        $(".loading").hide(); // Menyembunyikan elemen loading setelah permintaan selesai
      },
    });
  });
});
