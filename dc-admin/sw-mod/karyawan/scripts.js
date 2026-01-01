$(document).ready(function () {
  // Inisialisasi tabel DataTables dengan pengaturan tampilan
  $("#swdatatable").dataTable({
    iDisplayLength: 20,
    aLengthMenu: [
      [20, 30, 50, -1],
      [20, 30, 50, "All"],
    ],
  });
  // Fungsi untuk menampilkan pratinjau gambar sebelum diunggah
  function readURL(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();

      reader.onload = function (e) {
        $(".preview").attr("src", e.target.result); // Menampilkan gambar pratinjau
      };

      reader.readAsDataURL(input.files[0]); // convert to base64 string
    }
  }

  // Event handler untuk input file gambar
  $("#imgInp").change(function () {
    readURL(this);
  });
  // Fungsi untuk menampilkan elemen loading
  function loading() {
    $(".loading").show();
    $(".loading").delay(1500).fadeOut(500);
  }

  /* ----------- Add ------------*/
  // Event handler untuk form tambah karyawan
  $(".add-karyawan").submit(function (e) {
    if ($("#building").val() == "") {
      swal({
        title: "Oops!",
        text: "Harap bidang inputan tidak boleh ada yang kosong.!",
        icon: "error",
        timer: 1500,
      });
      return false; // Menghentikan pengiriman form jika ada field kosong
      loading();
    } else {
      loading();
      e.preventDefault(); // Mencegah pengiriman form default
      $.ajax({
        url: "sw-mod/karyawan/proses.php?action=add",
        type: "POST",
        data: new FormData(this), // Mengirimkan form data
        processData: false,
        contentType: false,
        cache: false,
        async: false,
        beforeSend: function () {
          loading(); // Menampilkan elemen loading
        },
        success: function (data) {
          if (data == "success") {
            swal({
              title: "Berhasil!",
              text: "Data Karyawan berhasil disimpan.!",
              icon: "success",
              timer: 1500,
            });

            // Redirect ke halaman karyawan setelah 2.5 detik
            //setTimeout(function(){location.reload(); }, 1500);
            window.setTimeout((window.location.href = "./karyawan"), 2500);
          } else {
            swal({ title: "Oops!", text: data, icon: "error", timer: 1500 });
          }
        },
        complete: function () {
          $(".loading").hide(); // Menyembunyikan elemen loading
        },
      });
    }
  });

  /* -------------------- Edit ------------------- */
  // Event handler untuk form update karyawan
  $(".update-karyawan").submit(function (e) {
    if ($("#building").val() == "") {
      swal({
        title: "Oops!",
        text: "Harap bidang inputan tidak boleh ada yang kosong.!",
        icon: "error",
        timer: 1500,
      });
      loading();
      return false; // Menghentikan pengiriman form jika ada field kosong
    } else {
      loading();
      e.preventDefault(); // Mencegah pengiriman form default
      $.ajax({
        url: "sw-mod/karyawan/proses.php?action=update",
        type: "POST",
        data: new FormData(this), // Mengirimkan form data
        processData: false,
        contentType: false,
        cache: false,
        async: false,
        beforeSend: function () {
          loading(); // Menampilkant elemen loading
        },
        success: function (data) {
          if (data == "success") {
            swal({
              title: "Berhasil!",
              text: "Data Karyawan berhasil disimpan.!",
              icon: "success",
              timer: 1500,
            });
            setTimeout(function () {
              location.reload();
            }, 2500);
            //window.setTimeout(window.location.href = "./karyawan",2500);
          } else {
            swal({ title: "Oops!", text: data, icon: "error", timer: 1500 });
          }
        },
        complete: function () {
          $(".loading").hide(); // Menyembunyikan elemen loading
        },
      });
    }
  });

  /* -------------------- Edit Password ------------------- */
  // Event handler untuk form update password
  $(".update-password").submit(function (e) {
    if ($("#password").val() == "") {
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
      e.preventDefault();
      $.ajax({
        url: "sw-mod/karyawan/proses.php?action=update-password",
        type: "POST",
        data: new FormData(this),
        processData: false,
        contentType: false,
        cache: false,
        async: false,
        beforeSend: function () {
          loading();
        },
        success: function (data) {
          if (data == "success") {
            swal({
              title: "Berhasil!",
              text: "Password Baru berhasil disimpan.!",
              icon: "success",
              timer: 2000,
            });

            //window.setTimeout(window.location.href = "./karyawan",2500);
          } else {
            swal({ title: "Oops!", text: data, icon: "error", timer: 1500 });
          }
        },
        complete: function () {
          $(".loading").hide();
        },
      });
    }
  });

  /*------------ Delete -------------*/
  // Event handler untuk tombol hapus
  $(document).on("click", ".delete", function () {
    var id = $(this).attr("data-id");
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
          url: "sw-mod/karyawan/proses.php?action=delete",
          type: "POST",
          data: { id: id }, // Mengirimkan ID yang akan dihapus
          success: function (data) {
            if (data == "success") {
              swal({
                title: "Berhasil!",
                text: "Data berhasil dihapus.!",
                icon: "success",
                timer: 1500,
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
        return false;
      }
    });
  });
});
