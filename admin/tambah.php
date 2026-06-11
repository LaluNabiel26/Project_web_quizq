<?php
include '../koneksi.php';
/** @var mysqli $koneksi */

if(isset($_POST['simpan'])){
    $pertanyaan = $_POST['pertanyaan'] ?? '';
    $a = $_POST['a'] ?? '';
    $b = $_POST['b'] ?? '';
    $c = $_POST['c'] ?? '';
    $d = $_POST['d'] ?? '';
    $jawaban = strtoupper($_POST['jawaban'] ?? '');

    mysqli_query($koneksi, "INSERT INTO soal 
    (pertanyaan, pilihan_a, pilihan_b, pilihan_c, pilihan_d, jawaban_benar)
    VALUES ('$pertanyaan','$a','$b','$c','$d','$jawaban')");

    echo "Soal berhasil ditambahkan!";
}
?>

<h2>Tambah Soal</h2>

<form method="POST">
    <input type="text" name="pertanyaan" placeholder="Pertanyaan" required><br><br>

    <input type="text" name="a" placeholder="Pilihan A" required><br><br>
    <input type="text" name="b" placeholder="Pilihan B" required><br><br>
    <input type="text" name="c" placeholder="Pilihan C" required><br><br>
    <input type="text" name="d" placeholder="Pilihan D" required><br><br>

    <input type="text" name="jawaban" placeholder="Jawaban (A/B/C/D)" required><br><br>

    <button type="submit" name="simpan">Simpan</button>
</form>