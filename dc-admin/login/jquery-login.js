//function pada login

//menampilkan pesan "Authenticating.." dalam elemen dengan ID #stat ketika proses autentikasi sedang berlangsung.
function loading() {
  $("#stat").html(
    '<div class="alert alert-info"><i>Authenticating..</i></div>'
  );
}
//jQuery menambahkan event handler klik pada elemen dengan ID #login. Saat elemen ini diklik, fungsi login() akan dipanggil.
$(document).ready(function () {
  $("#login").click(function () {
    login();
  });
});

//Mengecek apakah input username atau password kosong.
function login() {
  if ($("#username").val() == "" || $("#password").val() == "") {
    $("#stat").fadeTo("slow", "1.99");
    $("#stat").fadeIn("slow", function () {
      $("#stat").html(
        '<div class="alert alert-warning">Username/Password belum lengkap !</div>'
      );
    });
    return false;
  } else {
    loading();
    var username = $("#username").val();
    var password = $("#password").val();
    $.getJSON(
      "../login/login-proses.php",
      { username: username, password: password },
      function (json) {
        if (json.response.error == "0") {
          // jika login gagal
          $("#stat").fadeTo("slow", "1.99");
          $("#stat").fadeIn("slow", function () {
            $("#stat").html(
              '<div class="alert alert-danger">Periksa username & Password anda.!</div>'
            );
          });
        } // Login sukses
        else {
          $("#stat").fadeOut("slow", function () {
            window.location.replace("../");
            //window.location = url_admin;
          });
        }
      }
    );
    return false;
  }
}
