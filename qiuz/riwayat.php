<?php
session_start();

include '../koneksi.php';

/** @var mysqli $koneksi */

if (!isset($_SESSION['user']['id'])) {
    header("Location: ../login.php");
    exit;
}

if (!$koneksi) {
    die("Koneksi database gagal!");
}

$id = (int) $_SESSION['user']['id'];

$data = mysqli_query(
    $koneksi,
    "SELECT * FROM hasil WHERE user_id = $id ORDER BY tanggal DESC"
);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Riwayat Nilai</title>

    <style>
        body{
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg,#4facfe,#00f2fe);
            margin:0;
            padding:30px;
        }

        .container{
            max-width:800px;
            margin:auto;
            background:white;
            padding:30px;
            border-radius:20px;
            box-shadow:0 10px 25px rgba(0,0,0,0.2);
        }

        h2{
            text-align:center;
            color:#333;
            margin-bottom:25px;
        }

        table{
            width:100%;
            border-collapse:collapse;
        }

        th{
            background:#0d6efd;
            color:white;
            padding:12px;
        }

        td{
            padding:12px;
            border-bottom:1px solid #ddd;
            text-align:center;
        }

        tr:hover{
            background:#f5f5f5;
        }

        .btn{
            display:inline-block;
            margin-top:20px;
            padding:12px 20px;
            background:#198754;
            color:white;
            text-decoration:none;
            border-radius:8px;
        }

        .btn:hover{
            background:#157347;
        }

        .kosong{
            text-align:center;
            color:#666;
            margin-top:20px;
        }
    </style>
</head>
<body>

<div class="container">

    <h2>📊 Riwayat Nilai Quiz</h2>

    <?php if(mysqli_num_rows($data) > 0){ ?>

    <table>
        <tr>
            <th>No</th>
            <th>Nilai</th>
            <th>Tanggal</th>
        </tr>

        <?php
        $no = 1;
        while($row = mysqli_fetch_assoc($data)){
        ?>
        <tr>
            <td><?php echo $no++; ?></td>
            <td><?php echo $row['nilai']; ?></td>
            <td><?php echo $row['tanggal']; ?></td>
        </tr>
        <?php } ?>

    </table>

    <?php } else { ?>

        <p class="kosong">Belum ada riwayat nilai.</p>

    <?php } ?>

    <center>
        <a href="../dashboard.php" class="btn">
            🏠 Kembali ke Dashboard
        </a>
    </center>

</div>

</body>
</html>