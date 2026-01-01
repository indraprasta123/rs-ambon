tinymce.init({
  selector: "#swEditorText", // Pilih elemen dengan ID swEditorText
  menubar: true, // Menampilkan menu bar
  theme: "modern", // Menggunakan tema modern
  skin: "custom", // Menggunakan skin custom
  content_style: "p { font-size: 15px; }", // Menentukan gaya konten
  plugins:
    "codemirror, preview, wordcount, advlist, autolink, lists, link, image, charmap, print, preview, hr, anchor, pagebreak, searchreplace, wordcount, visualblocks, visualchars, fullscreen, insertdatetime, media, nonbreaking, save, paste, table, contextmenu, directionality, emoticons, paste, textcolor, colorpicker, textpattern", // Daftar plugin yang digunakan
  contextmenu: "link image inserttable | cell row column deletetable", // Menu konteks khusus
  codemirror: {
    indentOnInit: true, // Indentasi saat inisialisasi
    path: "codemirror-4.8", // Jalur ke codemirror
    config: {
      lineNumbers: true, // Menampilkan nomor baris
    },
  },
  toolbar1:
    "undo redo paste bold italic underline alignleft aligncenter alignright alignjustify bullist numlist outdent indent table blockquote charmap ", // Toolbar pertama
  toolbar2:
    "fontsizeselect styleselect link unlink emoticons insertdatetime image media forecolor backcolor code preview fullscreen", // Toolbar kedua
  content_css: [
    "./sw-assets/css/tiny.css", // CSS untuk konten
  ],
  image_advtab: true, // Menampilkan tab lanjutan untuk gambar
  convert_urls: false, // Tidak mengonversi URL
  paste_data_images: true, // Mengizinkan tempel gambar
  fontsize_formats: "8px 10px 12px 14px 18px 24px 36px", // Format ukuran font
  relative_urls: false, // Tidak menggunakan URL relatif
  remove_script_host: false, // Tidak menghapus host skrip
  file_browser_callback: function (field, url, type, win) {
    tinyMCE.activeEditor.windowManager.open(
      {
        file:
          "plugins/kcfinder/browse.php?opener=tinymce4&field=" +
          field +
          "&type=" +
          type, // File manager
        title: "File Manager",
        width: 900,
        height: 500,
        inline: true,
        close_previous: false,
      },
      {
        window: win,
        input: field,
      }
    );
    return false;
  },
});

// Inisialisasi DataTable dengan pengaturan khusus
$("#swdatatable").dataTable({
  iDisplayLength: 20, // Jumlah baris yang ditampilkan per halaman
  aLengthMenu: [
    [20, 30, 50, -1],
    [20, 30, 50, "All"],
  ], // Pilihan jumlah baris per halaman
});
