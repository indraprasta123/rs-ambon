$(document).ready(function () {
  // Inisialisasi DataTables pada tabel dengan id #swdatatable
  $("#swdatatable").dataTable({
    iDisplayLength: 31, // Jumlah baris yang ditampilkan per halaman
    aLengthMenu: [
      [31, 50, 100, -1], // Opsi jumlah baris per halaman
      [31, 50, 100, "All"], // Teks opsi jumlah baris per halaman
    ],
  });

  // Fungsi untuk menampilkan animasi loading
  function loading() {
    $(".loading").show(); // Menampilkan elemen dengan class "loading"
    $(".loading").delay(1500).fadeOut(500); // Menyembunyikan elemen setelah 1.5 detik dengan efek fade out
  }

  loadData(); // Panggil fungsi loadData saat halaman dimuat
  function loadData() {
    var id = $(".id").val(); // Ambil nilai dari elemen dengan class "id"
    $.ajax({
      url: "sw-mod/absensi/proses.php?action=absensi&id=" + id + "", // URL untuk request
      type: "POST", // Metode HTTP
      success: function (data) {
        $(".loaddata").html(data); // Masukkan data response ke dalam elemen dengan class "loaddata"
      },
    });
  }

  // Event handler untuk tombol dengan class "btn-clear"
  $(".btn-clear").click(function (e) {
    loadData(); // Panggil fungsi loadData untuk memuat data
    $(".month").val(""); // Kosongkan nilai select bulan
    $(".year").val(""); // Kosongkan nilai select tahun
  });

  // Event handler untuk tombol dengan class "btn-sortir"
  $(".btn-sortir").click(function (e) {
    var month_d = new Array();
    // Array untuk nama bulan
    month_d[0] = "Januari";
    month_d[1] = "Februari";
    month_d[2] = "Maret";
    month_d[3] = "April";
    month_d[4] = "Mei";
    month_d[5] = "Juni";
    month_d[6] = "Juli";
    month_d[7] = "Agustus";
    month_d[8] = "September";
    month_d[9] = "Oktober";
    month_d[10] = "November";
    month_d[11] = "Desember";

    var id = $(".id").val(); // Ambil nilai dari elemen dengan class "id"
    var month = $(".month").val(); // Ambil nilai dari select bulan
    var year = $(".year").val(); // Ambil nilai dari select tahun

    var d = new Date(month); // Buat objek Date dari nilai bulan
    var n = month_d[d.getMonth()]; // Ambil nama bulan dari array month_d
    $(".result-month").html(n); // Tampilkan nama bulan pada elemen dengan class "result-month"

    // Request data absensi berdasarkan bulan dan tahun
    $.ajax({
      url: "sw-mod/absensi/proses.php?action=absensi&id=" + id + "",
      method: "POST",
      data: { month: month, year: year },
      dataType: "text",
      cache: false,
      async: false,
      beforeSend: function () {
        // loading(); // Tampilkan loading sebelum request
      },
      success: function (data) {
        $(".loaddata").html(data); // Masukkan data response ke dalam elemen dengan class "loaddata"
      },
      complete: function () {
        // $(".loading").hide(); // Sembunyikan loading setelah request selesai
      },
    });
  });

  // Inisialisasi SimpleLightbox untuk elemen dengan class "picture a"
  (function () {
    var $gallery = new SimpleLightbox(".picture a", {});
  })();

  // Event handler untuk tombol dengan class "btn-print"
  $(".btn-print").click(function (e) {
    var id = $(".id").val(); // Ambil nilai dari elemen dengan class "id"
    var month = $(".month").val(); // Ambil nilai dari select bulan
    var year = $(".year").val(); // Ambil nilai dari select tahun
    var type = $(this).attr("data-id"); // Ambil jenis print dari atribut data-id

    // Tentukan URL berdasarkan jenis print (pdf, excel, print)
    if (type == "pdf") {
      if (month == "") {
        var url = "./absensi/print?action=pdf&id=" + id + ""; // URL untuk PDF tanpa filter bulan
      } else {
        var url =
          "./absensi/print?action=pdf&id=" +
          id +
          "&from=" +
          month +
          "&to=" +
          year +
          ""; // URL untuk PDF dengan filter bulan dan tahun
      }
    }

    if (type == "excel") {
      if (month == "") {
        var url = "./absensi/print?action=excel&id=" + id + ""; // URL untuk Excel tanpa filter bulan
      } else {
        var url =
          "./absensi/print?action=excel&id=" +
          id +
          "&from=" +
          month +
          "&to=" +
          year +
          ""; // URL untuk Excel dengan filter bulan dan tahun
      }
    }

    if (type == "print") {
      var url =
        "./absensi/print?action=excel&id=" +
        id +
        "&from=" +
        month +
        "&to=" +
        year +
        "&print=print"; // URL untuk print dengan filter bulan dan tahun
    }
    window.open(url, "_blank"); // Buka URL di tab baru
  });

  // Event handler untuk tombol dengan class "btn-print-all"
  $(".btn-print-all").click(function (e) {
    var building = $(".building").val(); // Ambil nilai dari select building
    var month = $(".month").val(); // Ambil nilai dari select bulan
    var year = $(".year").val(); // Ambil nilai dari select tahun
    var type = $(".type").val(); // Ambil tipe dari select type

    // Tentukan URL berdasarkan tipe (excel, print)
    if (type == "excel") {
      var url =
        "./absensi/print?action=allexcel&building=" +
        building +
        "&from=" +
        month +
        "&to=" +
        year +
        ""; // URL untuk Excel dengan filter building, bulan, dan tahun
    }
    if (type == "print") {
      var url =
        "./absensi/print?action=allexcel&building=" +
        building +
        "&from=" +
        month +
        "&to=" +
        year +
        "&print=print"; // URL untuk print dengan filter building, bulan, dan tahun
    }

    window.open(url, "_blank"); // Buka URL di tab baru
  });
});

// Event handler untuk tombol dengan class "btn-modal"
$(document).on("click", ".btn-modal", function () {
  $("#modal-location").modal(); // Tampilkan modal dengan id "modal-location"
  var latitude = $(this).attr("data-latitude"); // Ambil latitude dari atribut data-latitude
  var longitude = $(this).attr("data-longitude"); // Ambil longitude dari atribut data-longitude
  var name = $(".employees_name").html(); // Ambil nama karyawan dari elemen dengan class "employees_name"
  $(".modal-title-name").html(name); // Tampilkan nama karyawan pada judul modal

  // Tambahkan iframe ke dalam div dengan id "iframe-map" untuk menampilkan peta
  document.getElementById("iframe-map").innerHTML =
    '<iframe src="sw-mod/absensi/map.php?latitude=' +
    latitude +
    "&longitude=" +
    longitude +
    "&name=" +
    name +
    '" frameborder="0" width="100%" height="400px" marginwidth="0" marginheight="0" scrolling="no">';
});
