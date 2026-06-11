<?php
$koneksi = mysqli_connect(
    "localhost",
    "tiuinmtr_quizq",
    "quizq0000#",
    "tiuinmtr_quizq"
);

if(!$koneksi){
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>
