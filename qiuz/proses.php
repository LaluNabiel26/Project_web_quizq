<?php
session_start();

include '../koneksi.php';
/** @var mysqli $koneksi */

$jawaban = $_POST['jawaban'] ?? [];

$score = 0;

foreach($jawaban as $id => $jwb){
    $id = (int) $id; 

    $q = mysqli_query($koneksi,"SELECT jawaban_benar FROM soal WHERE id=$id");
    $d = mysqli_fetch_assoc($q);

    if($d && $jwb == $d['jawaban_benar']){
        $score += 10;
    }
}

if(!isset($_SESSION['user']['id'])){
    header("Location: ../login.php");
    exit;
}

$user_id = (int) $_SESSION['user']['id'];

mysqli_query($koneksi,"INSERT INTO hasil (user_id,nilai,tanggal) 
VALUES ($user_id,$score,NOW())");

header("Location: hasil.php?nilai=$score");
exit;
?>