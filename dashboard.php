<?php
session_start();

if(!isset($_SESSION['user'])){
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>

    <style>
        body{
            margin:0;
            font-family:Arial, sans-serif;
            background:#f2f2f2;
        }

        .container{
            width:500px;
            margin:80px auto;
            background:white;
            padding:30px;
            border-radius:10px;
            box-shadow:0 0 10px rgba(0,0,0,0.2);
            text-align:center;
        }

        h2{
            color:#333;
            margin-bottom:20px;
        }

        .btn{
            display:block;
            width:100%;
            padding:15px;
            margin:10px 0;
            text-decoration:none;
            color:white;
            border-radius:5px;
            font-size:16px;
            font-weight:bold;
            box-sizing:border-box;
        }

        .quiz{
            background:#0d6efd;
        }

        .riwayat{
            background:#198754;
        }

        .admin{
            background:#fd7e14;
        }

        .logout{
            background:#dc3545;
        }

        .btn:hover{
            opacity:0.9;
        }
    </style>
</head>
<body>

<div class="container">

    <h2>
        Selamat Datang,
        <?php echo $_SESSION['user']['nama']; ?>
    </h2>

    <a href="quiz/soal.php" class="btn quiz">
        Mulai Quiz
    </a>

    <a href="quiz/riwayat.php" class="btn riwayat">
        Riwayat Nilai
    </a>

    <?php if($_SESSION['user']['role'] == 'admin'){ ?>
        <a href="admin/soal.php" class="btn admin">
            Menu Admin
        </a>
    <?php } ?>

    <a href="logout.php" class="btn logout">
        Logout
    </a>

</div>

</body>
</html>
