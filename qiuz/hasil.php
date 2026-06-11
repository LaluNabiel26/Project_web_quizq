<?php
session_start();

include '../koneksi.php';

/** @var mysqli $koneksi */

if (!isset($_SESSION['user'])) {
    header("Location: ../login.php");
    exit;
}

if (!$koneksi) {
    die("Koneksi database gagal!");
}

$jawaban_user = $_POST['jawaban'] ?? [];

$data = mysqli_query($koneksi, "SELECT * FROM soal");

$benar = 0;
$salah = 0;

while ($row = mysqli_fetch_assoc($data)) {
    $id = $row['id'];

    if (isset($jawaban_user[$id])) {

        if ($jawaban_user[$id] == $row['jawaban_benar']) {
            $benar++;
        } else {
            $salah++;
        }
    }
}

$total = $benar + $salah;
$nilai = $total > 0 ? round(($benar / $total) * 100, 2) : 0;

$user_id = (int)$_SESSION['user']['id'];

mysqli_query(
    $koneksi,
    "INSERT INTO hasil (user_id, nilai, tanggal)
     VALUES ('$user_id', '$nilai', NOW())"
);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Hasil Quiz</title>

    <style>
        body{
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg,#4facfe,#00f2fe);
            display:flex;
            justify-content:center;
            align-items:center;
            min-height:100vh;
            margin:0;
        }

        .card{
            background:white;
            width:450px;
            padding:30px;
            border-radius:20px;
            text-align:center;
            box-shadow:0 10px 25px rgba(0,0,0,0.2);
        }

        h2{
            color:#333;
            margin-bottom:20px;
        }

        .nilai{
            font-size:40px;
            font-weight:bold;
            color:#198754;
            margin:20px 0;
        }

        .info{
            font-size:18px;
            margin:10px 0;
        }

        .btn{
            display:inline-block;
            margin-top:20px;
            padding:12px 25px;
            background:#0d6efd;
            color:white;
            text-decoration:none;
            border-radius:8px;
        }

        .btn:hover{
            background:#0b5ed7;
        }
    </style>
</head>
<body>

<div class="card">

    <h2>🎉 Hasil Quiz</h2>

    <div class="nilai">
        <?php echo $nilai; ?>
    </div>

    <div class="info">
        ✅ Benar : <b><?php echo $benar; ?></b>
    </div>

    <div class="info">
        ❌ Salah : <b><?php echo $salah; ?></b>
    </div>

    <div class="info">
        📊 Nilai Akhir : <b><?php echo $nilai; ?></b>
    </div>

    <a href="../dashboard.php" class="btn">
        🏠 Kembali ke Dashboard
    </a>

</div>

</body>
</html>
