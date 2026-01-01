<?PHP
// Menggunakan fungsi addslashes untuk menambahkan backslash sebelum tanda kutip tunggal
$slash = addslashes("'");

// Menggunakan str_replace untuk menghapus semua tanda kutip tunggal dari variabel $slash
$slash = str_replace("'", "", $slash);

// Fungsi untuk mengganti karakter tertentu dalam string dengan string kosong
function replace_character($string)
{
	// Menghapus tanda kurung buka
	$string = str_replace('(', '', $string);
	// Menghapus tanda kurung tutup
	$string = str_replace(')', '', $string);
	// Menghapus tanda kurung siku buka
	$string = str_replace('[', '', $string);
	// Menghapus tanda kurung siku tutup
	$string = str_replace(']', '', $string);
	// Menghapus tanda kurung kurawal buka
	$string = str_replace('{', '', $string);
	// Menghapus tanda kurung kurawal tutup
	$string = str_replace('}', '', $string);
	// Menghapus tanda garis miring
	$string = str_replace('/', '', $string);
	// Menghapus tanda bintang
	$string = str_replace('*', '', $string);
	// Menghapus tanda ampersand
	$string = str_replace('&', '', $string);
	// Menghapus tanda topi (caret)
	$string = str_replace('^', '', $string);
	// Menghapus tanda at
	$string = str_replace('@', '', $string);
	// Menghapus tanda pagar
	$string = str_replace('#', '', $string);
	// Menghapus tanda dolar
	$string = str_replace('$', '', $string);
	// Menghapus tanda seru
	$string = str_replace('!', '', $string);
	// Menghapus tanda titik dua
	$string = str_replace(':', '', $string);
	// Menghapus tanda titik koma
	$string = str_replace(';', '', $string);
	// Menghapus tanda tanya
	$string = str_replace('?', '', $string);
	// Menghapus tanda tambah
	$string = str_replace('+', '', $string);
	// Menghapus tanda sama dengan
	$string = str_replace('=', '', $string);
	// Menghapus tanda pipa
	$string = str_replace('|', '', $string);
	// Menghapus tanda backtick
	$string = str_replace('`', '', $string);
	// Menghapus tanda tilde
	$string = str_replace('~', '', $string);
	// Menghapus tanda kutip ganda
	$string = str_replace('"', '', $string);
	// Menghapus tanda kutip tunggal
	$string = str_replace("'", '', $string);
	// Menghapus tanda persen
	$string = str_replace("%", '', $string);
	// Menghapus tanda garis bawah
	$string = str_replace("_", '', $string);
	// Menghapus tanda titik
	$string = str_replace(".", '', $string);
	// Menghapus tanda dua titik berturut-turut
	$string = str_replace("..", '', $string);
	// Menghapus tanda koma
	$string = str_replace(",", '', $string);
	// Menghapus spasi
	$string = str_replace(" ", '', $string);

	// Mengembalikan string yang telah dimodifikasi
	return $string;
}

?>