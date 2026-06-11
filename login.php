<?php
session_start();
include 'koneksi.php';

$error = "";

if(isset($_POST['login'])){
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if(empty($email) || empty($password)){
        $error = "Email dan password wajib diisi!";
    } else {

        $q = mysqli_query($koneksi, "SELECT * FROM users WHERE email='$email'");
        $data = mysqli_fetch_assoc($q);

        if($data && password_verify($password, $data['password'])){
            $_SESSION['user'] = $data;

            header("Location: dashboard.php");
            exit;
        } else {
            $error = "Login gagal!";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Login</title>

    <style>
        body{
            font-family: Arial, sans-serif;
            background:#f2f2f2;
            display:flex;
            justify-content:center;
            align-items:center;
            height:100vh;
            margin:0;
        }

        .container{
            width:350px;
            background:white;
            padding:30px;
            border-radius:10px;
            box-shadow:0 0 10px rgba(0,0,0,0.2);
        }

        h2{
            text-align:center;
            margin-bottom:20px;
        }

        input{
            width:100%;
            padding:10px;
            margin:8px 0;
            border:1px solid #ccc;
            border-radius:5px;
            box-sizing:border-box;
        }

        button{
            width:100%;
            padding:12px;
            background:#0d6efd;
            color:white;
            border:none;
            border-radius:5px;
            cursor:pointer;
        }

        button:hover{
            background:#0b5ed7;
        }

        .error{
            color:red;
            text-align:center;
            margin-bottom:15px;
        }

        .back{
            text-align:center;
            margin-top:15px;
        }

        .back a{
            text-decoration:none;
        }
    </style>
</head>
<body>

<div class="container">

    <h2>Login</h2>

    <?php if($error != ""){ ?>
        <div class="error"><?php echo $error; ?></div>
    <?php } ?>

    <form method="POST">
        <input type="email" name="email" placeholder="Masukkan Email" required>

        <input type="password" name="password" placeholder="Masukkan Password" required>

        <button type="submit" name="login">Login</button>
    </form>

    <div class="back">
        <br>
        <a href="index.html">← Kembali ke Beranda</a>
    </div>

</div>

</body>
</html>